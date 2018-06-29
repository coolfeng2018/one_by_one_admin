<?php
/**
 * 百人牛牛系统庄家配置
 * typeid=6
 */
namespace App\Http\Controllers;

class SetBrnnbankerController extends SetgamecfgController {
    
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 6;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '百人牛牛系统庄家配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'brnn_banker';
    
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/brnn_banker/sntcfg?act=%s';
    }
    
    
}
