<?php

namespace App\Http\Controllers;

use App\Repositories\GameClassRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameClassController extends BaseController
{
    protected $gamesclassRepository;

    function __construct(GameClassRepository $gamesclassRepository)
    {
        $this->gamesclassRepository=$gamesclassRepository;
    }


    public function list(){
        $data=$this->gamesclassRepository->list();
        return view('gameclass.list',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->gamesclassRepository->find($id);
        return view('gameclass.edit',['data'=>$data]);
    }

    public function addshow(){
        return view('gameclass.add');
    }

    public function  postdata(Request $request){
        $class_id=(int)$request->class_id;


        $data['class_name']=$request->class_name;
        $data['class_sort']=$request->class_sort;

        if($class_id){
            $preArr=DB::table('games_class')->select('class_name','class_sort')->where('class_id', $class_id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'分类设置',$class_id);

            $result=DB::table('games_class')->where('class_id', $class_id)->update($data);
            parent::saveLog('更新分类设置id--'.$class_id);
        }else{
            $result=DB::table('games_class')->insertGetId($data);
            parent::saveLog('添加分类设置id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>200,'msg'=>'ok']));
        }else{
            exit(json_encode(['status'=>500,'msg'=>'error']));
        }

    }

    public function del(Request $request){
        $id=$request->id;
        if($this->gamesclassRepository->del($id)){
            parent::saveLog('删除分类设置id--'.$id);
            return redirect('/gameclass/list');
        }else{
            return redirect('/gameclass/list');
        }
    }

}
