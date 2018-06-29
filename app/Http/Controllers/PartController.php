<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartController extends BaseController
{
    public function index(){
        $results = DB::table('part')->paginate(10);
        return view('Part.index',['res'=>$results]);
    }

    public function add(){
        return view('Part.add');
    }
    public function save(Request $request){

        $id=$request->id;

        $data['name']=$request->name;
        $data['status']=$request->status;

        if($id){
            $preArr=DB::table('part')->select('name','status')->where('id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'角色',$id);

            $result=DB::table('part')->where('id', $id)->update($data);
            parent::saveLog('更新角色id--'.$id);
        }else{
            $data['addtime']=date('Y-m-d H:i:s');
            $result=DB::table('part')->insertGetId($data);
            parent::saveLog('添加角色id--'.$id);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/part/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('part')->where('id', $id)->get();
        return view('Part.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('part')->where('id', '=', $id)->delete();
        parent::saveLog('删除角色id--'.$id);

        return redirect('/part/index');
    }

    public function  access(Request $request){

        //权限列表
        $results=DB::table('access')->select('id','pid','name')->where('status','=',1)->where('pid','=',0)->get();
        $tmp=$this->objectToArray($results);
        foreach ($tmp as $k =>$v){
            $lowLevel = DB::table('access')->select('id','pid','name')->where('status','=',1)->where('pid','=',$v['id'])->get();
            $lowLevels=$this->objectToArray($lowLevel);
            if($lowLevels){
                $tmp[$k]['level']=$lowLevels;
            }
        }
        $res['access']=$tmp;
        //我的权限
        $myAccess=[];
        if($request->id==1){
            $Access=DB::table('access')->select('id')->where('status','=',1)->get();
            $Access=$this->objectToArray($Access);
            foreach ($Access as $kk =>$vv){
               array_push($myAccess,$vv['id']);
            }
        }else{
            $Access=DB::table('part_access')->select('access_id')->where('part_id','=',$request->id)->get();
            $Access=$this->objectToArray($Access);
            foreach ($Access as $kk =>$vv){
                array_push($myAccess,$vv['access_id']);
            }
        }
        $res['myAccess']=$myAccess;
        $res['id']=$request->id;
        return view('Part.access',['res'=>$res]);
    }

    public function  accessSave(Request $request){
        $part_id=$request->id;
        //删除权限
        $res=DB::table('part_access')->where('part_id', '=', $part_id)->delete();
        $myStr=substr($request->mypro,1,-1);
        $myArr=explode(',',$myStr);
        //创建权限
        $count=0;
        foreach( $myArr as  $v){
            $data['part_id']=$part_id;
            $data['access_id']=$v;
            $Access=DB::table('access')->select('pid')->where('id','=',$v)->get();
            $checkAccess=$this->objectToArray($Access);
            if($checkAccess[0]['pid']>0){
                $check=DB::table('part_access')->select('id')->where('part_id','=',$part_id)->where('access_id','=',$checkAccess[0]['pid'])->get();
                $checkSub=$this->objectToArray($check);
                if(empty($checkSub)){
                    $dataSub['part_id']=$part_id;
                    $dataSub['access_id']=$checkAccess[0]['pid'];
                    $res=DB::table('part_access')->insertGetId($dataSub);
                }
            }
            $result=DB::table('part_access')->insertGetId($data);
            if($result){
                $count++;
            }
        }
        if(count($myArr)==$count){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/part/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    protected function objectToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }


}
