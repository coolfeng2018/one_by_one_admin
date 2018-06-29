<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ValueRepository;


class GameValueController extends BaseController
{
    protected $valueRepository;
    /**
     * 配置项
     */
    public $cfg = array(
        'LOSE_COINS_LIMIT'=>array('num'=>5000000, 'name'=>'今日输钱上限'),
        'BLACK_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'黑方区域押注上限'),
        'READ_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'红方区域押注上限'),
        'SPECAIL_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'特殊区域押注上限'),
        'PERSONAL_BLACK_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'黑方区域个人押注上限'),
        'PERSONAL_READ_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'红方区域个人押注上限'),
        'PERSONAL_SPECAIL_SIDE_COINS_LIMIT'=>array('num'=>2000000, 'name'=>'特殊区域个人押注上限'),
        'BIND_PHONE_REWARD'=>array('num'=>3, 'name'=>'绑定手机获取3元奖励'),
        //'EXCHANGE_LIMIT'=>array('num'=>1000, 'name'=>'兑换下线'),
        
        'BASE_COMPENSATION_COND'=>array('num'=>30000, 'name'=>'破产补助条件'),
        'BASE_COMPENSATION_COINS'=>array('num'=>80000, 'name'=>'破产补助每次给予金币值'),
        'BASE_COMPENSATION_TIMES_LIMIT'=>array('num'=>3, 'name'=>'破产补助每天次数限制'),
        'HONGHEI_FEE_PERCENT'=>array('num'=>0.05, 'name'=>'红黑大战抽水百分比'),
        'HARVEST_THRESHOLD'=>array('num'=>50000000, 'name'=>'虎豹大战亏损阀门控制'),
        
        'RETENTION_MONEY_LIMTI'=>array('num'=>1000, 'name'=>'保留金限制'),
        'BR_NN_FEE_PERCENT'=>array('num'=>0.05, 'name'=>'百人牛牛台费抽水'),
        'BR_TOTAL_BET_COINS_LIMIT'=>array('num'=>1000000, 'name'=>'百人牛牛下注总额限制'),
        'BR_PERSONAL_BET_COINS_LIMIT'=>array('num'=>1000000, 'name'=>'百人牛牛个人下注限制'),
        'BR_NN_SITDOWN_COIN_LIMIT'=>array('num'=>1000000, 'name'=>'百人牛牛坐下金币最小限制'),
        'BR_NN_MIN_BANKER_COINS'=>array('num'=>1000000, 'name'=>'百人牛牛坐庄金币最小限制'),
        'ZJH_FEE_PERCENT'=>array('num'=>'0.05', 'name'=>'扎金花抽水百分比'),
        
        
        
    );
          
    
    public function __construct(ValueRepository $valueRepository)
    {
        $this->valueRepository=$valueRepository;
    }
    
    

    /**
     * 游戏常量列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id']=$_GET['id']??'';
        $param['value']=$_GET['value']??'';
        $res=$this->valueRepository->info($param);
        $recordData=$this->valueRepository->findRecordData();
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
        return view('Value.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'valuecfg'=>$this->cfg]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('Value.add',['valuecfg'=>$this->cfg]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){
        $primaryId=$request->ValueId;
        $data['value']=$request->value;
        $data['id']=$request->id;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('value')->select('value','id')->where('ValueId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'游戏常量',$primaryId);

            $result=DB::table('value')->where('ValueId', $primaryId)->update($data);
            parent::saveLog('更新游戏常量ValueId--'.$primaryId);
        }else{
            $result=DB::table('value')->insertGetId($data);  
            parent::saveLog('添加游戏常量ValueId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/gamevalue/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ValueId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->ValueId;
        $results=DB::table('value')->where('ValueId', $primaryId)->get(); 
        return view('Value.edit',['res'=>$results,'valuecfg'=>$this->cfg]);
    }

    public function delete(Request $request){
        $ValueId=$request->ValueId;
        $res=DB::table('value')->where('ValueId', '=', $ValueId)->delete();
        parent::saveLog('删除游戏常量ValueId--'.$ValueId);

        return redirect('/gamevalue/index');
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
        $res=$this->valueRepository->baseArray($request);
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);  
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                } 
                $where['table_name'] = 'value';
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
