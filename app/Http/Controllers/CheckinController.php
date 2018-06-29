<?php

namespace App\Http\Controllers;

use App\Repositories\CheckinRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends BaseController
{
    protected $checkinRepository;

    function __construct(CheckinRepository $checkinRepository)
    {
        $this->checkinRepository=$checkinRepository;
    }

    public function list(){
        $frequency=config('sign.frequency');
        $type=$this->checkinRepository->getProps();
        $data=$this->checkinRepository->list();
        return view('checkin.list',['data'=>$data,'frequency'=>$frequency,'type'=>$type]);
    }

    public function find(Request $request){
        $id=$request->id;
        $frequency=config('sign.frequency');
        $type=$this->checkinRepository->getProps();
        $data=$this->checkinRepository->find($id);
        return view('checkin.edit',['data'=>$data,'frequency'=>$frequency,'type'=>$type]);
    }

    public function addshow(){
        $frequency=config('sign.frequency');
        $type=$this->checkinRepository->getProps();
        return view('checkin.add',['frequency'=>$frequency,'type'=>$type]);
    }

    public function postdata(Request $request){
        $checkin_id=(int)$request->checkin_id;

        $data['checkin_name']=$request->checkin_name;
        $data['items']=$request->items;//$request->role_num;
        $data['status']=$request->status;

        if($checkin_id){
            $preArr=DB::table('checkin_conf')->select('checkin_name','items','status')->where('checkin_id', $checkin_id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'签到',$checkin_id);

            $result=DB::table('checkin_conf')->where('checkin_id', $checkin_id)->update($data);
            parent::saveLog('更新签到id--'.$checkin_id);
        }else{
            $result=DB::table('checkin_conf')->insertGetId($data);
            parent::saveLog('添加签到id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }

    public function del(Request $request){
        $id=$request->id;
        if($this->checkinRepository->del($id)){
            parent::saveLog('删除签到id--'.$id);
            return redirect('/checkin/list');
        }else{
            return redirect('/checkin/list');
        }
    }

}
