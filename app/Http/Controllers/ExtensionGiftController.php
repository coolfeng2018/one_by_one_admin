<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ExtensionGiftController extends BaseController
{
    public function index(){
        $res=$this->ExtensionGift();
        return view('ExtensionGift.index',['res'=>$res]);
    }
    public function update(Request $request){
        $res['gift']=$this->ExtensionGift();
        $res['kind']=$this->keyVal();
        return view('ExtensionGift.update',['res'=>$res]);
    }

    public function save(Request $request){
        $award=$request->award;
        try{
            Redis::set('ExtensionGift',$award);
            parent::saveLog('更新推广奖励');
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/extensionGift/index']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>0,'msg'=>$e]));
        }

    }

    protected function ExtensionGift(){
        $info=Redis::get('ExtensionGift');
        $res=json_decode($info,true);
        if(empty($res)){
            $res[0]=['type'=>1,'number'=>'','name'=>'钻石'];
        }
        return $res;
    }
    protected function  keyVal(){
        $res = DB::table('props')->select('PropsId', 'PropsName')->get();
        $tmp = json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['PropsId']] = $v['PropsName'];
        }
        return $arr;
    }
}
