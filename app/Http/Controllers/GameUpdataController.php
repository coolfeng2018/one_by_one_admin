<?php

namespace App\Http\Controllers;

use App\Lib\VersionAdapter;
use App\Repositories\CheckinRepository;
use App\Repositories\GameUpdataRepository;
use Illuminate\Http\Request;
use Phalcon\Version;

class GameUpdataController extends BaseController
{
    protected $gameupdateRepository;
    protected $checkinRepository;

    function __construct(GameUpdataRepository $gameupdataRepository,CheckinRepository $checkinRepository)
    {
        $this->gameupdateRepository=$gameupdataRepository;
        $this->checkinRepository=$checkinRepository;
    }

    public function list(){
        $data=$this->gameupdateRepository->findBy('version_list', "*", "", null, 0,null, null, true, 10);
        return view('gameupdata.list',['data'=>$data]);
    }
    
    public function listv2() {
        $data = $this->gameupdateRepository->findBy('version_listv2', "*", "", null, 0,null, null, true, 10);
        foreach ($data as &$val) {
            $str = $pf = "";
            $arr = explode(',', $val->platform);
            foreach (is_array($arr) ? $arr : [] as $v) {
                if ($v==1) {
                    $pf = "安卓"; 
                } elseif ($v == 2) {
                    $pf = "ios"; 
                } elseif ($v == 3) {
                    $pf = "window";
                } else {
                    continue;
                }
                if (empty($str)) {
                    $str = $pf;
                } else {
                    $str = $str.", ".$pf;
                }
            }
            $val->pf = $str;
        }

        return view('gameupdata.listv2',['data'=>$data]);
    }

    public function find(Request $request){
        $id=$request->id;
        $data=$this->gameupdateRepository->findBy('version_list', '*', [['id', $id]], 1);
        $someArr = ['allow_version', 'allow_channel', 'deny_version', 'deny_channel'];
        foreach ($someArr as $index) {
            if ($data[0]->$index != '*' && ! empty($data[0]->$index)) {
                $data[0]->$index = implode(',', explode('::', $data[0]->$index));
            }
        }
        $gameInfo = json_decode($data[0]->game_info, true);

        return view('gameupdata.editnew',['data'=>$data[0], 'gameInfo' => $gameInfo, 'gamelist' => implode(',',array_keys($gameInfo))]);
    }

    public function addshow(){
        $type=$this->checkinRepository->getProps();
//        $game=$this->gameupdateRepository->gamelist();
        return view('gameupdata.add',['type'=>$type]);
    }

    public function postdata(Request $request){
        $data=$request->all();
        /** 版本&渠道 start **/
        $someArr = ['allow_version', 'allow_channel', 'deny_version', 'deny_channel', 'is_public'];
        foreach ($someArr as $val) {
            if ($data[$val.'_select'] == '1') {
                if (strpos($val, 'allow') !== false || $val == 'is_public') {
                    $data[$val] = "*";
                } else {
                    $data[$val] = "";
                }
            } 
        }
        /** 版本&渠道 end **/
        $gameList = explode(',', $data['game_list']);
        $ret = $this->_delData($data, $gameList);
        if ( ! $ret['success']) {
            exit(json_encode(['status'=>-1, 'msg' => $ret['errmsg']]));
        }
        $status = '200';
        if ($data['update_type'] == 1 && $data['is_upload'] == 1) { // 热更，同步资源包
            //运行脚本，发送到资源服务器
            exec("/data/scripts/scp_package_resource.sh ".$data['version'].".zip", $arr, $status);
            if ($ret != 3) {
                switch ($status) {
                    case 1:
                        exit(json_encode(['status'=>$status,'msg' => '上传目录不存在']));
                        break;
                    case 2:
                        exit(json_encode(['status'=>$status,'msg' => '需要上传的文件不存在']));
                        break;
                    case 4:
                        exit(json_encode(['status'=>$status,'msg' => '上传失败']));
                        break;
                }
            }
        }

        exit(json_encode(['status'=>200,'msg'=>'ok']));
    }

