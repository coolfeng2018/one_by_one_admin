<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Excel;

class OrderController extends BaseController
{
    protected $orderRepository;
    protected $userRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }
    
    private $_goods = [
        110 => ['productName' => '金币100'], 
        111 => ['productName' => '金币290'], 
        112 => ['productName' => '金币490'], 
        113 => ['productName' => '金币990'], 
        114 => ['productName' => '金币1690'], 
        115 => ['productName' => '金币3990'], 
        116 => ['productName' => '金币6990'], 
        117 => ['productName' => '金币19990'], 
    ];

    public function index(){
        $param['uid']=$_GET['uid']??''; // 用户id
        $param['status']=$_GET['status']??'z'; // 支付状态
        $param['channel']=$_GET['channel']??'z'; // 平台
        $param['payment_channel']=$_GET['payment_channel']??'z'; // 支付渠道
        $param['stime']=$_GET['stime']??date('Y-m-d 00:00', strtotime('-6 days')); // 开始时间
        $param['etime']=$_GET['etime']??date('Y-m-d 23:59'); // 结束时间
        $export = isset($_GET['export']) ? $_GET['export'] : 0;

        $results=$this->orderRepository->info($param, $export);
        if ($export == 1) {
            $title = "订单记录";
            $descList = [['用户id','订单号','付款方式','支付结果','平台','商品名称','金额','购买时间']];
            $list = [];
            foreach ($results as $v) {
                $productName = isset($this->_goods[$v->product_id]) ? $this->_goods[$v->product_id]['productName'] : "未知";
                $list[] = [
                    $v->uid, 
                    $v->order_id, 
                    $this->getPaymentName($v->payment_channel), 
                    $this->getPayResult($v->status),
                    $v->channel,
                    $productName,
                    $v->amount,
                    date('Y-m-d H:i:s', $v->create_time)
                ];
            } 
            return $this->doExport($descList, $list, $title);
        }
        
        foreach ($results as & $val) {
            $user = null;
            $val->amount = round($val->amount / 100, 2);
            if (isset($this->_goods[$val->product_id])) {
                $val->productName = $this->_goods[$val->product_id]['productName'];
            } else {
                if ($val->payment_channel == 'gm') { // 人工订单
                    $val->productName = "金币".($val->amount * 100);
                } else {
                    $val->productName = null;
                }
            }
            $uinfo = $this->userRepository->getMonUserInfo($val->uid);
            $val->nickname = isset($uinfo['name']) ? $uinfo['name'] : "";
        }
        $res['results']=$results;

        return view('Order.index',['res'=>$res,'search'=>$param]);
    }

    /**
     * 添加人工订单
     * @return type
     */
    public function addArtificialOrder() {
        $goods = $this->_goods;
        return view('Order.artificia', ['data' => [], 'goods' => $goods]);
    }
    
    public function getUserInfo() {
        $param['uid']=$_POST['uid']??''; // 用户id
        $user = $this->userRepository->getUser($param);
        $len = 10 - strlen($param['uid']);
        $zero = sprintf("%0".$len."d", 0);
        $nuid = $zero . $param['uid'];
        $orderId = 'gm'.date('ymdHis').$nuid;
        if (empty($user) || empty($param['uid'])) {
            die(json_encode(['success' => false, 'user'=>[], 'orderId' => $orderId, 'channel' => '']));
        } else {

            if (preg_match("/iphone/Ui", $user->device_brand)) {
                $channel = 'ios';
            } elseif(preg_match("/android/Ui", $user->device_brand) || preg_match("/android/Ui", $user->channel)) {
                $channel = 'android';
            } else {
                $channel = '';
            }
            die(json_encode(['success' => true, 'user'=>$user, 'orderId' => $orderId, 'channel' => $channel]));
        }
    }
    
    /**
     * 保存人工订单
     */
    public function save(Request $request) {
        $params['uid'] = $request->uid;
        $params['order_id'] = $request->order_id;
        $params['channel'] = $request->channel;
        $params['amount'] = $request->amount*100;
        $params['payment_channel'] = $request->pay_channel;
        $params['product_id'] = 0; // 人工订单
        $params['create_time'] = strtotime($request->create_time);
        $params['channel_order'] = $params['order_id'];
        $params['status'] = 0; // 0:已下单，1:已支付未处理，2:已支付已处理完成
        
        if ($this->orderRepository->add($params)) {
            parent::saveLog('添加人工订单id--'.$params['order_id'].'的记录');
            die(json_encode(['status' => true]));
        }
        
        die(json_encode(['status' => false]));
    }
    
    /**
     * 发布，修改订单状态为已完成发货
     * @param Request $request
     */
    public function public (Request $request) {
        $oid = $request->oid;
        if (empty($oid)) {
            die(json_encode(['status' => false, 'code' => '-100']));
        }
        
        $data = Redis::get('publicorder_'.$oid);
        if ( ! empty($data)) {
            die(json_encode(['status' => false, 'code' => '-104']));
        } else {
            Redis::set('publicorder_'.$oid, 1);
            Redis::expire('publicorder_'.$oid, 3); // 设置3秒过期时间
        }
        
        $exist = $this->orderRepository->getOneOrder(['order_id' => $oid]);
        if (empty($exist)) { // 订单不存在
            die(json_encode(['status' => false, 'code' => '-101']));
        }
        if ($exist->status == 2) { // 订单状态为已支付
            die(json_encode(['status' => false, 'code' => '-102']));
        }
        // 发邮件发货
        $sendRet = $this->SendMailto($exist->uid, $exist->order_id, round($exist->amount/100, 2), $exist->amount);

        if ($sendRet['code'] == 200) {
            $ret = $this->orderRepository->update(['order_id' => $oid], ['status' => 2, 'paid_time' => time()]);
            if ($ret) {
                die(json_encode(['status' => true]));
            } else {
                Log::info('line:'.__LINE__.' update Order Fail [邮件发货失败]:'.json_encode(['order_id'=> $oid, 'status' => 2, 'paid_time' => time()])); 
            }
        } else {
            die(json_encode(['status' => false, 'code' => '-104']));
        }

        die(json_encode(['status' => false, 'code' => '-103']));
    }
    
    /**
     * 调api接口邮件发货
     * @param type $uid 用户id
     * @param type $orderId 订单id
     * @param type $amount 订单金额
     * @param int $number 发货数量
     * @param int $ptype 发货类型，1001金币， 1002钻石，1003元宝，1004人民币
     */
    private function SendMailto($uid, $orderId, $amount, $number, $ptype=1001) {
        parent::saveLog('人工订单id--'.$orderId." 发布");
        $params = (object)[
            'title' => '人工充值成功提示',
            'content' => "您人工充值的" . $amount . "元已到账，请注意查收。",
            'mail_type' => 2,
            'op_user' => 'GM',
            'range' => $uid,
            'attach_list' => '',
            'coins' => $number,

        ];

        $sendRet = sendEmail($params);
        if ($sendRet == true) {
            return ['code' => '200'];
        } else {
            return ['code' => '505', 'msg' => '未知错误'];
        }
    }
    
    /**
     * 导出excel
     * @param type $descList excel里面第一行
     * @param type $result 具体内容
     * @param type $title excel文件名
     */
    private function doExport($descList, $result, $title="execlLog") {
        $cellData = array_merge($descList, $result);
        Excel::create($title,function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData); 
                $sheet->setWidth(['A' => 20, 'B' => 20, 'C' => 20, 'D' => 20, 'E' => 20, 'F' => 20, 'G' => 20, 'H' => 20]);
            });
        })->export('xls');
    }
    
    /**
     * 获取支付名称S
     * @param type $paymentChannel
     * @return string
     */
    private function getPaymentName ($paymentChannel) {
        switch ($paymentChannel) {
            case 'xiaoqian_qq':
            case 'qq':
                $name = "QQ支付";
                break;
            case 'xiaoqian_alipay':
            case 'alipay':
                $name = "支付宝";
                break;                                                   
            case 'xiaoqian_wx':
            case 'wx':
                $name = "微信支付";
                break;
            case 'xiaoqian_union':
            case 'union':
                $name = '银联支付';
                break;
            case 'gm':
                $name = '人工订单';
                break;
            default:
                $name = '未知';
                break;
        }
        return $name;
    }
    
    /**
     * 支付结果
     * @param type $status
     * @return string
     */
    private function getPayResult($status) {
        switch ($status) {
            case 0:
                $msg = "已下单";
                break;
            case 1:
                $msg = "已支付未处理";
                break;
            case 2:
                $msg = "已支付已处理完成";
                break;
        }
        return $msg;
    }
}
