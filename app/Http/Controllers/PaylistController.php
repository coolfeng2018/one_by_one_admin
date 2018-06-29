<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaylistController extends BaseController {
    /**
     * 配置状态 2为生效的  预留字段  想做缓存用
     * @var integer
     */
    protected $o_isvalid = 2;
    
    /**
     * 配置说明列表
     * @var array
     */
    protected $cfg_list = array(
        //必配项-start
        'pagename' => '支付列表配置',//页面名称        
        //必配项-end
        
        //上下架状态
        'o_status' => array(
            1 => array('tip' => '不生效','css' => 'label-danger'),//下架 
            2 => array('tip' => '生效','css' => 'label-success')//上架
        ),
        //是否支持手动输入金额0 固定充值 1 自定义充值
        'status' => array(
            0 => array('tip' => '固定充值','css' => ''),
            1 => array('tip' => '自定义充值','css' => '')
        ),
        //支付方式
        'payment_ways' => array(
            'alipay'=> '支付宝',
            'wx'=> '微信',
            'union'=> '银联',
            'qq'=> 'QQ',
            'iap'=> 'ios内支付',
        )
       
    );
    
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function list(Request $request){
        //列表展示
        $where = '1=1 order by o_status DESC';//生效的排在前面        
        $where .= ' , sort_id ASC';//按照位置id升序排列
        //$list = DB::table('paylist')->whereRaw($where)->tosql();
        $list = DB::table('paylist')->whereRaw($where)->paginate(30);

        //组成数组结构显示
        $all_data = DB::table('paylist')->whereRaw($where)->get();
        $all_arr = $this->getArray($all_data);
        $valid_arr = $this->getValid($all_arr);        
        $back  = array(
            'data' => $list,
            'all_prev' => $this->getPrevStr($all_arr),
            'valid_prev' =>$this->getPrevStr($valid_arr),
            'page'=>isset($request->page)&& !empty($request->page) ? $request->page : 1,
            'pagename' => $this->cfg_list['pagename'],
            'cfg_list' => $this->cfg_list
        );
        return view('Paylist.list',$back);
    }
    

    /**
     * 生成展示的字符串
     * @param unknown $arr
     * @return mixed
     */
    public function getPrevStr($arr) {
        return highlight_string(print_r($arr,true),true);
    }
    
    /**
     * 筛选出生效的配置
     * @param unknown $arr
     * @return unknown[]
     */
    public function getValid($arr){
        $back = array();
        foreach ($arr as $k =>$v) {
            if($v['o_status'] == $this->o_isvalid){
                $back[] = $v;
            }
        }
        return $back;
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
     * 修改页面
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function mod(Request $request){
        $page = isset($request->page) && !empty($request->page) ? $request->page : 1;
        $id = $request->id;
        $res = DB::table('paylist')->where('id', $id)->get();
        $back = $_GET;
        $back['page'] = $page;
        $back['res'] = $res;
        $back['pagename'] = $this->cfg_list['pagename'];
        $back['cfg_list'] = $this->cfg_list;
        return view('Paylist.edit',$back);
    }
    
    /**
     * 添加页面
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add(Request $request){
        $page = isset($request->page) && !empty($request->page) ? $request->page : 1;
        $back = $_GET;
        $back['page'] = $page;
        $back['pagename'] = $this->cfg_list['pagename'];
        $back['cfg_list'] = $this->cfg_list;
        return view('Paylist.add',$back);
    }
    
    /**
     * 提交表单处理
     * @param Request $request
     * @return string
     */
    public function save(Request $request) {
        $modid= isset($_GET['modid']) ? $_GET['modid'] : 0;
        $data['name']=isset($_GET['name']) ? trim($_GET['name']) : '';
        $data['payment_channels'] = isset($_GET['payment_channels']) ? trim($_GET['payment_channels']) : '';
        $data['payment_ways'] = isset($_GET['payment_ways']) ? trim($_GET['payment_ways']) : '';
        $data['money_list'] = isset($_GET['money_list']) ? trim($_GET['money_list']) : '';
        $data['status'] = isset($_GET['status']) ? (int)$_GET['status'] : 0;
        $data['udefined_min'] = isset($_GET['udefined_min']) ? (int)$_GET['udefined_min'] : 0;
        $data['udefined_max'] = isset($_GET['udefined_max']) ? (int)$_GET['udefined_max'] : 0;
        $data['memo'] = isset($_GET['memo']) ? trim($_GET['memo']) : '';
        $data['sort_id']=  isset($_GET['sort_id']) ? (int)$_GET['sort_id'] : 0;
        $data['o_status']= isset($_GET['o_status']) ? (int)$_GET['o_status'] : 0;
        $data['op_name'] = "（".session('admin')["id"]."）".session('admin')["username"];
        $data['op_time'] = date('Y-m-d H:i:s',time()); 
        if($modid==0){//添加
            $result=DB::table('paylist')->insertGetId($data);
            parent::saveLog('添加paylist.id--'.$result.'的记录');
        }else{//修改
            $his_obj = DB::table('paylist')->where('id', $modid)->get();
            $his_arr = $this->getArray($his_obj);            
            if(isset($his_arr[0]['id'])) {
                $record = $this->getWhatIsModify($his_arr[0],$data);
                if(isset($record['op_time']))unset($record['op_time']);
                if(isset($record['op_name']))unset($record['op_name']);
                if(isset($record['id']))unset($record['id']);
            }else{
                $record = $data;
            }
            parent::saveLog('更新paylist.id('.$modid.')更新('.http_build_query($record).')');
            $result=DB::table('paylist')->where('id', $modid)->update($data);
        }
        if($result){
            exit(json_encode(['status'=>0,'msg'=>'成功']));
        }else{
            exit(json_encode(['status'=>1,'msg'=>'失败']));
        }
    }
    
    /**
     * 获取被修改信息
     * @param unknown $his_arr
     * @param unknown $now_arr
     * @return string[]
     */
    public function getWhatIsModify($his_arr,$now_arr) {
        $back = array();
        $diff_his = array_diff_assoc($his_arr,$now_arr);
        if(isset($diff_his['op_time']))unset($diff_his['op_time']);
        if(isset($diff_his['op_name']))unset($diff_his['op_name']);
        if(isset($diff_his['id']))unset($diff_his['id']);
        $keys = array_keys($diff_his);
        foreach ($keys as $k => $v) {
            if(isset($now_arr[$v])) {
                $back[$v] = (isset($diff_his[$v]) ? $diff_his[$v] : '')."--".(isset($now_arr[$v]) ? $now_arr[$v] : '');//[被变更的key名]=> "变更之前的值--变更之后的值"
            }
            
        }
        return $back;
    }
    
    
    /**
     * 删除节点
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function del(Request $request){
        $page = isset($request->page) && !empty($request->page) ? $request->page : 1;
        $type = isset($request->type) ? $request->type : '';//todo 上下架
        $id=$request->id;
        $tid=$request->typeid;
        $res=DB::table('gamecfg')->where('id', '=', $id)->delete();
        parent::saveLog('删除节点paylist.id--'.$id);
        if($res){
            exit(json_encode(['status'=>1,'msg'=>'删除成功--id='.$id,'page'=>$page]));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'删除失败','page'=>$page]));
        }
    }
}
