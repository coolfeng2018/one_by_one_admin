<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsCategoryController extends BaseController
{
    public function index(){
        $results =DB::table('goods_category')->paginate(10);
        return view('GoodsCategory.index',['res'=>$results]);
    }

    public function add(){
        return view('GoodsCategory.add');
    }
    public function save(Request $request){
        $id=$request->id;
        $data['CategoryName']=$request->name;
        $data['AllowVersion']=$request->suitTag;
        $data['DenyVersion']=$request->banTag;
        $data['AllowChannel']=$request->suitSign;
        $data['DenyChannel']=$request->banSign;
        if($id){
            $preArr=DB::table('goods_category')->select('CategoryName','AllowVersion','DenyVersion','AllowChannel','DenyChannel')->where('CategoryId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'渠道分类',$id);

            $result=DB::table('goods_category')->where('CategoryId', $id)->update($data);
            parent::saveLog('更新渠道分类id--'.$id);
        }else{
            $result=DB::table('goods_category')->insertGetId($data);
            parent::saveLog('添加渠道分类id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/goodsCategory/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){

        $id=$request->id;
        $results=DB::table('goods_category')->where('CategoryId', $id)->get();
        return view('GoodsCategory.update',['res'=>$results]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('goods_category')->where('CategoryId', '=', $id)->delete();
        parent::saveLog('删除渠道分类id--'.$id);

        return redirect('goodsCategory/index');

    }
}
