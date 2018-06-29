<?php

namespace App\Http\Controllers;

use App\Repositories\ShopRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;



class ShopController extends BaseController
{
    /**
     * 发送服务器路由
     * 配置为空就不显示，配置了发送路由就显示按钮
     * @var string
     */
    protected $sntcfg_btn = 'shop';
    protected $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository=$shopRepository;
    }

    /**
     * 商城配置
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['id'] = $_GET['id']??'';
        $param['name'] = $_GET['name']??'';
        $res = $this->shopRepository->info($param);
        $recordData = $this->shopRepository->findRecordData() ? $this->shopRepository->findRecordData() : array();
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
        $item=DB::table('item')->select('id','name')->get()->toArray();
        return view('Shop.index',['res'=>$res,'search'=>$param,'recordData'=>$recordData,'checkServerData'=>$checkServerData,'checkCustomerData'=>$checkCustomerData,'item'=>$item,'sntcfg_btn'=>$this->sntcfg_btn]);
    }

    /**
     * 新增常量
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $item=DB::table('item')->get()->toArray();  
        return view('Shop.add',['items'=>$item]);
    }

    /**
     * 保存数据
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){ 
        $primaryId=$request->ShopId;
        //base data
        $data['id']=$request->id;
        $data['name']=$request->name;
        $data['price']=$request->price;
        $data['goods']=$request->goods;
        $data['index']=$request->index;
        $data['discount']=$request->discount;
        $data['icon_name']=$request->icon_name;
        $data['ios_goods_id']=$request->ios_goods_id;

        if($primaryId){
            $data['updated_at']=date('Y-m-d H:i:s');
            $preArr=DB::table('shop')->select('id','name','price','goods','index','discount','icon_name','ios_goods_id')->where('ShopId', $primaryId)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'商城',$primaryId);
            $result=DB::table('shop')->where('ShopId', $primaryId)->update($data); 
            parent::saveLog('商城ShopId--'.$primaryId);
        }else{
            $result=DB::table('shop')->insertGetId($data);
            parent::saveLog('商城ShopId--'.$result);
        }
        if($result){
            exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/shop/index']));
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ShopId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $primaryId=$request->ShopId;
        $results=DB::table('shop')->where('ShopId', $primaryId)->first(); 
        $item=DB::table('item')->get()->toArray(); 
        return view('Shop.edit',['res'=>$results,'items'=>$item]);
    }

    public function delete(Request $request){
        $ShopId=$request->ShopId;
        $res=DB::table('shop')->where('ShopId', '=', $ShopId)->delete();
        parent::saveLog('删除商城ShopId--'.$ShopId);

        return redirect('/shop/index');
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
        $res=$this->shopRepository->baseArray($request);   
        //数组转lua
        $luaData = "\nreturn ".convert_data($res,0);
        if($luaData){
            try{
                $select = explode(',', $select);
                foreach ($select as $key => $value) {
                    $select[$key] = $type.'_'.$value;
                }
                $where['table_name'] = 'shop';
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

    public function uploads(Request $request){
        $file = $request->file('file');
        $repath = $request->repath??'store';
        $preDir='uploads';
        $path = $file->store('/store',$preDir );

        $client=new Client();

        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($preDir.'/'.$path,'r')],['name'=>'type','contents'=>$repath]]]);

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
    
    
    /**
     * 发送服务器配置
     * @param Request $request
     */
    protected function sndcfg(Request $request) {
        $cfgname = $this->sntcfg_btn;
        $param['select'] = $request->select;
        $lua_str=$this->shopRepository->baseArray($param);
        $lua_str = "\nreturn ".convert_data($lua_str,0);
        $res = $this->doUpload($cfgname,$lua_str);
        exit(json_encode($res));
    }
}
