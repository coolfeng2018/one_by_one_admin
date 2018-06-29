<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PrivateSettingController extends BaseController
{
    public function index(){
        $res['setting']=$this->get_info();
        $res['kind']=$this->keyVal();
        return view('PrivateSetting.index',['res'=>$res]);
    }
    public function update(Request $request){
        $id=$request->id;
        $res=$this->get_single_info($id);
        $res['id']=$id;
        return view('PrivateSetting.update',['res'=>$res]);
    }

    public function save(Request $request){

        $id=$request->id;

        $data['round']=$request->score;
        $data['spend']=$request->card;
        $data['max_exist']=$request->max;
        $data['options']['permission']['status']=$request->ptype;
        $data['options']['permission']['whitelist']=explode(",",$request->plist);
        $data['options']['toll']['status']=$request->atype;
        $data['options']['toll']['whitelist']=explode(",",$request->alist);

        $info = json_encode($data);

        try{
            Redis::hSet('GameSetting#'.$id,'PrivateRoom',$info);

            parent::saveLog('更新私房配置');
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/privateSetting/index']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>0,'msg'=>$e]));
        }

    }

    public function games(){
        $arr[1]='1001';
//        $arr[2]='1003';
        return $arr;
    }
    public function keyVal(){
        $res = DB::table('games')->where('scene_id','=','2')->select('kind_id', 'game_name')->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['kind_id']]=$v['game_name'];
        }
        return $arr;
    }
    public function get_info(){
        $game=$this->games();
        foreach ($game as $k){
            $info=Redis::hGet('GameSetting#'.$k,'PrivateRoom');
            $res[$k]=json_decode($info,true);
            if(empty($res[$k])){
                $res[$k]['round']=0;
                $res[$k]['spend']=0;
                $res[$k]['max_exist']=0;
                $res[$k]['options']['permission']['status']=0;
                $res[$k]['options']['permission']['whitelist']=[];
                $res[$k]['options']['toll']['status']=0;
                $res[$k]['options']['toll']['whitelist']=[];
            }
        }

        foreach ($res as $k => $v){
            $res[$k]['options']['permission']['List'] = implode(',',$v['options']['permission']['whitelist']);
            $res[$k]['options']['toll']['List'] = implode(',',$v['options']['toll']['whitelist']);
        }

        return $res;
    }

    public function get_single_info($item){
        $info=Redis::hGet('GameSetting#'.$item,'PrivateRoom');
        $res=json_decode($info,true);
        if(empty($res)){
            if(empty($res)){
                $res['round']=0;
                $res['spend']=0;
                $res['max_exist']=0;
                $res['options']['permission']['status']=0;
                $res['options']['permission']['whitelist']=[];
                $res['options']['toll']['status']=0;
                $res['options']['toll']['whitelist']=[];
            }
        }
        $res['options']['permission']['List']=implode(',',$res['options']['permission']['whitelist'] );
        $res['options']['toll']['List']=implode(',',$res['options']['toll']['whitelist']);

        return $res;
    }
}
