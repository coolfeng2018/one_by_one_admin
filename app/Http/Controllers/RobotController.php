<?php
/**
 * 机器人金币查询
 * 2018-06-13
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class RobotController  extends BaseController {
 
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function robotcoins(Request $request){
        $back = array();
        $r_key = 'robotcoins';
        $data = Redis::hgetall($r_key);
        $back['data'] = $data;
        $back['rtypelist'] = $this->robot_typelist;
        $back['pagename'] = '机器人金币';
        return view('Robot.coinslist',$back);
    }
    
 
}
