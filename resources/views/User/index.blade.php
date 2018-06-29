<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 用户管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div id="sample_1_filter" class="dataTables_filter">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                ID:&nbsp;<input type="text" id="uid" class="form-control input-sm input-small input-inline" value="{{$search['uid']}}" aria-controls="sample_1">
                                昵称:&nbsp;<input type="text" id="name" class="form-control input-sm input-small input-inline" value="{{$search['name']}}" aria-controls="sample_1">
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 昵称 </th>
                        <th> 性别 </th>
                        <th> 登录类型 </th>
                        <th> 登录平台 </th>
                        <th> 手机号 </th>
                        <th> 设备号 </th>
                        <th> 状态 </th>
                        <th> 注册时间 </th>
                        <th> 登录时间 </th>
                        <th> 用户类型 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->UserId }}</td>
                                    <td>{{ $resources->NickName }}</td>
                                    <td><span class="label label-sm label-danger">
                                        @php
                                            switch ($resources->Gender) {
                                                case 0:
                                                    echo "保密";
                                                    break;
                                                case 1:
                                                    echo "男";
                                                    break;
                                                case 2:
                                                    echo "女";
                                                    break;
                                                }
                                        @endphp
                                        </span>
                                    </td>
                                    <td><span class="label label-sm label-warning">
                                        @php
                                        switch ($resources->LoginType) {
                                            case 0:
                                                echo "游客";
                                                break;
                                            case 1:
                                                echo "微信";
                                                break;
                                            case 2:
                                                echo "QQ";
                                                break;
                                            }
                                        @endphp
                                        </span>
                                    </td>
                                    <td><span class="label label-sm label-info">
                                        @if($resources->MobilePlatform == 0)
                                                安卓
                                            @else
                                                苹果
                                            @endif
                                        </span>
                                    </td>

                                    <td>{{ $resources->Mobile }}</td>
                                    <td>{{ $resources->MachineCode }}</td>
                                    <td><span class="label label-sm label-success">
                                        @if($resources->Status == 1)
                                                禁用
                                            @else
                                                正常
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->RegisterTime }}</td>
                                    <td>{{ $resources->LastLoginTime }}</td>
                                    <td>
                                        @if($resources->ServiceType==1)
                                            <span class="label label-sm label-warning">币商</span>
                                        @else
                                            普通用户
                                        @endif
                                    </td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/user/black?id={{ $resources->UserId }}"> 封号管理
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/user/asset?id={{ $resources->UserId }}"> 资产管理
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @if($resources->ServiceType==0)
                                            <a class="ajaxify btn sbold green" href="/user/saveCoinServer?id={{ $resources->UserId }}&uid={{ $search['uid'] }}&name={{ $search['name'] }}"> 成为币商 </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                            {!! $res->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
$(function(){
    var href="/user/index?";

    $("#search").click(function(){
        $("#search").attr("href",href+"uid="+$("#uid").val()+"&name="+$("#name").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&uid="+$("#uid").val()+"&name="+$("#name").val());
    });
});
</script>
