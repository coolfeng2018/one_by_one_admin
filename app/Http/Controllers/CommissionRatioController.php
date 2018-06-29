<?php

namespace App\Http\Controllers;

use App\Repositories\CashRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CommissionRatioController extends BaseController
{
    public function index(){
    	$agentCommission=Redis::get('AgentCommission');
    	$agentCommission=json_decode($agentCommission); 
        return view('CommissionRatio.index',['agentCommission'=>$agentCommission]);
    }

    public function edit(Request $request){
    	$agentCommission=Redis::get('AgentCommission');
    	$agentCommission=json_decode($agentCommission);
    	return view('CommissionRatio.edit',['agentCommission'=>$agentCommission->{$request->type},'type'=>$request->type]);
    }

    public function save(Request $request){
        $agentCommission = Redis::get('AgentCommission');
        $agentCommission = $preArr =json_decode($agentCommission,true);//原有的数据
        //切换数据
        $newData = json_decode($request->commissionRatio,true);
        foreach ($newData as $value){
            $agentCommission[$request->type] = $value;//赋值
        }
        try{
            Redis::set('AgentCommission',json_encode($agentCommission));
            parent::saveTxtLogs($preArr,$agentCommission,'代理金返水配置',$request->type);
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }catch (\Exception $e) {
            exit(json_encode(['status' => 1, 'msg' => $e]));
        }
    }
}
