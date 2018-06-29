<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ChannelVersionRepository;



class ChannelVersionController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'channel_version';
    protected $channelVersionRepository;

    public function __construct(ChannelVersionRepository $channelVersionRepository)
    {
        $this->channelVersionRepository=$channelVersionRepository;
    }

    /**
     * 任务分享公告配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['curr_version'] = $_GET['curr_version']??'';
        $param['task_share_title'] = $_GET['task_share_title']??'';
        $res = $this->channelVersionRepository->info($param);
        $recordData = $this->channelVersionRepository->findRecordData();
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
        return view('ChannelVersion.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('ChannelVersion.add');
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->ChannelVersionId;
        //base data
        $data['id']=$request->id;
        $data['curr_version']=$request->curr_version;
        $data['title']=$request->title;
        $data['des']=$request->des;
        $data['targetUrl']=$request->targetUrl;
        $data['img']=$request->img;
        $data['shareImg']=$request->shareImg;
        $data['sharetype']=$request->sharetype;
        $data['sharetab']=$request->sharetab;
        $data['task_share_title']=$request->task_share_title;
        $data['task_share_content']=$request->task_share_content;
        $data['task_share_url']=$request->task_share_url;
        $data['announcement_url']=$request->announcement_url;
        $data['kefu_url']=$request->kefu_url;
        $data['agent_url']=$request->agent_url;
        $data['payment_ways']=$request->payment_ways;
        $data['payment_channels']=$request->payment_channels;
        
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('channel_version')->select('id','curr_version','title','des','targetUrl','img','shareImg','sharetype','sharetab','task_share_title','task_share_content','task_share_url','announcement_url','kefu_url','agent_url','agent_url','payment_ways','payment_channels')->where('ChannelVersionId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'任务分享公告',$primaryId);

            $result=DB::table('channel_version')->where('ChannelVersionId', $primaryId)->update($data);
            parent::saveLog('任务分享公告ChannelVersionId--'.$primaryId);
        }else{
            $result=DB::table('channel_version')->insertGetId($data);
            parent::saveLog('任务分享公告ChannelVersionId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/channelVersion/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ChannelVersionId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->ChannelVersionId;
        $results=DB::table('channel_version')->where('ChannelVersionId', $primaryId)->first();
        return view('ChannelVersion.edit',['res'=>$results]);
    }

    public function delete(Request $request){
        $ChannelVersionId=$request->ChannelVersionId;
        $res=DB::table('channel_version')->where('ChannelVersionId', '=', $ChannelVersionId)->delete();
        parent::saveLog('删除任务分享公告ChannelVersionId--'.$ChannelVersionId);

        return redirect('/channelVersion/index');
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
        $res=$this->channelVersionRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'channel_version';
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
        $lua_str=$this->channelVersionRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
    
    

    
}
