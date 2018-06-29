<?php
/**
 * 库存配置
 * 
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SetScoreController extends BaseController {
    /**
     * 系统庄家配置的游戏
     * @var array
     */
    protected $glist = array( );
    /**
     * 修改类型
     * @var array
     */
    protected $_typelist = array(
        'addsystemcoins'=>'加库存',
        'subsystemcoins'=>'减库存'
    );
    /**
     * 游戏id
     * @var integer
     */
    protected $gid = 200002;
    
    /**
     * 初始化 可以系统庄家配置的游戏列表
     * (non-PHPdoc)
     * @see Home_Wxbase_Controller::init()
     */
    public function __construct(){
        parent::__construct();
        $this->glist = $this->gamelist;
        if(isset($this->glist[1] )) unset($this->glist[1]);
        if(isset($this->glist[2] )) unset($this->glist[2]);
        if(isset($this->glist[3] )) unset($this->glist[3]);
        if(isset($this->glist[200000] )) unset($this->glist[200000]);
    }
    
    /**
     * 修改库存
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function modstore(Request $request){
        $gid = isset($request->gid) ? $request->gid : $this->gid;//默认龙凤对决
        $type = isset($request->type) ? $request->type : '';
        $url = env('SERVERAPI')."/gm";
        //$url = "http://192.168.1.202:8888/gm";
        $getdata_param = array(
            'cmd' =>'getsystemcoins',
            'gid' =>(int)$gid
        );
        $re = $this->curl($url,array('data'=>json_encode($getdata_param)));
        $re_arr = json_decode($re,true);
        $store_num = isset($re_arr['code'])&&isset($re_arr['curr'])  ? $re_arr['curr'] : 0;
        if(isset($request->act) && $request->act == 'act') {
            if(empty($type)) {
                exit(json_encode(['status'=>3,'msg'=>'请选择修改类型']));
            }else{
                $param = array(
                    'cmd'=>$type,
                    'gid'=>(int)$gid,
                    'value'=>(int)$request->num
                );
                $res = $this->reqCserver($param, $type);
                parent::saveLog('修改库存   gid='.$gid.' 操作'.$this->_typelist[$type].' data：'.json_encode($param).' res'.json_encode($res));
                if(isset($res['code']) && $res['code'] == 0) {
                    exit(json_encode(['status'=>0,'msg'=>'修改成功！']));
                }else{
                    exit(json_encode(['status'=>2,'msg'=>'修改失败']));
                }
                exit(json_encode(['status'=>2,'msg'=>'修改失败~！']));
            }
        }
        $back = $_GET;
        $back['typelist'] = $this->_typelist;
        $back['type'] = $type;
        $back['gamelist'] = $this->glist;
        $back['gid'] = $gid;
        $back['pagename'] = isset($this->glist[$gid]) ? $this->glist[$gid].'修改库存' : '修改库存';
        $back['store_num'] = isset($store_num) ? $store_num :0;
        return view('Store.index',$back);
    }
    
}
