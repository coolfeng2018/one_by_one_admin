<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SaleGiftController extends BaseController
{
    public function index(){
        $res['charge']=$this->getRedisConfig(1);
        $res['gift']=$this->getRedisConfig(2);
        $res['kind']=$this->keyVal();

        return view('SaleGift.index',['res'=>$res]);
    }

    public function updateCharge(){
        $res['charge']=$this->getRedisConfig(1);
        $res['kind']=$this->keyVal();

        return view('SaleGift.updateCharge',['res'=>$res]);
    }
    public function saveCharge(Request $request){

        $data['stime']=$request->stime;
        $data['etime']=$request->etime;
        $data['price']=$request->price;
        $data['saling']=json_decode($request->detail,true);

        $stime=time();
        $etime=strtotime($data['etime']);
        $lifetime=$etime-$stime;

        if($lifetime<=0){
            return response()->json(['status'=>0,'msg'=>'修改失败,下架时间错误']);
        }

        $data=json_encode($data);
        try{
            Redis::set('FirstCharge',$data);
            Redis::expire('FirstCharge',$lifetime);

            parent::saveLog('更新首充礼包');
            return response()->json(['status'=>1,'msg'=>'修改成功','url'=>'/saleGift/index']);
        }catch(Exception $e){
            return json_encode(['status'=>0,'msg'=>'修改失败']);
        }
    }


    public function updateGift(){
        $res['gift']=$this->getRedisConfig(2);
        $res['kind']=$this->keyVal();
        return view('SaleGift.updateGift',['res'=>$res]);
    }
    public function saveGift(Request $request){

        $data['stime']=$request->stime;
        $data['etime']=$request->etime;
        $data['price']=$request->price;
        $data['saling']=json_decode($request->detail,true);

        $stime=time();
        $etime=strtotime($data['etime']);
        $lifetime=$etime-$stime;

        if($lifetime<=0){
            return response()->json(['status'=>0,'msg'=>'修改失败,下架时间错误']);
        }

        $data=json_encode($data);
        try{
            Redis::set('GiftSet',$data);
            Redis::expire('GiftSet',$lifetime);

            parent::saveLog('更新超值礼包');
            return response()->json(['status'=>1,'msg'=>'修改成功','url'=>'/saleGift/index']);
        }catch(Exception $e){
            return json_encode(['status'=>0,'msg'=>'修改失败']);
        }
    }


    public function keyVal(){
        $res = DB::table('props')->select('PropsId', 'PropsName')->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['PropsId']]=$v['PropsName'];
        }
        return $arr;
    }
    public function getRedisConfig($item){
        if($item==1){
            $info=Redis::get('FirstCharge');
        }elseif($item==2){
            $info=Redis::get('GiftSet');
        }
        $res=json_decode($info,true);

        if(empty($res)){
            $res['stime'] = date('Y-m-d H:i:s');
            $res['etime'] = date('Y-m-d H:i:s');
            $res['price'] = 0;
            $res['saling'][]=['type'=>1,'number'=>0];
        }

        return $res;
    }
}
