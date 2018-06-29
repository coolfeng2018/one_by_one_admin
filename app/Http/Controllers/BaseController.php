<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller {
    /**
     * 每页显示条数
     * @var integer
     */
    protected $page_size = 30;
    /**
     * 游戏列表
     * @var array
     */
    protected  $gamelist = array();
    
    /**
     * 服务器请求列表
     * @var array
     */
    protected $c_requrl = array(
        'upload' => '',
        'gm' => ''
    );
    
    /**
     * 机器人类型
     * @var array
     */
    protected $robot_typelist = array(
        'zjh_junior'=>'扎金花初级场 ',
        'zjh_normal'=>' 扎金花普通场 ',
        'nn_normal'=>'看牌抢庄新手场 ',
        'nn_senior'=>'看牌抢庄精英场 ',
        'ddz_junior'=>'斗地主新手场 ',
        'ddz_normal'=>'斗地主普通场 ',
        'hhdz_normal'=>'红黑大战普通场 ',
        'brnn_normal'=>'百人牛牛普通场 ',
        'lfdj_normal'=>'龙虎大战普通场 ',
    );
    

    /**
     * 房间类型
     * @var array
     */
    protected $tablelist = array(
        100 => '金花初级',
        101 => '金花普通',
        102 => '金花精英',
        103 => '金花土豪',
        200 => '牛牛新手',
        201 => '牛牛精英',
        202 => '牛牛大师',
        203 => '牛牛土豪',
        200001 => '百人',
        200000 => '红黑', 
        200002 => '龙凤对决',
        300 => '斗地主初级',
        301 => '斗地主中级',
        302 => '斗地主高级',
    );
    
    /**
     * 金币变化原因
     * @var array
     */
    protected $gold_reasonlist = array(
        1=>array('en'=>'BET_COIN','cn'=>'押注'),
        2=>array('en'=>'WIN_COIN','cn'=>'赢金币'),//+
        3=>array('en'=>'BET_COIN_BACK','cn'=>'押注失败金币返回'),
        4=>array('en'=>'COST_COIN_ERROR_BACK','cn'=>'扣除金币失败返还'),
        6=>array('en'=>'PAY_FEE','cn'=>'扣台费'),
        7=>array('en'=>'USE_MAGIC_PICTRUE','cn'=>'使用魔法表情'),
        15=>array('en'=>'PAY_COMMISSION','cn'=>'抽取佣金-红黑大战抽取台费'),//红黑大战抽取台费
        
        100000=>array('en'=>'GAMECOIN_BANKRUPT','cn'=>'破产补助'),
        100001=>array('en'=>'GAMECOIN_REGISTER','cn'=>'注册送金币'),
        100002=>array('en'=>'GAMECOIN_SYS_ADD','cn'=>'后台加金币'),
        100003=>array('en'=>'GAMECOIN_SYS_MINUS','cn'=>'后台减金币'),
        100004=>array('en'=>'GAMECOIN_SHARE','cn'=>'分享奖励'),
        100005=>array('en'=>'GAMECOIN_BIND','cn'=>'绑定奖励'),
        100006=>array('en'=>'GAMECOIN_PROMOTION_LST','cn'=>'活动推广金币消耗'),
        100007=>array('en'=>'GAMECOIN_PROMOTION_WIN','cn'=>'活动推广金币奖励'),
        100008=>array('en'=>'GAMECOIN_CHARGE_REWARD','cn'=>'首充送金币'),
        100019=>array('en'=>'SIGN_IN','cn'=>'签到'),
        100020=>array('en'=>'TAKE_SIGN_AWARD','cn'=>'领取签到奖励'),
        100021=>array('en'=>'TAKE_TASK_AWARD','cn'=>'领取任务奖励'),
        100022=>array('en'=>'TAKE_MAIL_ATTACH','cn'=>'领取邮件奖励'),
        100023=>array('en'=>'GM','cn'=>'GM操作'),
        100025=>array('en'=>'BUY_FROM_SHOP','cn'=>'商城购买'),
        100027=>array('en'=>'NEWBIE_AWARD','cn'=>'新手奖励'),
        100028=>array('en'=>'COST_COIN_ERROR_BACK','cn'=>'充值'),//+充值
        100029=>array('en'=>'COST_COIN_ERROR_BACK','cn'=>'为机器人增加金币'),
        100030=>array('en'=>'ADD_COINS_FOR_ROBOT','cn'=>'领取任务奖励'),
        
        100040=>array('en'=>'EXCHANGE_COINS','cn'=>'兑换金币'),//提现
        100041=>array('en'=>'BIND_PHONE_REWARD','cn'=>'绑定手机奖励'),
        100039=>array('en'=>'DESPOSIT_SAFE_BOX','cn'=>'保险箱操作'),
        
    );
    /**
     * 初始化游戏列表
     * (non-PHPdoc)
     * @see Home_Wxbase_Controller::init()
     */
    public function __construct(){        
        $games_obj = DB::table('games')->get();
        foreach ($games_obj as $k => $v) {
            $this->gamelist[$v->game_type] = $v->game_name;
        }
    }
    
    public function saveLog($string){
        $arr['uid']=session('admin')['id'];
        $arr['mark']=$string;
        $results = DB::table('logger')->insertGetId($arr);
        
    }

    public function saveTxtLog($preArr,$data,$string,$id){
        $tmpPre=json_encode(arraypro($preArr,$data));
        $tmpNext=json_encode(arraypro($data,$preArr));
        $uid=session('admin')['id'];
        Log::info('管理员id----'.$uid.'更新'.$string.'id----'.$id.'修改前'.$tmpPre.'修改后'.$tmpNext);
    }
    public function saveTxtLogs($preArr,$data,$string,$id){
        $tmpPre=json_encode($preArr);
        $tmpNext=json_encode($data);
        $uid=session('admin')['id'];
        Log::info('管理员id----'.$uid.'更新'.$string.'id----'.$id.'修改前'.$tmpPre.'修改后'.$tmpNext);
    }
    public function saveAssetsLog($string,$id){
        $uid=session('admin')['id'];
        Log::info('管理员id----'.$uid.'更新用户id----'.$id.'资产'.$string);
    }
    
    /**
     * 获取游戏服用户信息直接查mongo
     * @return array
     */
    protected function getMonUserInfo($uid = 0){
        $manager = new \MongoDB\Driver\Manager(env('MONGOAPI'));// 10.0.0.4:27017
        $filter = ['uid' => ['$eq' => (int)$uid]];
        // 查询数据
        $query = new \MongoDB\Driver\Query($filter);
        $cursor = $manager->executeQuery('yange_data.base', $query);
        
        $base = [];
        foreach ($cursor as $document) {
            $rs =  json_decode( json_encode( $document),true);
            $base = $rs;
        }
        $cursor2 = $manager->executeQuery('yange_data.users', $query);
        
        $users = [];
        foreach ($cursor2 as $document) {
            $rs =  json_decode( json_encode( $document),true);
            $users = $rs;
        }
        $data=array_merge($base,$users);
        $data['coins'] = isset($data['coins']) ? $data['coins']/100 : 0 ;
        return $data;
        
    }
    
    /**
     * 查询用户昵称
     * @param number $uid
     * 为空就是没有这个用户信息
     * --就是未设置昵称
     */
    protected function getUserNick($uid = 0) {
        $nick = '';
        $res = $this->getMonUserInfo($uid);
        if(isset($res['uid']) && !empty($res['uid'])) {
            $nick = isset($res['name']) ? $res['name'] : '--';//未设置昵称  
        }
        return $nick;
    }
    
    /**
     * 发送服务器
     * @param unknown $filename
     * @param unknown $str
     * @return number[]|string[]
     */
    protected function doUpload($filename,$str) {
        $back = array('status'=>2,'msg'=>'发送失败~~！');
        $url = env('SERVERAPI_UPLOAD').'/upload';
        $params = array(
            $filename.'.lua'=>$str,
        );
        $params_json = json_encode($params);
        $this->saveLog('发送配置--'.$filename.'--内容--'.$params_json);
        $result = $this->curl($url,array('data'=>$params_json));
        if($result == 'scuess') {//成功
            $this->wlog('发送配置'.$filename.'  url:'.$url.'  res:'.$result,'sndcfg');
            $back = array('status'=>0,'msg'=>'发送成功！');
        }else{
            $this->wlog('发送配置'.$filename.'  url:'.$url.'  res:'.$result,'sndcfg_err');
            $back = array('status'=>1,'msg'=>'发送失败'.$result);
        }
        return $back;
    }
    
    /**
     * 请求服务器
     * @param unknown $param_arr
     * @param string $func
     * @return mixed
     */
    protected function reqCserver($param_arr,  $cmd = 'setaffectvalue',$func = 'gm',$url = '') {
        $res = array();
        $param_json = json_encode($param_arr);
        if(empty($url)) {
            $url = env('SERVERAPI');
        }
        $result = $this->curl($url."/".$func,array('data'=>$param_json));
        $res = json_decode($result,true);
        if(isset($res['code']) && $res['code'] == 0) {
            $this->wlog($cmd.'  url:'.$url.'  params'.$param_json.'  res:'.$result, $func);
        }elseif(isset($res['code']) && $res['code'] != 0){
            $this->wlog($cmd.' url:'.$url.'  params'.$param_json.'  res:'.$result, $func.'_err');
        }
        return $res;
    }
    
    /**
     * 获取修改内容
     * @param unknown $preArr
     * @param unknown $data
     * @param unknown $string
     * @param unknown $id
     */
    public function getWhatIsModify($pre_arr,$now_arr){
        $tmpPre=json_encode(arraypro($pre_arr,$now_arr));
        $tmpNext=json_encode(arraypro($now_arr,$pre_arr));
        return $tmpPre.'修改为'.$tmpNext;
    }
    
    /**
     * 记录文件日志
     * @param string $content  内容
     * @param string $filename 路径
     * @param string 
     */
    public function wlog($content,$filename = '') {
        if(!empty($filename)) {
            $path = 'logs/'.$filename.'.log';
            Log::useDailyFiles(storage_path($path));
        }
        Log::info("(".session('admin')["id"].")".session('admin')["username"]." : ".$content);
    }
    /**
     * 获取用户角色
     * @param unknown $admin_id
     * @return number
     */
    protected function getRoleIdByAdminId($admin_id) {
        $res = DB::table('part_admin')->select('part_id')->whereRaw('admin_id='.$admin_id)->first();
        return isset($res->part_id) ? $res->part_id : 0;
    }
    
    
    /**
     * 获取管理员的渠道列表
     * @param unknown $admin_id
     * @return mixed[]
     */
    public function getMyCidList($admin_id) {
        $list = array();
        $list_obj = DB::table('admin_cid')->where('admin_id','=',$admin_id)->get();
        foreach ($list_obj as $k =>$v) {
            $list[] = $v->cid;
        }
        return $list;
    }
    
    public function getAdminCidList() {
        $list_json = session('admin')['cid_list'];
        return json_decode($list_json,true);
    }
    /**
     * 获取所有渠道数组
     * @param unknown $admin_id
     * @return mixed[]
     */
    public function getAllCidList() {
        $list_obj = DB::table('channel_list')->select('id','name','code')->where('status','=',1)->get();
        foreach ($list_obj as $k =>$v) {
            $list[] = $v->id;
        }
        return $list;
    }
    
    
//     public function fliterCid($data) {
//         $back = array();
//         $cid_list = $this->getMyCidCode();
//         foreach ($data as $k=>$v) {
//             if(is_array($v)){
//                 if(isset($v['channel']) && !in_array($v['channel'],$cid_list)) {
//                     unset($back[$k]);
//                 }
//             }elseif (is_object($v)) {
//                 if(isset($v->channel) && !in_array($v->channel,$cid_list)) {
//                     unset($back[$k]);
//                 }
//             }
//         }
//         return $back;
//     }
    
    /**
     * 获取渠道列表
     * @return array[]
     */
    public function getMyCodeWhere() {
        $back = '';
        $cid_code_arr = $this->getMyCidCode();
        if(!empty($cid_code_arr)) {
            $where = implode("','", $cid_code_arr);
            $back =  " in ( '".$where."') ";
        }
        return $back;
    }
    
    /**
     * 获取渠道列表
     * @return array[]
     */
    public function getMyCidCode() {
        $back = array();
        $my_cid_list = $this->getAdminCidList();
        $tmp  = array();
        foreach ($my_cid_list as $k=>$v) {
            $tmp[] = ' id ='.$v;
        }
        $where = implode(" or ", $tmp);
        $res = DB::table('channel_list')->select('code')->whereRaw($where)->get();
        foreach ($res as $k=>$v) {
            $back[$k] = $v->code;
        }
        return $back;
    }
    
    /**
     * curl模拟GET/POST发送请求
     * @param string $url 请求的链接
     * @param array $data 请求的参数
     * @param string $timeout 请求超时时间
     * @return mixed
     * @since 1.0.1
     */
    public function curl($url, $data = array(), $timeout = 5) {
        $ch = curl_init();
        if (!empty($data) && $data) {
            if(is_array($data)){
                $formdata = http_build_query($data);
            } else {
                $formdata = $data;
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