    public function del(Request $request){
        $id=$request->id;
        $where = [['id', $id]];
        $this->gameupdateRepository->delData('version_list', $where);

        return redirect('/gameupdata/list');
    }
    
    public function delv2(Request $request) {
        $id=$request->id;
        $where = [['id', $id]];
        $this->gameupdateRepository->delData('version_listv2', $where);

        return redirect('/gameupdata/listv2');
    }
    /**
     * 设置是否公开更新(非公开状态只有制定IP可以更新)
     *
     * @param string id version表主键id
     * @param status 修改公开状态  0 非公开 1公开
     * @return 
     */
    public function setpublic(Request $request){
        //更新是否公开状态
        $version_id = $request->id;
        $public_type = $request->status;
        $rs = $this->gameupdateRepository->findupdate_public($version_id,$public_type);
        if($rs) parent::saveLog('修改公开状态id--'.$version_id);
        return redirect('/gameupdata/list');
    }

    /**
     * zip上传分析
     * @param \Illuminate\Http\Request $request
     */
    public function uploadzip(Request $request) {
        $tmp = "./tmp/" . $_FILES["myfile"]["name"];
        $fileList = explode('.', $_FILES["myfile"]["name"]);
        if (array_pop($fileList) != 'zip') {
            return ['success' => false, 'errorcode' => -1, 'errmsg' => '格式错误']; //格式错误
        }
        $tmpArr = explode('.', $_FILES["myfile"]["name"]);
        if (count($tmpArr) != 4 || ! is_numeric($tmpArr[0]) || ! is_numeric($tmpArr[1]) || ! is_numeric($tmpArr[2])) {
            return ['success' => false, 'errorcode' => -2, 'errmsg' => '文件名错误']; //文件名错误
        }
        array_pop($tmpArr);
        $fileName = implode('.', $tmpArr);
        
        $retArr = [];
        if (file_exists($tmp)) {
            unlink($tmp);
        }
        move_uploaded_file($_FILES["myfile"]["tmp_name"], "./tmp/" . $_FILES["myfile"]["name"]);
        $zip = new \ZipArchive(); 
        $res = $zip->open("./tmp/" . $_FILES["myfile"]["name"]); 

        if ($res) {
            $zip->extractTo('./tmp/tmpfile'); 
            $ver = substr($zip->getnameindex(0), 0, -1);
            $retArr = $this->_getFileList('./tmp/tmpfile/'.$ver.'/manifests/');
        } else {
            return ['success' => false, 'errorcode' => -3, 'errmsg' => '解压失败']; //解压失败
        }

        $zip->close(); 
        
        // 删除临时文件
        $this->_delDirAndFile("./tmp/tmpfile");
        //unlink($tmp);
        return ['success' => true, 'retArr' => $retArr, 'ver' => $ver];

    }
    
    /**
     * 处理data
     * @param object $data
     * @param array $gameList
     */
    private function _delData($data, $gameList) {
        $gameInfo = [];
        if ($data['update_type'] == '1') { // 自由热更才记录上传信息
            foreach ($gameList as $gameCode) {
                $gameInfo[$gameCode] = [
                    'gameCode' => $gameCode,
                    'update_url' => $data[$gameCode."_source"],
                    'version_manifest' => $data[$gameCode."_detail"],
                    'manifest_url' => $data[$gameCode."_project"],
                ];
            }
        }

        $info = [
            'version' => trim($data['version']),
            'update_type' => $data['update_type'],
            'is_public' => isset($data['is_public']) ? $data['is_public'] : '*',
            'ver_int' => VersionAdapter::implodeVer(trim($data['version'])),
            'is_force' => $data['is_force'],
            'allow_channel' => $data['allow_channel'],
            'deny_channel' => $data['deny_channel'],
            'allow_version' => $data['allow_version'],
            'deny_version' => $data['deny_version'],
            'modified_time' => date('Y-m-d H:i:s'),
            'release_time' => $data['release_time'],
            'game_info' =>json_encode($gameInfo),
            'size' => $data['size'],
            'description' => $data['description'],
            'apk_update_url' => $data['apk_update_url'],
        ];

        if ( ! isset($data['release_id']) || empty($data['release_id'])) {
            $info['created_time'] = date('Y-m-d H:i:s');
            $type = 'insert';
            $ret = $this->gameupdateRepository->addData('version_list', $info);
        } else {
            $type = 'edit';
            $eWhere = [['id', $data['release_id']]];
            $ret = $this->gameupdateRepository->editData('version_list', $info, $eWhere);
        }
        return ['success' => true, 'ret' =>$ret];
    }
    
