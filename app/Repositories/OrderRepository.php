<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 21:18
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function info($param, $export=0){
        $where=[];

        if( $param['uid'] != null){
            $where['uid']= $param['uid'];
        }
        // 支付状态
        if( $param['status'] !== null && $param['status'] != 'z'){
            $where['status']=$param['status'];
        }
        /*
        // 支付方式
        if($param['payment_channel'] !== null && $param['payment_channel'] != 'z'){
            $where['payment_channel']=$param['payment_channel'];
        }
         */
        // 平台
        if($param['channel'] && $param['channel'] != 'z'){
            $where['channel']=$param['channel'];
        }

        if($param['stime'] && $param['etime']){
            $param['stime'] = strtotime($param['stime']);
            $param['etime'] = strtotime($param['etime']);
            $query=DB::connection('mysql2')->table('order')
                ->select('*')
                ->whereBetween('create_time',[$param['stime'],$param['etime']])
                ->where($where);
            if($param['payment_channel'] !== null && $param['payment_channel'] != 'z'){
                $query->where('payment_channel', 'like', '%'.$param['payment_channel'].'%');
            }
        }else{
            $query=DB::connection('mysql2')->table('order')->select('*')->where($where);
            if($param['payment_channel'] !== null && $param['payment_channel'] != 'z'){
                $query->where('payment_channel', 'like', '%'.$param['payment_channel'].'%');
            }
        }
        if ($export == 0) {
            $result = $query->orderBy('create_time','desc')->paginate(10);
        } else {
            $result = $query->orderBy('create_time','desc')->get()->toArray();
        }
        return $result;
    }
    
    /**
     * 插入订单
     * @param type $params
     * @return boolean
     */
    public function add($params) {
         if(DB::connection('mysql2')->table('order')->insert($params)){
             return true;
         }else{
             return false;
         }
    }
    
    public function update($where, $updateArr) {
        try{
            DB::connection('mysql2')->table('order')->where($where)->update($updateArr);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }
    
    public function getOneOrder($where) {
        return DB::connection('mysql2')->table('order')->where($where)->first();
    }

}