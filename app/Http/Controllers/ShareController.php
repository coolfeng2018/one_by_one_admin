<?php

namespace App\Http\Controllers;

use App\Repositories\ShareRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ShareController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'share';
    protected $newbieAwardRepository;

    public function __construct(ShareRepository $newbieAwardRepository)
    {
        $this->newbieAwardRepository=$newbieAwardRepository;
    }

    /**
     * 游戏分享配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['title'] = $_GET['title']??'';
        $param['channel'] = $_GET['channel']??'';
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
        return view('Share.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('Share.add');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ShareId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->ShareId;
        $results=DB::table('share')->where('ShareId', $primaryId)->first();  
        return view('Share.edit',['res'=>$results]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->ShareId;
        //base data
        $data['channel']=$request->channel;
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

 
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('share')->select('channel','title','des','targetUrl','img','shareImg','sharetype','sharetab','task_share_title','task_share_content','task_share_url')->where('ShareId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'游戏分享',$primaryId);
            $result=DB::table('share')->where('ShareId', $primaryId)->update($data); 
            parent::saveLog('游戏分享ShareId--'.$primaryId);
        }else{
            $result=DB::table('share')->insertGetId($data);
            parent::saveLog('游戏分享ShareId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/share/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $ShareId=$request->ShareId;
        $res=DB::table('share')->where('ShareId', '=', $ShareId)->delete();
        parent::saveLog('删除游戏分享ShareId--'.$ShareId);

        return redirect('/share/index');
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
                $where['table_name'] = 'share';
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
