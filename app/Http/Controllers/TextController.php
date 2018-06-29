<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\TextRepository;


class TextController extends BaseController
{
    /**
     * 是否现实发送到服务器按钮 
     * @var string
     */
    protected $sntcfg_btn = 'text';
    protected $textRepository;
          
    public function __construct(TextRepository $textRepository)
    {
        $this->textRepository=$textRepository;
    }

    /**
     * 文本配置列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['type']=$_GET['type']??'';
        $param['content']=$_GET['content']??'';
        // $param['id']=$_GET['id']??'';
        $res=$this->textRepository->info($param);
        $recordData=$this->textRepository->findRecordData();
        if($recordData){
            $checkServerData = '';
            $checkCustomerData = '';
            foreach (json_decode($recordData->server_record) as $key => $value) {
                $value = str_replace('server_', '', $value);
                $checkServerData .= $value.',';
            }
            foreach (json_decode($recordData->customer_record) as $key => $value) {
                $value = str_replace('customer_', '', $value);
                $checkCustomerData .= $value.',';
            }
            $checkServerData = substr($checkServerData, 0,strlen($checkServerData)-1);
            $checkCustomerData = substr($checkCustomerData, 0,strlen($checkCustomerData)-1);
        }
        return view('Text.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('Text.add');
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){
        $primaryId=$request->TextId;
        $data['id']=$request->id;
        $data['type']=$request->type;
        $data['content']=$request->content;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('text')->select('type','content')->where('TextId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'文本配置',$primaryId);

            $result=DB::table('text')->where('TextId', $primaryId)->update($data);
            parent::saveLog('更新文本配置TextId--'.$primaryId);
        }else{
            $result=DB::table('text')->insertGetId($data);  
            parent::saveLog('添加文本配置TextId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/text/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $TextId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->TextId;
        $results=DB::table('text')->where('TextId', $primaryId)->get(); 
        return view('Text.edit',['res'=>$results]);
    }

    public function delete(Request $request){
        $TextId=$request->TextId;
        $res=DB::table('text')->where('TextId', '=', $TextId)->delete();
        parent::saveLog('删除文本配置TextId--'.$TextId);

        return redirect('/text/index');
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
        $res=$this->textRepository->baseArray($request);
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);  
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                } 
                $where['table_name'] = 'text';
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
        $lua_str=$this->textRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
