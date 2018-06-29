<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OneByOneWithdrawController extends BaseController
{
    public function index(){
        $param['uid']=$_GET['uid']??'';
        $param['Status']=$_GET['Status']??0;
        

        $param['page']=$_GET['page']??1;
        $param['Status']=$_GET['Status']??'';

        $param['refresh']=$_GET['refresh']??10;

        // $res['total']= DB::table('withdraw')->count();
        DB::connection()->enableQueryLog();
        $sql = '(SELECT UpdateAt from withdraw as b where b.uid = a.uid and Status = 1  and b.WithdrawId < a.WithdrawId ORDER BY `WithdrawId` desc limit 1) as LastCreateAt';
        $where = [];
        if($param['uid']){
            $where['a.uid'] = $param['uid'];
        }
        if($param['Status']){
            $where['Status'] = $param['Status'];
        }
        DB::connection()->enableQueryLog();
        $res['results'] = DB::table('withdraw as a')->select('a.*','b.remark',DB::raw($sql))
                            ->leftJoin('withdraw_remark as b', 'b.uid', '=', 'a.uid')
                            ->where($where)
                            ->orderBy('Status','asc')
                            // ->orderBy('uid','asc')
                            ->orderBy('CreateAt','desc')
                            // ->orderBy('WithdrawId','desc')
                            ->paginate(10);

        $res['total']= DB::table('withdraw as a')->select('a.*','b.remark',DB::raw($sql))
                            ->leftJoin('withdraw_remark as b', 'b.uid', '=', 'a.uid')
                            ->where($where)
                            ->count();
        // $sqsl = DB::getQueryLog();  
        foreach ($res['results'] as $key => $value) {  
            $res['results'][$key]->nickName = $this->getUserNick($value->uid);
            $res['results'][$key]->Substr = false;
            $res['results'][$key]->remarkNew = $value->remark;
            if(mb_strlen($value->remarkNew)>=20){
                $res['results'][$key]->remarkNew = mb_substr($value->remarkNew, 0,18);
                $res['results'][$key]->Substr = true;
            }
            $res['results'][$key]->WithdrawInfo = json_decode($value->WithdrawInfo);
            $res['results'][$key]->Fees = $value->Amount*0.02;
        } 
        return view('OneByOneWithdraw.index',['res'=>$res,'search'=>$param]);
    }

    /**
     * [getNewWithdraw 查询是否有新的提现消息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getNewWithdraw(Request $request){
        //关闭声音提示
        if($request->update){
            $update['IsRead'] = 1;
            DB::beginTransaction();
            try{
                DB::table('withdraw')->where('IsRead','=',0)->update($update);
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                Log::info($e->getMessage());
                return response()->json(['code'=>400,'msg'=>'关闭声音失败,请重试。','result'=>[]]);
            } 
            return response()->json(['code'=>200,'msg'=>'ok','result'=>[]]);
        }
        $result = DB::table('withdraw')->select('WithdrawId')->where('IsRead','=',0)->first();
        if(!$result){
            return response()->json(['code'=>400,'msg'=>'ok','result'=>[]]);
        }
        return response()->json(['code'=>200,'msg'=>'ok','result'=>[]]);
    }

    /**
     * [saveRemark 保存备注]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveRemark(Request $request){
        $remark = $request->remark; 
        $uid = $request->uid; 
        if($uid){
            DB::beginTransaction();
            try{
                $update['remark'] = $remark;
                $result = DB::table('withdraw_remark')->where('uid','=',$uid)->first();
                if($result){
                    DB::table('withdraw_remark')->where('uid','=',$uid)->update($update);
                }else{
                    $update['uid'] = $uid;
                    DB::table('withdraw_remark')->insert($update);
                }
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                Log::info($e->getMessage());
                return response()->json(['code'=>400,'msg'=>'邮件发送失败,请重试。','result'=>[]]);
            }  
        }
        return response()->json(['code'=>200,'msg'=>'备注修改成功!']); 
    }

    public function updateStatus(Request $request){
        $withdrawId=$request->WithdrawId;
        $data['Status']=$request->status;
        $data['updateAt']=date('Y-m-d H:i:s',time());

        $where['Status']=0;
        $where['WithdrawId']=$withdrawId;

        $preArr=DB::table('withdraw')->where('WithdrawId', $withdrawId)->first();
 
        $preArr=json_decode(json_encode($preArr), true);
        parent::saveTxtLog($preArr,$data,'申请管理',$withdrawId);

        DB::beginTransaction();
        try
        {
            DB::connection()->enableQueryLog();
            $result=DB::table('withdraw')->where($where)->update($data);
            if(!$result){
                DB::rollBack();
                $sql = DB::getQueryLog();
                Log::info($result);
                Log::info($sql);
                return response()->json(['status'=>400,'msg'=>'修改失败'.$result]);
            }
            if($data['Status']==3){
                $put = [];
                $put['uid'] = $preArr['uid'];
                $put['Amount'] = $preArr['Amount']*100;//提现金额
                Log::info($put);//记录返回信息日志
                //服务端加金币start
                $url = env('WITHDRAWReturnBack').'?'.'uid='.$put['uid'].'&coins='.$put['Amount'];
                Log::debug($url);
                $client = new Client(['timeout' => 2.0]);
                $responseNormal = $client->request('GET', $url, ['headers' => null]); 
                if ($responseNormal->getStatusCode()==200)
                {
                    $resultNormal=$responseNormal->getBody()->getContents(); 
                    Log::info($resultNormal);//记录返回信息日志
                    $resultNormal=json_decode($resultNormal,true);
                    if($resultNormal['code']!=0){
                        DB::rollBack();
                        return response()->json(['status'=>400,'msg'=>'请求驳回失败']);
                    }
                }else{
                    DB::rollBack();
                    $resultNormal=$responseNormal->getBody()->getContents(); 
                    Log::info($responseNormal->getStatusCode());
                    Log::info($resultNormal);
                    return response()->json(['status'=>400,'msg'=>'连接接口超时']);
                }
                //服务端加金币end
            }
            DB::commit();
            parent::saveLog('修改申请id--'.$withdrawId);
        }catch (\Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            Log::info($data);
            Log::info($request);
            return response()->json(['status'=>400,'msg'=>$e->getMessage()]);
        }
        //发送邮件通知
        if($data['Status']==2){
            $email = (object) [
                'title' => '兑换申请被拒绝',
                'content' => '您申请兑换'.$preArr['Amount'].'元被拒绝，请联系客服。',
                'mail_type' => 2,
                'range' => $preArr['uid'],
                'op_user' => 'GM',
            ]; 
        }elseif($data['Status']==3){
            $email = (object) [
                'title' => '兑换申请被驳回',
                'content' => '您申请兑换'.$preArr['Amount'].'元被驳回，金币已退回至您的账号上，有疑问请联系客服。',
                'mail_type' => 2,
                'range' => $preArr['uid'],
                'op_user' => 'GM',
            ]; 
        }else{
            $email = (object) [
                'title' => '兑换申请已通过',
                'content' => '您申请兑换'.$preArr['Amount'].'元已通过，请查看账号余额，部分商户有可能转账延迟到账，请耐心等待。',
                'mail_type' => 2,
                'range' => $preArr['uid'],
                'op_user' => 'GM',
            ]; 
        }
        $url = env('PORJECT_ONE_BY_ONE_API');
        sendEmail($email);
        return response()->json(['status'=>200,'msg'=>'ok']);
    }
}
