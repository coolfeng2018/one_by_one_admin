<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CloseController extends BaseController
{
    public function index(){

        $results = DB::table('close')->paginate(10);
        $res['results']=$results;
        return view('Close.index',['res'=>$res]);
    }

    public function add(){
        return view('Close.add');
    }
    public function save(Request $request){

        $id=$request->id;

        $data['title']=$request->title;
        $data['content']=$request->detail;
        $data['stime']=$request->stime;
        $data['etime']=$request->etime;
        $data['status']=$request->status;

        if($id){
            $preArr=DB::table('close')->select('title','content','stime','etime','status')->where('id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'停机',$id);

            $result=DB::table('close')->where('id', $id)->update($data);
            parent::saveLog('更新停机id--'.$id);
        }else{
            $result=DB::table('close')->insertGetId($data);
            parent::saveLog('添加停机id--'.$result);
        }


        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/close/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('close')->where('id', $id)->get();
        $res['results']=$results;
        return view('Close.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('close')->where('id', '=', $id)->delete();
        parent::saveLog('删除促销id--'.$id);

        return redirect('/close/index');
    }

}
