<?php

namespace App\Http\Controllers;

use App\Repositories\HorseMessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class HorseMessageController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'horse_message';
    protected $horseMessageRepository;

    public function __construct(HorseMessageRepository $horseMessageRepository)
    {
        $this->horseMessageRepository=$horseMessageRepository;
    }

    /**
     * 跑马灯配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['ID'] = $_GET['ID']??'';
        $param['content'] = $_GET['content']??'';
        $res = $this->horseMessageRepository->info($param);
        $recordData = $this->horseMessageRepository->findRecordData() ? $this->horseMessageRepository->findRecordData() : array();
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
        return view('HorseMessage.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('HorseMessage.add');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $HorseMessageId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->HorseMessageId;
        $results=DB::table('horse_message')->where('HorseMessageId', $primaryId)->first();  
        return view('HorseMessage.edit',['res'=>$results]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->HorseMessageId;
        //base data
        $data['ID']=$request->ID;
        $data['content']=$request->content;
        $data['min_time']=$request->min_time;
        $data['max_time']=$request->max_time;
            
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('horse_message')->select('ID','content','min_time','max_time')->where('HorseMessageId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'跑马灯',$primaryId);
            $result=DB::table('horse_message')->where('HorseMessageId', $primaryId)->update($data); 
            parent::saveLog('跑马灯HorseMessageId--'.$primaryId);
        }else{
            $result=DB::table('horse_message')->insertGetId($data);
            parent::saveLog('跑马灯HorseMessageId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/horsemessage/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $HorseMessageId=$request->HorseMessageId;
        $res=DB::table('horse_message')->where('HorseMessageId', '=', $HorseMessageId)->delete();
        parent::saveLog('删除跑马灯HorseMessageId--'.$HorseMessageId);

        return redirect('/horsemessage/index');
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
        $res=$this->horseMessageRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'horse_message';
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
        $lua_str=$this->horseMessageRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
