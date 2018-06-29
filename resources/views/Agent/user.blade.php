<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理-下级用户 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="  input-inline ">
                            <a class="ajaxify btn sbold green" href="{{urldecode($backurl)}}"> 返回代理
                                <i class="fa fa-reply"></i>
                            </a>
                        </div>
                        <div class="row">
                            <div class="input-inline" style="float:right;">
                                Date:&nbsp;
                                <input type="text" id="stime" class=" form-control input-inline" value="{{$search['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control input-inline" value="{{$search['etime']}}">&nbsp;
                                <input type="hidden" id="aid" class="form-control input-inline" value="{{$search['aid']}}" >&nbsp;&nbsp;
                                游戏ID:&nbsp;<input type="text" id="uid" class="form-control input-inline" value="{{$search['uid']}}" >&nbsp;
                                
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                                <input type="hidden" id="backurl" value="@if(empty($backurl)) {{$actions['index']}} @else {{urldecode($backurl)}} @endif">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 游戏ID </th>
                        <th> 对局数 </th>
                        <th> 充值信息 </th>
                        <th> 绑定时间 </th>
                       
                    </tr>

                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>
                                        @if($resources->UserId) 
                                        <a class=" ajaxify" href="/uinfo/index?act=search&uid={{ $resources->UserId }}">{{ $resources->UserId }}</a> 
                                        @else
                                            未绑定游戏ID
                                        @endif
                                    </td>
                                    <td>{{ $resources->num }}</td>
                                    <td><a class="ajaxify" href="/order/index?&status=z&channel=z&payment_channel=z&stime=&etime=&uid={{ $resources->UserId }}">{{ $resources->amount }}</a></td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    
                                </tr>
                            @endforeach
                        </div>
                        
                        
                    </tbody>
                </table>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                     {!! $paginator->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
        
    </div>
</div>
<script>
$(function() {
    $('#stime').datetimepicker();
    $('#etime').datetimepicker();
    var backurl = $('#backurl').val();
    //查找
    var href = "/agent/user?";
    $("#search").click(function () {
        $("#search").attr("href", href + "&aid=" + $("#aid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+"&backurl=" +backurl);
    });
    var aobj = $(".pagination").find("a");
    aobj.each(function () {
        $(this).attr("href", $(this).attr("href") + "&aid=" + $("#aid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+"&backurl=" +backurl);
    });
});
</script>
