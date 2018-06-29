<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\ServersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServersController extends BaseController
{
    protected $serverRepository;
    protected $gamesRepository;

    function __construct(ServersRepository $serverRepository,GameRepository $gamesRepository)
    {
        $this->serverRepository=$serverRepository;
        $this->gamesRepository=$gamesRepository;
    }

    public function list(){
        $data=$this->serverRepository->list();
        return view('gameservers.list',['data'=>$data]);
    }

    public function find(Request $request){
        $games_server_id=$request->id;
        $games=$this->gamesRepository->listall();
        $data=$this->serverRepository->find($games_server_id);
        return view('gameservers.edit',['data'=>$data,'games'=>$games]);
    }

    public function addshow(){
        $games=$this->gamesRepository->listall();
        return view('gameservers.add',['games'=>$games]);
    }

    public function  postdata(Request $request){
//        $server_id=(int)$request->server_id;
        $subtype=$request->subtype;

        $data['server_name']=$request->server_name;
        //$data['server_ip']=$request->server_ip;
        //$data['server_port']=$request->server_port;
        //$data['online_quantity']=$request->online_quantity;
        $data['kind_id']=$request->kind_id;
        $data['deskset_level']=$request->level;
        if($subtype=='add'){//添加
            $result=$this->serverRepository->add($data);
            if($result){
                parent::saveLog('添加游戏服务id--'.$result);
                return json_encode(['status'=>200,'msg'=>'添加成功']);
            }else{
                return json_encode(['status'=>500,'msg'=>'添加失败']);
            }
        }else{ //修改
            if($this->serverRepository->edit($data,$request->games_server_id)){
                parent::saveLog('更新游戏服务id--'.$request->server_id);
                return json_encode(['status'=>200,'msg'=>'修改成功']);
            }else{
                return json_encode(['status'=>200,'msg'=>'修改失败']);
            }
        }
    }

    public function del(Request $request){
        $id=$_GET['id'];
        var_dump($id);
        if($this->serverRepository->del($id)){
            parent::saveLog('删除游戏服务id--'.$id);
            return redirect('/gameserver/list');
        }
    }

    public function findbydeskset(Request $request){
        $id=$request->id;
        $data=$this->serverRepository->findbydeskset($id);
        return $data;
    }


}
