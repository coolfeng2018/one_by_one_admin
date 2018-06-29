<?php

namespace App\Http\Controllers;

use App\Repositories\AnnouncementRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends BaseController
{
    protected $announcementRepository;

    function __construct(AnnouncementRepository $announcementRepository)
    {
        $this->announcementRepository=$announcementRepository;
    }

    public function list(){
        $data=$this->announcementRepository->list();
        return view('announcement.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->announcementRepository->find($id);
        return view('announcement.edit',['data'=>$data]);
    }

    public function addshow(){
        return view('announcement.add');
    }

    public function postdata(Request $request){
        $announcementid=(int)$request->AnnouncementId;

        $data['Title']=$request->title;
        $data['Description']=$request->des;
        $data['ImageUrl']=$request->imageurl;
        $data['StartTime']=$request->starttime;
        $data['EndTime']=$request->endtime;
        $data['Action']=$request->action;
        $data['ActionType']=$request->actiontype;
        $data['Status']=$request->status;
        $data['Tag']=$request->tag;
        $data['Sort']=$request->sort;


        if($announcementid){
            $preArr=DB::table('announcement')->select('Title','Description','ImageUrl','StartTime','EndTime','Action','ActionType','Status','Tag','Sort')->where('AnnouncementId', $announcementid)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'公告',$announcementid);

            $result=DB::table('announcement')->where('AnnouncementId', $announcementid)->update($data);
            parent::saveLog('更新公告id--'.$announcementid);
        }else{
            $result=DB::table('announcement')->insertGetId($data);
            parent::saveLog('添加公告id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }
    }

    public function del(Request $request){
        $id=$request->id;
        if($this->announcementRepository->del($id)){
            parent::saveLog('删除公告id--'.$id);
            return redirect('/announcement/list');
        }else{
            return redirect('/announcement/list');
        }
    }
}
