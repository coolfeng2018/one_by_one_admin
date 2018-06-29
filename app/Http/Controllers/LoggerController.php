<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\LoggerRepository;

class LoggerController extends Controller
{
    protected $loggerRepository;

    public function __construct(LoggerRepository $loggerRepository)
    {
        $this->loggerRepository=$loggerRepository;
    }
    public function index(){

        $param['uname']=$_GET['uname']??'';
        $param['stime']=$_GET['stime']??'';
        $param['etime']=$_GET['etime']??'';

        $results=$this->loggerRepository->info($param);
        $res['results']=$results;

        return view('Logger.index',['res'=>$res,'search'=>$param]);
    }
//    public function search(Request $request){
//
//        $pram['uname']=$request->uname;
//
//        $pram['stime']=$request->stime;
//        $pram['etime']=$request->etime;
//
//
//        //分页
//        $config=[];
//        $page=$request->page;
//        $config['page']=$page;
//
//        if($page>0){
//            $page=$page-1;
//        }else{
//            $page=$page;
//        }
//        //区间
//        $pre=10;
//        $offset=$page*$pre;
//
//        if( $pram['stime'] && $pram['etime']){
//            if($pram['uname']){
//                $results = DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id','admin.username','logger.mark','logger.addtime')
//                    ->where('admin.username','=',$pram['uname'])->where('logger.addtime','>=',$pram['stime'])->where('logger.addtime','<=',$pram['etime'])
//                    ->orderBy('logger.id', 'desc')->offset($offset)->limit($pre)->get();
//
//                $total=  DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id')
//                    ->where('admin.username','=',$pram['uname'])->where('logger.addtime','>=',$pram['stime'])->where('logger.addtime','<=',$pram['etime'])
//                    ->count();
//            }else{
//                $results = DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id','admin.username','logger.mark','logger.addtime')
//                    ->where('logger.addtime','>=',$pram['stime'])->where('logger.addtime','<=',$pram['etime'])
//                    ->orderBy('logger.id', 'desc')->offset($offset)->limit($pre)->get();
//
//                $total=  DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id')
//                    ->where('logger.addtime','>=',$pram['stime'])->where('logger.addtime','<=',$pram['etime'])
//                    ->count();
//            }
//
//        }else{
//            if($pram['uname']){
//                $results = DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id','admin.username','logger.mark','logger.addtime')
//                    ->where('admin.username','=',$pram['uname'])
//                    ->orderBy('logger.id', 'desc')->offset($offset)->limit($pre)->get();
//
//                $total=  DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id')
//                    ->where('admin.username','=',$pram['uname'])
//                    ->count();
//            }else{
//                $results = DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id','admin.username','logger.mark','logger.addtime')
//                    ->orderBy('logger.id', 'desc')->offset($offset)->limit($pre)->get();
//
//                $total=  DB::table('logger')->join('admin','admin.id','=','logger.uid')
//                    ->select('logger.id')
//                    ->count();
//            }
//        }
//
//        $num=ceil($total/$pre);
//        //分页信息
//        $config['total']=$total;
//        $config['num']=$num;
//
//        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$results,'pram'=>$pram,'pagination'=>$config]));
//    }
}
