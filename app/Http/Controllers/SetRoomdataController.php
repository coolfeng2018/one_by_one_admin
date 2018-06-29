<?php
/**
 * 房间配置
 * typeid=8
 */
namespace App\Http\Controllers;

class SetRoomdataController extends SetgamecfgController {
    
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 8;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '房间配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'roomdata';
    
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'first_tab'=> array('key_col'=>'first_tab' ,'name'=>'房间ID'),
        'name'=> array('key_col'=>'name' ,'name'=>'场次名称'),
        'min'=> array('key_col'=>'min' ,'name'=>'进场最小限制'),
        'max'=> array('key_col'=>'max' ,'name'=>'进场最大限制'),
        'dizhu'=> array('key_col'=>'dizhu' ,'name'=>'底注'),
        'dingzhu'=> array('key_col'=>'dingzhu' ,'name'=>'顶注'),
        'cost'=> array('key_col'=>'cost' ,'name'=>'台费'),
        'open_robot'=> array('key_col'=>'open_robot' ,'name'=>'是否开放机器人'),
        'robot_type'=> array('key_col'=>'robot_type' ,'name'=>'机器人类型'),
        
        'max_look_round'=> array('key_col'=>'max_look_round' ,'name'=>'最大看牌轮数'),
        'comparable_bet_round'=> array('key_col'=>'comparable_bet_round' ,'name'=>'最大可比轮数'),
        'max_bet_round'=> array('key_col'=>'max_bet_round' ,'name'=>'可比轮数'),
        'img_bg'=> array('key_col'=>'img_bg' ,'name'=>'底图名'),
        'img_icon'=> array('key_col'=>'img_icon' ,'name'=>'标识图片名'),
        'grab_banker_times'=>array('key_col'=>'grab_banker_times' ,'name'=>'抢庄区间配置'),
    );
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/roomdata/sntcfg?act=%s';
    }
    
    
 
}
