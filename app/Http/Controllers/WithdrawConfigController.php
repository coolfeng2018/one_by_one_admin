<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class WithdrawConfigController extends BaseController
{
    protected $withdrawRepository;
    public function index(){
        //验证提取范围
        $rangeCurrentAmount = Redis::get('rangeCurrentAmount');
        $minAmount = Redis::get('minAmount');
        return view('OneByOneWithdrawConfig.index',['rangeCurrentAmount'=>$rangeCurrentAmount,'minAmount'=>$minAmount]);
    }

    public function update(){
        $rangeCurrentAmount = Redis::get('rangeCurrentAmount');
        $minAmount = Redis::get('minAmount');
        return view('OneByOneWithdrawConfig.update',['rangeCurrentAmount'=>$rangeCurrentAmount,'minAmount'=>$minAmount]);
    }

    public function save(Request $request){
        $request = $request->all(); 
        $rangeCurrentAmount=$request['rangeCurrentAmount'];
        $minAmount=$request['minAmount'];
        Redis::set('rangeCurrentAmount',$rangeCurrentAmount);
        Redis::set('minAmount',$minAmount);
        return response()->json(['status' =>200, 'message' => 'ok']);
    }
}
