<?php

namespace App\Http\Controllers;

use App\Repositories\GameListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class GameListController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'game_list';
    protected $gameListRepository;

    public function __construct(GameListRepository $gameListRepository)
    {
        $this->gameListRepository=$gameListRepository;
    }

    /**
     * 大厅列表配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['game_type'] = $_GET['game_type']??'';
        $res = $this->gameListRepository->info($param);
        $recordData = $this->gameListRepository->findRecordData() ? $this->gameListRepository->findRecordData() : array();
        $checkServerData = '';
        $checkCustomerData = '';
        if($recordData){
            $checkServerData = '';
            $checkCustomerData = '';
            if($recordData->server_record){
                foreach (json_decode($recordData->server_record) as $key => $value) {
                    $value = str_replace('server_', '', $value);
                    $checkServerData .= $value.',';
                }
                $checkServerData = substr($checkServerData, 0,strlen($checkServerData)-1);
            }
            if($recordData->customer_record){
                foreach (json_decode($recordData->customer_record) as $key => $value) {
                    $value = str_replace('customer_', '', $value);
                    $checkCustomerData .= $value.',';
                }
                $checkCustomerData = substr($checkCustomerData, 0,strlen($checkCustomerData)-1);
            }
        } 
        return view('GameList.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $games=DB::table('games')->get()->toArray();
        return view('GameList.add',['datagame'=>$games]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $GameListId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->GameListId;
        $results=DB::table('game_list')->where('GameListId', $primaryId)->first(); 
        $games=DB::table('games')->get()->toArray();
        return view('GameList.edit',['res'=>$results,'datagame'=>$games]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->GameListId;
        //base data
        $data['id']=$request->id;
        $data['game_type']=$request->game_type;
        $data['name']=$request->name;
        $data['icon']=$request->icon;
        $data['shown_type']=$request->shown_type;
        $data['status']=$request->status;
        
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('game_list')->select('id','game_type','name','icon','shown_type','status','updated_at')->where('GameListId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'大厅列表',$primaryId);
            $result=DB::table('game_list')->where('GameListId', $primaryId)->update($data); 
            parent::saveLog('大厅列表GameListId--'.$primaryId);
        }else{
            $result=DB::table('game_list')->insertGetId($data);
            parent::saveLog('大厅列表GameListId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/gamelist/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $GameListId=$request->GameListId;
        $res=DB::table('game_list')->where('GameListId', '=', $GameListId)->delete();
        parent::saveLog('删除大厅列表GameListId--'.$GameListId);

        return redirect('/gamelist/index');
    }

    /**
     * 数组转lua
     **/
    public function lua(Request $request){
        $type = $request->type;
        $lua = $request->lua;
        $select = $request->select;
        if($lua){
            //curl 数据到接口
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }
        //基础数组
        $res=$this->gameListRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'game_list';
                $data[$type.'_record'] = json_encode($select);
                DB::table('user_behavior_record')->where($where)->update($data);
                exit(json_encode(['status'=>1,'msg'=>'ok','lua_data'=>$luaData]));
            }catch (\Exception $e){
                exit(json_encode(['status'=>0,'msg'=>$e]));
            }
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    
    /**
     * 发送服务器配置
     * @param Request $request
     */
    protected function sndcfg(Request $request) {
        $cfgname = $this->sntcfg_btn;
        $param['select'] = $request->select;
        $lua_str=$this->gameListRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
