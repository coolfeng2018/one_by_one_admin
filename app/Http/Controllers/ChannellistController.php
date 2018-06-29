<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ChannellistRepository;
use Illuminate\Support\Facades\Log;

class ChannellistController extends BaseController
{
    protected $channellistRepository;

    public function __construct(ChannellistRepository $channellistRepository)
    {
        $this->channellistRepository = $channellistRepository;
    }
    
    public function index(Request $request) {
        $data = $this->channellistRepository->findBy('channel_list');
        return view('Channellist.list',['res' => $data]);
    }
    
    public function add(Request $request) {
        $data = (object)['id' => '', 'name' => '', 'code' => ''];
        return view('Channellist.add', ['data' => $data]);
    }
    
    public function save(Request $request){
        $id=$request->id;
        $data['name']=$request->name;
        $data['code']=$request->code;
        //$data['status']=$request->status;
        $data['modified_time'] = date('Y-m-d H:i:s');
        if($id){
            $result=DB::table('channel_list')->where('id', $id)->update($data);
            parent::saveLog('修改渠道id'.$id.'的记录');
        }else{
            $data['created_time'] = date('Y-m-d H:i:s');
            $result=DB::table('channel_list')->insertGetId($data);
            parent::saveLog('修改渠道id'.$result.'的记录');
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/channellist/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    
    public function delete(Request $request) {
        $id=$request->id;
        $res=DB::table('channel_list')->where('id', '=', $id)->delete();
        return redirect('/channellist/index');
    }
    
    public function update(Request $request) {
        $id = $request->id;
        $data = DB::table('channel_list')->where('id', '=', $id)->first();
        
        return view('Channellist.add', ['data' => $data]);
    }

}