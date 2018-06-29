<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> 系统配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            {{--<div class="btn-group">--}}
                                {{--<a class="ajaxify btn sbold green" href="/config/add"> 新增--}}
                                    {{--<i class="fa fa-plus"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            <button id="proConfig"  class=" btn sbold yellow" > 发布</button>ps:确认配置信息调整完毕后，记得发布！
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    </thead>
                    <tbody>
                        <div>
                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>ID</td>
                                <td>{{ $resources->Id }}</td>
                            </tr>

                          
                            @foreach(json_decode($resources->ActiveDetail,true) as $kk=> $vv)
                                <tr class="odd gradeX">
                                    <td>{{ $vv['key'] }}</td>
                                    <td>{{ $vv['value'] }}</td></tr>
                            @endforeach
                            <tr class="odd gradeX">
                                <td>操作</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/config/update?id={{ $resources->Id }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </div>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $('#proConfig').click(function(){
            $.ajax( {
                type : "post",
                url : "/config/show",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}'},
                success : function(data) {
                    if(data.status){
                        alert('发布成功');
                    }else{
                        alert('发布失败');
                    }
                }
            });
        });

    });
</script>
