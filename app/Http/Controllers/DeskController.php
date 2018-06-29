<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeskController extends BaseController
{
    public function index(){
        $results = DB::table('desksets')->paginate(10);
        $res['results']=$results;
        $res['games']=$this->keyVal();
        return view('Desk.index',['res'=>$res]);
    }

    public function add(){
        $res['games']=$this->keyVal();
        return view('Desk.add',['res'=>$res]);
    }
    public function save(Request $request){

        $id=$request->id;
        $rule=$request->rule;
        $tmp=str_replace('"','', $rule);
        $tmp=str_replace("'",'"', $tmp);
        $data['deskset_name']=$request->name;
        $data['kind_id']=$request->game;
        $data['level']=$request->level;
        $data['logo_url']=$request->img1;
        $data['score_url']=$request->img2;
        $data['gif_url']=$request->img3;
        $data['least_bet']=$request->low;
        $data['maximum_bet']=$request->high;
        $data['fee']=$request->fee;
        $data['status']=$request->status;
        $data['sort_id']=$request->sort;
        $data['rule']=$tmp;

        if($id){
            $preArr=DB::table('desksets')->select('deskset_name','kind_id','level','logo_url','score_url','gif_url','least_bet','maximum_bet','fee','status','sort_id','rule')->where('deskset_id', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'场次',$id);

            $result=DB::table('desksets')->where('deskset_id', $id)->update($data);
            parent::saveLog('更新场次id--'.$id);
        }else{
            $result=DB::table('desksets')->insertGetId($data);
            parent::saveLog('添加场次id--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/desk/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;
        $results=DB::table('desksets')->where('deskset_id', $id)->get();
        $res['results']=$results;
        $res['games']=$this->keyVal();
        return view('Desk.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('desksets')->where('deskset_id', '=', $id)->delete();
        parent::saveLog('删除场次id--'.$id);

        return redirect('desk/index');
    }

    public function uploads(Request $request){
        $file = $request->file('file');
        $preDir='uploads';
        $path = $file->store('/desk',$preDir );

        $client=new Client();
        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($preDir.'/'.$path,'r')],['name'=>'type','contents'=>'resource']]]);

        if($response->getStatusCode()==200) {
            $result=$response->getBody();
            $result=json_decode($result);
            if($result->status==200) {
                unlink($preDir.'/'.$path);
                $resPath=$result->data->filePath;
            }else{
                $resPath='';
            }
        }else{
            $resPath='';
        }
        return response()->json(array('msg' => $resPath,'RemoteDir'=>config('suit.ImgRemoteUrl')));
    }

    //获取游戏分类
    protected function keyVal(){
        $res = DB::table('games')->where('scene_id','=','1')->select('kind_id', 'game_name')->get();
        $tmp=json_decode(json_encode($res), true);
        foreach ($tmp as $k => $v) {
            $arr[$v['kind_id']]=$v['game_name'];
        }
        return $arr;
    }
}
