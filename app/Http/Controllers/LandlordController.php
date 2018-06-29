<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class LandlordController extends BaseController
{
    public function index(){
        $results = DB::table('landlord')->paginate(10);
        return view('Landlord.index',['res'=>$results]);
    }

    public function add(){
        return view('Landlord.add');
    }
    public function save(Request $request){

        $id=$request->id;
        $data['NickName']=$request->name;
        $data['AvatarUrl']=$request->img;

        if($id){
            $preArr=DB::table('landlord')->select('NickName','AvatarUrl')->where('Id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'庄家',$id);

            $result=DB::table('landlord')->where('Id', $id)->update($data);
            parent::saveLog('更新庄家id--'.$id);
        }else{

            $result=DB::table('landlord')->insertGetId($data);
            parent::saveLog('添加庄家id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/landlord/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('landlord')->where('Id', $id)->get();
        return view('Landlord.update',['res'=>$results]);
    }

    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('landlord')->where('Id', '=', $id)->delete();
        parent::saveLog('删除庄家id--'.$id);

        return redirect('/landlord/index');
    }

    public function uploads(Request $request){
        $file = $request->file('file');
        $preDir='uploads';
        $path = $file->store('/avatars',$preDir );
        $client=new Client();
        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($preDir.'/'.$path,'r')],['name'=>'type','contents'=>'avatars']]]);

        if($response->getStatusCode()==200) {
            $result=$response->getBody();
            $result=json_decode($result);
            if($result->status==200) {
                unlink($preDir.'/'.$path);
                $resPath=$result->data->filePath;
            }else{
                $resPath='';
            }
        }else{
            $resPath='';
        }
        return response()->json(array('msg' => $resPath,'RemoteDir'=>config('suit.ImgRemoteUrl')));
    }
    public function addPro(Request $request){
        $results = DB::table('landlord')->select('NickName','AvatarUrl')->first();
        $tmpRes=\GuzzleHttp\json_encode($results);
        try{
            Redis::set('dealer',$tmpRes);
            exit(json_encode(['status'=>1,'msg'=>'发布成功']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>0,'msg'=>json_encode($e)]));
        }
    }
}
