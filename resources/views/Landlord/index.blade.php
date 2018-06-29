<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 百人机器庄家管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/landlord/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <button id="addMore"  class=" btn sbold yellow" >发布</button>ps:(目前取第一条记录)确认调整完毕后，记得发布！
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 昵称 </th>
                        <th> 头像 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->Id }}</td>
                                    <td>{{ $resources->NickName }}</td>
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->AvatarUrl}}" style="width:60px;height: 60px;"></td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/landlord/update?id={{ $resources->Id }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/landlord/delete?id={{ $resources->Id }}"> 删除
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
                url : "/landlord/addPro",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}'},
                success : function(data) {
                    if(data.status){
                        alert(data.msg);
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });

    });
</script>