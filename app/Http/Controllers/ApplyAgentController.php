<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplyAgentController extends BaseController
{
    public function index(){
        $res['total']= DB::table('apply_agent')->count();

        $results = DB::table('apply_agent')->paginate(10);

        foreach ($results as $k => $v){
            if(empty($v->Group)){
                $results[$k]->info=[];
            }else{
                $sql="select UserId,AgentId,RegisterTime,LastLoginTime from users where UserId in (".$v->Group.")";
                $info=DB::select($sql);
                $results[$k]->info=$this->objToArray($info);
            }
        }
        $res['results']=$results;

        return view('ApplyAgent.index',['res'=>$res]);
    }
    public function updateStatus(Request $request){
        $id=$request->id;
        $data['Status']=$request->status;

        $preArr=DB::table('apply_agent')->select('Status')->where('Id', $id)->first();
        $preArr=json_decode(json_encode($preArr), true);
        parent::saveTxtLog($preArr,$data,'申请管理',$id);

        $result=DB::table('apply_agent')->where('Id', $id)->update($data);
        parent::saveLog('修改申请id--'.$id);

        return redirect('/applyAgent/index');
    }

    protected function objToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }

}
