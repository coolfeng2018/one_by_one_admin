<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class DatacenterRepository
{
    public function getInfomation($param, $where) {
        $result = DB::table('dc_log_result.user_result')
            ->select('*')
            ->whereBetween('time',[$param['stime'],$param['etime']])
            ->where($where)
            ->orderBy('time','desc')
            ->paginate(10);
        return $result;
    }
    
    public function getChannel() {
        $result = DB::table('one_by_one.channel_list')
            ->select('code')
            ->get();
        $channel = [];
        foreach ($result as $val) {
            $channel[] = $val->code;
        }

        return $channel;
    }
    
    /**
     * 获取新注册用户
     * @param type $channel
     * @param type $op
     * @return type
     */
    public function getNewUserCount($channel, $op=200000) {
        $query = DB::table('dc_log_user.user'.date('Ym'))
            ->whereBetween('time',[strtotime(date('Y-m-d 00:00:00')),strtotime(date('Y-m-d 23:59:59'))])
            ->where(['op' => $op]);
        if ($channel != 'all') {
            $query = $query->where(['channel' => $channel]);
        }
        return $query->count('id');
    }
    
    /**
     * 获取活跃用户
     * @param type $channel
     * @param type $op
     * @return type
     */
    public function getActiveUserCount($channel, $op=200001) {
        $sql = "select distinct uid from dc_log_user.user".date('Ym')." where time".
                " between ".strtotime(date('Y-m-d 00:00:00'))." and ".strtotime(date('Y-m-d 23:59:59')).
                " and op={$op} ";
        if ($channel != 'all') {
            $sql .= " and channel='".$channel."'";
        }
        $data = DB::select($sql);
        return count($data);
    }
    
    public function paySum($channel, $startTime="", $endTime="") {
        if(empty($startTime)) {
            $startTime = strtotime(date('Y-m-d 00:00:00'));
        }
        if (empty($endTime)) {
            $endTime = strtotime(date('Y-m-d 23:59:59'));
        }
        $sql = sprintf("select sum(amount) as amount from %s as a ".
                "left join %s as b on a.uid=b.uid ".
                "where a.channel='%s' and b.status=2 and b.create_time between '%s' and '%s' ",
                "dc_log_user.users",
                "payment.order",
                $channel,
                $startTime,
                $endTime);
        if ($channel == 'all') {
            $sql = sprintf("select sum(amount) as amount from %s as a ".
                    "left join %s as b on a.uid=b.uid ".
                    "where b.status=2 and b.create_time between '%s' and '%s' ",
                    "dc_log_user.users",
                    "payment.order",
                    $startTime,
                    $endTime);
        }
        $data = DB::select($sql);
        return isset($data[0]->amount) ? $data[0]->amount : 0;
    }
    
    
    public function exchangeCoin($channel, $startTime="", $endTime="") {
        if(empty($startTime)) {
            $startTime = date('Y-m-d 00:00:00');
        }
        if (empty($endTime)) {
            $endTime = date('Y-m-d 23:59:59');
        }
        $sql = sprintf("select sum(b.Amount) as amount from %s as a ".
                "left join %s as b on a.uid=b.uid ".
                "where a.channel='%s' and b.CreateAt between '%s' and '%s' b.and status=1 ", 
                "dc_log_user.users", 
                "one_by_one.withdraw",
                $channel, 
                $startTime, 
                $endTime
            );
        if ($channel == 'all') {
        $sql = sprintf("select sum(b.Amount) as amount from %s as a ".
                "left join %s as b on a.uid=b.uid ".
                "where b.CreateAt between '%s' and '%s' and b.status=1 ", 
                "dc_log_user.users", 
                "one_by_one.withdraw",
                $startTime, 
                $endTime
            );
        }
        $data = DB::select($sql);
        return isset($data[0]->amount) ? $data[0]->amount : 0;
    }
    
}