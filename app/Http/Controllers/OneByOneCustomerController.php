<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class OneByOneCustomerController extends BaseController
{
    static $MAIL_STATUS_TOBE = 0;//待发送
    static $MAIL_STATUS_ISTOBE = 1;//已发送
    static $MAIL_STATUS_DELETE = 2;//删除（不是已领取状态,可以修改邮件，修改后重置为状态为待发送,重置未读/已读）

    static $MAIL_TYPE_ALL = 1;//全服
    static $MAIL_TYPE_ONLY = 2;//指定玩家

    static $READ_STATE_TRUE = 0;//未读
    static $READ_STATE_FALSE = 1;//已读

    static $RECEIVE_STATE_FALSE = 0;//未领取
    static $RECEIVE_STATE_TRUE = 1;//已领取

    public function index(Request $request){
        if($request->isMethod('post')){
            $results = [];
            $post=$request->all();
            $send_range = $post['send_range'];
            $send_range = explode(';', $send_range); 
            foreach ($send_range as $key => $value) {
                if(!is_numeric($value)){
                    return response()->json(['code'=>402,'msg'=>'收件人必须以;分隔!','result'=>$results]); 
                }
            }
            foreach ($send_range as $key => $value) {
                $param['title'] = $post['send_title'];
                $param['content'] = $post['send_content'];
                $param['op_user'] = $post['send_op_user'];
                // $param['range'] = $post['send_range'];
                $param['range'] = $value;
                $param['coins'] = $post['send_coins'];
                DB::beginTransaction();
                try{
                    DB::connection()->enableQueryLog();
                    DB::table('platform_mail')->insert($param);
                    Log::debug(print_r(DB::getQueryLog(),true));
                    parent::saveLog('添加邮件成功!--'.json_encode($param));
                    DB::commit();
                }catch (\Exception $e){ 
                    DB::rollBack();
                    Log::info($e->getMessage());
                    return response()->json(['code'=>402,'msg'=>'添加邮件失败,请重试。','result'=>[]]);
                }
            } 
            return response()->json(['code'=>200,'msg'=>'添加邮件成功!','result'=>$results]); 
        }

        $param['id']=$_GET['id']??'';
        $param['op_user']=$_GET['op_user']??'';
        $param['range']=$_GET['range']??'';
        $param['title']=$_GET['title']??'';
        $param['status']=$_GET['status']??'';

        $where = [];
        if($param['id']){
            $where['id'] = $param['id'];
        }
        if($param['op_user']){
            $where['op_user'] = $param['op_user'];
        }
        if($param['title']){
            $where['title'] = $param['title'];
        }
        if($param['status']){
            // $param['status'] = ['1'=>'已读','2'=>'未读','3'=>'已领取','4'=>'未领取','5'=>'待发送',];
            // 已读未读，根据有无附件判断,目前只有金币，所以只根据coins是否为0来判断即可
            switch ($param['status']) {
                case '1':
                    $where['status'] = self::$MAIL_STATUS_ISTOBE;
                    $where['read_state'] = self::$READ_STATE_FALSE;
                    $where['coins'] = 0;
                    break;

                case '2':
                    $where['status'] = self::$MAIL_STATUS_ISTOBE;
                    $where['read_state'] = self::$READ_STATE_TRUE;
                    $where['coins'] = 0;
                    break;

                case '3':
                    $where['status'] = self::$MAIL_STATUS_ISTOBE;
                    $where['receive_state'] = self::$RECEIVE_STATE_TRUE;
                    break;

                case '4':
                    $where['status'] = self::$MAIL_STATUS_ISTOBE;
                    $where['receive_state'] = self::$RECEIVE_STATE_FALSE;
                    break; 

                case '5':
                    $where['status'] = self::$MAIL_STATUS_TOBE;
                    break;
                
                default:
                    # code...
                    break;
            }
            
        }
 
        Log::debug($where);
        DB::connection()->enableQueryLog();
        if($param['range']){
            $result = DB::table('platform_mail')
            ->where($where)
            ->where('op_user','<>','system')
            ->whereRaw(DB::raw("FIND_IN_SET(".$param['range'].",`range`)"))
            ->orderBy('create_at', 'desc')
            ->paginate(10);//paginate(10);
        }else{
            $result = DB::table('platform_mail')
            ->where($where)
            ->where('op_user','<>','system')
            ->where(function($query) use($param) {  
                if ($param['status']!=5 && $param['status']==3 || $param['status']==4) { 
                    $query->where('coins','<>',0);  
                }  
            })
            ->orderBy('create_at', 'desc')
            ->paginate(10);
        } 
       
        Log::debug(DB::getQueryLog()); 
        //var_dump($result);exit;
        return view('OneByOneCustomer.index',['res'=>$result,'search'=>$param]);
    }

    /**
     * [sendAllEmail 一键发送待发送邮件]
     * @param  Request $request [null]
     * @return [type]           [json]
     */
    public function sendAllEmail(Request $request){
        $results = [];
        $range = [];
        //确认逻辑
        $sendData = DB::table('platform_mail')->where('status','=',self::$MAIL_STATUS_TOBE)->get();
        if(!$sendData){
            return response()->json(['code'=>200,'msg'=>'邮件发送成功!','result'=>$results]);
        } 
        foreach ($sendData as $key => $value) {
            $range[] = $value->range;
            $update = [];
            $update['status'] = self::$MAIL_STATUS_ISTOBE;
            DB::beginTransaction();
            try{
                DB::connection()->enableQueryLog();
                    DB::table('platform_mail')->where('id','=',$value->id)->update($update);
                Log::debug(print_r(DB::getQueryLog(),true));
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                Log::info($e->getMessage());
                return response()->json(['code'=>400,'msg'=>'邮件发送失败,请重试。','result'=>[]]);
            }
        }
        //调用发送邮件接口
        $url = env('SERVER_MAIL_API_URL');
        $param = [
            'cmd' => 'notifynewmail',
            'range' => implode(',', $range),
            'mail_type' => 2
        ];
        $dataRequest['data'] = json_encode($param); 
        Log::debug($dataRequest);
        $result = curl($url,$dataRequest);
        $res = json_decode($result,true);  
        Log::debug($res);

        parent::saveLog('一键发送邮件!--'.json_encode($sendData));
        //确认逻辑
        return response()->json(['code'=>200,'msg'=>'邮件发送成功!','result'=>$results]); 
    }

    /**
     * [editEmail 修改邮件]
     * @param  Request $request [null]
     * @return [type]           [json]
     */
    //根据邮件，查看是否已经领取，符合条件，调用接口，修改状态。
    public function editEmail(Request $request){
        $request = $request->all();
        $body['title'] = $request['edit_title'];
        $body['content'] = $request['edit_content'];
        $body['coins'] = $request['edit_coins'];

        $where['id'] = $request['edit_seq'];
        $where['receive_state'] = self::$RECEIVE_STATE_FALSE;

        $results = [];
        $range = [];
        //验证
        $mailData = DB::table('platform_mail')->where($where)->first();  
        if(!$mailData){
            return response()->json(['code'=>200,'msg'=>'无法修改邮件,请重试。','result'=>$results]);
        }

        DB::beginTransaction();
        try{
            DB::connection()->enableQueryLog();
                $body['read_state'] = self::$READ_STATE_TRUE;
                $body['receive_state'] = self::$RECEIVE_STATE_FALSE;
                Log::debug($body);
                DB::table('platform_mail')->where($where)->update($body);
            Log::debug(print_r(DB::getQueryLog(),true));
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json(['code'=>400,'msg'=>'邮件修改失败,请重试。','result'=>[]]);
        }
        //调用发送邮件接口
        if($mailData->status==self::$MAIL_STATUS_ISTOBE){
            $url = env('SERVER_MAIL_API_URL');
            $param = [
                'cmd' => 'modifymail',
                'range' => $request['edit_range'],
                'mail_type' => 2
            ];
            $dataRequest['data'] = json_encode($param); 
            Log::debug($dataRequest);
            $result = curl($url,$dataRequest);
            $res = json_decode($result,true);  
            Log::debug($res);
        }

        $body['range'] = $request['edit_range'];
        $body['id'] = $request['edit_seq'];
        parent::saveLog('修改邮件!--'.json_encode($body));
        //确认逻辑
        return response()->json(['code'=>200,'msg'=>'邮件修改成功!','result'=>$results]); 
    }

}
