<?php
/**
 * 消息配置
 * typeid=3
 */
namespace App\Http\Controllers;

class SetWxlistController extends SetgamecfgController {

    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 3;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '消息配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'wxlist';
        
    
}
