<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class NewcomersGiftController extends BaseController
{
    public function index(){
        $res=$this->NewGift();
        return view('NewcomersGift.index',['res'=>$res]);
    }
    public function update(Request $request){
        $res['gift']=$this->NewGift();
        $res['kind']=$this->keyVal();
        return view('NewcomersGift.update',['res'=>$res]);
    }

    public function save(Request $request){
        $award=$request->award;
        try{
            Redis::set('NewcomersGift',$award);
            parent::saveLog('更新新手奖励');
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/newcomersGift/index']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>0,'msg'=>$e]));
        }

    }

    protected function NewGift(){
        $info=Redis::get('NewcomersGift');
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
