<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-equalizer font-sunglo"></i>
                    <span class="caption-subject bold uppercase"> 游戏展示方案列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            <a class="btn green ajaxify" href="/gameshow/addshow"> 添加方案
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <button id="proGateway"  class=" btn sbold yellow" > 发布</button>ps:确认展示方案调整完毕后，记得发布！
                    </div>
                </div>
                    ps: * all allow
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 方案名称 </th>
                        <th> 允许版本 </th>
                        <th> 禁止版本 </th>
                        <th> 允许渠道 </th>
                        <th> 禁止渠道 </th>
                        <th> 查看配置 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>
                        @foreach($data as $k=>$v)
                            <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                <td class="sorting_1"> {{ $v->gameshow_id }} </td>
                                <td> {{ $v->gameshow_name }} </td>
                                <td> {{ $v->allowVersion }} </td>
                                <td> {{ $v->denyVersion }} </td>
                                <td> {{ $v->allowChannel }} </td>
                                <td> {{ $v->denyChannel }} </td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/showpieces/list?id={{ $v->gameshow_id }}"> 查看配置
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/gameshow/edit?id={{ $v->gameshow_id }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @if($v->type==1)
                                        <span style="color:red"></span>
                                    @else
                                        <a class="ajaxify btn sbold green" href="/gameshow/del?id={{ $v->gameshow_id }}"> 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </div>
                    {{ $data->links() }}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$(function(){
    //发布
    $('#proGateway').click(function () {
        $.ajax({
            type: "post",
            url: "/gameshow/postedgame",
            dataType: 'json',
            data: {'_token': '{{csrf_token()}}'},
            success: function (data) {
                if (data.status) {
                    alert('发布成功');
                } else {
                    alert(data.msg);
                }
            }
        });
    });
})
</script>