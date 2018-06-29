<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Repositories\ConfigRepository;

class ConfigController extends BaseController
{
    protected $configRepository;
    function __construct(ConfigRepository $configRepository){
        $this->configRepository = $configRepository;
    }

    public function index(){

        $results = DB::table('config')->get();
//        $results='[{"key": "Hello","value": "World"},{"key": "Hello","value": "World"},{"key": "Hello","value": "World"},{"key": "Hello","value": "World"}]';
        return view('Config.index',['res'=>$results]);
    }

    public function add(){
        return view('Config.add');
    }

    public function save(Request $request){

        $id=$request->id;

        // $data['FriendsMax']=$request->max;
        $data['ActiveDetail']=$request->detail;

        if($id){
            $preArr=DB::table('config')->select('ActiveDetail')->where('Id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'杂项配置',$id);

            $result=DB::table('config')->where('Id', $id)->update($data);
            parent::saveLog('更新杂项配置id--'.$id);
        }else{
            $result=DB::table('config')->insertGetId($data);
            parent::saveLog('添加杂项配置id--'.$id);
        }

        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/config/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('config')->where('Id', $id)->get();
        return view('Config.update',['res'=>$results]);
    }

    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('config')->where('Id', '=', $id)->delete();
        parent::saveLog('删除杂项配置id--'.$id);

        return redirect('config/index');
    }

    public function show(Request $request){
        $res = DB::table('config')->first();

        $tmp=json_decode(json_encode($res), true);

        $result=$tmp['ActiveDetail'];

        try{
            Redis::set('config',$result);
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>1,'msg'=>$e]));
        }

    }

    public function download(Request $request){ 
        if ($request->type) {
            $result = $this->configRepository->todoConfig($request->type);
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }
        return view('Config.download');
    }
}
