<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class PartyController extends BaseController
{
    //活动列表
    public function index(){
        $result=DB::table('lottery_party')->orderby('id','desc')->paginate(10);
        return view('Party.index',['res'=>$result]);
    }

    public function add(){
        return view('Party.add');
    }
    public function save(Request $request){

        $id=$request->id;

        $data['name']=$request->name;
        $data['start']=$request->stime;
        $data['end']=$request->etime;

        if($id){
            $preArr=DB::table('lottery_party')->select('name','start','end')->where('id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'活动',$id);

            $result=DB::table('lottery_party')->where('id', $id)->update($data);
            parent::saveLog('更新活动id--'.$id);
        }else{
            $data['addtime']=date('Y-m-d H:i:s');
            $result=DB::table('lottery_party')->insertGetId($data);
            parent::saveLog('添加活动id--'.$id);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/party/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('lottery_party')->where('id', $id)->get();
        return view('Party.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('lottery_party')->where('id', '=', $id)->delete();
        parent::saveLog('删除活动id--'.$id);

        return redirect('/party/index');
    }


    //活动详细配置
    public function detailList(Request $request){
        $lpid=$request->pid;
        $result=DB::table('lottery_award')->where('lpid',$lpid)->get();

        return view('Party.detailList',['res'=>$result,'pid'=>$lpid]);
    }

    public function detailAdd(Request $request){
        $lpid=$request->pid;

        $awardList['levels']=config('suit.lotteryLevel');
        $awardList['types']=config('suit.lotteryType');

        return view('Party.detailAdd',['pid'=>$lpid,'award'=>$awardList]);
    }
    public function detailSave(Request $request){

        $id=$request->id;

        $data['lpid']=$request->pid;
        $data['level']=$request->level;
        $data['name']=$request->name;
        $data['type']=$request->type;
        $data['price']=$request->price;
        $data['total']=$request->total;
        $data['number']=$request->number;

        $data['budget']=$data['price']* $data['total'];

        if($id){
            $preArr=DB::table('lottery_award')->select('lpid','lpid','name','type','price','total','number','budget')->where('id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'活动详细',$id);

            $result=DB::table('lottery_award')->where('id', $id)->update($data);
            parent::saveLog('更新活动详细id--'.$id);
        }else{
            $data['addtime']=date('Y-m-d H:i:s');
            $result=DB::table('lottery_award')->insertGetId($data);
            parent::saveLog('添加活动详细id--'.$id);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/party/detailList?pid='.$data['lpid']]));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function detailUpdate(Request $request){
        $id=$request->id;
        $results=DB::table('lottery_award')->where('id', $id)->get();

        $awardList['levels']=config('suit.lotteryLevel');
        $awardList['types']=config('suit.lotteryType');

        return view('Party.detailUpdate',['res'=>$results,'award'=>$awardList]);
    }
    public function detailDelete(Request $request){
        $id=$request->id;
        $pid=$request->pid;
        $res=DB::table('lottery_award')->where('id', '=', $id)->delete();
        parent::saveLog('删除活动详细id--'.$id);

        return redirect('/party/detailList?pid='.$pid);
    }
}
