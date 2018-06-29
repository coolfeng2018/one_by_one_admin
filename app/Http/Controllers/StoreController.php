<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


class StoreController extends BaseController {
    /**
     * 修改类型
     * @var array
     */
    private $_typelist = array(
        'addbrnncoins'=>'加库存',
        'subbrnncoins'=>'减库存'
    );
    /**
     * 修改库存
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function modstore(Request $request){            
        $type = isset($request->type) ? $request->type : '';
        $url = env('SERVERAPI')."/gm";
        //$url = "http://192.168.1.235:8888/gm";//TODO
        $re = $this->curl($url,array('data'=>json_encode(array('cmd'=>'getbrnncoins'))));
        $re_arr = json_decode($re,true);
        $store_num = isset($re_arr['code'])&&isset($re_arr['curr'])  ? $re_arr['curr'] : 0;
        if(isset($request->act) && $request->act == 'act') {  
            if(empty($type)) {
                exit(json_encode(['status'=>3,'msg'=>'请选择修改类型']));
            }else{
                $param = array(
                    'cmd'=>$type,
                    'value'=>(int)$request->num
                );
                $res = $this->reqCserver($param, $type);
                parent::saveLog('修改库存   '.$type.' data：'.json_encode($param).' res'.json_encode($res));
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
        $back['pagename'] = '修改库存';
        $back['store_num'] = isset($store_num) ? $store_num :0;
        return view('Store.mod',$back);
    }
}