<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\DatacenterRepository;
use Illuminate\Support\Facades\Redis;

class DatacenterController extends BaseController
{
    protected $orderRepository;

    public function __construct(DatacenterRepository $datacenterRepository)
    {
        $this->datacenterRepository = $datacenterRepository;
    }
    
    /**
     * 综合信息
     */
    public function information (Request $request) {
        $params['stime'] = empty($request->stime) ? (strtotime(date('Y-m-d'))-86400*30) : strtotime($request->stime);
        $params['etime'] = empty($request->etime) ? strtotime(date('Y-m-d')) : strtotime($request->etime);
        $channel = session('admin')['username'];

        $chList = $this->datacenterRepository->getChannel();
        if ( ! in_array(session('admin')['username'], $chList) && session('admin')['part_id'] == 1) {
            $showChannel = 1;
            $channel = empty($request->channel) ? 'all' : $request->channel;
        } else {
            $showChannel = 0;
        }
        $remain = $this->datacenterRepository->getInfomation($params, ['channel' => $channel]);
        foreach ($remain as &$val) {
            $startTime = date('Y-m-d 00:00:00', $val->time);
            $endTime = date('Y-m-d 23:59:59', $val->time);
            $val->ecoin = $this->datacenterRepository->exchangeCoin($channel, $startTime, $endTime);
            $val->paysum = $this->datacenterRepository->paySum($channel, strtotime($startTime), strtotime($endTime));
        }

        // 需要统计实时数据
        $now = date('Ymd');
        $showToday = false;
        $today = [];
        if($now >= date('Ymd', $params['stime']) && $now <= date('Ymd', $params['etime'])) {
            $today['dnu'] = $this->datacenterRepository->getNewUserCount($channel); // 新增用户
            $today['dau'] = $this->datacenterRepository->getActiveUserCount($channel); // 活跃用户
            $today['rn1'] = 0;
            $today['paysum'] = $this->datacenterRepository->paySum($channel);
            $today['ecoin'] = $this->datacenterRepository->exchangeCoin($channel);
            $showToday = true;
        }
        
        $res['results']=$remain;
        return view('datacenter.index',['res'=>$res,'search'=>$params, 'showChannel' => $showChannel, 
            'chList' => $chList, 'sChannel' => $channel, 'today' => $today, 'showTaday' => $showToday]);
    }
}