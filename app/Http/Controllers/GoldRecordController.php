<?php
/**
 * 金币流水查询
 * 2018-05-08
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GoldRecordController  extends BaseController {
    /**
     * 控制器名称
     * @var string
     */
    protected $pagename = '金币流水';

    /**
     * 变化类型
     * @var array
     */
    protected $oplist = array(
        1 => '增加',
        2 => '减少'
    );

    
    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function list(Request $request){
        $params['uid'] = isset($request->uid) ? $request->uid :'';
        $params['Status'] = isset($request->Status) ? $request->Status :'';
        
        $params['page'] = isset($request->page) ? $request->page :1;
        $params['start'] = isset($request->start) && !empty($request->start) ? $request->start : date('Y-m-d H:i:s',strtotime('-1 week'));
        $params['end'] = isset($request->end) && !empty($request->end) ? $request->end : date('Y-m-d H:i:s',time());
        
        $params['reason'] = isset($_GET['reason']) ? $_GET['reason'] : '';
        $params['table'] = isset($_GET['table']) ? $_GET['table'] : '';
        
        //过滤渠道
        $codelist =  $this->getMyCodeWhere();
        if($codelist) {
            $where = ' channel '.$codelist;
        }else{
            $where = ' 0 ';
        }
        //过滤渠道
        
        if($params['uid']) {
            $where .= ' and uid ='.(int)$params['uid'];
        }
        if($params['start']) {
            $where .=' and user_money.time>='.strtotime($params['start']);
        }
        if($params['end']) {
            $where .=' and user_money.time<='.(strtotime($params['end'])+60);
        }
        if($params['reason']) {
            $where .=' and user_money.reason='.(int)$params['reason'];
        }
        
        if($params['table']) {
            $where .=' and user_money.table_type='.(int)$params['table'];
        }
        
        $where .=' order by time desc';
        $res =  DB::table('user_money')->whereRaw($where)->paginate(10);
        
        $data = $this->getShowList($res);
        $back  = array(
            'data' => $data,
            'pagename' => $this->pagename,
            'search'=>$params,
            'reasonlist'=>$this->gold_reasonlist,
            'tablelist'=>$this->tablelist
        );
        return view('GoldRecord.list',$back);
    }
    
    /**
     * 对展示数组进行处理
     * @param unknown $all
     * @return array
     */
    public function getShowList($all) {
        foreach ($all as $k =>$v) {
            $v->rsn = isset($this->gold_reasonlist[$v->reason]) ? $this->gold_reasonlist[$v->reason]['cn'] : $v->reason;
            $v->table = isset($this->tablelist[$v->table_type]) ? $this->tablelist[$v->table_type] : $v->table_type;
            $v->optime = date('Y-m-d H:i:s',$v->time);
            $v->cur_num = $v->curr/100;
            $v->chg_num = $v->value/100;
        }
        return $all;
    }
    
    /**
     * 台费查询
     * @param unknown $all
     * @return array
     */
    public function tflist(Request $request){
        $uid = isset($request->uid) ? $request->uid : 0;
        //每个放假台费
        $data = array();
        foreach ($this->tablelist as $key => $value) {
            $where = '(reason = 6 or reason = 15) and uid = '.(int)$uid." and table_type = {$key}";
            $res =  DB::table('user_money')->whereRaw($where)->sum('value');
            $data[$key] = $res/100;
        }
        $back  = array(
            'data' => $data,
            'game_data' => $this->tablelist,
            'uid'=>$uid,
            'pagename' => '台费查询',
        );
        return view('GoldRecord.tflist',$back);
    }
    
    /**
     * 实时数据统计
     * 
     */
      public function todaydata(Request $request){
          $uid = isset($request->uid) ? $request->uid : 0;
          //每个放假台费
          $data = array();
       
          $table = 'dc_log_user.user' . date('Ym', time());
          $where = "op = 200000 and time >= ".strtotime(date('Ymd'));
          //$where = "op = 200000 and time >= 0";
          $rs_uid =  DB::table($table)->select(['uid'])->whereRaw($where)->get()->toArray();
         
          $uid_list = array();
          foreach ($rs_uid as $k => $v) {
            $uid = json_decode(json_encode($v), true); 
            $uid_list[] = $uid['uid'];
          }
          
          //新增用户数
          $new_count = count($uid_list);
          $new_str = implode(",", $uid_list);
          
          $where = "op = 200001 and time >= ".strtotime(date('Ymd'));
          //$where = "op = 200001 and time >= 0";
          $act_rs = DB::table($table)->select(['uid'])->whereRaw($where)->get()->toArray();
          
          
          $sql = "select count(distinct uid) as actcount  from {$table} where {$where}";
          $act_rs = DB::select($sql);
          
          //活跃用户数
          $act_count = 0;
          foreach ($act_rs as $value) {
              $value = json_decode(json_encode($value), true);
              $act_count = $value['actcount'];
          }
          
         
          //新增用户充值总额
          $amout = 0;
          $pay_table = 'payment.order';
          if($new_count > 0){
              $amout = DB::table($pay_table)->whereIn('uid', $uid_list)->where('status',2)->sum('amount');
              $amout = $amout/100;
          }
          
          //总充值额度
          $amout_total = 0;
          $where = "status = 2 and create_time >= ".strtotime(date('Ymd'));
          //$where = "create_time >= 0";
          $amout_total = DB::table($pay_table)->whereRaw($where)->sum('amount');
          $amout_total = $amout_total/100;
          
          //新增用户充值人数
          $upcount = 0;
          if($new_count > 0){
              $sql = "select count(distinct uid) as upcount  from {$pay_table} where uid in ({$new_str}) and status = 2";
              $info=DB::select($sql);
              
              //新增充值人数
              $upcount = 0;
              foreach ($info as $value) {
                  $value = json_decode(json_encode($value), true); 
                  $upcount = $value['upcount'];
              }
          }
          
          //总充值人数
          $act_pay_count = 0;
          $where = "status = 2 and  create_time >= ".strtotime(date('Ymd'));
          $sql = "select count(distinct uid) as actpaycount  from {$pay_table} where {$where}";
          $info=DB::select($sql);
          
          foreach ($info as $value) {
              $value = json_decode(json_encode($value), true);
              $act_pay_count = $value['actpaycount'];
          }
          
          //新增提现总额
          $withdraw_table = 'one_by_one.withdraw';
          $withdraw = 0;
          if($new_count > 0){
              $withdraw = DB::table($withdraw_table)->whereIn('uid', $uid_list)->sum('Amount');
          }
          //总提现额度
          $withdraw_total = 0;
          $where = "Status = 1 and CreateAt >= '".date('Y-m-d')."'";
          //$where = "create_time >= 0";
          $withdraw_total = DB::table($withdraw_table)->whereRaw($where)->sum('Amount');
          $data  = array(
              '新增人数' => $new_count,
              '新增用户充值人数' => $upcount,
              '新增人数充值总额(元)'=>$amout,
              '新增提现总额' => $withdraw,
              '活跃人数' => $act_count,
              '总充值人数' => $act_pay_count,
              '总充值' => $amout_total,
              '总提现' => $withdraw_total,
          );
          
          $table_data = array_keys($data);
          
          $back  = array(
              'data' => $data,
              'game_data' => $table_data,
              'pagename' => '实时数据',
          );
          
          return view('GoldRecord.todaydata',$back);
      }
}
