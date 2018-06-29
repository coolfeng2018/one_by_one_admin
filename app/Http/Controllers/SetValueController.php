<?php
/**
 * 常量配置
 * typeid=5
 */
namespace App\Http\Controllers;

class SetValueController extends SetgamecfgController {
    
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 5;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '常量配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'value';
    
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/value/sntcfg?act=%s';
    }
}
