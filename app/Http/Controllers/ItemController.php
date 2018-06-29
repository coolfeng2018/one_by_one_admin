<?php

namespace App\Http\Controllers;

use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ItemController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'item';
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository=$itemRepository;
    }

    /**
     * 道具表配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['name'] = $_GET['name']??'';
        $res = $this->itemRepository->info($param);
        $recordData = $this->itemRepository->findRecordData() ? $this->itemRepository->findRecordData() : array();
        $checkServerData = '';
        $checkCustomerData = '';
        if($recordData){
            $checkServerData = '';
            $checkCustomerData = '';
            if($recordData->server_record){
                foreach (json_decode($recordData->server_record) as $key => $value) {
                    $value = str_replace('server_', '', $value);
                    $checkServerData .= $value.',';
                }
                $checkServerData = substr($checkServerData, 0,strlen($checkServerData)-1);
            }
            if($recordData->customer_record){
                foreach (json_decode($recordData->customer_record) as $key => $value) {
                    $value = str_replace('customer_', '', $value);
                    $checkCustomerData .= $value.',';
                }
                $checkCustomerData = substr($checkCustomerData, 0,strlen($checkCustomerData)-1);
            }
        } 
        return view('Item.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('Item.add');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ItemId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->ItemId;
        $results=DB::table('item')->where('ItemId', $primaryId)->first();  
        return view('Item.edit',['res'=>$results]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->ItemId;
        //base data
        $data['id']=$request->id;
        $data['name']=$request->name;
        $data['description']=$request->description;
        $data['icon']=$request->icon; 
        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('item')->select('id','name')->where('ItemId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'道具表',$primaryId);
            $result=DB::table('item')->where('ItemId', $primaryId)->update($data); 
            parent::saveLog('道具表ItemId--'.$primaryId);
        }else{
            $result=DB::table('item')->insertGetId($data);
            parent::saveLog('道具表ItemId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/item/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }


    public function delete(Request $request){
        $ItemId=$request->ItemId;
        $res=DB::table('item')->where('ItemId', '=', $ItemId)->delete();
        parent::saveLog('删除道具表ItemId--'.$ItemId);

        return redirect('/item/index');
    }

    /**
     * 数组转lua
     **/
    public function lua(Request $request){
        $type = $request->type;
        $lua = $request->lua;
        $select = $request->select;
        if($lua){
            //curl 数据到接口
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }
        //基础数组
        $res=$this->itemRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'item';
                $data[$type.'_record'] = json_encode($select);
                DB::table('user_behavior_record')->where($where)->update($data);
                exit(json_encode(['status'=>1,'msg'=>'ok','lua_data'=>$luaData]));
            }catch (\Exception $e){
                exit(json_encode(['status'=>0,'msg'=>$e]));
            }
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    /**
     * 发送服务器配置
     * @param Request $request
     */
    protected function sndcfg(Request $request) {
        $cfgname = $this->sntcfg_btn;
        $param['select'] = $request->select;
        $lua_str=$this->itemRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
    
}
