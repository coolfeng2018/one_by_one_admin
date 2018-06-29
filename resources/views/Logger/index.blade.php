<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 日志列表</span>
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
                                昵称:
                                <input type="text" id="uname" class="form-control input-circle input-inline" value="{{$search['uname']}}" aria-controls="sample_1">
                                操作日期:&nbsp;&nbsp;<input type="text" id="stime" class=" form-control input-circle input-inline" value="{{$search['stime']}}">至<input type="text" id="etime" class=" form-control input-circle input-inline" value="{{$search['etime']}}">&nbsp;&nbsp;
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 操作人员 </th>
                        <th> 操作内容 </th>
                        <th> 操作时间 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->id }}</td>
                                    <td>{{ $resources->username }}</td>
                                    <td><span class="label label-sm label-info">{{ $resources->mark }}</span></td>
                                    <td>{{ $resources->addtime }}</td>
                                </tr>
                            @endforeach
                        </div>
                    </tbody>
                    {!! $res['results']->links() !!}
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#stime').datetimepicker();
    $('#etime').datetimepicker();

    var href="/logger/index?";

    $("#search").click(function(){
        $("#search").attr("href",href+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&uname="+ $("#uname").val());
    });

    var aobj=$(".pagination").find("a");
    
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&uname="+ $("#uname").val());
    });
});
</script>
