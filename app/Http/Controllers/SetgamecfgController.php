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


class SetgamecfgController extends BaseController {
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
     * 查询的key
     * @var array
     */
    protected $keys_obj = array();
    
    /**
     * 是否展示选择器
     * @var string
     */
    protected $show_slider = false;
    
    /**
     * 添加时的提示信息
     * @var array
     */
    protected $tips_col = array(
        'desc'=> array('color'=>'', 'tip'=>'描述信息 /配置名称 '),
        'key_col'=> array('color'=>'', 'tip'=>'用>分割例： ucode>ios>ver'),
        'val_col'=> array(
            array('color'=>'', 'tip' => '多个可用英文分号切割; 如：5,10;15,20;25,30;35,40 或者{2,10,3};{2,10,3};{2,10,3}')
        ),
        'memo'=>array(
            array('color'=>'font-red-mint', 'tip' => '不需要填写此项 此项供开发配置 ')
        )
    );
    
    /**
     * 全局url
     * @var array
     */
    protected $actions = array(
        //'list' => '/setcfg/X/list?page=%s&filter=%s',
        'list' => '/setcfg/X/list?page=%s&filter=%s',
        'mod' => '/setcfg/X/mod?page=%s&modid=%s&filter=%s',
        'del' => '/setcfg/X/del',
        'save' => '/setcfg/X/save',
        'add' => '/setcfg/X/add?page=%s&filter=%s&key_col=%s',///lock?uid=%s&flag=%s
        //'multi_list'=>'/setcfg/X/multi_list',
        'multi_save'=>'/setcfg/X/save',
        'down' => '/setcfg/X/downlua',
    );
    
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'first_tab'=> array('key_col'=>'first_tab' ,'name'=>'房间ID'),
        'name'=> array('key_col'=>'name' ,'name'=>'场次名称'),
        'min'=> array('key_col'=>'min' ,'name'=>'进场最小限制'),
        'max'=> array('key_col'=>'max' ,'name'=>'进场最大限制'),
        'dizhu'=> array('key_col'=>'dizhu' ,'name'=>'底注'),
        'dingzhu'=> array('key_col'=>'dingzhu' ,'name'=>'顶注'),
        'cost'=> array('key_col'=>'cost' ,'name'=>'台费'),
        'open_robot'=> array('key_col'=>'open_robot' ,'name'=>'是否开放机器人'),
        'robot_type'=> array('key_col'=>'robot_type' ,'name'=>'机器人类型'),
        
