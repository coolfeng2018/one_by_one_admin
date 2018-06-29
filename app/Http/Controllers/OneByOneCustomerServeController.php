<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OneByOneCustomerServeController extends BaseController
{
    protected $customerID = 888888;//客服ID
    /**
     * 每页显示条数
     * @var integer
     */
    protected $page_size = 20;
    /**
     * 后台设置为已读的read_state状态值
     * @var integer
     */
    protected $is_read = 2;
    
    /**
     * 回复状态
     * @var array
     */
    protected $reply_tips = array(
        0=>'未回复',
        1=>'已读',
        2=>'已回复'
    );
    
    public function index(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $total = $this->getCustumData('total');
        $data['total'] = isset($total[0]->total) ? $total[0]->total : 0;
        $data['results'] = $this->getCustumData();
        
        $back = $_GET;
        $back['page'] = $page;
        $back['reply_tips'] = $this->reply_tips;
        $back['res'] = $data;
        return view('OneByOneCustomerServe.index',$back);
        /*
        //原代码：
         $res['total']= DB::table('customer')->where('uid','<>',$this->customerID)->count(DB::raw("distinct(uid)"));
        // $res['total']= DB::table('customer')->where('uid','<>',$this->customerID)->count();
        //获取有效用户列表
        $res['results'] = DB::table('customer')->where('uid','<>',$this->customerID)->orderBy('CustomerId', 'desc')->paginate(10);
        //消息内容
          foreach ($res['results'] as $key => $value) {
            
            //获取uid最近一条消息记录
            $message = DB::table('message')->where('FromUid','=',$value->uid)->orderBy('MessageId','desc')->first();
            $res['results'][$key]->message = $message->message;//留言内容
            $res['results'][$key]->time = $message->time;//留言时间
            //获取最近一条客服回复该uid的记录
            $where['FromUid'] = $this->customerID;
            $where['ToUid'] = $value->uid; 
            // DB::connection()->enableQueryLog();
            $receiveMessage = DB::table('message')->where($where)->orderBy('MessageId','desc')->first();
            // $sql = DB::getQueryLog();
            if(!$receiveMessage){
                $res['results'][$key]->replyStatus = '未回复'; 
                $res['results'][$key]->reply_status_num = 0; //未回复
                continue;
            }
            if($receiveMessage->MessageId<$message->MessageId){
                $res['results'][$key]->replyStatus = '未回复'; 
                $res['results'][$key]->reply_status_num = 0; //未回复
                continue;
            }
            $res['results'][$key]->replyStatus = '已回复'; 
            $res['results'][$key]->reply_status_num = 1; //已回复
            return view('OneByOneCustomerServe.index',['res'=>$res]);

        }  */ 
    }
    

    
    /**
     * 获取连表查询的数据
     * @param string $type
     * @return array
     */
    //         $sql = 'SELECT c.* ,m.message,m.MessageId AS m_mid,m.time AS m_time,m.FromUid AS m_FromUid,mm.MessageId AS mm_mid ,mm.time AS mm_time,
    //                     CASE
    //                         WHEN (c.time IS NOT NULL AND m.time IS NOT NULL AND mm.time IS NOT NULL) THEN GREATEST(c.time,m.time,mm.time)
    //                         WHEN (c.time IS NOT NULL AND m.time IS NOT NULL AND mm.time IS NULL) THEN GREATEST(c.time,m.time)
    //                         WHEN (c.time IS NOT NULL AND m.time IS NULL AND mm.time IS NULL) THEN c.time
    //                      END
    //                         AS updatetime,
    //                     CASE
    //                         WHEN (mm.time IS NOT NULL AND mm.time>m.time )THEN 2
    //                         WHEN ( NOT(mm.time IS NOT NULL AND mm.time>m.time) AND m.read_state=2 ) THEN 1
    //                         ELSE 0
    //                     END  AS re_status
    //         FROM customer c
    //         LEFT JOIN (SELECT mes1.*
    //             FROM  (SELECT  MAX(MessageId) max_mid ,FromUid
    //                 FROM message
    //                 GROUP BY FromUid ORDER BY MessageId DESC) AS mes2
    //             LEFT JOIN message AS mes1 ON mes2.FromUid=mes1.FromUid AND mes2.max_mid=mes1.MessageId ) AS m ON c.`uid` = m.`FromUid`
    //             LEFT JOIN ( SELECT mes3.*
    //                 FROM  (SELECT  MAX(MessageId) max_mid ,ToUid
    //                     FROM message
    //                     GROUP BY ToUid ORDER BY MessageId DESC) AS mes4
    //                 LEFT JOIN message AS mes3 ON mes4.ToUid=mes3.ToUid AND mes4.max_mid=mes3.MessageId  ) AS mm ON c.`uid` = mm.`ToUid`
    //                 WHERE c.`uid`!=88888 #and CustomerId=42#group by c.`uid`
    //                 ORDER BY re_status ASC,updatetime DESC';
    protected function getCustumData($type = '') {
        $data = array();
        if($type == 'total') {
            $select = 'count(c.CustomerId) as total, ';
        }else{
            $select  = 'c.* ,m.message,m.MessageId AS m_mid,m.time AS m_time,m.FromUid AS m_FromUid,mm.MessageId AS mm_mid,';
        }
        $select .= 'CASE 
                    	WHEN (c.time IS NOT NULL AND m.time IS NOT NULL AND mm.time IS NOT NULL) THEN GREATEST(c.time,m.time,mm.time) 
                    	WHEN (c.time IS NOT NULL AND m.time IS NOT NULL AND mm.time IS NULL) THEN GREATEST(c.time,m.time)
                    	WHEN (c.time IS NOT NULL AND m.time IS NULL AND mm.time IS NULL) THEN c.time
                    END AS updatetime,
                    CASE 
                    	WHEN (mm.time IS NOT NULL AND mm.time>m.time )THEN 2 
                    	WHEN ( NOT(mm.time IS NOT NULL AND mm.time>m.time) AND m.read_state='.$this->is_read.' ) THEN 1
                    	ELSE 0 
                    END  AS re_status';
        $sql = DB::table(DB::raw('customer c'))
        ->selectRaw($select)
        ->leftJoin(DB::raw("(SELECT mes1.*
                		FROM  (SELECT  MAX(MessageId) max_mid ,FromUid
                		FROM message 
                		GROUP BY FromUid ORDER BY MessageId DESC) AS mes2
                		LEFT JOIN message AS mes1 ON mes2.FromUid=mes1.FromUid AND mes2.max_mid=mes1.MessageId ) AS m"),'c.uid','=','m.FromUid')
        ->leftJoin(DB::raw("( SELECT mes3.*
                		FROM  (SELECT  MAX(MessageId) max_mid ,ToUid
                		FROM message 
                		GROUP BY ToUid ORDER BY MessageId DESC) AS mes4
                		LEFT JOIN message AS mes3 ON mes4.ToUid=mes3.ToUid AND mes4.max_mid=mes3.MessageId  ) AS mm"),'c.uid','=','mm.ToUid')
        ->where('uid','<>',$this->customerID)
        ->orderBy('re_status', 'ASC')
        ->orderBy('updatetime', 'DESC');
        if($type == 'total') {
            $data = $sql->get();
        }else{
            $data = $sql->paginate($this->page_size);
        }
        return $data; 
    }

    public function ajax(Request $request){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        //ajax
        if($request->type=='receive'){
            Log::debug($request);
            DB::beginTransaction();
            try{
                $insert['ToUid'] = $request->uid;
                $insert['FromUid'] = $this->customerID;
                $insert['message'] = $request->receive;
                Log::debug($insert);
                $result = DB::table('message')->insert($insert);
                $time = time();
                if(!$result){
                    throw new \Exception("插入失败");
                }
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                Log::info($e->getMessage());
                return response()->json(['code'=>400,'msg'=>'server error','result'=>[]]);
            }
            return response()->json(['code'=>200,'msg'=>'OK','result'=>['time'=>date('Y-m-d H:i:s',$time)]]);
        }elseif ($request->type=='isread') {//设置为已读
            $id=$request->mid;
            $update['read_state'] = $this->is_read;//设置为已读
            $res = DB::table('message')->where('MessageId','=',$id)->update($update);
            parent::saveLog('设置为已读   message.MessageId--'.$id);
            if($res){
                $this->wlog('update message  data:'.$id.'  res:'.$res,'db'); 
            }else{
                $this->wlog('update message  data:'.$id.'  res:'.$res,'db_err');
            }
            exit(json_encode(['status'=>0]));
        }

        $results = [];
        $uid = $request->uid;
        DB::connection()->enableQueryLog();
        $message = DB::table('message')->where('FromUid','=',$request->uid)->orWhere('ToUid','=',$request->uid)->get();
        $sql = DB::getQueryLog(); 
        return view('OneByOneCustomerServe.ajax',['res'=>$message,'uid'=>$request->uid,'page'=>$page]);
    }
}