    private function _getFileList($dir) {
        $file = [];
        $resoure = opendir($dir);
        while($row = readdir($resoure)) {
            if ($row != "." && $row != "..") {
                $file[] = $row;
            }
        }
        $this->_gameList = $file;
        return $file;
    }
            
    private function _delDirAndFile( $dirName )
    {
        if ( $handle = opendir( "$dirName" ) ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$dirName/$item" ) ) {
                        $this->_delDirAndFile( "$dirName/$item" );
                    } else {
                        unlink( "$dirName/$item" );
                    }
                }
            }
            closedir($handle);
            @rmdir( $dirName );
        }
    }    
    
    /**
     * 第二版热更
     */
    public function showV2(Request $request) {
        $id=$request->id;
        $baseUrl = env('HOT_UPDATE_RESOURCE');
        if (empty($id)) {
            $obj = [
                'id' => '',
                'allow_version' => '',
                'allow_channel' => '',
                'deny_version' => '',
                'deny_channel' => '',
                'is_public' => '',
                'release_time' => date('Y-m-d H:i'),
                'version' => '',
                'is_force' => 1,
                'update_type' => 1,
                'description' => '',
                //'apk_update_url' => '',
                'apk_url_android' => '',
                'apk_url_ios' => '',
                'apk_url_windows' => '',
                'size' => '',
                'baseUrl' => $baseUrl,
                'platform' => '1,2,3'
            ];
            $gamelist = '';
            $obj = json_decode(json_encode($obj));
        } else {
            $tmp = $this->gameupdateRepository->findBy('version_listv2', '*', [['id', $id]], 1);
            $obj = $tmp[0];

            $someArr = ['allow_version', 'allow_channel', 'deny_version', 'deny_channel'];
            foreach ($someArr as $index) {
                if ($obj->$index != '*' && ! empty($obj->$index)) {
                    $obj->$index = implode(',', explode('::', $obj->$index));
                }
            }
            
            $gameInfo = json_decode($obj->game_info, true);
            if (isset($gameInfo['android'])) {
                $gamelist = implode(',',array_keys($gameInfo['android']));
            }elseif (isset($gameInfo['ios'])) {
                $gamelist = implode(',',array_keys($gameInfo['ios']));
            }elseif (isset($gameInfo['windows'])) {
                $gamelist = implode(',',array_keys($gameInfo['windows']));
            } else {
                $gamelist = "";
            }
            
            $apkUrlList = @json_decode($obj->apk_update_url, true);
            if (empty($apkUrlList)) {
                $obj->apk_url_android = '';
                $obj->apk_url_ios = '';
                $obj->apk_url_windows = '';
            } else {
                $obj->apk_url_android = isset($apkUrlList['android']) ? $apkUrlList['android'] : "";
                $obj->apk_url_ios = isset($apkUrlList['ios']) ? $apkUrlList['ios'] : "";
                $obj->apk_url_windows = isset($apkUrlList['windows']) ? $apkUrlList['windows'] : "";
            }
            
            $obj->baseUrl = $baseUrl;
            $obj->size = empty($obj->size) ? 0 : $obj->size;
        }
        return view('gameupdata.showv2',['data' => $obj, 'gamelist' => $gamelist]);
    }
    
    public function updatev2(Request $request) {
        //$this->postdata($request);
        $data=$request->all();
        /** 版本&渠道 start **/
        $someArr = ['allow_version', 'allow_channel', 'deny_version', 'deny_channel', 'is_public'];
        foreach ($someArr as $val) {
            if ($data[$val.'_select'] == '1') {
                if (strpos($val, 'allow') !== false || $val == 'is_public') {
                    $data[$val] = "*";
                } else {
                    $data[$val] = "";
                }
            } 
        }
        /** 版本&渠道 end **/
        $gameList = explode(',', $data['game_list']);
        $ret = $this->_delDatav2($data, $gameList);
        $pfs = explode(',', $data['pf']);
        
        $sh = "/data/scripts/scp_package_resource_v2.sh";
        foreach($pfs as $pfId) {
            $platform = $this->_getPf($pfId);
            if ( ! $ret['success']) {
                exit(json_encode(['status'=>-1, 'msg' => $ret['errmsg']]));
            }
            $status = '200';
            if ($data['update_type'] == 1 && $data['is_upload'] == 1) { // 热更，同步资源包
                //运行脚本，发送到资源服务器
                exec($sh." ".$data['version'].".zip  '".$platform."'", $arr, $status);
                if ($status != 3) {
                    switch ($status) {
                        case 1:
                            exit(json_encode(['status'=>$status,'msg' => '上传目录不存在']));
                            break;
                        case 2:
                            exit(json_encode(['status'=>$status,'msg' => '需要上传的文件不存在']));
                            break;
                        case 4:
                            exit(json_encode(['status'=>$status,'msg' => '上传失败']));
                            break;
                    }
                }
            }
        }

        exit(json_encode(['status'=>200,'msg'=>'ok']));
    }
    
    
    
    /**
     * zip上传分析
     * @param \Illuminate\Http\Request $request
     */
    public function uploadzipv2(Request $request) {
        $baseUrl = env('HOT_UPDATE_RESOURCE');
        $tmp = "./tmp/" . $_FILES["myfile"]["name"];
        $fileList = explode('.', $_FILES["myfile"]["name"]);
        if (array_pop($fileList) != 'zip') {
            return ['success' => false, 'errorcode' => -1, 'errmsg' => '格式错误']; //格式错误
        }
        $tmpArr = explode('.', $_FILES["myfile"]["name"]);
        if (count($tmpArr) != 4 || ! is_numeric($tmpArr[0]) || ! is_numeric($tmpArr[1]) || ! is_numeric($tmpArr[2])) {
            return ['success' => false, 'errorcode' => -2, 'errmsg' => '文件名错误']; //文件名错误
        }
        array_pop($tmpArr);
        $fileName = implode('.', $tmpArr);
        
        $retArr = [];
        if (file_exists($tmp)) {
            unlink($tmp);
        }
        move_uploaded_file($_FILES["myfile"]["tmp_name"], "./tmp/" . $_FILES["myfile"]["name"]);
        $zip = new \ZipArchive(); 
        $res = $zip->open("./tmp/" . $_FILES["myfile"]["name"]); 

        if ($res) {
            $zip->extractTo('./tmp/tmpfile'); 
            $ver = substr($zip->getnameindex(0), 0, -1);
            $retArr = $this->_getFileList('./tmp/tmpfile/'.$ver.'/src/game/');
            if (is_dir('./tmp/tmpfile/'.$ver.'/src/lobby/')) { // 大厅，独树一格
                $retArr[] = 'lobby';
            }
            //if (is_dir('./tmp/tmpfile/'.$ver.'/src/update/')) { // 同上
                $retArr[] = 'update';
            //}
        } else {
            return ['success' => false, 'errorcode' => -3, 'errmsg' => '解压失败']; //解压失败
        }

        $zip->close(); 
        
        // 删除临时文件
        $this->_delDirAndFile("./tmp/tmpfile");
        return ['success' => true, 'retArr' => $retArr, 'ver' => $ver, 'baseUrl' => $baseUrl];
    }

    
    /**
     * 处理data
     * @param object $data
     * @param array $gameList
     */
    private function _delDatav2($data, $gameList) {
        $gameInfo = [];
        $table = 'version_listv2';

        if ($data['update_type'] == '1') { // 自由热更才记录上传信息
            $pf = explode(',', $data['pf']);
            foreach ($pf as $va) {
                switch ($va) {
                    case 1:
                        $pfName = "android";
                        break;
                    case 2:
                        $pfName = "ios";
                        break;
                    case 3:
                        $pfName = "windows";
                        break;
                }
                $gameInfo = [];
                foreach ($gameList as $gameCode) {
                    if ($gameCode == 'lobby' || $gameCode == 'update') {
                        $gdir = "";
                    } else {
                        $gdir = "game/";
                    }
                    $gameInfo[$gameCode] = [
                        'gameCode' => $gameCode,
                        "manifest_res" => "src/".$gdir.$gameCode."/version.manifest",
                        "resources_url" => @$data['baseUrl'] . "/" . @$pfName . "/" . @$data['version'],
                    ];
                }
                $gInfo[$pfName] = $gameInfo;
            }
            $apkUrlList = ['android' => '', 'ios' => '', 'windows' => ''];
        } else {
            $gInfo = [];
            $apkUrlList = [
                'android' => isset($data['apk_url_android']) ? $data['apk_url_android'] : "",
                'ios' => isset($data['apk_url_ios']) ? $data['apk_url_ios'] : "",
                'windows' => isset($data['apk_url_windows']) ? $data['apk_url_windows'] : "",
            ];
        }

        $info = [
            'version' => trim($data['version']),
            'update_type' => $data['update_type'],
            'is_public' => isset($data['is_public']) ? $data['is_public'] : '*',
            'ver_int' => VersionAdapter::implodeVer(trim($data['version'])),
            'is_force' => $data['is_force'],
            'allow_channel' => $data['allow_channel'],
            'deny_channel' => $data['deny_channel'],
            'allow_version' => $data['allow_version'],
            'deny_version' => $data['deny_version'],
            'modified_time' => date('Y-m-d H:i:s'),
            'release_time' => $data['release_time'],
            'game_info' =>json_encode($gInfo),
            'size' => $data['size'],
            'description' => $data['description'],
            'apk_update_url' => json_encode($apkUrlList),
            'platform' => $data['pf']
        ];

        if ( ! isset($data['release_id']) || empty($data['release_id'])) {
            $info['created_time'] = date('Y-m-d H:i:s');
            $type = 'insert';
            $ret = $this->gameupdateRepository->addData($table, $info);
        } else {
            $type = 'edit';
            $eWhere = [['id', $data['release_id']]];
            $ret = $this->gameupdateRepository->editData($table, $info, $eWhere);
        }
        return ['success' => true, 'ret' =>$ret];
    }
    
    /**
     * 获取 客户端
     * @param type $id
     * @return string
     */
    private function _getPf($id) {
        $pf = [
            '1' => 'android',
            '2' => 'ios',
            '3' => 'windows'
        ];
        return $pf[$id];
    }
    
    /**
     * 修改热更信息状态
     * @param Request $request
     */
    public function updateStatus(Request $request) {
        $id = $request->id;
        $status = $request->status;
        if (empty($id) || empty($status)) {
            die(json_encode(['success' => 0, 'errcode' => -1]));
        }
        $table = 'version_listv2';
        $this->gameupdateRepository->editData($table, ['status' => $status], [['id', $id]]);
        die(json_encode(['success' => 1]));
    }
}
