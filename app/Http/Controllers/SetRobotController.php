<?php
/**
 * 机器人配置
 * typeid=4
 */
namespace App\Http\Controllers;

class SetRobotController extends SetgamecfgController {
    
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 4;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '机器人配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'robot';
    
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'first_tab'=> array('key_col'=>'first_tab' ,'name'=>'类型'), 
        'count'=> array('key_col'=>'count' ,'name'=>'数量'),
        'max_coin'=> array('key_col'=>'max_coin' ,'name'=>'金币最大值'),
        'min_coin'=> array('key_col'=>'min_coin' ,'name'=>'金币最小值'),
        'probability_config'=> array('key_col'=>'probability_config' ,'name'=>'好牌概率(多条随机)','tips'=>'[1] = {机器人总金币下限, 机器人总金币下限, 获得好牌的概率}'),
        'total_coin'=> array('key_col'=>'total_coin' ,'name'=>'金币总量'),
        'probability_cnf'=> array('key_col'=>'probability_cnf' ,'name'=>'每门下注比例10表示100%'),
        'cnf'=> array('key_col'=>'cnf' ,'name'=>'下注限制','tips'=>'时间;&nbsp;数量;&nbsp;浮动数值'),        
        
    );
    
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/robot/sntcfg?act=%s';
    }
    
}
