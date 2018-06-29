<?php
/**
 * 网关配置
 * typeid=1
 */
namespace App\Http\Controllers;

class SetGatewayController extends SetgamecfgController {
    /**
     * 网关配置  的typeid
     * @var integer
     */
    protected $cfg_typeid = 1;
    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '网关配置';
    
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'gateway';
    
    /**
     * 添加时的提示信息
     * @var array
     */
    protected $tips_col = array(
        'desc'=> array('color'=>'', 'tip'=>'描述信息 /配置名称 '),
        'key_col'=> array('color'=>'', 'tip'=>'用>分割例： ucode>ios>ver'),
        'val_col'=> array(
            array('color'=>'', 'tip'=>'网关配置例： {"host": "123.207.42.46", "port": 8888}'),
        ),
        'memo'=>array(
             array('color'=>'font-red-mint', 'tip' => '*对外开放时不要填写此项！！！ '),
             array('color'=>'font-red-mint', 'tip' => '填写此项就表示此条记录为不对外开放,仅对此项内的ip开放，可填写多个IP，用英文逗号;分割'),
        )
    );
    
}
