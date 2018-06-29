<?php

namespace App\Http\Controllers;

use App\Repositories\BankruptcyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankruptcyController extends BaseController
{
    protected $bankruptcyRepository;

    function __construct(BankruptcyRepository $bankruptcyRepository)
    {
        $this->bankruptcyRepository=$bankruptcyRepository;
    }

    public function list(){
//        $frequency=config('bankruptcy.frequency');
//        $type=config('bankruptcy.type');
        $data=$this->bankruptcyRepository->list();
        return view('bankruptcy.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->bankruptcyRepository->find($id);
//        $frequency=config('bankruptcy.frequency');
//        $type=config('bankruptcy.type');
        return view('bankruptcy.edit',['data'=>$data]);
    }

    public function addshow(){
        $frequency=config('bankruptcy.frequency');
        $type=config('bankruptcy.type');
        return view('bankruptcy.add',['frequency'=>$frequency,'type'=>$type]);
    }

    public function postdata(Request $request){

        $bankruptcy_id=(int)$request->bankruptcy_id;
        $data['bankruptcy_name']=$request->bankruptcy_name;
//        $data['items']=$request->items;//$request->role_num;
        $data['below']=$request->below;
//        $data['status']=$request->status;
        $data['number']=$request->number;
        $data['amount']=$request->amount;

        if($bankruptcy_id){
            $preArr=DB::table('bankruptcy')->select('bankruptcy_name','below','number','amount')->where('bankruptcy_id', $bankruptcy_id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'破产补助',$bankruptcy_id);

            $result=DB::table('bankruptcy')->where('bankruptcy_id', $bankruptcy_id)->update($data);
            parent::saveLog('更新破产补助id--'.$bankruptcy_id);
        }else{
            $result=DB::table('bankruptcy')->insertGetId($data);
            parent::saveLog('添加破产补助id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }

    public function del(Request $request){
        $id=$request->id;
        if($this->bankruptcyRepository->del($id)){
            parent::saveLog('删除破产补助id--'.$id);
            return redirect('/bankruptcy/list');
        }else{
            return redirect('/bankruptcy/list');
        }
    }

}
