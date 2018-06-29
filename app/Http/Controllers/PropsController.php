<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropsController extends BaseController
{
    public function index(){
        $results = DB::table('props')->paginate(10);
        return view('Props.index',['res'=>$results]);
    }

    public function add(){
        return view('Props.add');
    }
    public function save(Request $request){
        $id=$request->id;
        $data['PropsName']=$request->name;
        $data['PropsDescription']=$request->describe;
        $data['PropsType']=$request->type;
        $data['Status']=$request->status;
        if($id){
            $preArr=DB::table('props')->select('PropsName','PropsDescription','PropsType','Status')->where('PropsId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'道具',$id);

            $result=DB::table('props')->where('PropsId', $id)->update($data);
            parent::saveLog('更新道具id--'.$id);
        }else{
            $result=DB::table('props')->insertGetId($data);
            parent::saveLog('添加道具id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/props/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){

        $id=$request->id;
        $results=DB::table('props')->where('PropsId', $id)->get();
        return view('Props.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('props')->where('PropsId', '=', $id)->delete();
        parent::saveLog('删除道具id--'.$id);

        return redirect('props/index');

    }

}
