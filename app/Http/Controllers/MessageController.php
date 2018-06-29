<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends BaseController
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository=$messageRepository;
    }

    public function list(){
        $data=$this->messageRepository->list();
        return view('message.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->messageRepository->find($id);
        return view('message.edit',['data'=>$data]);
    }

    public function addshow(){
        return view('message.add');
    }

    public function postdata(Request $request){
        $message_id=(int)$request->message_id;

        $data['concent']=$request->concent;
        $data['statrtime']=$request->statrtime;
        $data['endtime']=$request->endtime;
        $data['interval']=$request->interval;


        if($message_id){
            $preArr=DB::table('message')->select('concent','statrtime','endtime','interval')->where('message_id', $message_id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'庄家',$message_id);

            $result=DB::table('message')->where('message_id', $message_id)->update($data);
            parent::saveLog('更新广播id--'.$message_id);
        }else{
            $data['createtime']=date('Y-m-d H:i:s');
            $result=DB::table('message')->insertGetId($data);
            parent::saveLog('添加广播id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }
    }

    public function del(Request $request){
        $id=$request->id;
        if($this->messageRepository->del($id)){
            parent::saveLog('删除广播id--'.$id);
            return redirect('/message/list');
        }
    }
}
