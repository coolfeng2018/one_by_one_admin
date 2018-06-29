<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;


class UinfoController extends BaseController {
    /**
     * 修改类型
     * @var array
     */
    private $_typelist = array(
        'addcoins'=>'加金币',
        'reducecoins'=>'减金币'
    );
    /**
     * 封号解号
     * @var array
     */
    private $_locktype = array(
        'lock'=>'封号',
        'unlock'=>'解号'
    );
    /**
     * 账号状态
     * @var array
     */
    private $_lockstatus = array(
        1=>'封号状态',
        0=>'正常状态'
    );
    /**
     * 跳转链接
     */
    private $_actions = array(
        'locklist'=>'/uinfo/locklist?page=%s',
        'lock'=>'/uinfo/lock?act_type=act',
        'add'=>'/uinfo/lock?act_type=add&page=%s',
        'mod'=>'/uinfo/lock?act_type=mod&page=%s', 
        'observelist'=>'/uinfo/observe/list?page=%s',
        'observeadd'=>'/uinfo/observe/add?page=%s',
        'observemod'=>'/uinfo/observe/mod?page=%s',
        'observesave'=>'/uinfo/observe/save',
    );
    
    /**
     * 观察配置
     * 1生效中，2已达成，3暂停
     */
    private $_observecnf = array(
        //观察状态值含义
        'o_status' => array(
            1 => '生效中',
            2 => '已达成',
            3 => '中止',
        ),
        //调控类型  1增加 2减少  0中止的 
        'otype' => array(
            1 => '增加 ',
            2 => '减少'
        ),
    );
    
