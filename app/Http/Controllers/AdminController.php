<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends BaseController
{
    public function index(){
        return view('Admin.index');
    }

    public function check(Request $request){
        $where['username']=$request->user;
        $where['password']=md5($request->pwds);
        $where['status']=1;
        //用户信息
        $results = DB::table('admin')->select('id','username','password','status')->where($where)->get();
        $info=$this->objectToArray($results);
        if($info){
            //查询角色信息
            $res=DB::table('part_admin')
                ->select('part_id')->where('admin_id','=',$info[0]['id'])->get();
            $list=$this->objectToArray($res);

            //保存admin session信息
            $info[0]['part_id']=$list[0]['part_id'];
            
            //用户的渠道
            if($info[0]['part_id'] == 1) {
                $my_cid_list = $this->getAllCidList();
            }else{
                $my_cid_list = $this->getMyCidList($info[0]['id']);
            }
            $info[0]['cid_list'] = json_encode($my_cid_list);
            
            session(['admin'=>$info[0]]);

            //根据角色信息获取权限
            if($list[0]['part_id']==1){
                //超级管理员
                $Access=DB::table('access')->select('url')->where('url','<>','')->where('status','=',1)->get();
            }else{
                //非超级管理员
                $Access=DB::table('part_access')
                    ->join('access','part_access.access_id', '=', 'access.id')
                    ->select('access.url')->where('access.url','<>','')->where('part_access.part_id','=',$list[0]['part_id'])->get();
            }

            $Access=$this->objectToArray($Access);
            $myAccess=[];
            //我的权限
            foreach ($Access as $kk =>$vv){
                array_push($myAccess,$vv['url']);
            }
            //保存access session信息
            session(['access'=>$myAccess]);

            //日志记录
            parent::saveLog('登录系统');

            return response()->json(['status' =>1, 'msg' => 'ok','url'=>'/index/index']);
        }else{
            return response()->json(['status' =>0, 'msg' => 'error']);
        }
    }


    public function out(){
        //日志记录
        parent::saveLog('退出系统');

        Session::forget('admin');
        Session::forget('out');
        return redirect('/');
    }
    protected function objectToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }
    

}
