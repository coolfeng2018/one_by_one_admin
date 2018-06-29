<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;


class CardgameController extends BaseController {
    
    
    public function log(Request $request) {
        $uid = $request->uid;
        $sTime = empty($request->sTime) ? date('Y-m-d 00:00:00') : $request->sTime;
        $eTime = empty($request->eTime) ? date('Y-m-d 23:59:59') : $request->eTime;
        $tableType = empty($request->tableType) ? -1 : $request->tableType;
        $sTime = strtotime($sTime);
        $eTime = strtotime($eTime);

        $table = 'dc_log_game.gamemin'.date('Ym', $sTime);
        $where = 'begin_time between '.$sTime.' and '.$eTime;
        if ( ! empty($uid)) {
            $where .= " and true_user like '%".$uid."%' ";
        }
        if ($tableType != -1) {
            $where .= " and table_type=".$tableType;
        }
        $data = DB::table($table)->whereRaw($where)->orderBy('begin_time', 'desc')->paginate(10);
        foreach ($data as &$val) {
            $val->userNum = $val->all_user_count . "/" . ($val->all_user_count-$val->true_user_count);
            $val->winCount = -$val->system_win_sum;
        }

        $search = [
            'sTime' => $sTime, 
            'eTime' => $eTime, 
            'tableType' => $tableType,
            'uid' => $uid
        ];
        return view('cardgame.log',['data'=>$data, 'search' => $search, 'tablelist' => $this->tablelist, 'reasonlist' => $this->gold_reasonlist]);
    }
    
    public function list2(Request $request) {
        $tableGid = $request->tableGid;
        $sTime = $request->sTime;
        $table = 'dc_log_game.game'.date('Ym', strtotime($sTime));
        $data = DB::table($table)->whereRaw('table_gid="'.$tableGid.'"')->paginate(2);
        $htmls = $data->links();
        foreach ($data as &$v) {
            $uInfo = $this->getMonUserInfo($v->uid);
            if (isset($uInfo['name'])) {
                $v->nickname = $uInfo['name'];
            } else {
                $v->nickname = '未知';
            }
        }
        //$data = json_decode(json_encode($data), true);
        
        die(json_encode(['data' => $data, 'success' => true, 'pageHtml' => htmlspecialchars($htmls)]));
    }
    
    
    public function list(Request $request) {
        $tableGid = $request->tableGid;
        $sTime = $request->sTime;
        $table = 'dc_log_game.game'.date('Ym', strtotime($sTime));
        $data = DB::table($table)->whereRaw('table_gid="'.$tableGid.'"')->orderBy('is_robot', 'asc')->paginate(10);

        foreach ($data as &$v) {
            $uInfo = $this->getMonUserInfo($v->uid);
            if (isset($uInfo['name'])) {
                $v->nickname = $uInfo['name'];
            } else {
                $v->nickname = '机器人';
            }
        }

        return view('cardgame.list2',['data'=>$data, 'tableGid' => $tableGid, 'sTime' => $sTime]);
    }
    

}