    /**
     * 用户信息
     * @param Request $request
     */
    public function index(Request $request){ 
        $data = array(
            'uid'=>'',
            'msg'=>'',
            'data'=>array()
        );
        $act = isset($_GET['act']) ? $_GET['act'] :'';
        if($act == 'search') {
             $uid = isset($request->uid) ? $request->uid : 0;
             $res = $this->getMonUserInfo($uid);
             if(isset($res['uid']) && !empty($res['uid'])) {                
                 //op=1加金币2减金币
                 $sum  = 'sum(if(reason=100028,value,0))/100 as deposit_sum,';//充值
                 $sum .=' sum(if(reason=100040,value,0))/100 as exch_sum,';//兑换
                 $sum .=' sum(if(reason=2,value,0))/100 as win_sum,';//赢金币
                 $sum .=' sum(if(reason=1,value,0))/100 as lose_sum,';//输金币 TODO 1？？？
                 $sum .=' sum(if(reason=6,value,0))/100 as cost_sum';//台费 
                 $sum =  DB::table('user_money')
                 ->select(DB::raw($sum))
                 ->whereRaw('uid ='.(int)$uid)
                 ->first();
                 
                 //总充值
                 $charge_total = 0;
                 $where = 'uid ='.(int)$uid;
                 $charge_total = DB::table('payment.order')->whereRaw($where.' and status = 2')->sum('amount');
                 $charge_total = $charge_total/100;
                 //总提现
                 $withdraw_total = DB::table('one_by_one.withdraw')->whereRaw($where.' and Status = 1')->sum('Amount');
                 
                 //从DB中读取用户封号状态   可能会不准 TODO 
                 $where =' uid='.$uid.' and lock_status=1 and endtime>'.time();
                 $lock_res =  DB::table('user_lock')->whereRaw($where)->get();
                 $lockstatus = isset($lock_res[0]->uid) ? 1:0;
                 $lockstatus_id = isset($lock_res[0]->id) ? $lock_res[0]->id:'';
                 $data = array(
                     'uid'=>$request->uid,
                     'msg'=>'',
                     'data'=>array(
                         'coins' => isset($res['coins']) ? $res['coins'] : 0,//金币数量
                         'last_login_ip'=>isset($res['last_login_ip']) ? long2ip($res['last_login_ip']) : 0,//
                         'uid'=>isset($res['uid']) ? $res['uid'] : '',
                         
                         'nickname'=>isset($res['name']) ? $res['name'] : '--',//昵称
                         'last_login_time'=>isset($res['last_login_time']) ? date('Y-m-d H:i:s',$res['last_login_time']) : '--',
                         'last_login_addr'=>isset($res['last_login_ip']) ?  $this->getTaobaoAddress(long2ip($res['last_login_ip'])) : '--',
                         'regist_time'=>isset($res['created_time']) ? date('Y-m-d H:i:s',$res['created_time']) : '--',//注册时间
                         'cid'=>1,
                         'sex'=>isset($res['sex'])&&$res['sex']==2 ? '女' : '男',

                         'level'=>isset($res['level']) ? $res['level'] : '--',
                         
                         'lockstatus'=>$lockstatus,
                         'lockstatus_id'=>$lockstatus_id,
                         
                         //'deposit_sum' =>isset($sum->deposit_sum) ? $sum->deposit_sum : 0,//充值
                         'deposit_sum'=> $charge_total,
                         'draw_sum' => $withdraw_total,//提现
                         'exch_sum' =>isset($sum->exch_sum) ? $sum->exch_sum : 0,//兑换
                         'win_sum' =>isset($sum->win_sum) ? $sum->win_sum : 0,
                         'lose_sum' =>isset($sum->lose_sum) ? $sum->lose_sum : 0,
                         'cost_sum' =>isset($sum->cost_sum) ? $sum->cost_sum : 0,
                     )
                 );
             }else{
                 $data['uid'] = $uid;
                 $data['msg'] = '没有该用户';
             }
        }
        return view('Uinfo.index',$data);
    }
    
    
    /**
     *  通过淘宝IP地址库获取IP位置
     *1. 请求接口（GET）：http://ip.taobao.com/service/getIpInfo.php?ip=[ip地址字串]
     *2. 响应信息：（json格式的）国家 、省（自治区或直辖市）、市（县）、运营商
     *3. 返回数据格式Json：
     *其中code的值的含义为，0：成功，1：失败。
     */
    public function getTaobaoAddress($ip = ''){
        $address = '';
        $ip_content   = $this->curl("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
        $ip_arr = json_decode($ip_content,true);
        if(isset($ip_arr['code']) && $ip_arr['code'] == 0) {
            $address = $ip_arr['data']['region'].$ip_arr['data']['city'];
        }
        return $address;
    }  
    
    /**
     * 修改用户金币
     * @param Request $request
     */
    public function mod(Request $request) {
        
        if(isset($request->act) && $request->act == 'act') {
            
            if(empty($type)) {
                exit(json_encode(['status'=>3,'msg'=>'请选择修改类型']));
            }else{
                $param = array(
                    'cmd'=>$type,
                    'value'=>(int)$request->num,
                    'uid'=>(int)$request->uid
                );
                $params = json_encode($param);
                $res = $this->reqCserver($param, $type);
                parent::saveLog('修改玩家金币    '.$this->_typelist[$type].' data：'.json_encode($param).' res'.json_encode($res));
                if(isset($res['code']) && $res['code'] == 0) {
                    exit(json_encode(['status'=>0,'msg'=>'修改成功！ 该用户身上现有金币为'.$res['curr']]));
                }elseif(isset($res['code']) && $res['code'] != 0){
                    exit(json_encode(['status'=>1,'msg'=>'修改失败']));
                }
                exit(json_encode(['status'=>2,'msg'=>'修改失败~！']));
            }
        }
    }
    
    /**
     * 修改玩家金币
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function modgold(Request $request){  
        
        $type = isset($request->type) ? $request->type : '';
        if(isset($request->act) && $request->act == 'act') { 
            
            if(empty($type)) {
                exit(json_encode(['status'=>3,'msg'=>'请选择修改类型']));
            }else{
                $param = array(
                    'cmd'=>$type,
                    'value'=>(int)$request->num,
                    'uid'=>(int)$request->uid                   
                );
                $res = $this->reqCserver($param, $type);
                parent::saveLog('修改玩家金币    '.$this->_typelist[$type].' data：'.json_encode($param).' res'.json_encode($res));
                if(isset($res['code']) && $res['code'] == 0) {
                    exit(json_encode(['status'=>0,'msg'=>'修改成功！ 该用户身上现有金币为'.$res['curr']]));
                }else{
                    exit(json_encode(['status'=>1,'msg'=>'修改失败']));
                }                
                exit(json_encode(['status'=>2,'msg'=>'修改失败~！']));
            }
        }
        $back  = array(
            'typelist'=> $this->_typelist,
            'type' => $type,
            'pagename' => '修改玩家金币',
        ); 
        return view('Uinfo.modgold',$back);
    }
    

    

    
    
    /**
     * 封号解号
     * @param Request $request
     */
    public function lock(Request $request) {
        $act_type = isset($request->act_type) ? $request->act_type : '';
        $type = isset($request->type) ? $request->type : '';
        if ($act_type == 'act') {           
            
            $reason = isset($request->reason) ? $request->reason : '';
            $endtime = isset($request->endtime) ? strtotime($request->endtime) : '';
            if(!isset($request->uid) || empty($request->uid)) {
                $note = array('status'=>1,'msg'=>'请填写uid！');
            }else{
                //写db记录
                $modid= isset($request->id) ? (int)$request->id : 0;
                $db_data['uid']=(int)$request->uid;
                $db_data['reason']=$request->reason;
                $db_data['endtime']= (int)$endtime;
                $db_data['lock_status']= !$type;
                $db_data['op_name'] = session('admin')["id"].";".session('admin')["username"];
                $db_data['op_time'] = time();
                if($modid==0){//添加
                    $result=DB::table('user_lock')->insertGetId($db_data);
                    parent::saveLog('封号解号添加user_lock.id--'.$result.$request->type);
                }else{ //修改
                    parent::saveLog('封号解号更新user_lock.id('.$modid.').'.$request->type);
                    $result=DB::table('user_lock')->where('id', $modid)->update($db_data);
                }
                $cmd = 'forbidden';
                //发送服务器请求
                $param = array(
                    'cmd'=>$cmd,
                    'uid'=>(int)$request->uid,
                    'is_forbidden'=> (bool)!$type,
                    'end_time'=>(int)$endtime,
                    'reason'=>$reason
                );
                $res = $this->reqCserver($param, $cmd);
                parent::saveLog('修改玩家状态   '.$cmd.' data：'.json_encode($param).' res'.json_encode($res));

                //写后台操作日志
                if(isset($res['code']) && $res['code'] == 0) { 
                    $note = array('status'=>0,'msg'=>'修改成功！');
                }else{
                    $note = array('status'=>2,'msg'=>'修改失败');
                }
                
            }  
            exit(json_encode($note));
        }
        $back = $_GET;
        $back['typelist'] = $this->_locktype;
        $back['type'] = $type;
        $back['actions'] = $this->_actions;
        $back['pagename'] = '封号解号';
        $back['data'] = isset($res) ? $res : array();
        return view('Uinfo.lock',$back);
    }
    

    /**
     * 封号解号列表
     * @param Request $request
     */
    public function locklist(Request $request) {

        $page = isset($request->page) ? $request->page : 1;
        $uid = isset($request->uid) ? $request->uid :'';
        $start = isset($request->start) && !empty($request->start) ? strtotime($request->start) : '';
        $end = isset($request->end) && !empty($request->end) ? strtotime($request->end)+60 : '';
        $where = 'lock_status = 1';
        
        if($uid) {
            $where .= ' and uid ='.(int)$uid;
        }
        /* if($start) {
            $where .=' and user_lock.endtime>='.$start;
        }
        if($end) {
            $where .=' and user_lock.endtime<='.$end;
        } */

        $where .=' order by id desc';
        $res =  DB::table('user_lock')->whereRaw($where)->paginate(10);
        $data = $_GET;
        $data['actions'] = $this->_actions;
        $data['page'] = $page;
        $data['data'] = $res;
        $data['lockstatus'] = $this->_lockstatus;
        $data['locktype'] = $this->_locktype;
        $data['pagename'] = '封号列表';
        return view('Uinfo.locklist',$data);
    }
    
    
    /**
     * 监控用户列表
     * @param Request $request
     */
    public function observeList(Request $request) {
        $page = isset($request->page) ? $request->page : 1;
        $_GET['uid'] = isset($_GET['uid']) ? $_GET['uid'] :'';
        $_GET['otype'] = isset($_GET['otype']) ? $_GET['otype'] :'';
        $_GET['o_status'] = isset($_GET['o_status']) ? $_GET['o_status'] :'';
        $_GET['start'] = isset($_GET['start']) && !empty($_GET['start']) ? $_GET['start'] : date('Y-m-d H:i:s',strtotime('-1 week'));
        $_GET['end'] = isset($_GET['end']) && !empty($_GET['end']) ? $_GET['end'] : date('Y-m-d H:i:s',time());
        $where = '1 = 1';
        if($_GET['uid']) {
            $where .= ' and uid ='.(int)$_GET['uid'];
        }
        if($_GET['uid']) {
            $where .= " and user_observe.create_time>='".$_GET['start']."'";
        }
        if($_GET['uid']) {
            $where .= " and user_observe.create_time<='".$_GET['end']."'";
        }
        if($_GET['otype']) {
            $where .= " and user_observe.otype=".$_GET['otype'];
        }
        if($_GET['o_status']) {
            $where .= " and user_observe.o_status=".$_GET['o_status'];
        }

        $where .=' order by op_time desc, o_status asc';
       // $res =  DB::table('user_observe')->whereRaw($where)->get();
        $res =  DB::table('user_observe')->whereRaw($where)->paginate(15);
        foreach ($res as $k  =>$v) {
            //查询用户充值金额
            $sum = $this->getDespositSum($v->uid);
            if(isset($sum[0]->deposit_sum)  && !empty($sum[0]->deposit_sum)) {
                $res[$k]->deposit_sum = $sum[0]->deposit_sum;
            }else{
                $res[$k]->deposit_sum = 0;
            }
            //查询用户信息
            //$uinfo = $this->getMonUserInfo($v->uid);
            $uinfo = $this->getUrateInfo(array($v->uid));
            $res[$k]->username = isset($uinfo['name']) ?  $uinfo['name'] : $v->username;
            //进行中的
            if($v->o_status == 1) {
                //正常是读取mango中的数据
                $id = $uinfo['uid']==$v->uid ?  $uinfo['affect_id'] : -1;
                $res[$k]->affect_rate = $uinfo['uid']==$v->uid ?  $uinfo['affect_rate'] : '--';
                $res[$k]->affect_count = $uinfo['uid']==$v->uid ?  $uinfo['affect_count'] : '--';//影响额度
                $res[$k]->affect_state = $uinfo['uid']==$v->uid ?  $uinfo['affect_state'] : '--';//状态 1是正在运行 0 是停止使用
                
                //兼容延时   1.affect_state.判断生效中的记录    与manggo中的affect_id 是不是    一致  ;一致才会更改状态
                if( $res[$k]->affect_state == 0 && $id == $v->id) {
                    //中止原来的  type=2
                    $sql = "update user_observe set o_status= 2 where id=".$v->id;
                    $update = DB::update($sql);
                    parent::saveLog('调控概率自动完成  user_observe_update_id_('.$v->id.')_o_status=2_res '.$update);  
                    $this->wlog('user_observe  op_time='.date('Y-m-d H:i:s',time()).' id:'.$v->id.'  uinfo'.json_encode($uinfo).'  res:'.$update,'user_observe_autocomplete');
                    $res[$k]->o_status = 2;
                }

            }else{
                $res[$k]->affect_rate = '';
                $res[$k]->affect_count = '';
                $res[$k]->affect_state = '';
            }
        }
        $data = $_GET;
        $data['observecnf'] = $this->_observecnf;
        $data['actions'] = $this->_actions;
        $data['page'] = $page;
        $data['data'] = $res;
        $data['pagename'] = '用户监控列表';
        return view('Uinfo.observelist',$data);
    }
    
    /**
     * 通过接口获取用户信息
     * @param unknown $uid_arr
     */
    protected function getUrateInfo($uid_arr) {
        $back = array(
            'uid' => 0,
            'affect_count' => 0,
            'affect_rate' => 0,
            'affect_state' => 0,
            'affect_id' => 0
        );
        $uid_str = implode(",", $uid_arr);
        $cmd = 'getaffectvalue';
        //发送服务器请求
        $param = array(
            'cmd'=>$cmd,
            'uid_list'=>$uid_str
        );
        $res = $this->reqCserver($param, $cmd);  
        //写后台操作日志
        if(isset($res['code']) && $res['code'] == 0) {
            $back = array(
                'uid' => isset($res['affect_data_list'][0]['uid']) ? $res['affect_data_list'][0]['uid']: 0,
                'affect_count' => isset($res['affect_data_list'][0]['affect_count']) ? $res['affect_data_list'][0]['affect_count']: 0,
                'affect_rate' => isset($res['affect_data_list'][0]['affect_rate']) ? $res['affect_data_list'][0]['affect_rate']: 0,
                'affect_state' => isset($res['affect_data_list'][0]['affect_state']) ? $res['affect_data_list'][0]['affect_state']: 0,
                'affect_id' => isset($res['affect_data_list'][0]['affect_id']) ? $res['affect_data_list'][0]['affect_id']: 0
            );
        }
        return $back;
    }
    
    /**
     * 获取用户充值总额
     * @param unknown $uid
     * @return unknown
     */
    protected function getDespositSum($uid) {
        $sql = 'select sum(if(reason=100028,value,0)) as deposit_sum from user_money where uid='.$uid;
        $sum = DB::select($sql);
        return $sum;
    }
    
    /**
     * 用户监控
     * @param Request $request
     */
    public function observeAdd(Request $request) {
        $act_type = isset($request->act) ? $request->act : '';
        $_GET['uid'] = isset($_GET['uid']) ? (int)$_GET['uid'] : '';
        $_GET['gid'] = isset($_GET['gid']) ? (int)$_GET['gid'] : '';
        $_GET['otype'] = isset($_GET['otype']) ? (int)$_GET['otype'] : '';
        $_GET['o_status'] = isset($_GET['o_status']) ? (int)$_GET['o_status'] : '';
        $_GET['goal_num'] = isset($_GET['goal_num']) ? (int)$_GET['goal_num'] : '';
        $_GET['percent'] =  isset($_GET['percent']) ? (int)$_GET['percent'] : '';         
        //保存数据
        if($act_type == 'do') {
            $db_data['uid'] =  (int)$_GET['uid'];
            //查询用户昵称
            $db_data['username'] = $this->getUserNick($db_data['uid']);
             if(empty($db_data['username'])) {
                 exit(json_encode(['status'=>3,'msg'=>'玩家uid不存在，请检查']));
            }
            $db_data['gid'] =  (int)$_GET['gid'];
            $db_data['o_status'] = empty($_GET['o_status']) ?  1 : (int)$_GET['o_status'];
            $db_data['otype'] = empty($_GET['otype']) ?  1 : (int)$_GET['otype'];
            $db_data['goal_num'] = empty($_GET['goal_num']) ?  0 : (int)$_GET['goal_num'];
            $db_data['percent'] = empty($_GET['percent']) ?  0 : (int)$_GET['percent'];

            $db_data['op_name'] = session('admin')["id"].";".session('admin')["username"];
            $db_data['op_time'] = date('Y-m-d H:i:s',time());    
            //记录db 操作日志
            $db_res = $this->observeSave($db_data);
            //请求服务器起的参数
            $param_arr = array(
                'cmd' => 'setaffectvalue',
                'uid' => (int)$db_data['uid'],
                'affect_count' => $db_data['otype'] == 2 ? -$db_data['goal_num'] : (int)$db_data['goal_num'],
                'affect_rate' => $db_data['otype'] == 2 ? -$db_data['percent'] : (int)$db_data['percent'],
                'affect_id'=>(int)$db_res
            );
            //请求服务器
            $c_res = $this->reqCserver($param_arr);
            
            
            if($db_res && isset($c_res['code']) && $c_res['code'] == 0){
                exit(json_encode(array('status'=>0,'msg'=>'sucsess!！')));
            }else{
                exit(json_encode(array('status'=>3,'msg'=>'db_error~！')));
            }  
        }
        $back = $_GET;
        $back['observecnf'] = $this->_observecnf;
        $back['actions'] = $this->_actions;
        $back['pagename'] = '添加监控记录';
        return view('Uinfo.observe',$back);
    }
    
    /**
     * 用户监控
     * @param Request $request
     */
    public function observeMod(Request $request) {
        $id = isset($request->id) ? $request->id : '';
        $res = DB::table('user_observe')->where('id', $_GET['id'])->first();
        if(isset($_GET['act'])) {
            $db_data['id'] = $id;
            $db_data['uid'] = $res->uid;
            $db_data['username'] = $res->username;
            
            $db_data['gid'] = isset($_GET['gid']) ? $_GET['gid'] : $res->gid;
            $db_data['otype'] = isset($_GET['otype']) ? $_GET['otype'] : $res->otype;

            $db_data['op_name'] = session('admin')["id"].";".session('admin')["username"];
            $db_data['op_time'] = date('Y-m-d H:i:s',time());
             
            if($_GET['act'] == 'ajax') {//中止ajax操作  
                $db_data['goal_num'] = $res->goal_num;
                $db_data['percent'] = $res->percent;
                $db_data['o_status'] = 3;
                
            }elseif ($_GET['act'] == 'do') {
                $db_data['goal_num'] = isset($_GET['goal_num']) ? (int)$_GET['goal_num'] : 0;
                $db_data['percent'] = isset($_GET['percent']) ? (int)$_GET['percent'] : 0;
                $db_data['o_status'] = isset($_GET['o_status'])&& !empty($_GET['o_status']) ? (int)$_GET['o_status'] : 1;    
            }
            
            //请求服务器起的参数
            $param_arr = array(
                'cmd' => 'setaffectvalue',
                'uid' => (int)$db_data['uid'],
                'affect_count' => $db_data['otype'] == 2 ? -$db_data['goal_num'] : (int)$db_data['goal_num'],
                'affect_rate' => $db_data['otype'] == 2 ? -$db_data['percent'] : (int)$db_data['percent'],
                'affect_id'=>(int)$id
            );
            if($db_data['o_status'] == 3) {
                $param_arr['affect_count'] = 0;
                $param_arr['affect_rate'] = 0;
            }
            //请求服务器
            $c_res = $this->reqCserver($param_arr);

            //记录db 操作日志
            $db_res = $this->observeSave($db_data);
            if($db_res && isset($c_res['code']) && $c_res['code'] == 0){
                exit(json_encode(array('status'=>0,'msg'=>'sucsess!！')));
            }else{
                exit(json_encode(array('status'=>3,'msg'=>'db_error~！')));
            }  
        }
        
        $back = $_GET;
        $back['observecnf'] = $this->_observecnf;
        $back['actions'] = $this->_actions;
        $back['pagename'] = '修改监控记录';
        $back['data'] = isset($res) ? $res : array();
        return view('Uinfo.observemod',$back);
    }

    
    
    
    /**
     * 修改添加操作
     * @param unknown $data
     * @param string $table
     * @return unknown
     */
    public function observeSave($data,$table = 'user_observe') {
        $result = 0;
        if(isset($data['id']) && $data['id']) {
            $id = $data['id'];
            //中止原来的
            $sql = "update user_observe set o_status= 3,op_name='".$data['op_name']."',op_time='".$data['op_time']."' where id=".$id;
            $result = DB::update($sql);
            $logmsg = 'user_observe_mod_id_('.$id.')_中止 '; 
            if($data['o_status'] ==1 ) {
                unset($data['id']);
                //新增新的
                $result = DB::table($table)->insertGetId($data);
                //写操作记录
                $logmsg = 'user_observe_mod_id_('.$id.')_中止 ,修改新增id='.$result;
            }
            parent::saveLog($logmsg);
        }else{
            //查询有没有该用户记录， 如果有该用户记录， 把之前的中止掉
            $sql = "update user_observe set o_status= 3,op_name='".$data['op_name']."',op_time='".$data['op_time']."' where o_status=1 and uid=".$data['uid'];
            $update = DB::update($sql);
            $result=DB::table($table)->insertGetId($data);
            parent::saveLog('user_observe_add_id_('.$result.')_res '.$result);  
        }
        return $result;   
    }
    
}