<?php
/**
 * 21
 * typeid=11
 */
namespace App\Http\Controllers;

class Set21RateController extends SetgamecfgController {
    
    /**
     * 龙凤对决 系统庄家配置的typeid
     * @var integer
     */
    protected $cfg_typeid = 11;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '21点';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'bj_config';
    
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'GAME_START_WAIT' => array('key_col'=>'GAME_START_WAIT' ,'name'=>'游戏开始等待时间'),
        'TYPE_LIST' => array('key_col'=>'TYPE_LIST' ,'name'=>'牌型配置{牌点数，概率}','tips'=>'可以有多个，游戏时 随机选择一个'),
        'STORE_RANGE' => array('key_col'=>'STORE_RANGE' ,'name'=>'系统库存区间-共6项'),
        'STORE_RATE' => array('key_col'=>'STORE_RATE' ,'name'=>'各区间权重'),
    );
    
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/twentyone/sntcfg?act=%s';
    }
    
    protected $check_valid  = array(
        
    );
    
    /**
     * 检查
     * @var array
     */
    protected $add_chk_valid  = array(
        'key_vol'=>array('tips'=>'',''=>''),
        'val_col'=>array('tips'=>'',''=>''),
    );
}
