<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 机器人管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/robit/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            {{--<button id="addMore"  class=" btn sbold green" >点击添加机器人</button>--}}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 昵称 </th>
                        <th> 性别 </th>
                        <th> 头像 </th>
                        <th> 登录类型 </th>
                        <th> 登录平台 </th>
                        <th> 状态 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
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
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->AvatarUrl}}" style="width:60px;height: 60px;"></td>
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

                                    <td><span class="label label-sm label-success">
                                        @if($resources->Status == 1)
                                                禁用
                                            @else
                                                正常
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/robit/update?id={{ $resources->UserId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res->links() !!}
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $('#addMore').click(function(){
            $.ajax( {
                type : "post",
                url : "/robit/addMore",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}'},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });

    });
</script>