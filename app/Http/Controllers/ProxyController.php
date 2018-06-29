<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Repositories\ProxyRepository;


class ProxyController extends BaseController
{
    protected $proxyRepository;

    function __construct(ProxyRepository $proxyRepository){
        $this->proxyRepository=$proxyRepository;
    }
    public function index(){
        $res['stime']='';
        $res['etime']='';
        $res['uid']='';
        $res['mobile']='';
        return view('Proxy.index',['res'=>$res]);
    }
    public function search(Request $request){

        $pram['stime']=$request->stime;
        $pram['etime']=$request->etime;
        $pram['uid']=$request->uid;
        $pram['mobile']=$request->mobile;
        $pram['page']=$request->page;

        $res=$this->proxyRepository->info($pram);

        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$res,'pram'=>$pram]));
    }

    public function add(){
        return view('Proxy.add');
    }
    public function save(Request $request){

        $id=$request->id;

        $data['Mobile']=$request->mobile;
        $data['NickName']=$request->nick;
        $data['UserId']=$request->uid;
        $data['QQ']=$request->qq;
        $data['Wechat']=$request->wechat;
        $data['Status']=$request->status;
        //判定代理商号码是否存在
        if($id){
            $phone=DB::table('proxy')->where('Mobile','=',$data['Mobile'])->where('AgentId','<>',$id)->count();
        }else{
            $phone=DB::table('proxy')->where('Mobile','=',$data['Mobile'])->count();
        }
        if($phone){
            exit(json_encode(['status'=>0,'msg'=>'此号码已存在于代理商库中，请更换新号码']));
        }
        //判定游戏id是否存在
        $uinfo=DB::table('users')->where('UserId','=',$data['UserId'])->count();
        if(!$uinfo){
            exit(json_encode(['status'=>0,'msg'=>'此游戏ID不存在，请检查输入内容']));
        }
        //判定代理商游戏id是否存在
        if($id){
            $gameId=DB::table('proxy')->where('UserId','=',$data['UserId'])->where('AgentId','<>',$id)->count();
        }else{
            $gameId=DB::table('proxy')->where('UserId','=',$data['UserId'])->count();
        }
        if($gameId){
            exit(json_encode(['status'=>0,'msg'=>'此游戏ID已存在于代理商库中，请检查输入内容']));
        }

        //判定是否为分销用户
        $share=DB::table('distribution_user')->where('gameuserid','=',$data['UserId'])->first();
        $share=json_decode(json_encode($share), true);
        if($share['parent_id']>0){
            exit(json_encode(['status'=>0,'msg'=>'此游戏ID用户已处于分销系统中！']));
        }else{
            $shareLevel=DB::table('distribution_user')->where('parent_id','=',$share['distributionuser_id'])->count();
            if($shareLevel>0){
                exit(json_encode(['status'=>0,'msg'=>'此游戏ID用户已处于分销系统中！']));
            }
        }

        if($id){
            $data['Psd']=$request->psd;
            $preArr=DB::table('proxy')->select('Mobile','NickName','UserId','QQ','Wechat','Status','Psd')->where('AgentId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'代理',$id);

            $result=DB::table('proxy')->where('AgentId', $id)->update($data);
            parent::saveLog('更新代理id--'.$id);
        }else{
            $data['Psd']=md5($request->psd);
            $result=DB::table('proxy')->insertGetId($data);
            parent::saveLog('添加代理id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/proxy/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('proxy')->where('AgentId', $id)->get();
        return view('Proxy.update',['res'=>$results]);
    }

    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('proxy')->where('AgentId', '=', $id)->delete();
        parent::saveLog('删除代理id--'.$id);

        return redirect('proxy/index');
    }

    public function charge(){
        $id=$_GET['id'];
        if($id){
            $res['stime']=date("Y-m-d 00:00",strtotime("-1 month"));
            $res['etime']=date("Y-m-d H:i");
            $res['uid']=$id;
            return view('Proxy.charge',['res'=>$res]);
        }else{
            echo '参数丢失';
        }
    }
    public function searchCharge(Request $request){

        $pram['stime']=$request->stime;
        $pram['etime']=$request->etime;
        $pram['uid']=$request->uid;
        $pram['page']=$request->page;

        $res=$this->proxyRepository->chargeInfo($pram);
        $sale=$this->keyVal();

        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$res,'pram'=>$pram,'sale'=>$sale]));
    }

    public function trade(){
        $id=$_GET['id'];
        if($id){
            $res['stime']=date("Y-m-d 00:00",strtotime("-1 month"));
            $res['etime']=date("Y-m-d H:i");
            $res['aid']=$id;//代理id
            $res['uid']='';//搜索下级代理绑定gameid
            $res['mobile']='';//搜索下级代理mobile
            return view('Proxy.trade',['res'=>$res]);
        }else{
            echo '参数丢失';
        }
    }
    public function searchTrade(Request $request){

        $pram['stime']=$request->stime;
        $pram['etime']=$request->etime;
        $pram['aid']=$request->aid;
        $pram['uid']=$request->uid;
        $pram['mobile']=$request->mobile;
        $pram['page']=$request->page;

        $res=$this->proxyRepository->tradeInfo($pram);

        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$res,'pram'=>$pram]));
    }


    public function level(){
        $id=$_GET['id'];
        if($id){
            $res['stime']='';
            $res['etime']='';
            $res['aid']=$id;//代理id
            $res['uid']='';//搜索下级代理绑定gameid
            $res['mobile']='';//搜索下级代理mobile
            return view('Proxy.level',['res'=>$res]);
        }else{
            echo '参数丢失';
        }
    }
    public function searchLevel(Request $request){

        $pram['stime']=$request->stime;
        $pram['etime']=$request->etime;
        $pram['aid']=$request->aid;
        $pram['uid']=$request->uid;
        $pram['mobile']=$request->mobile;
        $pram['page']=$request->page;

        $res=$this->proxyRepository->levelInfo($pram);

        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$res,'pram'=>$pram]));
    }

    public function updateStatus(Request $request){
        $id=$request->id;
        $status=$request->status;
        if($status==0){
            $tmp=1;
        }elseif($status==1){
            $tmp=0;
        }
        $pid=$request->aid;
        $res=DB::table('proxy')->where('AgentId', '=', $id)->update(['Status' => $tmp]);
        parent::saveLog('更新二级代理状态--'.$id);


        return redirect('proxy/level?id='.$pid);
    }

    public function deleteLevel(Request $request){
        $id=$request->id;
        $pid=$request->aid;
        $res=DB::table('proxy')->where('AgentId', '=', $id)->delete();
        parent::saveLog('删除二级代理--'.$id);

        return redirect('proxy/level?id='.$pid);
    }


    public function updatePwd(){
        return view('Proxy.updatePwd');
    }

    public function savePwd(Request $request){
        $id=$request->mobile;

        $pwd=md5($request->psd);
        $res=DB::table('proxy')->where('Mobile', '=', $id)->update(['Psd' => $pwd]);

        parent::saveLog('更新电话号码'.$id.'的代理密码--');
        if($res){
            return response()->json(['status'=>1,'msg'=>'ok','url'=>'/proxy/index']);
        }else{
            return response()->json(['status'=>0,'msg'=>'修改失败']);
        }

    }

    public function configProxy(){
        $res=Redis::get('PROXY');
        $tmp=json_decode($res);
        return view('Proxy.configProxy',['res'=>$tmp]);
    }
    public function saveConfig(Request $request){
        $data['term']=(int)$request->term;
        $data['money']=(int)$request->money;
        $tmp=json_encode($data);

        try{
            Redis::set('PROXY',$tmp);
            parent::saveLog('更新代理充值设置');
            return response()->json(['status'=>1,'msg'=>'ok','url'=>'/proxy/index']);
        }catch (\Exception $e){
            return response()->json(['status'=>0,'msg'=>$e]);
        }
    }

    protected function keyVal(){

        $res = DB::table('sale')->select('SaleId', 'SaleName')->get();
        $arr[0]='无';
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['SaleId']]=$v['SaleName'];
        }

        return $arr;
    }
}
