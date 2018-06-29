<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChannelController extends BaseController
{
    public function index(){
        $results =DB::table('channels')->paginate(10);
        return view('Channel.index',['res'=>$results]);
    }

    public function add(){
        return view('Channel.add');
    }
    public function save(Request $request){
        $id=$request->id;
        $data['ChannelName']=$request->name;
        $data['ChannelCode']=$request->code;
        $data['IsOnline']=$request->type;
        if($id){
            $preArr=DB::table('channels')->select('ChannelName','ChannelCode','IsOnline')->where('ChannelId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'渠道',$id);

            $result=DB::table('channels')->where('ChannelId', $id)->update($data);
            parent::saveLog('修改渠道id--'.$id);
        }else{
            $result=DB::table('channels')->insertGetId($data);
            parent::saveLog('添加渠道id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/channel/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){

        $id=$request->id;
        $results=DB::table('channels')->where('ChannelId', $id)->get();
        return view('Channel.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;

        $res=DB::table('channels')->where('ChannelId', '=', $id)->delete();
        parent::saveLog('删除渠道id--'.$id);
        return redirect('/channel/index');

    }
}
