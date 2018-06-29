<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class OneByOneCustomerController extends BaseController
{
    public function index(Request $request){ 
        //kaishi
        $result = DB::table('platform_mail')->where('op_user','<>','system')->paginate(10);

        echo "<pre>";  
            print_r($result);  
        echo "</pre>";  
        exit;  
        //jiehsu

        $param['uid']=$_GET['uid']??'';
        //分页处理 start
        $data = '[{"seq":"1","send_time":"1525832996","send_user":"admin","uid":123,"title":"test1","content":"content1","modify_attch_list":"","attch_list":"","read_state":true,"modify_state":true,"receive_state":false},{"seq":"2","send_time":"1525832996","send_user":"admin","uid":123,"title":"test2","content":"content1","modify_attch_list":"","attch_list":"","read_state":false,"modify_state":true,"receive_state":true},{"seq":"3","send_time":"1525832996","send_user":"admin","uid":123,"title":"test3","content":"content1","modify_attch_list":"xxx","attch_list":"","read_state":true,"modify_state":true,"receive_state":true},{"seq":"4","send_time":"1525832996","send_user":"admin","uid":123,"title":"test4","content":"content1","modify_attch_list":"xxx","attch_list":"","read_state":true,"modify_state":false,"receive_state":true},{"seq":"5","send_time":"1525832996","send_user":"admin","uid":123,"title":"test5","content":"content1","modify_attch_list":"xxx","attch_list":[{"id":1001,"count":100},{"id":1001,"count":100}],"read_state":false,"modify_state":false,"receive_state":false}]';
        $data = json_decode($data,true);

        $perPage = 10;//显示页数
        if ($request->has('page')) {
                $current_page = $request->input('page');
                $current_page = $current_page <= 0 ? 1 :$current_page;
        } else {
                $current_page = 1;//当前页
        }
 
        //转时间 [{"id":1001,"count":100},{"id":1002,"count":200}]
        foreach ($data as $key => $value) {
            if($value['attch_list']){
                $tag = '';
                foreach ($value['attch_list'] as $k => $v) {
                    $tag = getProp($v['id']);
                    if($tag){  
                        $data[$key]['attch_list'][$k]['name'] = $tag;
                    }
                }
            }
            $data[$key]['send_time'] = date('Y-m-d H:i:s',$value['send_time']);
        }
  
        $item = array_slice($data, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($data);//总条数

        echo "<pre>";  
            print_r($item);  
        echo "</pre>";  
        exit;  
        $data = getPageApi($item, $total, $perPage, $current_page);
        $res['results'] = $data;
        $res['total'] = $total;
        //分页处理 end
          
        // echo "<pre>";  
        //     print_r($res);  
        // echo "</pre>";  
        // exit;  
        return view('OneByOneCustomer.index',['res'=>$res,'search'=>$param]);
    }

}
