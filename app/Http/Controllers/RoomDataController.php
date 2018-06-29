<?php

namespace App\Http\Controllers;

use App\Repositories\RoomDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class RoomDataController extends BaseController
{
    protected $roomDataRepository;
    public $cfg = array(
        ''=>'无机器人',
        'nn_normol' =>'牛牛普通场',
        'zjh_junior'=>'扎金花初级场',
        'zjh_normal'=>'扎金花普通场',
        'hhdz_normal'=>'红黑大战普通场',       
    );
    public function __construct(RoomDataRepository $roomDataRepository)
    {
        $this->roomDataRepository=$roomDataRepository;
    }

    /**
     * 房间配置配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $res = $this->roomDataRepository->info();
        $recordData = $this->roomDataRepository->findRecordData() ? $this->roomDataRepository->findRecordData() : array();
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
        return view('RoomData.index',['res'=>$res,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'rtype'=>$this->cfg]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('RoomData.add',['rtype'=>$this->cfg]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $RoomdataId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->RoomdataId;
        $results=DB::table('roomdata')->where('RoomdataId', $primaryId)->first();  
        return view('RoomData.edit',['res'=>$results,'rtype'=>$this->cfg]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->RoomdataId;
        //base data
        $data['ID']=$request->ID;
        $data['name']=$request->name;
        $data['min']=$request->min;
        $data['max']=$request->max;
        $data['cost']=$request->cost;
        $data['dizhu']=$request->dizhu;
        $data['dingzhu']=$request->dingzhu;
        $data['max_look_round']=$request->max_look_round;
        $data['comparable_bet_round']=$request->comparable_bet_round;
        $data['max_bet_round']=$request->max_bet_round;
        $data['img_bg']=$request->img_bg;
        $data['img_icon']=$request->img_icon;
        $data['open_robot']=$request->open_robot;
        $data['robot_type']=$request->robot_type;
        $data['grab_banker_times']=$request->grab_banker_times;
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('roomdata')->select('ID','name','min','max','cost','dizhu','dingzhu','max_look_round','comparable_bet_round','max_bet_round','img_bg','img_icon','open_robot','robot_type','grab_banker_times')->where('RoomdataId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'房间配置',$primaryId);
            $result=DB::table('roomdata')->where('RoomdataId', $primaryId)->update($data); 
            parent::saveLog('房间配置RoomdataId--'.$primaryId);
        }else{
            $result=DB::table('roomdata')->insertGetId($data);
            parent::saveLog('房间配置RoomdataId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/roomdata/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $RoomdataId=$request->RoomdataId;
        $res=DB::table('roomdata')->where('RoomdataId', '=', $RoomdataId)->delete();
        parent::saveLog('删除房间配置RoomdataId--'.$RoomdataId);

        return redirect('/roomdata/index');
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
        $res=$this->roomDataRepository->baseArray($request);
        foreach ($res as $key => $value) {
           $res[$key]['open_robot'] = $value['open_robot']==1 ? true : false;
        } 
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'roomdata';
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
}
