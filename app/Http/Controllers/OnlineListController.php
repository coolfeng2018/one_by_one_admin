<?php
/**
 * 在线列表
 *
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineListController extends BaseController {



    /**
     * 列表展示
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function getlist(){
        $url ='http://'.env('SERVERAPI').'/get_play_info';
      
        $result = $this->curl($url);
        
        $user_arr =  $this->_objectarray(json_decode($result));
      
        
        $game_type = array(
            0 => '大厅',
            100 => '金花初级',
            101 => '金花普通',
            102 => '金花精英',
            103 => '金花土豪',
            200 => '牛牛新手',
            201 => '牛牛精英',
            202 => '牛牛大师',
            203 => '牛牛土豪',
            300 => '斗地主新手',
            301 => '斗地主普通',
            302 => '斗地主精英',
            302 => '斗地主大师',
            200001 => '百人牛牛',
            200000 => '红黑大战',
            200002 => '龙虎大战',
        );
        
        $data = array();
        
        $online_list = array();
        $hall = 0; //大厅人数
        if(!empty($user_arr['play_info_list'])){
           
            foreach ($user_arr['play_info_list'] as $k => $v){
                $tmp = array();
                $tmp['uid'] = $v['uid'];
                $tmp['name'] = isset($v['name']) ? $v['name'] : '游客';
                $table_type = $v['table_type'];
                $tmp['table_type'] = $game_type[$table_type];
                
                /**携带金币额度、充值总额、
                                            线上充值总金额、线下充值总金额、
                                            充值笔数（线上+线下）、兑换总金额、
                                            输赢总额度（可用+、-表示）、总税收额度、
                                            渠道来源、注册时间 、首充用户用蓝色字体表示、
                                            点击玩家ID跳转到金币流水界面 。需要细化
                */
                
                
                $user_info = $this->getMonUserInfo($v['uid']);
                $tmp['coins'] = isset($user_info['coins']) ? $user_info['coins'] : 0; //玩家金币
                

                $pay_table = 'payment.order';
                //充值总额
                $amout_total = 0;
                $where = "status = 2 and uid = ".$v['uid'];
                //$where = "create_time >= 0";
                $amout_total = DB::table($pay_table)->whereRaw($where)->sum('amount');
                $amout_total = $amout_total/100;
                
                
                //线下充值
                $amout_offline = 0;
                $where = "status = 2 and uid = ".$v['uid']." and order_id like 'gm%'";
                $amout_offline = DB::table($pay_table)->whereRaw($where)->sum('amount');
                $amout_offline = $amout_offline/100;
                $tmp['amout_offline'] = $amout_offline;
                
                //线上充值
                $tmp['amout_online'] = $amout_total - $amout_offline;

                //充值总额
                $tmp['amout_total'] = $amout_total;
                
 
                //充值笔数
                $pay_count = 0;
                $where = "status = 2 and uid = ".$v['uid'];
                $sql = "select count(uid) as actpaycount  from {$pay_table} where {$where}";
                $info=DB::select($sql);
                
                foreach ($info as $value) {
                    $value = json_decode(json_encode($value), true);
                    $pay_count = $value['actpaycount'];
                }
                $tmp['pay_count'] = $pay_count;

               //总提现额度
               $withdraw_table = 'one_by_one.withdraw';
               $withdraw_total = 0;
               $where = "Status = 1 and uid = ".$v['uid'];
               //$where = "create_time >= 0";
               $withdraw_total = DB::table($withdraw_table)->whereRaw($where)->sum('Amount');
               $tmp['withdraw_total'] = $withdraw_total;
               
               //op=1加金币2减金币
               $sum = '';
               $sum .=' sum(if(reason=2,value,0)) as win_sum,';//赢金币
               $sum .=' sum(if(reason=1,value,0)) as lose_sum,';//输金币 TODO 1？？？
               $sum .=' sum(if(reason = 6 or reason = 15,value,0)) as cost_sum';//台费
               $sum =  DB::table('user_money')
               ->select(DB::raw($sum))
               ->whereRaw('uid ='.(int)$v['uid'])
               ->first();
               
               //玩家盈亏
               $user_wl = 0;
               $user_wl = $sum->win_sum - $sum->lose_sum;
               $tmp['user_wl'] = $user_wl /100;
               
               //总税收
               $cost_sum = 0;
               $cost_sum = !empty($sum->cost_sum) ? $sum->cost_sum : 0;
               $tmp['cost_sum'] = $cost_sum /100;
               
               //所属渠道
               $table = 'dc_log_user.users';
               $where = "uid = ".$v['uid'];
               $channel_info =  DB::table($table)->select(['channel'])->whereRaw($where)->get()->toArray();
               
               $channel = '--';
               foreach ($channel_info as $k => $v) {
                   $channel = json_decode(json_encode($v), true);
                   $channel = $channel['channel'];
               }
               $tmp['channel'] = $channel;
               
               //注册时间
               $tmp['created_time'] =  isset($user_info['created_time']) ? date('Y-m-d H:i:s',$user_info['created_time']) : '--';
               
               $online_list[] = $tmp;
               if($table_type == 0){
                   $hall += 1;
               }
            }
        }
        
        $data['online_list'] = $online_list;
        $data['all_count'] = count($data['online_list']);
        $data['hall_count'] = $hall;
        $data['game_count'] = $data['all_count'] - $hall;


        $table_data = array(
            '玩家id','玩家昵称','所在位置','携带金币额度',
            '线下充值总金额','线上充值总金额','充值总额','充值笔数','兑换总金额','盈亏(输+赢)',
            '总税收额度','渠道来源','注册时间',
        );
        $back  = array(
            'data' => $data,
            'game_data' => $table_data,
            'pagename' => '在线列表',
        );
        
        return view('OnlineList.online',$back);
        

        
    }
    
    private function _objectarray($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->_objectarray($value);
            }
        }
        return $array;
    }
    

    
    /**
     * curl模拟GET/POST发送请求
     * @param string $url 请求的链接
     * @param array $data 请求的参数
     * @param string $timeout 请求超时时间
     * @return mixed
     * @since 1.0.1
     */
    function curl($url, $data = array(), $timeout = 5) {
        
        $ch = curl_init();
        if (!empty($data) && $data) {
            if(is_array($data)){
                $formdata = http_build_query($data);
            } else {
                $formdata = $data;
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    
    
    
}
