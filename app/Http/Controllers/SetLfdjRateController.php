<?php
/**
 * 龙凤对决
 * typeid=9
 */
namespace App\Http\Controllers;

class SetLfdjRateController extends SetgamecfgController {
    
    /**
     * 龙凤对决 系统庄家配置的typeid
     * @var integer
     */
    protected $cfg_typeid = 9;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '龙凤对决';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'lfdj_rate';
    
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'STORE_RANGE'=> array('key_col'=>'STORE_RANGE' ,'name'=>'系统库存区间-共6项'),
        'STORE_RATE'=> array('key_col'=>'STORE_RATE' ,'name'=>'各区间权重{龙赢，平，凤赢}'),
        'EXTRA_FEE_PERCENT'=> array('key_col'=>'EXTRA_FEE_PERCENT' ,'name'=>'额外抽水比例(区间为[0,1))'), 
    );
    
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/lfdj_rate/sntcfg?act=%s';
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
