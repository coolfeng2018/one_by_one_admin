<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends BaseController
{
    protected $gamesRepository;

    function __construct(GameRepository $gamesRepository)
    {
        $this->gamesRepository=$gamesRepository;
    }

    //
    public function list(){
        $result=$this->gamesRepository->list();
        return view('game.list',['data'=>$result]);
    }

    public function addshow(){
        return view('game.add');
    }

    public function postdata(Request $request){

        $game_id=(int)$request->game_id;


        $data['game_id']=$request->game_id;
        $data['game_type']=$request->game_type;
        $data['game_name']=$request->game_name;
        // $data['game_icon_url']=$request->game_icon_url;
        if($game_id){
            $preArr=DB::table('games')->select('game_id','game_type','game_name','game_icon_url')->where('game_id', $game_id)->first();
            //验证游戏类型是否重复
            if($preArr->game_type!=$data['game_type']){
                $gameType = DB::table('games')->where(['game_type'=>$data['game_type']])->first();
                if($gameType){
                    exit(json_encode(['status'=>0,'msg'=>'游戏类型:'.$data['game_type'].' 已存在!']));
                }
            }
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'游戏列表',$game_id);

            $result=DB::table('games')->where('game_id', $game_id)->update($data);
            parent::saveLog('更新游戏列表id--'.$game_id);
        }else{
            //验证游戏类型是否重复
            $gameType = DB::table('games')->where(['game_type'=>$data['game_type']])->first(); 
            if($gameType){
                exit(json_encode(['status'=>0,'msg'=>'游戏类型:'.$data['game_type'].' 已存在!']));
            }
            $result=DB::table('games')->insertGetId($data);
            parent::saveLog('添加游戏列表id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }

    public function del(Request $request){
        $id=$request->id;
        if($this->gamesRepository->del($id)){
            parent::saveLog('删除游戏列表id--'.$id);
            return redirect('/game/list');
        }else{
            return redirect('/game/list');
        }
    }

    public  function editshow(Request $request){
        $id=$request->id;
        $data=$this->gamesRepository->find($id);

        return view('game.edit',['data'=>$data]);
    }

    /*
     * ajax上传图片
     */
    public function uploads(Request $request){
        $file = $request->file('file');
        $repath = $request->repath??'active';
        $preDir='uploads';
        $path = $file->store('/active',$preDir );

        $client=new Client();

        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($preDir.'/'.$path,'r')],['name'=>'type','contents'=>$repath]]]);

        if($response->getStatusCode()==200) {
            $result=$response->getBody();
            $result=json_decode($result);
            if($result->status==200) {
                unlink($preDir.'/'.$path);
                $resPath=$result->data->filePath;
            }else{
                $resPath='';
            }
        }else{
            $resPath='';
        }
        return response()->json(array('msg' => $resPath,'RemoteDir'=>config('suit.ImgRemoteUrl')));
    }

    public function getGameType(Request $request){
        $request = $request->game_type;
        $result=$this->gamesRepository->gametype($request);
        exit(json_encode($result));
    }
}
