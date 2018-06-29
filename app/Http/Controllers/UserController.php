<?php

namespace App\Http\Controllers;

use App\Lib\MoneyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;

class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function index(){
        exit('<span style="color:red;">敬请期待!</span>');
        $param['uid']=$_GET['uid']??'';
        $param['name']=$_GET['name']??'';

        $res=$this->userRepository->info($param);

        return view('User.index',['res'=>$res,'search'=>$param]);
    }
    public function saveCoinServer(Request $request){
        $uid=$request->id;
        $param['uid']=$request->uid;
        $param['name']=$request->name;

        $data['ServiceType']=1;

        DB::table('users')->where('UserId', $uid)->update($data);

        return redirect('/user/index?uid='.$param['uid'].'&name='.$param['name']);

    }

    //封号
    public function black(Request $request){
        $id=$request->id;
        $results = DB::table('record_block')->where('UserId','=',$id)->paginate(10);
        $res['results']=$results;
        $res['uid']=$id;
        return view('User.black',['res'=>$res]);
    }
    public function black_add(Request $request){
        $uid=$request->uid;
        $res['uid']=$uid;
        return view('User.black_add',['res'=>$res]);
    }
    public function black_save(Request $request){
        $id=$request->id;

        $data['UserId']=$request->uid;
        $data['Reason']=$request->reason;
        $data['StartTime']=$request->start;
        $data['EndTime']=$request->end;
        $data['Status']=$request->status;

        if($id){
            $preArr=DB::table('record_block')->select('UserId','Reason','StartTime','EndTime','Status')->where('BlockId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'黑名单',$id);

            $result=DB::table('record_block')->where('BlockId', $id)->update($data);
            parent::saveLog('更新黑名单id--'.$id);
        }else{
            $result=DB::table('record_block')->insertGetId($data);
            parent::saveLog('添加黑名单id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/user/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function black_update(Request $request){

        $id=$request->id;
        $results=DB::table('record_block')->where('BlockId', $id)->get();
        return view('User.black_update',['res'=>$results]);
    }
    public function black_delete(Request $request)
    {
        $id = $request->id;
        $res = DB::table('record_block')->where('BlockId', '=', $id)->delete();
        parent::saveLog('删除黑名单id--'.$id);

        return redirect('user/index');
    }
    //资产
    public function asset(Request $request){
        $id=$request->id;

        $mc = new MoneyClient;
        $mc->connect(config('suit.CoinServerIp'), config('suit.CoinServerPort'));

        $uinfo=$mc->getUser($id);

        if($uinfo['result']==1){
            $res['UserId']=$id;
            $res['coin']=$uinfo['newmoney'];
            $res['card']=$uinfo['newcard'];
            $res['gem']=$uinfo['newdiamond'];
        }else{
            $res['UserId']=$id;
            $res['coin']='金币服异常,请稍后进行相应操作';
            $res['card']='金币服异常,请稍后进行相应操作';
            $res['gem']='金币服异常,请稍后进行相应操作';
        }
        $mc->close();

        return view('User.asset',['res'=>$res]);
    }

    public function asset_update(Request $request){
        $id=$request->id;

        $mc = new MoneyClient;
        $mc->connect(config('suit.CoinServerIp'), config('suit.CoinServerPort'));

        $uinfo=$mc->getUser($id);

        if($uinfo['result']==1){
            $res['UserId']=$id;
            $res['coin']=$uinfo['newmoney'];
            $res['card']=$uinfo['newcard'];
            $res['gem']=$uinfo['newdiamond'];
        }else{
            $res['UserId']=$id;
            $res['coin']='金币服异常,请稍后进行相应操作';
            $res['card']='金币服异常,请稍后进行相应操作';
            $res['gem']='金币服异常,请稍后进行相应操作';
        }
        $mc->close();

        return view('User.asset_update',['res'=>$res]);
    }
    public function asset_save(Request $request){

        $id=$request->id;

        $coin=$request->coin;
        $card=$request->card;
        $gem=$request->gem;

        $oldCard=$request->oldCard;
        $oldCoin=$request->oldCoin;
        $oldGem=$request->oldGem;

        parent::saveAssetsLog('金币修改前'.$oldCoin.'修改后'.$coin.'房卡修改前'.$oldCard.'修改后'.$card.'钻石修改前'.$oldGem.'修改后'.$gem,$id);

        $arrMoney['money']=$coin-$oldCoin;
        $arrCard['card']=$card-$oldCard;
        $arrDiamond['diamond']=$gem-$oldGem;

        $mc = new MoneyClient;
        $mc->connect(config('suit.CoinServerIp'), config('suit.CoinServerPort'));

        if($arrMoney['money']!=0){
            if($arrMoney['money']>0){
                $mc->modUser((int)$id,GAMECOIN_SYS_ADD,$arrMoney);
            }else{
                $mc->modUser((int)$id,GAMECOIN_SYS_MINUS,$arrMoney);
            }
        }
        if($arrCard['card']!=0){
            if($arrCard['card']>0){
             $mc->modUser((int)$id,ROOMCARD_SYS_ADD,$arrCard);
            }else{
             $mc->modUser((int)$id,ROOMCARD_SYS_MINUS,$arrCard);
            }
        }
        if($arrDiamond['diamond']!=0){
            if($arrDiamond['diamond']>0){
                $mc->modUser((int)$id,DIAMOND_SYS_ADD,$arrDiamond);
            }else{
                $mc->modUser((int)$id,DIAMOND_SYS_MINUS,$arrDiamond);
            }
        }
        
        $mc->close();

        parent::saveLog('更新用户资产');

        return response()->json(['status'=>1,'msg'=>'ok','url'=>'/user/index']);

    }

    protected function objToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }

}