        'max_look_round'=> array('key_col'=>'max_look_round' ,'name'=>'最大看牌轮数'),
        'comparable_bet_round'=> array('key_col'=>'comparable_bet_round' ,'name'=>'最大可比轮数'),
        'max_bet_round'=> array('key_col'=>'max_bet_round' ,'name'=>'可比轮数'),
        'img_bg'=> array('key_col'=>'img_bg' ,'name'=>'底图名'),
        'img_icon'=> array('key_col'=>'img_icon' ,'name'=>'标识图片名'),
        
        
    );
    
    /**
     * 初始化action
     * (non-PHPdoc)
     * @see Home_Wxbase_Controller::init()
     */
    public function __construct(){
        $act = array();
        foreach($this->actions as $k=>$v) {
            $v = str_replace('X', $this->classname, $v);
            $act[$k] = $v;
        }
        $this->actions = $act;
        $this->keys_obj = $this->getKeysByDB();
    }
    
    
    
    /**
     * 取出需要的key_val
     * $colname 为列名
     * @param unknown $typeid
     * @return array();
     */
    protected function getKeyVal($list,$colname = '') {
        $key_val = array();
        //过滤查询有效配置信息
        foreach($list as $k => $v) {
            if(isset($v->key_col) && isset($v->val_col)) {
                if($colname == '') {
                    $key_val[$v->key_col] = $v;
                }else{
                    $key_val[$v->key_col] = $v->$colname;
                }
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
    
    protected function changeToStr($val,$depth = 0) {
        if(is_array($val)){//为Null的不展示
            $str = "{\n";//todo '' 
            foreach($val as $key=>$value){
                $str .= $this->getTab($depth+1);//缩进  
                if(is_string($key)) {
                    $str .= "[".$this->changeToStr($key,NULL)."] = ";//组装key
                }elseif (is_int($key)){//&& $depth==0
                    $str .= "[".$key."] = ";//组装key
                }
                if(is_array($value)) {
                    ksort($value);//按字典排序
                    $str .= $this->changeToStr($value,$depth+1);//数组层进递归
                }elseif(strpos($value,';')){
                    $arr = explode(";",$value);
                    //lua的数组都是从1开始的， 将从0开始的数组转为从1开始
                    $value = array();
                    foreach($arr as $key=>$val){
                        $value[$key+1] = $val;
                    }
                    $str .= $this->changeToStr($value,$depth+1);//数组层进递归
                }else{
                    $str .= $this->changeToStr($value,NULL);//组装val的值
                }
                $str .= ",\n";
            }
            $str .= getTab($depth);
            $str .= "}";
            return $str;
        }elseif(is_bool($val)){ 
            return $val ? "true":"false";
        }elseif(is_float($val)){
            return "$val";
        }elseif(is_string($val)){
            //对于val_col里如 {-1000000000000000000, 9999999, 50}这样的元素进行 处理
            if(preg_match("/^\{[0-9\-][0-9\, \-]*[0-9\-]\}$/",$val)) {            
                return "$val";
            }
            if(preg_match("/^\{.*\}$/",$val)) {
                
                return "$val";
            }
            //对于浮点型进行处理
            if(preg_match("/^[0-9\.]+$/",$val)) {
                return "$val";
            }
            //对于布尔进行处理
            if($val == 'true'){
                return "true";
            }
            
            if($val == 'false'){
                return "false";
            }
            if(preg_match("/^\d*$/",$val)) {
                $val = (int)$val;
                return "$val";
            }

            return"\"$val\"";
        }elseif(is_int($val)){
            return "$val";
        }else{
            return "unknown data type";
        }
        
        
    }
    
    /**
     * 获取缩进距离
     * @param unknown $depth
     * @return string
     */
    protected function getTab($depth){
        $str = '';
        if(!is_null($depth)) {
            for($i=0;$i < $depth;++$i){
                $str .= "\t";
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
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $page = isset($request->page) ? $request->page : 1;
        $id = $request->modid;
        $res = DB::table('gamecfg')->where('id', $id)->get();        
        $back = $_GET;
        
        $back['res'] = $res;
        $back['filter'] = $filter;
        $back['page'] = $page;
        $back['pagename'] = $this->pagename;
        $back['actions'] = $this->actions;
        $back['tips_col'] = $this->tips_col;
        return view('Gamecfg.mod',$back);
    }
    
    /**\
     * 添加页面
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function add(Request $request){
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $key = isset($_GET['key_col']) ? $_GET['key_col'] : '';
        $page = isset($request->page) ? $request->page : 1;
        $id = $request->id;
        $back = $_GET;
        $back['page'] = $page;
        $back['filter'] = $filter;
        $back['pagename'] = $this->pagename;
        $back['actions'] = $this->actions;
        $back['tips_col'] = $this->tips_col;
        return view('Gamecfg.insert',$back);
    }
    
    /**
     * 提交表单处理
     * @param Request $request
     * @return string
     */
    protected function save(Request $request) {
        $modid= isset($_POST['modid']) ? $_POST['modid'] : 0;
        $data['desc']=isset($request->desc) ? $request->desc : '';
        $data['typeid']=$this->cfg_typeid;
        $data['key_col']=trim($request->key_col);
        $data['val_col']=trim($request->val_col);
        $data['memo']=isset($request->memo) ? $request->memo : '';
        $o_status = isset($request->o_status) ? $request->o_status : 1;
        $data['o_status'] = $this->is_validall == 1 ? $this->o_status : $o_status;
        $data['op_name'] = session('admin')["id"].";".session('admin')["username"];
        $data['op_time'] = date('Y-m-d H:i:s',time());
        if($modid==0){//添加  TODO
            $result=DB::table('gamecfg')->insertGetId($data);
            parent::saveLog('添加gamecfg.id--'.$result.'添加key('.$request->key_col.')=>val('.$request->val_col.')');
            if(!$result){
                $this->wlog('addfail tablename:gamecfg  data:'.http_build_query($data).'  res:'.$result,'db_err');
            }else{
                $this->wlog('add tablename:gamecfg  data:'.http_build_query($data).'  res:'.$result,'db');
            }
        }else{ //修改
            $his_obj = DB::table('gamecfg')->where('id', $modid)->get();
            $his_arr = $this->getArray($his_obj);
            if(isset($his_arr[0]['id'])) {
                $record = $this->getWhatIsModify($his_arr[0],$data);
            }else{
                $record = $data;
            }
            parent::saveLog('更新gamecfg.id('.$modid.')更新('.$record.')');
            $result=DB::table('gamecfg')->where('id', $modid)->update($data);
            if(!$result){
                $this->wlog('modfail tablename:gamecfg  data:'.$record.'  res:'.$result,'db_err');
            }else{
                $this->wlog('mod tablename:gamecfg  data:'.$record.'  res:'.$result,'db');
            }
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
     * 删除节点
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function del(Request $request){
        $id=$request->id;
        $tid=$this->cfg_typeid;
        $his_obj = DB::table('gamecfg')->where('id', $id)->get();
        $his_arr = $this->getArray($his_obj);
        $keyname = isset($his_arr[0]['key_col']) ? $his_arr[0]['key_col'] :'';
        $res=DB::table('gamecfg')->where('id', '=', $id)->delete();
        parent::saveLog('删除节点gamecfg.id--'.$id.",key_col=(".$keyname.")");
        if($res){
            $this->wlog('del tablename:gamecfg  data:'.$id.'  res:'.$res,'db');
            exit(json_encode(['status'=>1,'msg'=>'删除成功--id='.$id]));
        }else{
            $this->wlog('delfail tablename:gamecfg  data:'.$id.'  res:'.$res,'db_err');
            exit(json_encode(['status'=>0,'msg'=>'删除失败']));
        }
    }
    
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function list(Request $request){
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $page = isset($request->page) ? $request->page : 1;
        //所有配置
        $where = 'typeid='.$this->cfg_typeid.' and o_status='.$this->o_status;
        $all_cfg = DB::table('gamecfg')->whereRaw($where)->paginate(10);//有分页 
        //生效配置 字符串
        $lua_str = $this->getValidConfString();
        $data = array(
            'page' => $page,
            'filter' => $filter,
            'data' => $all_cfg,
            'prev' => highlight_string(print_r($lua_str, true),true),
            'pagename' => $this->pagename,
            'actions'=>$this->actions,
            
        );
        //TODO 想加个筛选框
//         if($this->show_slider == true){
//             $data['keys'] = $this->getSelectKey();
//         } 
        return view('Gamecfg.index',$data);
        
    }
    
    
    /**
     * 用>分割key组成数组
     * @param array $array
     * @return array:
     */
    public function multiEasyToComplex($array){ 
        $data = array();        
        if(!empty($array)) {
            foreach($array as $k=>$val) {
                if(is_object($val)) $val = (array)$val;               
                $str = '';
                $key = explode('>', $k);
                foreach($key as $ke=>$v) {                    
                    $str .= '[\''.$v.'\']';
                }
                if(is_array($val)){
                    eval("\$data".$str."=\$val;");
                   
                }else{
                    eval("\$data".$str.'=\''.$val.'\';');
                }                
            }
        }
        return $data;
    }
    
    /**
     * 组装成展示需要的格式
     * @param unknown $list
     * @return array
     */
    public function getAllShowArr($list) { 
        $tabs = array();
        $back = array();
        foreach ($list as $k=>$v){
            foreach ($v as $kvol=>$vvol) {
                $tabs[$kvol] = array('key_col'=>$kvol,'name'=>$kvol);
                $arr_dim = $this->getmaxdim($vvol);//数组维度
                if (isset($vvol['val_col'])) {
                    if(strpos($vvol['val_col'],';')) {
                        $arr = explode(";", $vvol['val_col']);
                        $v_arr = array();
                        foreach ($arr as $kk=>$vv) {
                            $v_arr[$kk+1] = $vv;
                        }
                        $temp = $this->changeToStr($v_arr);
                        $back[$k][$kvol] = array('type'=>'arr','str'=>highlight_string($temp,true));
                    }else{
                        $back[$k][$kvol] = $vvol;
                    }
                }elseif (!isset($vvol['val_col']) && is_array(current($vvol)) ) {
                    if($arr_dim == 2) {
                        $arr = $this->getNeedArr($vvol);
                        $temp = $this->changeToStr($arr);
                        $back[$k][$kvol] = array('type'=>'arr','str'=>highlight_string($temp,true));
                    }elseif ($arr_dim == 3) {
                        $arr = $this->getNeedArr($vvol,3);
                        $temp = $this->changeToStr($arr);
                        $back[$k][$kvol] = array('type'=>'arr','str'=>highlight_string($temp,true));
                    }
                    
                }
            }
        }
        return array('list'=>$back,'tabs'=>$tabs);
    }
    
    
    /**
     * 判断数组是几维数组
     * @param unknown $vDim
     * @return number
     */
    public function getmaxdim($arr){
        if(!is_array($arr)){
            return 0;
        } else {
            $max = 0;
            foreach($arr as $item) {
                $t = $this->getmaxdim($item);
                if( $t > $max) $max = $t;
            }
            return $max + 1;
        }
    }
    /**
     * 组成二级页需要的数组格式
     * @param array $list
     * @return array
     */
    public function getOneShowArr($list) { //暂时没用
        
        $tabs = array();
        $back = array();
        foreach ($list as $k=>$v){
            foreach ($v as $kvol=>$vvol) {
                $tabs[$kvol] = array('key_col'=>$kvol,'name'=>$kvol);
                if (isset($vvol['val_col'])) {
                    if(strpos($vvol['val_col'],';')) {
                        $arr = explode(";", $vvol['val_col']);
                        $v_arr = array();
                        foreach ($arr as $kk=>$vv) {
                            $v_arr[$kk+1] = $vv;
                        }
                        $temp = $this->changeToStr($v_arr);
                        $back[$k][$kvol] = array('type'=>'arr','str'=>highlight_string($temp,true));
                    }else{
                        $back[$k][$kvol] = $vvol;
                    }
                }elseif (!isset($vvol['val_col']) && is_array(current($vvol)) ) {
                    $arr = $this->getNeedArr($vvol);
                    $temp = $this->changeToStr($arr);
                    $back[$k][$kvol] = array('type'=>'arr','str'=>highlight_string($temp,true));
                }
            }
        }
        return array('list'=>$back,'tabs'=>$tabs);
        
    }
    
    /**
     * 获取需要的数组
     * @param unknown $arr
     * @return array
     */
    public function getNeedArr_bak($arr,$arr_dim = 2) {
        if($arr_dim == 3){
            $back = array();
            if(is_array($arr)) {
                foreach($arr as $key =>$val) {
                    //var_dump($key,$val);exit;
                    if(isset($val['val_col'])){
                        $back[$key] = $val['val_col'];
                    }
                }
            }
            return $back;  
        }else{
            $back = array();
            if(is_array($arr)) {
                foreach($arr as $key =>$val) {
                    if(isset($val['val_col'])){
                        $back[$key] = $val['val_col'];
                    }
                }
            }
            return $back;  
        } 
    }
    
    /**
     * 获取需要的数组
     * @param unknown $arr
     * @return array
     */
    public function getNeedArr($arr,$arr_dim = 2) {
        if(!is_array($arr)){
            return array();
        } else {
            $back = array();
            foreach($arr as $item=>$item_val) {
                if(isset($item_val['val_col'])){
                    $back[$item] = $item_val['val_col'];
                }else{
                    $t = $this->getNeedArr($item_val,$arr_dim-1);
                    if(!empty($t)){
                        $back[$item] = $t;
                    }
                }
            }
            return $back;
        }
  
    }
    /**
     * 发送配置
     * @param Request $request
     */
    protected function sndcfg(Request $request) {
        $cfgname = $this->classname;
        if(isset($request->act) && $request->act == 'do') {
            if(empty($cfgname)) {
                exit(json_encode(['status'=>3,'msg'=>'miss 参数']));
            }else{
                $lua_str = $this->getValidConfString();
                $res = $this->doUpload($cfgname,$lua_str);
                exit(json_encode($res)); 
            }        
        }
        exit(json_encode(['status'=>3,'msg'=>'发送失败~~~！']));
    }
    
    /**
     * 获取配置的不同的key
     * @return array;
     */
    protected function getSelectKey() {      
        foreach ($this->keys_obj as $k =>$v) {
           $arr = explode('>', $v->key_col);
           if(isset($arr[0]) && !empty($arr[0])) {
               $keys[$arr[0]] = array('key'=>$arr[0],'desc'=>$v->desc);
           }
        }
        return $keys;
    } 

    
    /**
     * 从数据库查询
     * @return unknown
     */
    protected function getKeysByDB() {
        $where = 'typeid='.$this->cfg_typeid;
        return DB::table('gamecfg')->select(['key_col','desc'])->whereRaw($where)->get();//有分页  'typeid', $this->cfg_typeid
    }
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function multi_list(Request $request){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $page = isset($_G['page']) ? $_GET['page'] : 1;
        $tipmsg = isset($_GET['tipmsg']) ? $_GET['tipmsg'] : '';
        $where = 'typeid='.$this->cfg_typeid.' and o_status='.$this->o_status;
        if(!empty($filter)) {//二级
            $where = $where.' and key_col like "'.$filter.'>%"';
        }
        $res =  DB::table('gamecfg')->whereRaw($where)->get();
        $key_val = $this->getKeyVal($res);
        //组成展示的列表
        $list_cfg = $this->multiEasyToComplex($key_val);
        $show_list = $this->getAllShowArr($list_cfg);//getOneShowArr
        if(isset($show_list['tabs']) && !empty($show_list['tabs'])){
            $diff = array_diff_key($show_list['tabs'],$this->tabname);
            $tabs = array_merge($this->tabname, $diff);
        }
        //var_dump($show_list);exit;
        $key_val = $this->getKeyVal($res,'val_col');
        $prev_cfg = $this->multiEasyToComplex($key_val);//_easyToComplex
        $lua_str = $this->changeToStr($prev_cfg);

        $data['actions'] = $this->actions;
        $data['page'] = $page;
        $data['filter'] = $filter;
        $data['tabname'] = isset($tabs) ? $tabs : $this->tabname;
        $data['prev'] = isset($lua_str) ? highlight_string(print_r($lua_str, true),true) : '';
        $data['pagename'] = $this->pagename;
        
        $data['tipmsg'] = isset($tipmsg) ? $tipmsg : '';
        if(empty($filter)) {//首页
            //$data['tabname'] = isset($tabs) ? $tabs : $this->tabname;
            $data['cfgdata'] = isset($show_list['list']) ? $show_list['list'] : '';
            return view('Gamecfg.multi_index',$data);
        }else{
            $data['cfgdata'] = $list_cfg;
            return view('Gamecfg.multi_index_detail',$data);
        }
        
    }
    
    
    /**
     * 修改保存
     * @param Request $request
     */
    public function multi_save(Request $request) {
        if(isset($request->act_type) && $request->act_type == 'multi_save') {
            $modid = $request->pk; 
            $data['val_col'] = $request->value;
            $data['op_name'] = session('admin')["id"].";".session('admin')["username"];
            $data['op_time'] = date('Y-m-d H:i:s',time());
            if($modid==0){//添加
                $data['desc']=isset($request->desc) ? $request->desc : '';
                $data['memo']=isset($request->memo) ? $request->memo : '';
                $data['key_col']=trim($request->name);
                $data['typeid']=$this->cfg_typeid;
                $o_status = isset($request->o_status) ? $request->o_status : 1;//不生效
                $data['o_status'] = $this->is_validall == 1 ? $this->o_status : $o_status;
                $result=DB::table('gamecfg')->insertGetId($data);
                parent::saveLog('添加gamecfg.id--'.$result.'添加key('.$request->key_col.')=>val('.$request->val_col.')');
            }else{ //修改
                $result=DB::table('gamecfg')->where('id', $modid)->update($data);
                parent::saveLog('更新gamecfg.id('.$modid.')更新value为('.$data['val_col'].')');
            }
            if($result){
                exit(json_encode(['status'=>0,'msg'=>'成功']));
            }else{
                exit(json_encode(['status'=>1,'msg'=>'失败']));
            }
        }else{//同save
            $modid= isset($_POST['modid']) ?$_POST['modid'] : 0;
            $data['desc']=isset($request->desc) ? $request->desc : '';
            $data['typeid']=$this->cfg_typeid;
            $data['key_col']=trim($request->key_col);
            $data['val_col']=trim($request->val_col);
            $data['o_status']=2;//默认都是有效的
            $data['memo']=isset($request->memo) ? $request->memo : '';
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
                }else{
                    $record = $data;
                }
                parent::saveLog('更新gamecfg.id('.$modid.')更新('.$record.')');
                $result=DB::table('gamecfg')->where('id', $modid)->update($data);
               
            }
            if($result){
                exit(json_encode(['status'=>0,'msg'=>'成功']));
            }else{
                exit(json_encode(['status'=>1,'msg'=>'失败']));
            }
        }
    }
    
    /**
     * 生效的配置文件数组
     * 供下载和发送
     */
    public function getValidConfString() {
        $where = 'typeid='.$this->cfg_typeid.' and o_status='.$this->o_status;
        $data =  DB::table('gamecfg')->whereRaw($where)->get();
        $key_val = $this->getKeyVal($data,'val_col');
        $prev_cfg = $this->multiEasyToComplex($key_val);
        return  "return ".$this->changeToStr($prev_cfg);
    }
    
    /**
     * 生成lua文件
     * @param Request $request
     */
    public function downlua(Request $request) {
        $db_name = $this->classname;
        $filename = $db_name.'.lua';
        $lua_str = $this->getValidConfString();
        //文件头
        header("Content-Type: application/octet-stream");
        if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {
            header('Content-Disposition:  attachment; filename="' . urlencode($filename) . '"');
        } elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: attachment; filename*="utf8' .  $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' .  $filename . '"');
        }  
        //输出文件内容
        echo $lua_str;
    }
}
