<?php
/**
 * 后台配置
 * tpye类型 ：1.网关配置
 * 2.类型配置
 *
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApicfgBaseController extends BaseController {
    /**
     * 配置状态 2为生效的  预留字段  想做缓存用
     * @var integer
     */
    protected $o_status = 2;
    /**
     * 网关配置  的typeid 1
     * @var integer
     */
    protected $cfg_typeid = 1;
    
    /**
     * 是否全部有效
     * @var integer
     */
    protected $is_validall = 1;
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '网关配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'gateway';
    
    /**
     * 全局url
     * @var array
     */
    protected $actions = array(
        'list' => '/setcfg/X/list?page=%s',
        'mod' => '/setcfg/X/mod?page=%s&id=%s',
       // 'del' => '/setcfg/X/del',
        'save' => '/setcfg/X/save',
        'add' => '/setcfg/X/add?page=%s',///lock?uid=%s&flag=%s
    );
    
    /**
     * 初始化action
     * (non-PHPdoc)
     * @see Home_Wxbase_Controller::init()
     */
    function __construct(){
        $act = array();
        foreach($this->actions as $k=>$v) {
            $v = str_replace('X', $this->classname, $v);
            $act[$k] = $v;
        }
        $this->actions = $act;
    }
    
    
    
    /**
     * 取出需要的key_val
     * @param unknown $typeid
     * @return array();
     */
    protected function getKeyVal($list) {
        $key_val = array();
        //过滤查询有效配置信息
        foreach($list as $k => $v) {
            if(isset($v->key_col) && isset($v->val_col)) {
                $key_val[$v->key_col] = $v->val_col;
            }
        }
        return $key_val;
    }
    
    /**
     * 将key拆分成数组
     * @param array $array
     * @return array:
     */
    private function _easyToComplex($array){
        $data = array();
        if(!empty($array)) {
            foreach($array as $k=>$val) {
                $str = '';
                $key = explode('>', $k);
                foreach($key as $ke=>$v) {
                    $str .= '[\''.$v.'\']';
                    
                }
                eval("\$data".$str.'=\''.$val.'\';');
            }
        }
        return $data;
    }
    
    protected function changeToStr($arr,$depth = 0) {
        $str = '';
        if(is_array($arr)){
            $output = array("{\n");
            foreach($arr as $key=>$value){
                array_push($output,$this->getTab($depth+1));
                array_push($output,"[");
                array_push($output,$this->changeToStr($key,NULL));
                array_push($output,"] = ");
                if(is_array($value)) {
                    array_push($output,$this->changeToStr($value,$depth+1));
                }else{
                    array_push($output,$this->changeToStr($value,NULL));
                }
                array_push($output,",\n");
            }
            array_push($output,$this->getTab($depth));
            array_push($output,"}");
            return implode("",$output);
            
        }elseif(is_bool($arr)){
            return $arr ? "true":"false";
        }elseif(is_float($arr)){
            return "$arr";
        }elseif(is_string($arr)){
            return"\"$arr\"";
        }elseif(is_int($arr)){
            return "$arr";
        }else{
            throw new Exception("unknown data type" . gettype($arr));
        }
        
    }
    
    protected function getTab($depth){
        $str = '';
        if(!is_null($depth)) {
            for($i=0;$i < $depth;++$i){
                $str .= '\t';
            }
        }
        return $str;
    }
    
    /**
     * 修改页面
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function mod(Request $request){
        $page = isset($request->page) ? $request->page : 1;
        $id = $request->id;
        $res = DB::table('gamecfg')->where('id', $id)->get();
        
        $back = $_GET;
        $back['res'] = $res;
        $back['page'] = $page;
        $back['pagename'] = $this->pagename;
        $back['actions'] = $this->actions;
        return view('Gamecfg.mod',$back);
    }
    
    /**\
     * 添加页面
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function add(Request $request){
        $page = isset($request->page) ? $request->page : 1;
        $id = $request->id;
        $back = $_GET;
        $back['page'] = $page;
        $back['pagename'] = $this->pagename;
        $back['actions'] = $this->actions;
        return view('Gamecfg.insert',$back);
    }
    
    /**
     * 提交表单处理
     * @param Request $request
     * @return string
     */
    protected function save(Request $request) {
        $modid=(int)$request->modid;
        $data['desc']=$request->desc;
        $data['typeid']=$this->cfg_typeid;
        $data['key_col']=trim($request->key_col);
        $data['val_col']=trim($request->val_col);
        $data['o_status']=2;//默认都是有效的
        $data['memo']=$request->memo;
        $data['o_status'] = $this->is_validall == 1 ? $this->o_status : $request->o_status;
        $data['op_name'] = session('admin')["id"].";".session('admin')["username"];
        $data['op_time'] = date('Y-m-d H:i:s',time());
        if($modid==0){//添加
            $result=DB::table('gamecfg')->insertGetId($data);
            parent::saveLog('添加gamecfg.id--'.$result.'添加key('.$request->key_col.')=>val('.$request->val_col.')');
        }else{ //修改
            $his_obj = DB::table('gamecfg')->where('id', $modid)->get();
            $his_arr = $this->getArray($his_obj);
            if(isset($his_arr[0]['id'])) {
                $record = $this->getWhatIsModify($his_arr[0],$data);
                if(isset($record['op_time']))unset($record['op_time']);
                if(isset($record['op_name']))unset($record['op_name']);
                if(isset($record['id']))unset($record['id']);
            }else{
                $record = $data;
            }
            parent::saveLog('更新gamecfg.id('.$modid.')更新('.http_build_query($record).')');
            //parent::saveLog('更新gamecfg.id('.$modid.')更新key('.$request->key_col.')更新val('.$request->val_col.')');
            $result=DB::table('gamecfg')->where('id', $modid)->update($data);
        }
        if($result){
            exit(json_encode(['status'=>0,'msg'=>'成功']));
        }else{
            exit(json_encode(['status'=>1,'msg'=>'失败']));
        }
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
            $back[$v] = $diff_his[$v]."--".$now_arr[$v];//[被变更的key名]=> "变更之前的值--变更之后的值"
        }
        return $back;
    }
    
    
    /**
     * 删除节点
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function del(Request $request){
        $id=$request->id;
        $tid=$this->cfg_typeid;
        $res=DB::table('gamecfg')->where('id', '=', $id)->delete();
        parent::saveLog('删除节点gamecfg.id--'.$id);
        if($res){
            exit(json_encode(['status'=>1,'msg'=>'删除成功--id='.$id]));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'删除失败']));
        }
    }  
    
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function list(Request $request){
        $page = isset($request->page) ? $request->page : 1;
        $all_cfg = DB::table('gamecfg')->where('typeid', $this->cfg_typeid)->paginate(10);//有分页
        $data =  DB::table('gamecfg')->where('typeid', $this->cfg_typeid)->get();
        $key_val = getKeyVal($data);
        $prev_cfg = easyToComplex($key_val);//原始数组形式
        $lua_arr = changeToStr($prev_cfg);
        $data = array(
            'page' => $page,
            'data' => $all_cfg,
            'arr'=>json_encode($prev_cfg),
            'prev' => highlight_string(print_r($lua_arr, true),true),
            'pagename' => $this->pagename,
            'actions'=>$this->actions,
        );
        return view('Gamecfg.index',$data);
        
    }
    
    
    
}
