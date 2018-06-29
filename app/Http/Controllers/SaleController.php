<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SaleController extends BaseController
{
    public function index(){

        $results = DB::table('sale')->paginate(10);
        $res['props']=$this->keyVal();
        $res['results']=$results;

        return view('Sale.index',['res'=>$res]);
    }

    public function add(){
        $res['props']=$this->keyVal();
        return view('Sale.add',['res'=>$res]);
    }
    public function save(Request $request){

        $id=$request->id;

        $data['SaleName']=$request->name;
        $data['PropsId']=$request->kind;
        $data['Termtype']=$request->type;
        $data['TermMin']=$request->low;
        $data['TermMax']=$request->high;
        $data['TermUid']=$request->idset;
        $data['Status']=$request->status;

        if($id){
            $preArr=DB::table('sale')->select('SaleName','PropsId','Termtype','TermMin','TermMax','TermUid','Status')->where('SaleId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'促销',$id);

            $result=DB::table('sale')->where('SaleId', $id)->update($data);
            parent::saveLog('更新促销id--'.$id);
//            $this->DbToRedis($id,$data);
        }else{
            $result=DB::table('sale')->insertGetId($data);
            parent::saveLog('添加促销id--'.$result);
//            $this->DbToRedis($result,$data);
        }


        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/sale/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('sale')->where('SaleId', $id)->get();
        $res['results']=$results;
        $res['props']=$this->keyVal();
        return view('Sale.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('sale')->where('SaleId', '=', $id)->delete();
        parent::saveLog('删除促销id--'.$id);

        return redirect('sale/index');
    }
    //获取道具列表
    protected function keyVal(){
        $arr=[];

        $res = DB::table('props')->select('PropsId', 'PropsName')->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['PropsId']]=$v['PropsName'];
        }
        return $arr;
    }
}
