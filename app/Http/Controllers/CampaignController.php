<?php

namespace App\Http\Controllers;

use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends BaseController
{
    protected $campaignRepository;

    function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository=$campaignRepository;
    }

    public function list(){
        $data=$this->campaignRepository->list();
        return view('campaign.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->campaignRepository->find($id);
        return view('campaign.edit',['data'=>$data]);
    }

    public function addshow(){
        return view('campaign.add');
    }

    public function postdata(Request $request){
        $campaignid=(int)$request->CampaignId;

        $data['Title']=$request->title;
        $data['Description']=$request->des;
        $data['ImageUrl']=$request->imageurl;
        $data['StartTime']=$request->starttime;
        $data['EndTime']=$request->endtime;
        $data['Action']=$request->action;
        $data['ActionType']=(int)$request->actiontype;
        $data['Status']=(int)$request->status;
        $data['Tag']=$request->tag;
        $data['Sort']=$request->sort;

        if($campaignid){
            $preArr=DB::table('campaign')->select('Title','Description','ImageUrl','StartTime','EndTime','Action','ActionType','Status','Tag','Sort')->where('CampaignId', $campaignid)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'活动',$campaignid);

            $result=DB::table('campaign')->where('CampaignId', $campaignid)->update($data);
            parent::saveLog('更新活动id--'.$campaignid);
        }else{
            $result=DB::table('campaign')->insertGetId($data);
            parent::saveLog('添加活动id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }

    public function del(Request $request){
        $id=$request->id;

        if($this->campaignRepository->del($id)){
            parent::saveLog('删除活动id--'.$id);
            return redirect('/campaign/list');
        }else{
            return redirect('/campaign/list');
        }
    }
}
