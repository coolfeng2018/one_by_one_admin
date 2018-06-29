<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'AdminController@index');
Route::get('/admin/index', 'AdminController@index');
Route::post('/admin/check', 'AdminController@check');
Route::get('/index/access','IndexController@access');
Route::get('/robit/addRobot','RobitController@addRobot');

Route::get('/generalize/findbyidmap','WithdrawController@findByIdmap');

Route::group(["middleware" =>['web','checkNode'] ], function() {
    Route::get('/index/index', 'IndexController@index');

Route::get('/admin/out', 'AdminController@out');

Route::post('/imguploads','GameController@uploads');

//游戏管理start
Route::get('/game/list','GameController@list');
Route::get('/game/add/show','GameController@addshow');
Route::post('/game/add/post','GameController@postdata');
Route::get('/game/del','GameController@del');
Route::get('/game/edit','GameController@editshow');
Route::get('/game/getgametype','GameController@getGameType');

Route::get('/gameclass/list','GameClassController@list');
Route::get('/gameclass/add/show','GameClassController@addshow');
Route::post('/gameclass/add/post','GameClassController@postdata');
Route::get('/gameclass/edit','GameClassController@find');
Route::get('/gameclass/del','GameClassController@del');
//游戏管理end

//游戏服务start
Route::get('/gameserver/list','ServersController@list');
Route::get('/gameserver/addshow','ServersController@addshow');
Route::get('/gameserver/edit','ServersController@find');
Route::get('/gameserver/del','ServersController@del');
Route::post('/gameserver/post','ServersController@postdata');
Route::get('/gameserver/find/deskset','ServersController@findbydeskset');
//游戏服务end

//显示游戏列表start
    //方案
    Route::get('/gameshow/list','GameShowController@list');
    Route::get('/gameshow/addshow','GameShowController@addshow');
    Route::get('/gameshow/edit','GameShowController@find');
    Route::post('/gameshow/postdata','GameShowController@postdata');
    Route::get('/gameshow/del','GameShowController@del');

    //方案内容
    Route::get('/showpieces/list','GameShowController@showpieceslist');
    Route::get('/showpieces/add','GameShowController@addshowpieces');
    Route::get('/showpieces/edit','GameShowController@editshowpieces');
    Route::post('/showpieces/postshowpieces','GameShowController@postshowpieces');
    Route::get('/showpieces/del','GameShowController@delshowprieces');

    //子集添加
    Route::get('/showpieces/addpart','GameShowController@addpart');
    Route::post('/showpieces/savepart','GameShowController@savepart');

    Route::post('/gameshow/postedgame','GameShowController@postedgame');
//显示游戏列表end

//网关配置start
Route::get('/gateway/list','GateWayController@list');
Route::get('/gateway/addshow','GateWayController@addshow');
Route::get('/gateway/edit','GateWayController@find');
Route::get('/gateway/del','GateWayController@del');
Route::post('/gateway/post','GateWayController@postdata');

Route::post('/gateway/gatewayList','GateWayController@gatewayList');

Route::post('/gateway/batchupdatestatus','GateWayController@batchupdatestatus');
Route::post('/gateway/batchupdatesortid','GateWayController@batchupdateSortID');

//网关配置end



//停机维护
Route::get('/close/index','CloseController@index');
Route::get('/close/add','CloseController@add');
Route::post('/close/save','CloseController@save');
Route::get('/close/update','CloseController@update');
Route::get('/close/delete','CloseController@delete');

//公告配置start
Route::get('/announcement/list','AnnouncementController@list');
Route::get('/announcement/addshow','AnnouncementController@addshow');
Route::get('/announcement/edit','AnnouncementController@find');
Route::get('/announcement/del','AnnouncementController@del');
Route::post('/announcement/post','AnnouncementController@postdata');
//公告配置end

//活动配置start
Route::get('/campaign/list','CampaignController@list');
Route::get('/campaign/addshow','CampaignController@addshow');
Route::get('/campaign/edit','CampaignController@find');
Route::get('/campaign/del','CampaignController@del');
Route::post('/campaign/post','CampaignController@postdata');
//活动配置end

//破产补助配置start
Route::get('/bankruptcy/list','BankruptcyController@list');
Route::get('/bankruptcy/addshow','BankruptcyController@addshow');
Route::get('/bankruptcy/edit','BankruptcyController@find');
Route::get('/bankruptcy/del','BankruptcyController@del');
Route::post('/bankruptcy/post','BankruptcyController@postdata');
//破产补助配置end

//签到奖励配置start
Route::get('/checkin/list','CheckinController@list');
Route::get('/checkin/addshow','CheckinController@addshow');
Route::get('/checkin/edit','CheckinController@find');
Route::get('/checkin/del','CheckinController@del');
Route::post('/checkin/post','CheckinController@postdata');
//签到奖励配置end

//版本更新start
Route::get('/gameupdata/list','GameUpdataController@list');
Route::get('/gameupdata/addshow','GameUpdataController@addshow');
Route::get('/gameupdata/edit','GameUpdataController@find');
Route::get('/gameupdata/del','GameUpdataController@del');
Route::post('/gameupdata/postdata','GameUpdataController@postdata');
//版本更新end

//头像审核start
Route::get('/headshot/list','HeadshotController@list');
Route::get('/headshot/audit','HeadshotController@audit');
//头像审核end

//系统广播start
Route::get('/message/list','MessageController@list');
Route::get('/message/addshow','MessageController@addshow');
Route::get('/message/edit','MessageController@find');
Route::get('/message/del','MessageController@del');
Route::post('/message/postdata','MessageController@postdata');
//系统广播end

//推广奖励配置start
Route::get('/generalize/index','GeneralizeController@index');
Route::post('/generalize/checkUser','GeneralizeController@checkUser');
Route::get('/generalize/find','GeneralizeController@find');
Route::post('/generalize/save','GeneralizeController@save');
Route::get('/friend/share','GeneralizeController@friendshareshow');
Route::post('/friend/share/post','GeneralizeController@friendsharesave');
Route::get('/everyday/share','GeneralizeController@everydayshareshow');
Route::post('/everyday/share/post','GeneralizeController@everydaysharesave');
//推广奖励配置end

//提现申请start
Route::get('/generalize/withdrawlist','WithdrawController@list');
Route::get('/generalize/withdrawstatus','WithdrawController@updatastatus');
//提现申请end

Route::get('/props/index','PropsController@index');
Route::get('/props/add','PropsController@add');
Route::post('/props/save','PropsController@save');
Route::get('/props/update','PropsController@update');
Route::get('/props/delete','PropsController@delete');

//商品
Route::get('/goods/index','GoodsController@index');
Route::get('/goods/search','GoodsController@search');
Route::get('/goods/add','GoodsController@add');
Route::post('/goods/save','GoodsController@save');
Route::post('/goods/uploads','GoodsController@uploads');
Route::get('/goods/update','GoodsController@update');
Route::get('/goods/delete','GoodsController@delete');
Route::post('/goods/store','GoodsController@store');

//渠道分类
Route::get('/goodsCategory/index','GoodsCategoryController@index');
Route::get('/goodsCategory/add','GoodsCategoryController@add');
Route::post('/goodsCategory/save','GoodsCategoryController@save');
Route::get('/goodsCategory/update','GoodsCategoryController@update');
Route::get('/goodsCategory/delete','GoodsCategoryController@delete');

//渠道列表
Route::get('/channel/index','ChannelController@index');
Route::get('/channel/add','ChannelController@add');
Route::post('/channel/save','ChannelController@save');
Route::get('/channel/update','ChannelController@update');
Route::get('/channel/delete','ChannelController@delete');

//促销方案
Route::get('/sale/index','SaleController@index');
Route::get('/sale/add','SaleController@add');
Route::post('/sale/save','SaleController@save');
Route::get('/sale/update','SaleController@update');
Route::get('/sale/delete','SaleController@delete');

//特殊商品配置
Route::get('/saleGift/index','SaleGiftController@index');
Route::get('/saleGift/updateCharge','SaleGiftController@updateCharge');
Route::post('/saleGift/saveCharge','SaleGiftController@saveCharge');
Route::get('/saleGift/updateGift','SaleGiftController@updateGift');
Route::post('/saleGift/saveGift','SaleGiftController@saveGift');


//任务
Route::get('/task/index','TaskController@index');
Route::get('/task/add','TaskController@add');
Route::post('/task/save','TaskController@save');
Route::get('/task/edit','TaskController@edit');
Route::get('/task/delete','TaskController@delete');
Route::get('/task/lua','TaskController@lua');

//任务分享公告
Route::get('/channelVersion/index','ChannelVersionController@index');
Route::get('/channelVersion/add','ChannelVersionController@add');
Route::post('/channelVersion/save','ChannelVersionController@save');
Route::get('/channelVersion/edit','ChannelVersionController@edit');
Route::get('/channelVersion/delete','ChannelVersionController@delete');
Route::get('/channelVersion/lua','ChannelVersionController@lua');

//用户
Route::get('/user/index','UserController@index');
Route::post('/user/search','UserController@search');
Route::get('/user/saveCoinServer','UserController@saveCoinServer');

Route::get('/user/black','UserController@black');
Route::get('/user/black_add','UserController@black_add');
Route::post('/user/black_save','UserController@black_save');
Route::get('/user/black_update','UserController@black_update');
Route::get('/user/black_delete','UserController@black_delete');

Route::get('/user/asset','UserController@asset');
Route::get('/user/asset_update','UserController@asset_update');
Route::post('/user/asset_save','UserController@asset_save');

//机器人管理
Route::get('/robit/index','RobitController@index');
Route::get('/robit/add','RobitController@add');
Route::post('/robit/save','RobitController@save');
Route::get('/robit/update','RobitController@update');
Route::post('/robit/uploads','RobitController@uploads');
Route::post('/robit/addMore','RobitController@addMore');

//机器人庄家
Route::get('/landlord/index','LandlordController@index');
Route::get('/landlord/add','LandlordController@add');
Route::post('/landlord/save','LandlordController@save');
Route::get('/landlord/update','LandlordController@update');
Route::get('/landlord/delete','LandlordController@delete');
Route::post('/landlord/uploads','LandlordController@uploads');
Route::post('/landlord/addPro','LandlordController@addPro');


//场次
Route::get('/desk/index','DeskController@index');
Route::get('/desk/add','DeskController@add');
Route::post('/desk/save','DeskController@save');
Route::get('/desk/update','DeskController@update');
Route::get('/desk/delete','DeskController@delete');
Route::post('/desk/uploads','DeskController@uploads');


//私房配置
Route::get('/privateSetting/index','PrivateSettingController@index');
Route::get('/privateSetting/update','PrivateSettingController@update');
Route::post('/privateSetting/save','PrivateSettingController@save');


//转币房
Route::get('/privateCoinSetting/index','PrivateCoinSettingController@index');
Route::get('/privateCoinSetting/update','PrivateCoinSettingController@update');
Route::post('/privateCoinSetting/save','PrivateCoinSettingController@save');

//金币房配置
Route::get('/coinSetting/index','CoinSettingController@index');
Route::get('/coinSetting/add','CoinSettingController@add');
Route::post('/coinSetting/save','CoinSettingController@save');
Route::get('/coinSetting/update','CoinSettingController@update');
Route::get('/coinSetting/delete','CoinSettingController@delete');

//订单
Route::get('/order/index','OrderController@index');
Route::get('/order/search','OrderController@search');

//杂项配置
Route::get('/config/index','ConfigController@index');
Route::get('/config/add','ConfigController@add');
Route::get('/config/update','ConfigController@update');
Route::post('/config/save','ConfigController@save');
//Route::get('/config/delete','ConfigController@delete');
Route::post('/config/show','ConfigController@show');
//下载配置
Route::any('/config/download','ConfigController@download');


//新手礼包
Route::get('/newcomersGift/index','NewcomersGiftController@index');
Route::get('/newcomersGift/update','NewcomersGiftController@update');
Route::post('/newcomersGift/save','NewcomersGiftController@save');

//推广礼包
Route::get('/extensionGift/index','ExtensionGiftController@index');
Route::get('/extensionGift/update','ExtensionGiftController@update');
Route::post('/extensionGift/save','ExtensionGiftController@save');

//代理
Route::get('/proxy/index','ProxyController@index');
Route::post('/proxy/search','ProxyController@search');

Route::get('/proxy/add','ProxyController@add');
Route::post('/proxy/save','ProxyController@save');
Route::get('/proxy/update','ProxyController@update');
Route::get('/proxy/delete','ProxyController@delete');

Route::get('/proxy/charge','ProxyController@charge');
Route::post('/proxy/searchCharge','ProxyController@searchCharge');

Route::get('/proxy/trade','ProxyController@trade');
Route::post('/proxy/searchTrade','ProxyController@searchTrade');

Route::get('/proxy/level','ProxyController@level');
Route::post('/proxy/searchLevel','ProxyController@searchLevel');
Route::get('/proxy/updateStatus','ProxyController@updateStatus');
Route::get('/proxy/deleteLevel','ProxyController@deleteLevel');

Route::get('/proxy/updatePwd','ProxyController@updatePwd');
Route::post('/proxy/savePwd','ProxyController@savePwd');

Route::get('/proxy/configProxy','ProxyController@configProxy');
Route::post('/proxy/saveConfig','ProxyController@saveConfig');

//权限节点
Route::get('/access/index','AccessController@index');
Route::get('/access/add','AccessController@add');
Route::post('/access/save','AccessController@save');
Route::get('/access/update','AccessController@update');
Route::get('/access/delete','AccessController@delete');
//管理员
Route::get('/manage/index','ManageController@index');
Route::get('/manage/add','ManageController@add');
Route::post('/manage/save','ManageController@save');
Route::get('/manage/update','ManageController@update');
Route::get('/manage/delete','ManageController@delete');
//角色管理
Route::get('/part/index','PartController@index');
Route::get('/part/add','PartController@add');
Route::post('/part/save','PartController@save');
Route::get('/part/update','PartController@update');
Route::get('/part/delete','PartController@delete');

Route::get('/part/access','PartController@access');
Route::post('/part/accessSave','PartController@accessSave');

//日志
Route::get('/logger/index','LoggerController@index');
Route::post('/logger/search','LoggerController@search');



//分享
// Route::get('/share/index','ShareController@index');
// Route::post('/share/save','ShareController@save');

// Route::get('/share/friend','ShareController@friend');
// Route::post('/share/friendSave','ShareController@friendSave');

// Route::get('/share/everyday','ShareController@everyday');
// Route::post('/share/everydaySave','ShareController@everydaySave');

// Route::get('/share/bindProxy','ShareController@bindProxy');
// Route::post('/share/bindProxySave','ShareController@bindProxySave');

// Route::get('/share/proxyAward','ShareController@proxyAward');
// Route::post('/share/proxyAwardSave','ShareController@proxyAwardSave');
//联运&代理

//联运列表
Route::get('/union/index','UnionController@index');
Route::get('/union/add','UnionController@add');
Route::post('/union/save','UnionController@save');
Route::get('/union/update','UnionController@update');
Route::get('/union/delete','UnionController@delete');
//代理列表
Route::get('/agent/index','AgentController@index');
Route::post('/agent/search','AgentController@search');
Route::get('/agent/add','AgentController@add');
Route::post('/agent/save','AgentController@save');
Route::get('/agent/update','AgentController@update');

Route::get('/agent/union','AgentController@union');
Route::post('/agent/unionSave','AgentController@unionSave');

Route::get('/agent/level','AgentController@level');
Route::post('/agent/searchLevel','AgentController@searchLevel');

Route::get('/agent/user','AgentController@user');
Route::post('/agent/searchUser','AgentController@searchUser');

//申请列表
Route::get('/applyAgent/index','ApplyAgentController@index');
Route::get('/applyAgent/updateStatus','ApplyAgentController@updateStatus');

//提现列表
Route::get('/cash/index','CashController@index');
Route::get('/cash/updateStatus','CashController@updateStatus');
Route::get('/cash/findRecord','CashController@findRecord');

//代理金返水配置
Route::get('/commissionRatio/index','CommissionRatioController@index');
Route::get('/commissionRatio/edit','CommissionRatioController@edit');
Route::get('/commissionRatio/add','CommissionRatioController@add');
Route::get('/commissionRatio/delete','CommissionRatioController@delete');
Route::post('/commissionRatio/save','CommissionRatioController@save');


//活动管理
Route::get('/party/index','PartyController@index');
Route::get('/party/add','PartyController@add');
Route::post('/party/save','PartyController@save');
Route::get('/party/update','PartyController@update');
Route::get('/party/delete','PartyController@delete');

Route::get('/party/detailList','PartyController@detailList');
Route::get('/party/detailAdd','PartyController@detailAdd');
Route::post('/party/detailSave','PartyController@detailSave');
Route::get('/party/detailUpdate','PartyController@detailUpdate');
Route::get('/party/detailDelete','PartyController@detailDelete');

//错误码管理start
Route::get('/error/index','ErrorController@index');
Route::get('/error/create','ErrorController@create');
Route::post('/error/save','ErrorController@save');
Route::get('/error/update','ErrorController@update');
Route::get('/error/delete','ErrorController@delete');
Route::get('/error/lua','ErrorController@lua');
//错误码管理end

//游戏常量设置start
Route::get('/gamevalue/index','GameValueController@index');
Route::get('/gamevalue/add','GameValueController@add');
Route::post('/gamevalue/save','GameValueController@save');
Route::get('/gamevalue/edit','GameValueController@edit');
Route::get('/gamevalue/delete','GameValueController@delete');
Route::get('/gamevalue/lua','GameValueController@lua');
//游戏常量设置end

//文本配置start
Route::get('/text/index','TextController@index');
Route::get('/text/add','TextController@add');
Route::post('/text/save','TextController@save');
Route::get('/text/edit','TextController@edit');
Route::get('/text/delete','TextController@delete');
Route::get('/text/lua','TextController@lua');
//文本配置end

//大厅列表start
Route::get('/gamelist/index','GameListController@index');
Route::get('/gamelist/add','GameListController@add');
Route::post('/gamelist/save','GameListController@save');
Route::get('/gamelist/edit','GameListController@edit');
Route::get('/gamelist/delete','GameListController@delete');
Route::get('/gamelist/lua','GameListController@lua');
//大厅列表end

//跑马灯配置start
Route::get('/horsemessage/index','HorseMessageController@index');
Route::get('/horsemessage/add','HorseMessageController@add');
Route::post('/horsemessage/save','HorseMessageController@save');
Route::get('/horsemessage/edit','HorseMessageController@edit');
Route::get('/horsemessage/delete','HorseMessageController@delete');
Route::get('/horsemessage/lua','HorseMessageController@lua');
//跑马灯配置end

//机器人头像start
Route::get('/iconlibrary/index','IconLibraryController@index');
Route::get('/iconlibrary/add','IconLibraryController@add');
Route::post('/iconlibrary/save','IconLibraryController@save');
Route::get('/iconlibrary/edit','IconLibraryController@edit');
Route::get('/iconlibrary/delete','IconLibraryController@delete');
Route::get('/iconlibrary/lua','IconLibraryController@lua');
//机器人头像end

//道具表start
Route::get('/item/index','ItemController@index');
Route::get('/item/add','ItemController@add');
Route::post('/item/save','ItemController@save');
Route::get('/item/edit','ItemController@edit');
Route::get('/item/delete','ItemController@delete');
Route::get('/item/lua','ItemController@lua');
//道具表end

//新手奖励start
Route::get('/newbieaward/index','NewbieAwardController@index');
Route::get('/newbieaward/add','NewbieAwardController@add');
Route::post('/newbieaward/save','NewbieAwardController@save');
Route::get('/newbieaward/edit','NewbieAwardController@edit');
Route::get('/newbieaward/delete','NewbieAwardController@delete');
Route::get('/newbieaward/lua','NewbieAwardController@lua');
//新手奖励end

//游戏分享start
Route::get('/share/index','ShareController@index');
Route::get('/share/add','ShareController@add');
Route::post('/share/save','ShareController@save');
Route::get('/share/edit','ShareController@edit');
Route::get('/share/delete','ShareController@delete');
Route::get('/share/lua','ShareController@lua');
//游戏分享end

//房间配置start
Route::get('/roomdata/index','RoomDataController@index');
Route::get('/roomdata/add','RoomDataController@add');
Route::post('/roomdata/save','RoomDataController@save');
Route::get('/roomdata/edit','RoomDataController@edit');
Route::get('/roomdata/delete','RoomDataController@delete');
Route::get('/roomdata/lua','RoomDataController@lua');
//房间配置end

//签到配置start
Route::get('/signing/index','SigningController@index');
Route::get('/signing/add','SigningController@add');
Route::post('/signing/save','SigningController@save');
Route::get('/signing/edit','SigningController@edit');
Route::get('/signing/delete','SigningController@delete');
Route::get('/signing/lua','SigningController@lua');
//签到配置end

//商城管理start
Route::get('/shop/index','ShopController@index');
Route::get('/shop/add','ShopController@add');
Route::post('/shop/save','ShopController@save');
Route::get('/shop/edit','ShopController@edit');
Route::get('/shop/delete','ShopController@delete');
Route::get('/shop/lua','ShopController@lua');
Route::post('/shop/uploads','ShopController@uploads');
//商城管理end

//好友房配置start
Route::get('/friendroomdata/index','FriendRoomDataController@index');
Route::get('/friendroomdata/add','FriendRoomDataController@add');
Route::post('/friendroomdata/save','FriendRoomDataController@save');
Route::get('/friendroomdata/edit','FriendRoomDataController@edit');
Route::get('/friendroomdata/delete','FriendRoomDataController@delete');
Route::get('/friendroomdata/lua','FriendRoomDataController@lua');
Route::post('/friendroomdata/uploads','FriendRoomDataController@uploads');
//好友房配置end

//新年活动配置start
Route::get('/active/index','ActiveController@index');
Route::get('/active/add','ActiveController@add');
Route::post('/active/save','ActiveController@save');
Route::get('/active/edit','ActiveController@edit');
Route::get('/active/delete','ActiveController@delete');
Route::get('/active/lua','ActiveController@lua');
//新年活动配置end

});







