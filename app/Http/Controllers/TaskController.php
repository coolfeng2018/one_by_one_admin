<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class TaskController extends BaseController
{
    /**
     * 是否现实发送到服务器按钮
     * @var string
     */
    protected $sntcfg_btn = 'task';
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository=$taskRepository;
    }

    /**
     * 任务管理配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['type'] = $_GET['type']??'';
        $res = $this->taskRepository->info($param);
        $recordData = $this->taskRepository->findRecordData() ? $this->taskRepository->findRecordData() : array();
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
        return view('Task.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $games=DB::table('games')->get()->toArray();  
        return view('Task.add',['datagame'=>$games]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->TaskId;
        //base data
        $data['id']=$request->id;
        $data['type']=$request->type;
        $data['param']=$request->param;
        $data['game_type']=$request->game_type;
        $data['cycle']=$request->cycle;
        $data['process']=$request->process;
        $data['name']=$request->name;
        // $data['award_list']=json_decode($request->award_list,true);
        $data['award_list']=$request->award_list;
        $data['next_id']=$request->next_id;

        //特殊处理award_list
        // if($data['award_list']){
        //     foreach ($data['award_list'] as $key => $value) {
        //             $dataAwardList[$key+1] = $value;
        //     }
        //     $data['award_list'] = json_encode($dataAwardList);
        // } 
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('task')->select('id','type','param','game_type','cycle','process','name','award_list','next_id')->where('TaskId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'任务管理',$primaryId);
            $result=DB::table('task')->where('TaskId', $primaryId)->update($data); 
            parent::saveLog('任务管理TaskId--'.$primaryId);
        }else{
            $result=DB::table('task')->insertGetId($data);
            parent::saveLog('任务管理TaskId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/task/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $TaskId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->TaskId;
        $results=DB::table('task')->where('TaskId', $primaryId)->first(); 
        $games=DB::table('games')->get()->toArray();  
        return view('Task.edit',['res'=>$results,'datagame'=>$games]);
    }

    public function delete(Request $request){
        $TaskId=$request->TaskId;
        $res=DB::table('task')->where('TaskId', '=', $TaskId)->delete();
        parent::saveLog('删除任务管理TaskId--'.$TaskId);

        return redirect('/task/index');
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
        $res=$this->taskRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'task';
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
        $lua_str=$this->taskRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
