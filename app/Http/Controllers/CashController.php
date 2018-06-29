<?php

namespace App\Http\Controllers;

use App\Repositories\CashRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashController extends BaseController
{
    protected $cashRepository;

    public function __construct(CashRepository $cashRepository)
    {
        $this->cashRepository=$cashRepository;
    }

    public function index(){
        $res['type']=$this->keyVal(1);

        $param['type']=$_GET['type']??-1;
        $param['stime']=$_GET['stime']??'';
        $param['etime']=$_GET['etime']??'';
        $param['uid']=$_GET['uid']??'';

        $select = 'a.*,a.Status AS w_status,a.CreateAt as acreate,b.*';
        $from   = 'agent_withdraw as a LEFT JOIN (select agents.*,tmp.* from agents left join tmp_agents_depth_parent tmp on agents.AgentId = tmp.id) AS b ON a.AgentId=b.AgentId';
        $where  = '1=1';
        if(!empty($param['uid'])) {
            $where .= ' and b.UserId='.(int)$param['uid'];
        }
        if(!empty($param['type']) && $param['type']!=-1) {
            $where .= ' and a.WithdrawChannel='.(int)$param['type'];
        }
        if(!empty($param['stime'])) {
            $where .= " and a.CreateAt>='".$param['stime']."'";
        }
        if(!empty($param['etime'])) {
            $where .= " and a.CreateAt<='".$param['etime']."'";
        }
        $where .= '  order by a.AgentWithdrawId desc';
        $result = DB::table(DB::raw($from))->selectRaw($select)->whereRaw($where)->paginate(30);
       // var_dump($res);exit;
        


        $res['result']=$result;

        return view('Cash.index',['res'=>$res,'search'=>$param]);
    }

    public function updateStatus(Request $request){
        $id=$request->id;
        $data['Status']=$request->status;

        $preArr=DB::table('agent_withdraw')->select('Status','AgentId','Amount')->where('AgentWithdrawId', $id)->first();
        $preArr=json_decode(json_encode($preArr), true);


        $result=DB::table('agent_withdraw')->where('AgentWithdrawId', $id)->update($data);
        //操作agents更新账户金额
        $ainfo=DB::table('agents')->select('Balance','FrozenAmount')->where('AgentId', $preArr['AgentId'])->first();
        $ainfo=json_decode(json_encode($ainfo), true);
        if($data['Status']==1){
            $upd['FrozenAmount']=$ainfo['FrozenAmount']-$preArr['Amount'];
        }elseif($data['Status']==2){
            $upd['Balance']=$ainfo['Balance']+$preArr['Amount'];
            $upd['FrozenAmount']=$ainfo['FrozenAmount']-$preArr['Amount'];
        }
        $result1=DB::table('agents')->where('AgentId', $preArr['AgentId'])->update($upd);

        parent::saveLog('修改提现审核id--'.$id.'的状态值改为'.$data['Status']);
        $this->wlog('withdraw  id:'.$id.'  status:'.$data['Status'],'money_draw');
        return redirect('/cash/index');
    }

    public function findRecord(Request $request){
        $id=$request->id;
        $page=(int)$request->page;
        $page=$page-1;
        $size=$request->size;
        $res=$this->cashRepository->findRecordData($id,$page,$size);

        return response()->json(['status'=>200,'res'=>$res]);
    }


    protected function keyVal($item){
        if($item==1){
            $arr[-1]='全部';
            $arr[0]='银行';
            $arr[1]='支付宝';
            $arr[2]='微信';
        }
        return $arr;
    }
}
