<?php

namespace App\Http\Controllers;

use App\Lib\MoneyClient;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RobitController extends BaseController
{
    public function index(){
        $results = DB::table('users')->leftjoin('role_info','role_info.UserId','=','users.UserId')
            ->select('users.UserId','users.LoginType','users.MobilePlatform','users.Gender','users.NickName','users.AvatarUrl','users.Status')
            ->where('role_info.IsRobot','=',1)->paginate(10);
        return view('Robit.index',['res'=>$results]);
    }

    public function add(){
        return view('Robit.add');
    }
    public function save(Request $request){

        $id=$request->id;
        $data['NickName']=$request->name;
        $data['AvatarUrl']=$request->img;

        $data['Gender']=$request->sex;
        $data['LoginType']=$request->type;
        $data['MobilePlatform']=$request->os;
        $data['Status']=$request->status;

        if($id){
            $result=DB::table('users')->where('UserId', $id)->update($data);
            parent::saveLog('更新机器人id--'.$id);
        }else{
            //插入users
            $result=DB::table('users')->insertGetId($data);
            //插入role_info
            $tmp['UserId']=$result;
            $tmp['IsRobot']=1;
            $resInfo=DB::table('role_info')->insert($tmp);
            parent::saveLog('添加机器人id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/robit/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('users')->select('UserId','NickName','AvatarUrl','Gender','LoginType','MobilePlatform','Status')->where('UserId', $id)->get();
        return view('Robit.update',['res'=>$results]);
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
    //点击添加机器人
//    public function addMore(Request $request){
//
//        $data['NickName']=$this->randomName(8);
//
//        $img_array = glob("uploads/robot/*.{gif,jpg,png}",GLOB_BRACE);
//        if(count($img_array)==0){
//            return json_encode(['status'=>0,'msg'=>'图片数量不足,请添加图片']);
//        }
//        $item = array_rand($img_array);
//        $img=$img_array[$item];
//
//        $data['AvatarUrl']=$this->uploadFile($img,'avatars');
//
//        $data['Gender']=mt_rand(0,2);
//        $data['LoginType']=mt_rand(0,2);
//        $data['MobilePlatform']=mt_rand(0,1);
//        //插入users
//        $result=DB::table('users')->insertGetId($data);
//        //插入role_info
//        $tmp['UserId']=$result;
//        $tmp['IsRobot']=1;
//        $resInfo=DB::table('role_info')->insert($tmp);
//        parent::saveLog('添加机器人id--'.$result);
//
//        if($result){
//            return json_encode(['status'=>1,'msg'=>'ok','url'=>'/robit/index']);
//        }else{
//            return json_encode(['status'=>0,'msg'=>'error']);
//        }
//    }
//
//
//    private function randomName($length, $chars = '0123456789qwertyuiopasdfghjklzxcvbnm') {
//        $hash = '';
//        $max = strlen($chars) - 1;
//        for($i = 0; $i < $length; $i++) {
//            $hash .= $chars[mt_rand(0, $max)];
//        }
//        return $hash;
//    }
//
//    private function uploadFile($tmpFile,$fileType)
//    {
//        $client=new Client();
//        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($tmpFile,'r')],['name'=>'type','contents'=>$fileType]]]);
//        if($response->getStatusCode()==200)
//        {
//            $result=$response->getBody();
//            $result=json_decode($result);
//            if($result->status==200)
//            {
//                unlink($tmpFile);
//                return $result->data->filePath;
//            }
//            else
//            {
//                return false;
//            }
//        }
//        else
//        {
//            return false;
//        }
//    }

    //服务添加机器人
    public function addRobot(){
        $maxId=DB::table('users')->max('UserId');
        if($maxId){
            $tmp=$maxId;
        }else{
            $tmp=10000000;
        }
        $tmpId=$tmp+mt_rand(1,10);

        $data['UserId']=$tmpId;
        $data['NickName']=$_GET['name'];
        $data['AvatarUrl']=$_GET['url'];

        $data['Gender']=mt_rand(0,2);
        $data['LoginType']=mt_rand(0,2);
        $data['MobilePlatform']=mt_rand(0,1);

        //插入users
        $result=DB::table('users')->insert($data);
        //插入role_info
        $tmps['UserId']=$tmpId;
        $tmps['IsRobot']=1;
        $resInfo=DB::table('role_info')->insert($tmps);

        $mc = new MoneyClient;
        $mc->connect(config('suit.CoinServerIp'), config('suit.CoinServerPort'));
        $mc->newUser($tmpId,GAMECOIN_REGISTER,[]);

        parent::saveLog('添加机器人id--'.$tmpId);
    }

}
