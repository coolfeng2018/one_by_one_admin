<?php
/**
 * 牌型概率配置
 * typeid=7
 */
namespace App\Http\Controllers;
class SetCardTypeGeneralController extends SetgamecfgController {  
    /**
     * 牌型概率配置 7
     * @var integer
     */
    protected $cfg_typeid = 7;    
    /**
     * 页面名称
     * @var integer
     */
    protected $pagename = '牌型概率百分比配置';   
    /**
     * 路由的名 控制器的名
     * @var string
     */
    protected $classname = 'card_type_general';   
    /**
     * 列名
     * @var array
     */
    protected $tabname = array(
        'first_tab'=> array('key_col'=>'first_tab' ,'name'=>'游戏ID'),
        'gaopaibudaiA'=> array('key_col'=>'gaopaibudaiA' ,'name'=>'高牌不带A'),
        'gaopaidaiA'=> array('key_col'=>'gaopaidaiA' ,'name'=>'高牌带A'),
        'duizi2_9'=> array('key_col'=>'duizi2_9' ,'name'=>'对子2-9'),
        'duizi10_A'=> array('key_col'=>'duizi10_A' ,'name'=>'对子10-A'),
        'shunzi'=> array('key_col'=>'shunzi' ,'name'=>'顺子'),
        'jinhua'=> array('key_col'=>'jinhua' ,'name'=>'金花'),
        'shunjin'=> array('key_col'=>'shunjin' ,'name'=>'顺金'),
        'baozi'=> array('key_col'=>'baozi' ,'name'=>'豹子'),
    );   
    /**
     * 加上这个配置才会展示出来
     * 
     */
    public function __construct(){
        parent::__construct();
        $this->actions['sntcfg'] = '/setcfg/card_type_general/sntcfg?act=%s';
    }

 
}

