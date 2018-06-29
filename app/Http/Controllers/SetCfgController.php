<?php
/**
 * 类型配置
 * typeid=2
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetCfgController extends SetgamecfgController {
    /**
     * 配置状态 2为生效的  预留字段  想做缓存用
     * @var integer
     */
    protected $o_status = 2;
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 2;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '配置类型配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'typecfg';
    
    //     function __construct(){
    //         parent::__construct();
    //         $this->actions['del'] = 'test';
    //     }
    
    
}
