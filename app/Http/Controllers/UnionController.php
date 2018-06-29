<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnionController extends BaseController
{
    public function index(){
        $results =DB::table('unions')->orderby('UnionId', 'desc')->paginate(10);
        return view('Union.index',['res'=>$results]);
    }

    public function add(){
        return view('Union.add');
    }
    public function save(Request $request){
        $id=$request->id;
        $data['UnionName']=$request->name;
        $data['UnionCode']=$request->code;
        $data['SharingRatio']=$request->num;
        $data['SharingType']=$request->type;
        if($id){
            $data['UpdateAt']=date('Y-m-d H:i:s');
            $preArr=DB::table('unions')->select('UnionName','UnionCode','SharingRatio','SharingType','UpdateAt')->where('UnionId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'联运',$id);

            $result=DB::table('unions')->where('UnionId', $id)->update($data);
            parent::saveLog('修改联运id--'.$id);
        }else{
            $result=DB::table('unions')->insertGetId($data);
            parent::saveLog('添加联运id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/union/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){

        $id=$request->id;
        $results=DB::table('unions')->where('UnionId', $id)->get();
        return view('Union.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;

        $res=DB::table('unions')->where('UnionId', '=', $id)->delete();
        parent::saveLog('删除联运id--'.$id);
        return redirect('/union/index');

    }
}
