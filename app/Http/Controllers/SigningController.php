<?php

namespace App\Http\Controllers;

use App\Repositories\SigningRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Chumper\Zipper\Facades\Zipper;



class SigningController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'signing';
    protected $signingRepository;

    public function __construct(SigningRepository $signingRepository)
    {
        $this->signingRepository=$signingRepository;
    }

    /**
     * 签到配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['month'] = $_GET['month']??'';
        $res = $this->signingRepository->info($param);
        $recordData = $this->signingRepository->findRecordData() ? $this->signingRepository->findRecordData() : array();
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
        return view('Signing.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $games=DB::table('games')->get()->toArray();  
        return view('Signing.add',['datagame'=>$games]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->SigningId;
        //base data
        $data['month']=$request->month;
        $data['awards_list']=$request->awards_list;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('signing')->select('month','awards_list')->where('SigningId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'签到',$primaryId);
            $result=DB::table('signing')->where('SigningId', $primaryId)->update($data); 
            parent::saveLog('签到SigningId--'.$primaryId);
        }else{
            $result=DB::table('signing')->insertGetId($data);
            parent::saveLog('签到SigningId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/signing/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SigningId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->SigningId;
        $results=DB::table('signing')->where('SigningId', $primaryId)->first(); 
        $games=DB::table('games')->get()->toArray();  
        return view('Signing.edit',['res'=>$results,'datagame'=>$games]);
    }

    public function delete(Request $request){
        $SigningId=$request->SigningId;
        $res=DB::table('signing')->where('SigningId', '=', $SigningId)->delete();
        parent::saveLog('删除签到SigningId--'.$SigningId);

        return redirect('/signing/index');
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
        $res=$this->signingRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'signing';
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
        $lua_str=$this->signingRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
    
   
}
