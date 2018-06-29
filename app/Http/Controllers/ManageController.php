<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageController extends BaseController
{
    public function index(){
        $results = DB::table('admin')
            ->leftjoin('part_admin','admin.id','=','part_admin.admin_id')
            ->leftjoin('part','part.id','=','part_admin.part_id')
            ->select('admin.id','admin.username','admin.status','admin.addtime','part.name','part.id as pid')
            ->paginate(10);
        $back['page'] = isset($_GET['page'])  ? $_GET['page'] : 1;
        $back['res'] = $results;
        return view('Manage.index',$back);
    }

    public function add(){
        $admin_id = session('admin')['id'];
        $admin_roleid = session('admin')['part_id'];
        //非超级管理员 只能添加和自己角色相同的用户
        $where = '';
        if($admin_roleid != 1) {
            $where = ' and id='.$admin_roleid;
        }
        $role = $this->keyVal($where);
        return view('Manage.add',['res'=>$role]);
    }
    
    public function save(Request $request){

        $id=$request->id;
        $data['username']=$request->name;
        $data['status']=$request->status;

        $tmp['part_id']=$request->type;
        if($id){
            if( $request->pwds && md5($request->pwds)!= $request->psd){
                $data['password']=md5($request->pwds);
            }else{
                $data['password']=$request->psd;
            }

            $result=DB::table('admin')->where('id', $id)->update($data);
            parent::saveLog('更新管理员id--'.$id);

            $res=DB::table('part_admin')->where('admin_id', $id)->update($tmp);
        }else{
            $data['password']=md5($request->pwds);
            $result=DB::table('admin')->insertGetId($data);
            parent::saveLog('添加管理员id--'.$result);

            $tmp['admin_id']=$result;
            $res=DB::table('part_admin')->insertGetId($tmp);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/manage/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results = DB::table('part_admin')
            ->leftjoin('admin','admin.id','=','part_admin.admin_id')
            ->select('admin.id','admin.username','admin.password','admin.status','part_admin.part_id')
            ->where('admin.id', $id)->get();
        
        //获取角色列表
        $admin_id = session('admin')['id'];
        $admin_roleid = session('admin')['part_id'];
        //非超级管理员 只能添加和自己角色相同的用户
        $where = '';
        if($admin_roleid != 1) {
            $where = ' and id='.$admin_roleid;
        }
        $role = $this->keyVal($where);
        
        $res['results']=$results;
        $res['role']=$role;
        return view('Manage.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('admin')->where('id', '=', $id)->delete();
        $res=DB::table('part_admin')->where('admin_id', '=', $id)->delete();
        parent::saveLog('删除管理员id--'.$id);

        return redirect('/manage/index');
    }

    protected function keyVal($where = ''){
        $where = empty($where) ? '1=1' : '1=1'.$where;
        $res = DB::table('part')->select('id', 'name')->whereRaw($where)->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['id']]=$v['name'];
        }
        return $arr;
    }
    /**
     * 设置渠道过滤
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function  cidfliter(Request $request){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $act = isset($_GET['act']) ? $_GET['act'] : '';
        $admin_id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($act == 'do') {
            $myStr=substr($request->mypro,1,-1);
            $my_now_list = explode(',',$myStr);
            $my_prev_list = $this->getMyCidList($admin_id);
            $del = array_diff($my_prev_list,$my_now_list);
            $add = array_diff($my_now_list,$my_prev_list);
            //删除权限
            if(!empty($del)) {
                foreach ($del as $k=>$v) {
                    $where = 'cid ='.$v.' and admin_id='.$admin_id;
                    $res = DB::table('admin_cid')->whereRaw($where)->delete();
                    parent::saveLog('管理员管理-删除用户.id='.$admin_id.'渠道权限cid'.$v.')  res='.$res);
                }
                
            }
            //增加权限
            if(!empty($add)) {
                foreach ($add as $k=>$v) {
                    $add_info['admin_id'] = $admin_id;
                    $add_info['cid'] = $v;
                    $add_info['op_name'] = session('admin')["id"]."-".session('admin')["username"];
                    $add_info['op_time'] = date('Y-m-d H:i:s',time());
                    $res = DB::table('admin_cid')->insertGetId($add_info);
                    parent::saveLog('管理员管理-增加用户admin_id='.$admin_id.'渠道权限id='.$res.')  res='.$res);
                }
            }
            exit(json_encode(['status'=>0,'msg'=>'ok','url'=>'/manage/cidfliter?id='.$admin_id.'&page='.$page]));

        }else{
            
            //渠道列表
            $tmp[0]['level'] = DB::table('channel_list')->select('id','name','code')->where('status','=',1)->get();
            $tmp[0]['name'] = '渠道列表';
            
            $admin_roleid = $this->getRoleIdByAdminId($admin_id);
            //用户的渠道
            if($admin_roleid == 1) {
                $my_cid_list = $this->getAllCidList();
            }else{
                $my_cid_list = $this->getMyCidList($admin_id);
            }
            $res['access']=$tmp;
            $res['myAccess'] = $my_cid_list;
            $res['id']=$request->id;
            
            $back = $_GET;
            $back['res'] = $res;
            $back['page'] = $page;
            return view('Manage.cid',$back);
        }
        
    }

    

}
