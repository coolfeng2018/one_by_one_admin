<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class GeneralizeController extends BaseController
{
    public function index(){
        $data=Redis::get('rewardconf');
        return view('generalize.index',['data'=>json_decode($data)]);
    }

    public function checkUser(Request $request){
          $uid=$request->id;
          $res=DB::table('distribution_user')->select('distributionuser_id','parent_id')->where('gameuserid','=',$uid)->first();

          if(empty($res)){
              return response()->json(['status'=>0,'msg'=>'error用户不存在']);
          }else{
              if($res->parent_id>0){
                  return response()->json(['status'=>1,'msg'=>'warning,用户已在分销系统中!']);
              }else{
                  $low=DB::table('distribution_user')->where('parent_id','=',$res->distributionuser_id)->count();
                  if($low>0){
                      return response()->json(['status'=>1,'msg'=>'warning,用户已在分销系统中!!']);
                  }else{
                      return response()->json(['status'=>1,'msg'=>'ok!']);
                  }
              }
          }

    }

    public function find(){
        $data=Redis::get('rewardconf');
        return view('generalize.find',['data'=>json_decode($data)]);
    }

    public function save(Request $request){
        $one=$request->one;
        $two=$request->two;
        $three=$request->three;
        $everyday=$request->everyday;

        $sharing_type=$request->sharing_type;
        $sharing_img=$request->sharing_img;
        $sharing_content=$request->sharing_content;
        Redis::set('rewardconf',json_encode(['s1'=>$one,'s2'=>$two,'s3'=>$three,'everyday'=>$everyday,'sharing_type'=>$sharing_type,'sharing_img'=>$sharing_img,'sharing_content'=>$sharing_content]));
        parent::saveLog('更新推广奖励提成');
        return json_encode(['status'=>200,'msg'=>'保存成功']);
    }

    public function friendshareshow(){
        $data=Redis::get('InviteSetting');
        return view('generalize.friendsharing',['data'=>json_decode($data)]);
    }

    public function friendsharesave(Request $request){
        $sharing_title=$request->sharing_title;
        $sharing_content=$request->sharing_content;


        $sharing_img=$request->sharing_img;
        Redis::set('InviteSetting',json_encode(['sharing_title'=>$sharing_title,'sharing_img'=>$sharing_img,'sharing_content'=>$sharing_content]));
        parent::saveLog('更新好友分享');
        return json_encode(['status'=>200,'msg'=>'保存成功']);
    }

    public function everydayshareshow(){
        $data=Redis::get('everydayshareconf');
        return view('generalize.everydaysharing',['data'=>json_decode($data)]);
    }

    public function everydaysharesave(Request $request){
        $sharing_title=$request->sharing_title;
        $sharing_content=$request->sharing_content;

        $sharing_img=$request->sharing_img;
        Redis::set('everydayshareconf',json_encode(['sharing_title'=>$sharing_title,'sharing_img'=>$sharing_img,'sharing_content'=>$sharing_content]));
        parent::saveLog('更新每日分享');
        return json_encode(['status'=>200,'msg'=>'保存成功']);
    }

}
