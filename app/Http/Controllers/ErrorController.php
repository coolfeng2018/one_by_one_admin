<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Redis;
// use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ErrorCodeRepository;


class ErrorController extends BaseController
{
    /**
     * 是否现实发送到服务器按钮
     * @var string
     */
    protected $sntcfg_btn = 'error_des';
    protected $errorCodeRepository;
          
    public function __construct(ErrorCodeRepository $errorCodeRepository)
    {
        $this->errorCodeRepository=$errorCodeRepository;
    }

    /**
     * 错误码列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id']=$_GET['id']??'';
        $param['name']=$_GET['name']??'';
        $res=$this->errorCodeRepository->info($param);
        $recordData=$this->errorCodeRepository->findRecordData();
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
        return view('Error.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增错误码
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Error.create');
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){
        $primaryId=$request->ErrorCodeId;

        $data['name']=$request->name;
        $data['id']=$request->id;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('error_code')->select('name','id')->where('ErrorCodeId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'错误码',$primaryId);

            $result=DB::table('error_code')->where('ErrorCodeId', $primaryId)->update($data);
            parent::saveLog('更新错误码ErrorCodeId--'.$primaryId);
        }else{
            $result=DB::table('error_code')->insertGetId($data);  
            parent::saveLog('添加错误码ErrorCodeId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/error/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ErrorCodeId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $primaryId=$request->ErrorCodeId;
        $results=DB::table('error_code')->where('ErrorCodeId', $primaryId)->get(); 
        return view('Error.update',['res'=>$results]);
    }

    public function delete(Request $request){
        $ErrorCodeId=$request->ErrorCodeId;
        $res=DB::table('error_code')->where('ErrorCodeId', '=', $ErrorCodeId)->delete();
        parent::saveLog('删除错误码ErrorCodeId--'.$ErrorCodeId);

        return redirect('/error/index');
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
        $res=$this->errorCodeRepository->baseArray($request);
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);  
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                } 
                $where['table_name'] = 'error_code';
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
        $res=$this->errorCodeRepository->baseArray($request);
        $lua_str = "\nreturn ".convert_data($res,0);
        $result = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($result));
    }
}
