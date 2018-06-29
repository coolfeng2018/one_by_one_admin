<?php

namespace App\Http\Controllers;

use App\Repositories\FriendRoomDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class FriendRoomDataController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'friendroomdata';
    protected $friendRoomDataRepository;

    public function __construct(FriendRoomDataRepository $friendRoomDataRepository)
    {
        $this->friendRoomDataRepository=$friendRoomDataRepository;
    }

    /**
     * 好友房配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $res = $this->friendRoomDataRepository->info();
        $recordData = $this->friendRoomDataRepository->findRecordData() ? $this->friendRoomDataRepository->findRecordData() : array();
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
        return view('FriendRoomData.index',['res'=>$res,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('FriendRoomData.add');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $FriendRoomdataId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->FriendRoomdataId;
        $results=DB::table('friendroomdata')->where('FriendRoomdataId', $primaryId)->first();  
        return view('FriendRoomData.edit',['res'=>$results]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->FriendRoomdataId;
        //base data
        $data['table_type']=$request->table_type;
        $data['name']=$request->name;
        $data['is_club']=$request->is_club;
        $data['cost_type']=$request->cost_type;
        $data['cost']=$request->cost;
        $data['aa_cost']=$request->aa_cost;
        $data['max_count']=$request->max_count;
        $data['play_num']=$request->play_num;
        $data['min_dizhu']=$request->min_dizhu;
        $data['max_dizhu']=$request->max_dizhu;
        $data['min_white_dizhu']=$request->min_white_dizhu;
        $data['max_white_dizhu']=$request->max_white_dizhu;
        $data['min_ration']=$request->min_ration;
        $data['max_ration']=$request->max_ration;
        $data['comparable_bet_round']=$request->comparable_bet_round;
        $data['max_bet_round']=$request->max_bet_round;
        $data['max_look_round']=$request->max_look_round;
        $data['max_need_money']=$request->max_need_money;
        $data['white_list']=$request->white_list;
        $data['ration']=$request->ration;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('friendroomdata')->select('table_type','name','is_club','cost_type','cost','aa_cost','max_count','play_num','min_dizhu','max_dizhu','min_white_dizhu','max_white_dizhu','min_ration','max_ration','comparable_bet_round','max_bet_round','max_look_round','max_need_money','white_list','ration')->where('FriendRoomdataId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'好友房',$primaryId);
            $result=DB::table('friendroomdata')->where('FriendRoomdataId', $primaryId)->update($data); 
            parent::saveLog('好友房FriendRoomdataId--'.$primaryId);
        }else{
            $result=DB::table('friendroomdata')->insertGetId($data);
            parent::saveLog('好友房FriendRoomdataId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/friendroomdata/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $FriendRoomdataId=$request->FriendRoomdataId;
        $res=DB::table('friendroomdata')->where('FriendRoomdataId', '=', $FriendRoomdataId)->delete();
        parent::saveLog('删除好友房FriendRoomdataId--'.$FriendRoomdataId);

        return redirect('/friendroomdata/index');
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
        $res=$this->friendRoomDataRepository->baseArray($request);
        foreach ($res as $key => $value) {
           $res[$key]['is_club'] = $value['is_club']==1 ? true : false;
        } 
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'friendroomdata';
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
        $lua_str=$this->friendRoomDataRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
    
    
}
