<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoinSettingController extends BaseController
{
    public function index(){
        $results = DB::table('coinsetting')->paginate(10);
        $res['results']=$results;
        $res['games']=$this->keyVal();
        return view('CoinSetting.index',['res'=>$res]);
    }

    public function add(){
        $res['games']=$this->keyVal();
        return view('CoinSetting.add',['res'=>$res]);
    }
    public function save(Request $request){

        $id=$request->id;

        $data['KindId']=$request->game;
        $data['Level']=$request->level;
        $data['Status']=$request->status;
        $data['Config']=$request->rule;

        if($id){
            $preArr=DB::table('coinsetting')->select('KindId','Level','Status','Config')->where('Id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'金币房配置',$id);

            $result=DB::table('coinsetting')->where('Id', $id)->update($data);
            parent::saveLog('更新金币房配置id--'.$id);
        }else{
            $result=DB::table('coinsetting')->insertGetId($data);
            parent::saveLog('添加金币房配置id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/coinSetting/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('coinsetting')->where('Id', $id)->get();
        $res['results']=$results;
        $res['games']=$this->keyVal();
        return view('CoinSetting.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('coinsetting')->where('Id', '=', $id)->delete();
        parent::saveLog('删除金币房配置id--'.$id);

        return redirect('coinSetting/index');
    }

    //获取游戏分类
    protected function keyVal(){
        $res = DB::table('games')->where('scene_id','=','1')->select('kind_id', 'game_name')->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            if($v['kind_id']!=1003){
                $arr[$v['kind_id']]=$v['game_name'];
            }
        }
        return $arr;
    }
}
