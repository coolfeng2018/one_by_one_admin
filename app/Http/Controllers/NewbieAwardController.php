<?php

namespace App\Http\Controllers;

use App\Repositories\NewbieAwardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class NewbieAwardController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'newbie_award';
    protected $newbieAwardRepository;

    public function __construct(NewbieAwardRepository $newbieAwardRepository)
    {
        $this->newbieAwardRepository=$newbieAwardRepository;
    }

    /**
     * 新手奖励配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['item_id'] = $_GET['item_id']??'';
        $res = $this->newbieAwardRepository->info($param);
        $recordData = $this->newbieAwardRepository->findRecordData() ? $this->newbieAwardRepository->findRecordData() : array();
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
        return view('NewbieAward.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $item=DB::table('item')->get()->toArray();
        return view('NewbieAward.add',['item'=>$item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $NewbieAwardId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->NewbieAwardId;
        $results=DB::table('newbie_award')->where('NewbieAwardId', $primaryId)->first();  
        $item=DB::table('item')->get()->toArray();
        return view('NewbieAward.edit',['res'=>$results,'item'=>$item]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->NewbieAwardId;
        //base data
        $data['id']=$request->id;
        $data['item_id']=$request->item_id;
        $data['count']=$request->count;
 
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('newbie_award')->select('id','item_id','count')->where('NewbieAwardId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'新手奖励',$primaryId);
            $result=DB::table('newbie_award')->where('NewbieAwardId', $primaryId)->update($data); 
            parent::saveLog('新手奖励NewbieAwardId--'.$primaryId);
        }else{
            $result=DB::table('newbie_award')->insertGetId($data);
            parent::saveLog('新手奖励NewbieAwardId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/newbieaward/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $NewbieAwardId=$request->NewbieAwardId;
        $res=DB::table('newbie_award')->where('NewbieAwardId', '=', $NewbieAwardId)->delete();
        parent::saveLog('删除新手奖励NewbieAwardId--'.$NewbieAwardId);

        return redirect('/newbieaward/index');
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
        $res=$this->newbieAwardRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'newbie_award';
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
        $lua_str=$this->newbieAwardRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
