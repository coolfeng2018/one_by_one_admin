<?php

namespace App\Http\Controllers;

use App\Repositories\WithdrawRepository;
use Illuminate\Http\Request;

class WithdrawController extends BaseController
{
    protected $withdrawRepository;

    public function __construct(WithdrawRepository $withdrawRepository)
    {
        $this->withdrawRepository=$withdrawRepository;
    }

    public function list(){
        $search['type']=$_GET['type']??-1;
        $search['starttime']=$_GET['starttime']??date("Y-m-d H:i:s", strtotime("-3 year"));;
        $search['endtime']=$_GET['endtime']??date("Y-m-d H:i:s");
        $search['uid']=$_GET['uid']??0;
        $data=$this->withdrawRepository->list($search);

        return view('generalize.withdrawlist',['data'=>$data,'search'=>$search]);
    }

    public function findByIdmap(){
        $duid=$_GET['duid'];
        $page=(int)$_GET['page']-1;
        $size=$_GET['size'];
        $data=$this->withdrawRepository->findByIdmap($duid,$page,$size);
        $count=$this->withdrawRepository->findByIdmapCount($duid);
        $duserinfo=$this->withdrawRepository->myduserinfo($duid);
        return json_encode(['status'=>200,'data'=>$data,'count'=>$count,'duserinfo'=>$duserinfo]);
    }

    public function updatastatus(){
        $id=$_GET['id'];
        $status=$_GET['status'];
        if($this->withdrawRepository->edit($id,$status)){
            parent::saveLog('审核提现id--'.$id);
            return redirect('/generalize/withdrawlist');
        }else{
            return redirect('/generalize/withdrawlist');
        }
    }
}
