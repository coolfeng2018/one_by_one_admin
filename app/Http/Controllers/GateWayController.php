<?php

namespace App\Http\Controllers;

use App\Repositories\GateWayRepository;
use App\Repositories\ServersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GateWayController extends BaseController
{
    protected $gatewayRepository;
    protected $serverRepository;

    function __construct(GateWayRepository $gateWayRepository,ServersRepository $serversRepository)
    {
        $this->gatewayRepository=$gateWayRepository;
        $this->serverRepository=$serversRepository;
    }

    public function list(){
        $data=$this->gatewayRepository->list();
        return view('gateway.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->gatewayRepository->find($id);
        $server=$this->serverRepository->listall();
        $serveridarr=[];
        foreach ($data->server_id as $v){
            $serveridarr[$v->server_id]=$v->server_id;
        }
        return view('gateway.edit',['data'=>$data,'server'=>$server,'server_id'=>$serveridarr]);
    }

    public function addshow(){
        $server=$this->serverRepository->listall();
        return view('gateway.add',['server'=>$server]);
    }

    public function postdata(Request $request){
        $gateway_id=(int)$request->gateway_id;

        $data['GameWayName']=$request->gamewayname;
        $data['Role_Num']=0;//$request->role_num;
        $data['SortID']=$request->sortid;
        $data['IsLock']=$request->islock;

        $data['server_id']=$request->server_id;

        if($gateway_id==0){//添加
            $result=$this->gatewayRepository->add(explode(',',$request->ip),$data);
            parent::saveLog('添加网关服务id--'.$result);
            if($result){
                return json_encode(['status'=>200,'msg'=>'添加成功']);
            }else{
                return json_encode(['status'=>500,'msg'=>'添加失败']);
            }
        }else{ //修改
            $data['IP']=$request->ip;
            $data['prot']=$request->prot;
            parent::saveLog('更新网关服务id--'.$gateway_id);
            if($this->gatewayRepository->edit($data,$gateway_id)){
                return json_encode(['status'=>200,'msg'=>'修改成功']);
            }else{
                return json_encode(['status'=>200,'msg'=>'修改失败']);
            }
        }
    }

    public function del(Request $request){
        $id=$request->id;
        if($this->gatewayRepository->del($id)){
            parent::saveLog('删除网关服务id--'.$id);
            return redirect('/gateway/list');
        }else{
            return redirect('/gateway/list');
        }
    }

    //批量修改状态
    public function batchupdatestatus(Request $request){
        $id=$request->id;
        $status=$request->islock;
        if($this->gatewayRepository->batchupdatestatus(implode(',',$id),$status)){
            return json_encode(['status'=>200,'msg'=>'修改成功']);
        }else{
            return json_encode(['status'=>500,'msg'=>'修改失败']);
        }
    }

    //批量修改权重排序
    public function batchupdateSortID(Request $request){
        $id=$request->id;
        $SortID=$request->SortID;
        if($this->gatewayRepository->batchupdateSortID(implode(',',$id),$SortID)){
            return json_encode(['status'=>200,'msg'=>'修改成功']);
        }else{
            return json_encode(['status'=>500,'msg'=>'修改失败']);
        }
    }

    
    protected function objectToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }

}
