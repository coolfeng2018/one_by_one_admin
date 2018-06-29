<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\AgentRepository;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Redis;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AgentController extends BaseController
{
    protected $agentRepository;
    
    protected $pagenum = 30;//每页条数
    /**
     * 动作列表
     * @var array
     */
    protected $actions = array(
        'index' =>'/agent/index',
        'add' => '/agent/add',
        'save' => '/agent/save',
        'update' => '/agent/update',
        'level' => '/agent/level',
        'user' => '/agent/user',
        'delete' => '/agent/delete',
    );
    /**
     * 代理等级
     * @var array
     */
    protected $agent_level = array(
        1=>'一级代理',
        2=>'二级代理',
        3=>'三级代理',
    );
    /**
     * 状态值 1可用2禁用
     * @param AgentRepository $agentRepository
     */
    protected $u_status = array(
        1=>'可用',
        2=>'禁用'
    );

    function __construct(AgentRepository $agentRepository){
        $this->agentRepository=$agentRepository;
    }
    /**
     * 代理列表
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $param['stime'] = isset($_GET['stime']) ? $_GET['stime'] : '';
        $param['etime'] = isset($_GET['etime']) ? $_GET['etime'] : '';
        $param['agentname'] = isset($_GET['agentname']) ? $_GET['agentname'] : '';
        
        $param['mobile'] = isset($_GET['mobile']) ? $_GET['mobile'] : '';
        $param['uid'] = isset($_GET['uid']) ? $_GET['uid'] : '';
        $param['agentid'] = isset($_GET['agentid']) ? $_GET['agentid'] : '';
        $param['status'] = isset($_GET['status']) ? $_GET['status'] : 0;
        
        $param['parentid'] = isset($_GET['parentid']) ? $_GET['parentid'] : '';
        //$results = $this->agentRepository->info($param);
        DB::statement('call sp_show_agent_nodes(0)');
        $select  = "A.*,B.*,(SELECT COUNT(*) FROM tmp_agents_depth_parent AS b1 WHERE FIND_IN_SET(A.AgentId,b1.plist)) AS num_all,(select COUNT(*) from agents as s1 where s1.ParentId = A.AgentId) as num";
        $select .= ",(select COUNT(*) from agent_third_auth as s2 where s2.AgentId = A.AgentId) as players";

        $where = 'A.AgentId=B.id';
        //代理昵称
        if($param['agentname']) {
            $where .= " and AgentName='".$param['agentname']."'";
        } 
        //创建时间区间
        if($param['stime']) {
            $where .= " and CreateAt>='".$param['stime']."'";
        }
        if($param['etime']) {
            $where .= " and CreateAt<='".$param['etime']."'";
        } 
        
        //代理ID
        if($param['agentid']) {
            $where .= ' and AgentId='.(int)$param['agentid'];
        }
        //代理状态
        if($param['status']) {
            $where .= ' and Status='.(int)$param['status'];
        }
        //代理的游戏id
        if($param['uid']) {
            $where .= ' and UserId='.(int)$param['uid'];
        }
        //代理手机号
        if($param['mobile']) {
            $where .= ' and Telephone='.(int)$param['mobile'];
        }
        
        //上级的代理ID
        if($param['parentid']) {
            $where .= ' and ParentId='.(int)$param['parentid'];
        }
        $where .= ' ORDER BY A.AgentId DESC';//按照位置id升序排列
        //$results = DB::table(DB::raw('agents A LEFT JOIN tmp_agents_depth_parent B ON A.AgentId=B.id'))->selectRaw($select)->whereRaw($where)->tosql();  
        //var_dump($results);exit;
        $results = DB::table(DB::raw('agents A LEFT JOIN tmp_agents_depth_parent B ON A.AgentId=B.id'))->selectRaw($select)->whereRaw($where)->paginate(30);  

        $data = $_GET;
        $data['actions'] = $this->actions;
        $data['agent_level'] = $this->agent_level;
        $data['u_status'] = $this->u_status;
        
        $data['search'] = $param;

        $data['res'] = $results;
        $data['url'] = env('PORJECT_ONE_BY_ONE_API').config('gamecfg.qr_content_url');
        $data['nowurl'] = isset($_GET['_url']) ? urlencode($_GET['_url'].'?page='.$page.'&'.http_build_query($param)) : '';
        return view('Agent.index',$data);
    }
    
    /**
     * 补齐二维码
     * @param unknown $obj_list
     */
    public function qr($obj_list) {
        foreach ($obj_list as $k =>$v) {
            if(!isset($v->QRCodeUrl) || empty($v->QRCodeUrl)) {
                $this->qrCodeInfo($v->id); 
            }
        }
    }
    
    /**
     * 添加代理
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add(){
        $data = $_GET;
        $data['actions'] = $this->actions;
        $data['agent_level'] = $this->agent_level;
        $data['u_status'] = $this->u_status;
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        return view('Agent.add',$data);
    }
    /**
     * 修改代理信息
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function update(Request $request){
        $id = $request->id;
        $results=DB::table('agents')->where('AgentId', $id)->get();
        $data = $_GET;
        $data['actions'] = $this->actions;
        $data['agent_level'] = $this->agent_level;
        $data['u_status'] = $this->u_status;
        $data['res'] = $results;
        //得到最大的时间
        return view('Agent.update',$data);
    }
    
    /**
     * 转换成数组
     * @param unknown $data
     * @return array[]
     */
    public function getArray($data) {
        $back = array();
        if(is_object($data)){
            $data = $data->toArray();
            foreach ($data as $k =>$v) {
                $back[$k]=(array)$v;
            }
        }
        return $back;
    }  
    
    /**
     * 保存添加、修改数据
     * @param Request $request
     * @return unknown
     */
    public function save(Request $request){  
        $id = $request->agentid;//代理ID 编辑
        $data['AgentName'] = $request->agentname;//代理昵称
        $data['Telephone'] = $request->mobile;//代理电话
        $data['Status'] = $request->status;//代理状态 1正常 2禁用
        $data['Ratio'] = $request->ratio;//代理提成比率
        $data['Password'] = isset($request->pwd) && !empty($request->pwd) ? md5($request->pwd) : '';//代理密码
        $data['UserId'] = $request->uid;//代理的玩家id

        $data['UpdateAt'] = date('Y-m-d H:i:s',time());
        $data['AdminName'] = session('admin')['username'];//管理员 
               
        //手机号格式
        if(!preg_match('/^1[34578]\d{9}$/', $data['Telephone'])){
            exit(json_encode(['status'=>3,'msg'=>'手机号码格式有误']));
        }
        //手机号是否唯一
        if($this->checkTelExist($data['Telephone'],$id) == false) {
            exit(json_encode(['status'=>3,'msg'=>'手机号码已经存在，请检查']));
        }
        
        //判断输入的玩家uid是否已是代理
        if($this->checkUidExistLevel($data['UserId']) == false) {
            exit(json_encode(['status'=>3,'msg'=>'玩家uid已经是下级代理，请检查']));
        }
        
        //判断输入的玩家uid是否已是下级玩家  
        if($this->checkUidExistUser($data['UserId']) == false) {
            exit(json_encode(['status'=>3,'msg'=>'玩家uid已经是下级玩家，请检查']));
        }
         
        
        //分成比例
        if($data['Ratio']>=100 || $data['Ratio']<0) {
            exit(json_encode(['status'=>3,'msg'=>'分成比例超出范围，请检查']));
        }
        $username = $this->getUserNick($data['UserId']);
        //查找用户的用户昵称， 查不到就使不存在这个用户
        if(empty($username)) {
            exit(json_encode(['status'=>3,'msg'=>'玩家uid不存在，请检查']));
        }
        if($id) {//修改
            $his_obj = DB::table('agents')->where('AgentId', $id)->first();
            $his_arr = (array)$his_obj;
            if(isset($his_arr['AgentId'])) {
                if(empty($data['Password'])){
                    $data['Password'] = $his_arr['Password'];
                }
                $record = $this->getWhatIsModify($his_arr,$data);
            }else{
                $record = $data;
            }
            parent::saveLog('更新agents.AgentId('.$id.')更新('.$record.')');
            $result=DB::table('agents')->where('AgentId', $id)->update($data);
            
        }else{//添加
            if(empty($data['Password'])){
                exit(json_encode(['status'=>3,'msg'=>'密码不能为空']));
            }
            $result = DB::table('agents')->insertGetId($data);
//             //生成二维码
//             $this->qrCodeInfo($result); 
//             if($result) {
//                 $add = $this->addThirdAuth($result, $data['UserId'], $username);//添加代理关系
                
//             }
            parent::saveLog('添加代理id--'.$result.'=>'.json_encode($data));
            
        }
        if($result){
            $this->wlog('agents  data:'.json_encode($data).'  res:'.$result,'db_err');
            exit(json_encode(['status'=>0,'msg'=>'成功']));
        }else{
            $this->wlog('agents  data:'.json_encode($data).'  res:'.$result,'db');
            exit(json_encode(['status'=>4,'msg'=>'修改失败']));
        }
        
    }
    
    /**
     * 添加代理绑定关系
     * @param unknown $agentid
     * @param unknown $uid
     * @param unknown $uname
     * @return unknown
     */
    public function addThirdAuth($agentid,$uid,$uname) {
        $data = array(
            'ThirdId' => ' ',
            'ThirdUnionId' => $uid,
            'UserId' => $uid,
            'Nickname' => $uname,
            'AgentId' =>$agentid 
        );
        $res = DB::table('agent_third_auth')->insertGetId($data);        
        if($res) {
            parent::saveLog('添加代关系agent_third_auth.id--'.$res.'=>'.json_encode($data));
            $this->wlog('agent_third_auth  data:'.json_encode($data).'  res:'.$res,'db');
        }else{
            $this->wlog('agent_third_auth  data:'.json_encode($data).'  res:'.$res,'db_err');
        }
        return $res;
    }
    

    
    /**
     * 判断下级代理UID是否存在
     * @param unknown $uid
     * @param number $agentid
     * @return boolean
     */
    public function checkUidExistLevel($uid) {
        $back = false;
        $where = 'UserId = '.$uid;

        $is_exist = DB::table('agents')->whereRaw($where)->count();
        if($is_exist==0){
            $back = true;
        }
        return $back;
    }
    
    /**
     * 判断下级玩家UID是否存在
     * @param unknown $uid
     * @param number $agentid
     * @return boolean
     */
    public function checkUidExistUser($uid) {
        $back = false;
        $where = 'UserId = '.$uid;

        $sql = 'select * from agent_third_auth where UserId='.$uid;
        $is_exist = DB::select($sql);
        //isset($re[0]->AgentId) && $re[0]->AgentId
        if(empty($is_exist)){
            $back = true;
        }
        return $back;
    }
    
    /**
     * 判断手机号是否存在
     * @param unknown $tel
     * @param number $agentid
     * @return boolean
     */
    public function checkTelExist($tel,$agentid = 0) {
        $back = false;
        $where = 'Telephone = '.$tel;
        if($agentid) {
            $where .= ' and AgentId != '.$agentid;
        }
        $is_exist = DB::table('agents')->whereRaw($where)->count();
        if($is_exist==0){
            $back = true;
        }
        return $back;
    }
    
    /**
     * 查询下级代理信息
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function level(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $param['pid'] = isset($_GET['pid']) ? $_GET['pid'] : '';
        $param['uid'] = isset($_GET['uid']) ? $_GET['uid'] : '';
        $param['stime'] = isset($_GET['stime']) ? $_GET['stime'] : '';
        $param['etime'] = isset($_GET['etime']) ? $_GET['etime'] : '';
        DB::statement('call sp_show_agent_nodes('.$param['pid'].')');
        $select = 'aou.*,B.depth,B.plist';
        $from  = 'tmp_agents_depth_parent B';
        $from .= ' LEFT JOIN (SELECT ao.* ,SUM(U.Round) AS num';
        $from .= ' FROM';
        $from .= '   (SELECT A.*,SUM(O.amount) AS amount';
        $from .= '    FROM agents A LEFT JOIN orders O ON A.UserId = O.uid';
        $from .= '    GROUP BY A.AgentId ) ao';
        $from .= ' LEFT JOIN user_game U ON ao.UserId = U.UserId';
        $from .= ' GROUP BY ao.AgentId ) aou ON aou.AgentId = B.id';
        $where  = ' where 1=1';
        if(!empty($param['uid'])) {
            $where .= ' and aou.UserId='.(int)$param['uid'];
        }
        if(!empty($param['stime'])) {
            $where .= " and aou.CreateAt>='".$param['stime']."'";
        }
        if(!empty($param['etime'])) {
            $where .= " and aou.CreateAt<='".$param['etime']."'";
        }
        $from  .= $where;
        $from  .= ' order by B.depth asc ,aou.AgentId desc';
        //$res = DB::table(DB::raw($from))->selectRaw($select)->paginate(30);
        $db_obj = DB::table(DB::raw($from))->selectRaw($select);
        $sql = $db_obj->tosql();
        $res = $db_obj->paginate($this->pagenum);//
        $res_total = DB::select('select count(AgentId) as totalnum from ( '.$sql.' ) as n');
        $total = isset($res_total[0]->totalnum) ? $res_total[0]->totalnum : 1;//记录总条数
        $perPage = $this->pagenum; //每页的记录数
        $current_page = $page; // 当前页
        $path = Paginator::resolveCurrentPath(); // 获取当前的链接"http://localhost/admin/account"
        $data = $_GET;
        $data['paginator'] = new LengthAwarePaginator($res, $total,$perPage, $current_page, [
            'path' => $path ,  //设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
            'pageName' => 'page', //链接的参数名 http://localhost/admin/manage?page=2
        ]);
        
        

        $data['actions'] = $this->actions;
        $data['agent_level'] = $this->agent_level;
        $data['u_status'] = $this->u_status;
        $data['res'] = $res;
        $data['search'] = $param;
        return view('Agent.level',$data);
    }
    
    
    /**
     * 查询下级玩家信息
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function user(){   
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $param['aid'] = isset($_GET['aid']) ? $_GET['aid'] : '';
        $param['uid'] = isset($_GET['uid']) ? $_GET['uid'] : '';
        $param['stime'] = isset($_GET['stime']) ? $_GET['stime'] : '';
        $param['etime'] = isset($_GET['etime']) ? $_GET['etime'] : '';
        
        
        $select = 'third_2.*,SUM(u.Round) AS num  ';
        $from  = '  	(SELECT third.*, SUM(o.amount) AS amount ';
        $from .= ' 	    FROM agent_third_auth third ';
        $from .= ' 	    LEFT JOIN orders o ON o.uid = third.UserId';
        $from .= ' 	    GROUP BY third.ThirdAuthId) third_2 ';
        $from .= ' LEFT JOIN user_game u ON third_2.UserId = u.UserID';
        
        $where = '1=1 ';
        if(!empty($param['aid'])) {
            $where .= ' and third_2.AgentId='.(int)$param['aid'];
        }
        if(!empty($param['uid'])) {
            $where .= ' and third_2.UserId='.(int)$param['uid'];
        }
        if(!empty($param['stime'])) {
            $where .= " and third_2.CreateTime>='".$param['stime']."'";
        }
        if(!empty($param['etime'])) {
            $where .= " and third_2.CreateTime<='".$param['etime']."'";
        }

        $where.= ' GROUP BY third_2.ThirdAuthId';
        $db_obj = DB::table(DB::raw($from))->selectRaw($select)->whereRaw($where);
        $sql = $db_obj->tosql();
        $res = $db_obj->paginate($this->pagenum);//paginate(2)
        
        
        $res_total = DB::select('select count(ThirdAuthId) as totalnum from ( '.$sql.' ) as n');
       
        $total = isset($res_total[0]->totalnum) ? $res_total[0]->totalnum : 1;//记录总条数
        $perPage = $this->pagenum; //每页的记录数
        $current_page = $page; // 当前页
        $path = Paginator::resolveCurrentPath(); // 获取当前的链接"http://localhost/admin/account"
        $data = $_GET;
        $data['paginator'] = new LengthAwarePaginator($res, $total,$perPage, $current_page, [
            'path' => $path ,  //设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
            'pageName' => 'page', //链接的参数名 http://localhost/admin/manage?page=2
        ]);
        $data['actions'] = $this->actions;
        $data['agent_level'] = $this->agent_level;
        $data['u_status'] = $this->u_status;
        $data['res'] = $res;
        $data['search'] = $param;

        return view('Agent.user',$data);
    }
    
    

    protected function belongToAgent($userId='',$ThirdUnionId=''){
        if(empty($userId)){
            return false;
        }
        $data = DB::table('agent_third_auth')->where('UserId','=',$userId)->first();
        if(!$data){
            if(empty($ThirdUnionId)){
                return false;
            }
            $data = DB::table('agent_third_auth')->where('ThirdUnionId','=',$ThirdUnionId)->first();
            if($data){
                return $data;
            }
            return false;
        }
        return $data; 
    }


    /**
    * 提成明细
    * @param AgentId
    */
    public function commissionDetail(){
        $param['aid']=$_GET['aid']??'';
        $param['type']=$_GET['type']??'';
        $param['stime']=$_GET['stime']??'';
        $param['etime']=$_GET['etime']??'';

 

        if($param['aid']){
            $res=$this->agentRepository->agentDetail($param); 
            $commission = $this->agentRepository->commission($param);
            return view('Agent.commission_detail ',['res'=>$res,'search'=>$param,'commission'=>$commission]);
        }else{
            echo '参数丢失';
        }
    }


    /**
    * 下级玩家消耗日志
    * @param AgentId
    */
    public function playerConsume(){
        $param['aid']=$_GET['aid']??'';
        $param['type']=$_GET['type']??'';
        $param['stime']=$_GET['stime']??'';
        $param['etime']=$_GET['etime']??'';

        // md5($time . '515^#' . $agent_uid)
 

        if($param['aid']){
            $res=$this->agentRepository->agentDetail($param); 
            $commission = $this->agentRepository->commission($param);
            return view('Agent.consume ',['res'=>$res,'search'=>$param,'commission'=>$commission]);
        }else{
            echo '参数丢失';
        }
    }


    protected function objectToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }


    //生成二维码
    protected function qrCodeInfo($agentId){
        error_log('in');
        //生成二维码
        $tmpPath=$this->CreateQrCode($agentId);
       
        //上传资源服务器
        $filePath=$this->uploadFile($tmpPath,'qrcode');

        //更新数据库
        $data['QRCodeUrl']=config('gamecfg.img_url').$filePath;
        error_log('up');
        $result = DB::table('agents')->where('AgentId', $agentId)->update($data);
        error_log($result);
        error_log('upend');
    }

    //生成二维码
    private function CreateQrCode($agentId){
        $jumpto_url = env('PORJECT_ONE_BY_ONE_API').config('gamecfg.qr_content_url');
        $jumpto_url = sprintf($jumpto_url,$agentId);
        $tmpPath=public_path().'/uploads/qrcode/'.$agentId.'hs'.'.png';

//        p($qrUrlInfo);p($tmpPath);die;
//        QrCode::format('png')->size(200)->encoding('UTF-8')->generate($qrUrlInfo,$tmpPath);

        QrCode::format('png')
            ->size(200)
            ->merge(public_path().'/uploads/suit.png',.1,true)
            ->encoding('UTF-8')
            ->generate($jumpto_url,$tmpPath);
        return $tmpPath;
    }
    //无页面上传
    private function uploadFile($tmpFile,$fileType)
    {
        $resourceUpload=config('gamecfg.img_upload_server');
        $client=new Client();
        $response=$client->post($resourceUpload,['multipart'=>[['name'=>'file','contents'=>fopen($tmpFile,'r')],['name'=>'type','contents'=>$fileType]]]);
        if($response->getStatusCode()==200)
        {
            $result=$response->getBody();
            $result=json_decode($result);
            if($result->status==200)
            {
                unlink($tmpFile);
                return $result->data->filePath;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
