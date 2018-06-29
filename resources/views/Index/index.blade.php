@extends('layouts.layouts')
@section('navbar')
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler">
                <span></span>
            </div>
        </li>
        @foreach($menu as $k => $v)
            <li class="nav-item @if($k==0) active @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-game-controller"></i>
                    <span class="title">{{$v['name']}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @foreach($v['level'] as $kk => $vv)
                    <li class="nav-item">
                        <a href="{{$vv['url']}}" class="ajaxify nav-link">
                            <i class="icon-directions"></i>
                            <span class="title">{{$vv['name']}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
        @endforeach


        {{--<li class="nav-item active">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-game-controller"></i>--}}
                {{--<span class="title">游戏配置管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/gateway/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-directions"></i>--}}
                        {{--<span class="title">网关服务</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/gameclass/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">分类设置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/gameserver/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-screen-desktop"></i>--}}
                        {{--<span class="title">游戏服务</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/game/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">游戏列表</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/gameshow/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">展示游戏列表</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/gameupdata/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">版本管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-map"></i>--}}
                {{--<span class="title">文章管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/campaign/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">活动配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/announcement/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">公告配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/message/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-folder"></i>--}}
                        {{--<span class="title">系统广播</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}



        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-diamond"></i>--}}
                {{--<span class="title">商品管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/props/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-diamond"></i>--}}
                        {{--<span class="title">道具管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/goodsCategory/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-diamond"></i>--}}
                        {{--<span class="title">渠道商品</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/sale/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-diamond"></i>--}}
                        {{--<span class="title">促销管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/goods/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-diamond"></i>--}}
                        {{--<span class="title">商品管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-bell"></i>--}}
                {{--<span class="title">任务管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/task/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-bell"></i>--}}
                        {{--<span class="title">任务管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-users"></i>--}}
                {{--<span class="title">用户管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/user/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">用户信息管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/headshot/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">头像审核</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-home"></i>--}}
                {{--<span class="title">场次管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/desk/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-home"></i>--}}
                        {{--<span class="title">场次管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/privateSetting/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-home"></i>--}}
                        {{--<span class="title">私房配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/coinSetting/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-home"></i>--}}
                        {{--<span class="title">金币房配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}



        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-basket"></i>--}}
                {{--<span class="title">订单管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/order/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-basket"></i>--}}
                        {{--<span class="title">订单管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-settings"></i>--}}
                {{--<span class="title">奖励补偿配置</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/newcomersGift/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-heart"></i>--}}
                        {{--<span class="title">新手奖励</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/extensionGift/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-heart"></i>--}}
                        {{--<span class="title">推广奖励</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/checkin/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-heart"></i>--}}
                        {{--<span class="title">签到奖励配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/bankruptcy/list" class="ajaxify nav-link">--}}
                        {{--<i class="icon-heart"></i>--}}
                        {{--<span class="title">破产补助配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-rocket"></i>--}}
                {{--<span class="title">代理管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/proxy/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-rocket"></i>--}}
                        {{--<span class="title">代理管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-settings"></i>--}}
                {{--<span class="title">推广管理</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/generalize/find" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">推广奖励配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/generalize/withdrawlist" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">推广奖励配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/friend/share" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">好友分享内容配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/everyday/share" class="ajaxify nav-link">--}}
                        {{--<i class="icon-users"></i>--}}
                        {{--<span class="title">每日分享内容配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<li class="nav-item">--}}
            {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-settings"></i>--}}
                {{--<span class="title">系统配置</span>--}}
                {{--<span class="arrow"></span>--}}
            {{--</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="/config/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-wrench"></i>--}}
                        {{--<span class="title">游戏杂项配置</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/access/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-wrench"></i>--}}
                        {{--<span class="title">权限节点管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/part/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-wrench"></i>--}}
                        {{--<span class="title">角色管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a href="/manage/index" class="ajaxify nav-link">--}}
                        {{--<i class="icon-wrench"></i>--}}
                        {{--<span class="title">管理员管理</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
    </ul>
@endsection
@section('content')
    <div class="page-content-body">

    </div>
@endsection
@stack('script')