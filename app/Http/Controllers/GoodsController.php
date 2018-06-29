<?php

namespace App\Http\Controllers;

use App\Repositories\GoodsRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class GoodsController extends BaseController
{
    protected $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository=$goodsRepository;
    }
    public function index(){
        $res['kind']=$this->keyVal(1);
        $res['props']=$this->keyVal(2);
        $res['sale']=$this->keyVal(3);
        $res['type']=$this->keyVal(4);
        $res['os']=$this->keyVal(5);


        $param['os']=$_GET['os']??0;
        $param['kind']=$_GET['kind']??0;
        $param['type']=$_GET['type']??0;

        $results = $this->goodsRepository->info($param);
        $res['results']=$results;

        return view('Goods.index',['res'=>$res,'search'=>$param]);
    }

//    public function search(Request $request){
//        //参数
//        $pram['os']=$request->os;
//        $pram['kind']=$request->kind;
//        $pram['types']=$request->types;
//
//        //where条件
//        $whereID=[];
//        if( $pram['os'] !=0){
//            switch ($pram['os']){
//                case 1:
//                    $whereID['Platform'] = 0;
//                    break;
//                case 2:
//                    $whereID['Platform'] = 1;
//                    break;
//                case 3:
//                    $whereID['Platform'] = 2;
//                    break;
//            }
//        }
//        if( $pram['kind'] !=0){
//            $whereID['CategoryId']=$pram['kind'];
//        }
//        if( $pram['types'] !=0){
//            $whereID['PropsId']=$pram['types'];
//        }
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
//
//        //区间
//        $pre=10;
//        $offset=$page*$pre;
//
//        //数据
//        if($whereID){
//            $results = DB::table('goods')->where($whereID)->orderBy('GoodsId', 'desc')->offset($offset)->limit($pre)->get();
//            $total= DB::table('goods')->where($whereID)->count();
//        }else{
//            $results = DB::table('goods')->orderBy('GoodsId', 'desc')->offset($offset)->limit($pre)->get();
//            $total= DB::table('goods')->count();
//        }
//
//
//        //分页信息
//        $num=ceil($total/$pre);
//        $config['total']=$total;
//        $config['num']=$num;
//
//        //结果集
//        $kind=$this->keyVal(1);
//        $props=$this->keyVal(2);
//        $sale=$this->keyVal(3);
//        exit(json_encode(['status'=>1,'msg'=>'ok','res'=>$results,'kind'=>$kind,'props'=>$props,'sale'=>$sale,'pram'=>$pram,'pagination'=>$config]));
//    }


    public function add(){
        $res['kind']=$this->keyVal(6);
        $res['props']=$this->keyVal(2);
        $res['sale']=$this->keyVal(3);
        return view('Goods.add',['res'=>$res]);
    }
    public function save(Request $request){
        $id=$request->id;

        $data['GoodsName']=$request->name;
        $data['CategoryId']=$request->kind;
        $data['SaleId']=$request->sale;
        $data['PropsId']=$request->gainTag;
        $data['Number']=$request->number;
        $data['ExpendType']=$request->costTag;
        $data['Amount']=$request->amount;
        $data['ImageUrl']=$request->img;
        $data['Status']=$request->status;
        $data['Platform']=$request->platform;
        $data['HandselPercent']=$request->gift;
        $data['SortNumber']=$request->level;
        $data['AppleProductIdentifier']=$request->appMark;
        $data['Tag']=$request->tag;
        $data['ExpiredAt']=$request->endTime;
        $data['Payment']=$request->payment;
        $data['Detail']=$request->detail;
        $data['GoodsType']=$request->goodsType;

        $term=$request->term;
        if($term>0){
            $data['Term']=$term;
        }else{
            $data['Term']=3650;
        }

        if($id){
            $preArr=DB::table('goods')->select('GoodsName','CategoryId','SaleId','PropsId','Number','ExpendType','Amount','ImageUrl','Status','Platform','HandselPercent','SortNumber','AppleProductIdentifier','Tag','ExpiredAt','Payment','Detail','Term','GoodsType')->where('GoodsId', $id)->first();
            $preArr=json_decode(json_encode($preArr), true);
            parent::saveTxtLog($preArr,$data,'商品',$id);

            $result=DB::table('goods')->where('GoodsId', $id)->update($data);
            parent::saveLog('更新商品id--'.$id);
        }else{
            $result=DB::table('goods')->insertGetId($data);
            parent::saveLog('添加商品id--'.$result);
        }
        if($result){
            if($id){
                $parmp=$request->parmp;
                $parmo=$request->parmo;
                $parmk=$request->parmk;
                $parmt=$request->parmt;
                exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/goods/index?page='.$parmp.'&os='.$parmo.'&kind='.$parmk.'&type='.$parmt]));
            }else{
                exit(json_encode(['status'=>1,'msg'=>'ok','url'=>'/goods/index']));
            }
        }else{
            exit(json_encode(['status'=>0,'msg'=>'error']));
        }
    }
    public function update(Request $request){
        $id=$request->id;

        $results=DB::table('goods')->where('GoodsId', $id)->get();
        $res['results']=$results;
        $res['kind']=$this->keyVal(6);
        $res['props']=$this->keyVal(2);
        $res['sale']=$this->keyVal(3);

        $pram['page']=$request->page;
        $pram['os']=$request->os;
        $pram['kind']=$request->kind;
        $pram['type']=$request->type;

        $res['parm']=$pram;
        return view('Goods.update',['res'=>$res]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $res=DB::table('goods')->where('GoodsId', '=', $id)->delete();
        parent::saveLog('删除商品id--'.$id);

        return redirect('goods/index');
    }
    //获取分类，道具,促销列表
    protected function keyVal($item){
        $arr=[];
        if($item==1){
            $res=DB::table('goods_category')->select('CategoryId','CategoryName')->get();
            $tmp=json_decode(json_encode($res), true);
            $arr[0]='ALL';
            foreach($tmp as  $k => $v){
                $arr[$v['CategoryId']]=$v['CategoryName'];
            }
        }elseif($item==2) {
            $res = DB::table('props')->select('PropsId', 'PropsName')->get();
            $tmp=json_decode(json_encode($res), true);
            foreach ($tmp as $k => $v) {
                $arr[$v['PropsId']]=$v['PropsName'];
            }
        }elseif($item==3){
            $res=DB::table('sale')->select('SaleId','SaleName')->get();
            $arr[0]='无促销';
            $tmp=json_decode(json_encode($res), true);
            foreach($tmp as  $k => $v){
                $arr[$v['SaleId']]=$v['SaleName'];
            }
        }elseif($item==4){
            $arr[0]='ALL';
            $arr[1]='金币';
            $arr[2]='钻石';
            $arr[3]='房卡';
        }elseif($item==5){
            $arr[0]='ALL';
            $arr[1]='全部平台';
            $arr[2]='安卓';
            $arr[3]='苹果';
        }elseif($item==6){
            $res=DB::table('goods_category')->select('CategoryId','CategoryName')->get();
            $tmp=json_decode(json_encode($res), true);
            foreach($tmp as  $k => $v){
                $arr[$v['CategoryId']]=$v['CategoryName'];
            }
        }
        return $arr;
    }

    public function uploads(Request $request){

        $file = $request->file('file');
        $preDir='uploads';
        $path = $file->store('/store',$preDir );

        $client=new Client();
        $response=$client->post(config('suit.ImgRemoteServer'),['multipart'=>[['name'=>'file','contents'=>fopen($preDir.'/'.$path,'r')],['name'=>'type','contents'=>'store']]]);
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

    public function store(Request $request){
        //商品信息
        $res = DB::table('goods_category')->select('CategoryId','CategoryName','AllowVersion','DenyVersion','AllowChannel','DenyChannel')->get();
        $tmpRes=json_decode(json_encode($res), true);
        $tmp=[];
        foreach ($tmpRes as $k => $v){
            if($v['AllowVersion']!='*'){
                $tmp[$k]['AllowVersion']=$this->stringToArray($v['AllowVersion']);
            }else{
                $tmp[$k]['AllowVersion']=$v['AllowVersion'];
            }
            if($v['DenyVersion']!='*'){
                $tmp[$k]['DenyVersion']=$this->stringToArray($v['DenyVersion']);
            }else{
                $tmp[$k]['DenyVersion']=$v['DenyVersion'];
            }
            if($v['AllowChannel']!='*'){
                $tmp[$k]['AllowChannel']=$this->stringToArray($v['AllowChannel']);
            }else{
                $tmp[$k]['AllowChannel']=$v['AllowChannel'];
            }
            if($v['DenyChannel']!='*'){
                $tmp[$k]['DenyChannel']=$this->stringToArray($v['DenyChannel']);
            }else{
                $tmp[$k]['DenyChannel']=$v['DenyChannel'];
            }
            //组装array
            $arr = DB::table('goods')->where('CategoryId','=',$v['CategoryId'])->select('SaleId','GoodsId','GoodsName','GoodsType','Number','ExpendType','Amount','ImageUrl','Platform','Payment','AppleProductIdentifier','Tag')->orderBy('GoodsType','ASC')->orderBy('SortNumber','ASC')->get();
            $arr = json_decode(json_encode($arr), true);
            $type1=$type2=$type3=[];
            foreach ($arr as $kk => $vv){
                if($vv['GoodsType']==1){
                    array_push($type1,$arr[$kk]);
                }elseif($vv['GoodsType']==2){
                    array_push($type2,$arr[$kk]);
                }elseif($vv['GoodsType']==3){
                    array_push($type3,$arr[$kk]);
                }
            }
            $tmp[$k]['category'][0]['GoodsType']=1;
            $tmp[$k]['category'][0]['goods']=$type1;

            $tmp[$k]['category'][1]['GoodsType']=2;
            $tmp[$k]['category'][1]['goods']=$type2;

            $tmp[$k]['category'][2]['GoodsType']=3;
            $tmp[$k]['category'][2]['goods']=$type3;
        }

        $result=json_encode($tmp);

        //促销信息
        $saleInfo = DB::table('sale')->get();
        $saleInfo=json_decode(json_encode($saleInfo), true);
        $saleNew=[];
        foreach ($saleInfo as $key =>$val){
            $saleNew['sale#'.$val['SaleId']]=$saleInfo[$key];
        }
        $saleNew=\GuzzleHttp\json_encode($saleNew);

        try{
            Redis::set('SALE',$saleNew);
            Redis::set('store',$result);
            exit(json_encode(['status'=>1,'msg'=>'ok']));
        }catch (\Exception $e){
            exit(json_encode(['status'=>0,'msg'=>json_encode($e)]));
        }

    }

    protected function stringToArray($str){
        $arr=explode(',',$str);
        return $arr;
    }

}
