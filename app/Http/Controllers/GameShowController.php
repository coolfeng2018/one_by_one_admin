<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\GameShowRepository;
use App\Repositories\GateWayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
class GameShowController extends BaseController
{
    protected $gameshowRepository;
    protected $gameRepository;
    protected $gatewayRepository;

    function __construct(GameShowRepository $gameShowRepository,GameRepository $gameRepository,GateWayRepository $gateWayRepository)
    {
        $this->gameshowRepository=$gameShowRepository;
        $this->gameRepository=$gameRepository;
        $this->gatewayRepository=$gateWayRepository;
    }
    //配置方案
    public function list(){
        $data=$this->gameshowRepository->list();
        return view('gameshow.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->gameshowRepository->find($id);
        return view('gameshow.edit',['data'=>$data]);
    }

    public function addshow(){
        return view('gameshow.add');
    }

    public function postdata(Request $request){
        $gameshow_id=$request->gameshow_id;

        $data['gameshow_name']=$request->gameshow_name;
        $data['allowChannel']=$request->allowChannel;
        $data['denyChannel']=$request->denyChannel;
        $data['allowVersion']=$request->allowVersion;
        $data['denyVersion']=$request->denyVersion;


        if($gameshow_id){
            $preArr=DB::table('game_show')->select('gameshow_name','allowChannel','denyChannel','allowVersion','denyVersion')->where('game_id', $gameshow_id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'展示列表方案',$gameshow_id);

            $result=DB::table('game_show')->where('game_id', $gameshow_id)->update($data);
            parent::saveLog('更新展示列表方案id--'.$gameshow_id);
        }else{
            $result=DB::table('game_show')->insertGetId($data);
            parent::saveLog('添加展示列表方案id--'.$result);
            $this->defaultCase($result);

        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }
    public function del(Request $request){
        $id=$request->id;
        //删除方案配置
        $res=DB::table('showpieces')->where('gameshow_id', '=', $id)->delete();
        parent::saveLog('删除展示列表方案id--'.$id);

        $id=$this->gameshowRepository->del($id);
        parent::saveLog('删除展示列表方案id--'.$id.'所有配置内容');

        return redirect('/gameshow/list');
    }



    //获取默认配置方案
//        protected function defaultCase($id){
//        $arr1=$this->gameshowRepository->getFirstLevel();
//        $arr2=$this->gameshowRepository->getSecondLevel();
//        foreach ($arr1 as $k=> $v){
//            $arr1[$k]['gameshow_id']=$id;
//            $result=DB::table('showpieces')->insertGetId($arr1[$k]);
//            if($v['ShowpiecesType']==2){
//                $caseNum=$result;
//            }
//        }
//        foreach ($arr2 as $key=> $val){
//            $arr2[$key]['gameshow_id']=$id;
//            $arr2[$key]['ParentId']=$caseNum;
//            $result=DB::table('showpieces')->insertGetId($arr2[$key]);
//        }
//    }


    protected function defaultCase($id){
        $arr1=$this->gameshowRepository->getFirstLevel();
        $arr2=$this->gameshowRepository->getSecondLevel();
        $arr3=$this->gameshowRepository->getFatherLevel();

        foreach ($arr1 as $k=>$v){
            $arr1[$k]['gameshow_id']=$id;
            $result=DB::table('showpieces')->insertGetId($arr1[$k]);
            $arr3[$k]['new']=$result;
        }
        foreach ($arr2 as $kk=>$vv){
            foreach ($arr3 as $kkk=>$vvv){
                if($vv['ParentId']==$vvv['ShowpiecesId']){
                    $arr2[$kk]['ParentId']=$vvv['new'];
                }
            }
            $arr2[$kk]['gameshow_id']=$id;
            $result=DB::table('showpieces')->insertGetId($arr2[$kk]);
        }
    }



    //配置方案内容
    public function showpieceslist(Request $request){
        $id=$request->id;
        $data=$this->gameshowRepository->find($id);
        $showpieces=$this->gameshowRepository->list_showpieces($id);
        $showpiecesdata=[];

        foreach ($showpieces as $v){
            if(isset($showpiecesdata[$v->ParentId])){
                $showpiecesdata[$v->ParentId]->gamelist[]=$v;
            }else{
                $showpiecesdata[$v->ShowpiecesId]=$v;
            }
        }
        $game=$this->gameRepository->listall();
        $pidshowpieces=$this->gameshowRepository->pidshowpieces();

        return view('gameshow.showpieceslist',['data'=>$data,'showpieces'=>$showpiecesdata,'game'=>$game,'pidshowpieces'=>$pidshowpieces]);
    }

    public function addshowpieces(Request $request){
        $id=$request->id;
        $res['id']=$id;
        $res['game']=$this->keyVal(1);
        return view('gameshow.addshowpieces',['data'=>$res]);
    }

    public function editshowpieces(Request $request){
        $id=$request->id;
        $results=DB::table('showpieces')->where('ShowpiecesId', $id)->get();
        $res['results']=$results;
        $res['game']=$this->keyVal(1);
        return view('gameshow.editshowpieces',['data'=>$res]);
    }

    public function postshowpieces(Request $request){
        $id=$request->id;

        $data['ShowpiecesName']=$request->name;
        $data['ShowpiecesType']=$request->type;
        $data['GameId']=$request->gameid;
        $data['SortNum']=$request->num;
        $data['Available']=$request->status;
        $data['gameshow_id']=$request->gid;
        if($id){
            $preArr=DB::table('showpieces')->select('ShowpiecesName','ShowpiecesType','GameId','SortNum','Available','gameshow_id')->where('ShowpiecesId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'更新展示列表方案id--'.$request->gid.'-配置内容',$id);

            $result=DB::table('showpieces')->where('ShowpiecesId', $id)->update($data);
            parent::saveLog('更新展示列表方案id--'.$request->gid.'-配置内容id--'.$id);
        }else{
            $result=DB::table('showpieces')->insertGetId($data);
            parent::saveLog('添加展示列表方案id--'.$request->gid.'-配置内容id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/showpieces/list?id='.$request->gid]));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    public function delshowprieces(Request $request){
        $id=$request->id;
        $results=DB::table('showpieces')->select('ShowpiecesType','ParentId','gameshow_id')->where('ShowpiecesId', $id)->get();
        $tmp=json_decode(json_encode($results), true);
        if($tmp[0]['ShowpiecesType']==2 &&$tmp[0]['ParentId']==0){
            $res=DB::table('showpieces')->where('ShowpiecesId', '=', $id)->orwhere('ParentId', '=', $id)->delete();
        }else{
            $res=DB::table('showpieces')->where('ShowpiecesId', '=', $id)->delete();
        }
        parent::saveLog('删除展示列表方案--配置内容id--'.$id);
        return redirect("/showpieces/list?id=".$tmp[0]['gameshow_id']);
    }




    //子集添加
    public function addpart(Request $request){
        $pid=$request->pid;
        $gid=$request->gid;
        $res['pid']=$pid;
        $res['gid']=$gid;
        $res['game']=$this->keyVal();
        return view('gameshow.addpart',['data'=>$res]);
    }

    public function savepart(Request $request){
        $data['ShowpiecesName']=$request->name;
        $data['ShowpiecesType']=$request->type;
        $data['GameId']=$request->gameid;
        $data['SortNum']=$request->num;
        $data['Available']=$request->status;
        $data['gameshow_id']=$request->gid;
        $data['ParentId']=$request->pid;

        $result=DB::table('showpieces')->insertGetId($data);
        parent::saveLog('添加展示列表方案--配置内容子集--'.$result);
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/showpieces/list?id='.$request->gid]));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }




    //发布
    public function postedgame(Request $request){
        $gateway=$this->getProGatewayList();
        if($gateway){
            $res=$this->getProSetting();
            
            try{
                Redis::set('GameShowPiecesSetting',$res);
                return response()->json(['status'=>1,'msg'=>'发布成功']);
            }catch (\Exception $e){
                return response()->json(['status'=>0,'msg'=>'游戏展示列表出现错误']);
            }
        }else{
            return response()->json(['status'=>0,'msg'=>'有效网关列表出现错误']);
        }
    }

    //有效网关列表
    protected function getProGatewayList(){

        $tmp=$this->gatewayRepository->gatewayList();
        $res=json_decode(json_encode($tmp), true);

        if($res){
            $sid=[];
            foreach ($res as $k=>$v){
                if(!isset($sid[$v['server_id']])){
                    $sid[$v['server_id']]=[];
                }
                array_push($sid[$v['server_id']],['ServerIp'=>$v['IP'],'ServerPort'=>$v['prot'],'Sort'=>$v['SortID']]);
            }
            try{
                $gatewayList=json_encode($sid);
                Redis::set('gatewayList',$gatewayList);
                return 1;
            }catch (\Exception $e){
                return 0;
            }
        }else{
            return 0;
        }
    }
    //游戏展示列表
    protected function getProSetting(){
        /**
         *游戏分类信息
         *game_id   唯一标识
         *kind_id   1001 牛牛 1002 百人牛牛  1003 炸金花
         *scene_id  1金币场  2私人场
         **/
        $sql='select game_id,kind_id,scene_id from games';
        $gameList=DB::select($sql);
        $gameList=json_decode(json_encode($gameList), true);

        //有效网关信息
        $sql='select a.game_id,b.server_id from games as a 
              join games_server as b on a.kind_id=b.kind_id and a.scene_id=b.game_type 
              join gateways as c on b.server_id=c.server_id 
              join gateway_info as d on c.gateway_id=d.GateWay_ID where d.IsLock=1 ';
        $serverList=DB::select($sql);
        $serverList=json_decode(json_encode($serverList), true);

        $gid=$sid=[];
        //根据game_id重组游戏信息
        foreach ($gameList as $kk=>$vv){
            if(!isset($gid[$vv['game_id']])){
                $gid[$vv['game_id']]=[];
            }
            array_push($gid[$vv['game_id']],['GameId'=>$vv['kind_id'],'GameType'=>$vv['scene_id']]);
        }
        //根据game_id获取其相应的有效server_id列表
        foreach ($serverList as $k=>$v){
            if(!isset($sid[$v['game_id']])){
                $sid[$v['game_id']]=[];
            }
            if(!in_array($v['server_id'],$sid[$v['game_id']])){
                array_push($sid[$v['game_id']],$v['server_id']);
            }
        }

        //方案信息
        $res = DB::table('game_show')->select('gameshow_id','allowChannel','denyChannel','allowVersion','denyVersion')->get();
        $tmp=json_decode(json_encode($res), true);
        $newRes=[];

        foreach ($tmp as $k => $v){

            if($v['allowChannel']!='*'){
                if($v['allowChannel']==''){
                    $newRes[$k]['allowChannel']=[];
                }else{
                    $newRes[$k]['allowChannel']=$this->stringToArray($v['allowChannel']);
                }
            }else{
                $newRes[$k]['allowChannel']=[$v['allowChannel']];
            }

            if($v['denyChannel']!='*'){
                if($v['denyChannel']==''){
                    $newRes[$k]['denyChannel']=[];
                }else{
                    $newRes[$k]['denyChannel']=$this->stringToArray($v['denyChannel']);
                }
            }else{
                $newRes[$k]['denyChannel']=[$v['denyChannel']];
            }

            if($v['allowVersion']!='*'){
                if($v['allowVersion']==''){
                    $newRes[$k]['allowVersion']=[];
                }else{
                    $newRes[$k]['allowVersion']=$this->stringToArray($v['allowVersion']);
                }
            }else{
                $newRes[$k]['allowVersion']=[$v['allowVersion']];
            }

            if($v['denyVersion']!='*'){
                if($v['denyVersion']==''){
                    $newRes[$k]['denyVersion']=[];
                }else{
                    $newRes[$k]['denyVersion']=$this->stringToArray($v['denyVersion']);
                }
            }else{
                $newRes[$k]['denyVersion']=[$v['denyVersion']];
            }

            //一层配置信息
            $arr = DB::table('showpieces')
                ->select( 'ShowpiecesName as Name', 'ShowpiecesType as Type', 'SortNum', 'ShowpiecesId','GameId as gid','Available as Status')
                ->where('gameshow_id','=',$v['gameshow_id'])
                ->where('ParentId','=',0)
                ->orderBy('gameshow_id','desc')
                ->orderBy('ShowpiecesType','asc')
                ->get();

            $arr=json_decode(json_encode($arr), true);

            foreach ($arr as $key=>$val){
                if($val['Type']==2){

                    $result[$key]['Name'] = $val['Name'];
                    $result[$key]['Type'] = $val['Type'];
                    //二层配置信息
                    $arrLevel = DB::table('showpieces')
                        ->select( 'ShowpiecesName as Name', 'ShowpiecesType as Type', 'SortNum','GameId as gid','Available as Status')
                        ->where('showpieces.gameshow_id','=',$v['gameshow_id'])
                        ->where('showpieces.ParentId','=',$val['ShowpiecesId'])
                        ->orderBy('showpieces.gameshow_id','desc')
                        ->orderBy('showpieces.ShowpiecesType','asc')
                        ->get();

                    $arrLevel=json_decode(json_encode($arrLevel), true);
                    $lowLevel=[];
                    foreach ($arrLevel as $kkk =>$vvv){

                        $lowLevel[$kkk]['Name']=$vvv['Name'];
                        $lowLevel[$kkk]['Type']=$vvv['Type'];
                        $lowLevel[$kkk]['SortNum']=$vvv['SortNum'];
                        $lowLevel[$kkk]['Status']=$vvv['Status'];

                        $lowLevel[$kkk]['GameId'] = $gid[$vvv['gid']][0]['GameId'];
                        $lowLevel[$kkk]['GameType'] = $gid[$vvv['gid']][0]['GameType'];
                        $lowLevel[$kkk]['serverList'] = $sid[$vvv['gid']];
                    }
                    $result[$key]['GameList'] = $lowLevel;
                }else{
                    $result[$key]['Name'] = $val['Name'];
                    $result[$key]['Type'] = $val['Type'];
                    $result[$key]['SortNum'] = $val['SortNum'];
                    $result[$key]['Status'] = $val['Status'];

                    $result[$key]['GameId'] = $gid[$val['gid']][0]['GameId'];
                    $result[$key]['GameType'] = $gid[$val['gid']][0]['GameType'];
                    $result[$key]['serverList'] = $sid[$val['gid']];
                }
            }
            $newRes[$k]['showpieces']=$result;
        }

        $results=json_encode($newRes);
        return $results;
    }

    //获取分类，道具,促销列表
    protected function keyVal($item=0){
        $arr=[];
        if($item==1){
            $arr['0']="(集合)";
        }
        $res=DB::table('games')->select('game_id','game_name','scene_id')->get();
        $tmp=json_decode(json_encode($res), true);

        foreach($tmp as  $k => $v){
            if($v['scene_id']==1){
                $type='金币场';
            }elseif($v['scene_id']==2){
                $type='私人场';
            }else{
                $type='';
            }
            $arr[$v['game_id']]=$v['game_name'].$type;
        }
        return $arr;
    }

    protected function stringToArray($str){
        $arr=explode(',',$str);
        return $arr;
    }
}
