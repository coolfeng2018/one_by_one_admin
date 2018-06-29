<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        $role=session('admin')['part_id'];
        if($role==1){
            //超级管理员
            $menu=DB::table('access')->select('id','name')->where('pid','=',0)->where('status','=',1)->where('type','=',1)->get();
            $menu=$this->objectToArray($menu);
            foreach ($menu as $k => $v){
                $lowMenu=DB::table('access')->select('id','url','name')->where('pid','=',$v['id'])->where('status','=',1)->where('type','=',1)->get();
                $lowMenu=$this->objectToArray($lowMenu);
                $menu[$k]['level']=$lowMenu;
            }
        }else{
            //非超级管理员
            $menu=DB::table('part_access')
                ->join('access','part_access.access_id', '=', 'access.id')
                ->select('access.id','access.name')->where('pid','=',0)->where('status','=',1)->where('type','=',1)->where('part_access.part_id','=',$role)->get();
            $menu=$this->objectToArray($menu);
            foreach ($menu as $k => $v) {
                $lowMenu = DB::table('part_access')
                    ->join('access', 'part_access.access_id', '=', 'access.id')
                    ->select('access.id','url', 'access.name')->where('pid', '=', $v['id'])->where('status', '=', 1)->where('type', '=', 1)->where('part_access.part_id', '=', $role)->get();
                $lowMenu=$this->objectToArray($lowMenu);
                $menu[$k]['level'] = $lowMenu;
            }
        }
        return view('Index.index',['menu'=>$menu]);
    }

    public function access(){
        return view('Index.access');
    }

    protected function objectToArray($obj){
        $arr=json_decode(json_encode($obj), true);
        return $arr;
    }
}
