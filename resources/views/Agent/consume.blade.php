<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理-提成明细 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="  input-inline ">
                            <a class="ajaxify btn sbold green" href="/agent/index"> 返回代理
                                <i class="fa fa-reply"></i>
                            </a>
                        </div>

                        <div class="row">
                             <div class="input-inline" style="padding-left:15px;">
                                <div style="color:red;padding-top: 10px;"><b>账户总提成:{{ $commission['sumCommissionRmb'] }}元</b>&nbsp;&nbsp;&nbsp;&nbsp;<b>账户剩余可提现金额:{{ $commission['Balance'] }}元</b></div>
                                <div style="color:blue;padding-top: 10px;"><b>金币总提成:{{ $commission['sumCommissionCoin']/10000 }}万</b>&nbsp;&nbsp;&nbsp;&nbsp;<b>账户剩余可提数额:{{ $commission['BalanceCoin']/10000 }}万</b></div>
                            </div>
                            <div class="input-inline" style="float:right;"><span id="demo">
                                日期区间:&nbsp;
                                <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{$search['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{$search['etime']}}">&nbsp;</span>
                                <input type="hidden" id="aid" class="form-control input-circle input-inline" value="{{$search['aid']}}" >&nbsp;&nbsp;
                                提成类型:&nbsp;
                                <select class="form-control input-circle input-inline" id="type">
                                    <option value=""></option>
                                    <option value="1" @if($search['type']==1) selected @endif>RMB</option>
                                    <option value="2" @if($search['type']==2) selected @endif>金币</option>
                                </select>&nbsp;
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> UID </th>
                        <th> 昵称 </th>
                        <th> 游戏 </th>
                        <th> 返现类型 </th>
                        <th> 数额 </th>
                        <th> 日期 </th>
                    </tr>

                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->source_user_id }}</td>
                                    <td>{{ $resources->source_user_name }}</td>
                                    <td>{{ $resources->game_type }}</td>
                                    <td>
                                        @if($resources->type==1)  
                                            RMB
                                        @else
                                            金币
                                        @endif
                                    </td>
                                    <td>{{ $resources->amount }}
                                        @if($resources->type==1)  
                                            元
                                        @else
                                            金币
                                        @endif
                                    </td>
                                    <td>{{ date('Y-m-d H:i:s', $resources->time) }}</td>
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
$(function() {
    // $('#stime').datetimepicker();
    // $('#etime').datetimepicker();

    //查找
    var href = "/agent/commission_detail?";

    $("#search").click(function () {
        $("#search").attr("href", href + "&aid=" + $("#aid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+ "&type=" + $("#type").val());
    });
    var aobj = $(".pagination").find("a");

    aobj.each(function () {
        $(this).attr("href", $(this).attr("href") + "&aid=" + $("#aid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+ "&type=" + $("#type").val());
    });
});

$(function() {
    $('#demo').daterangepicker({
        "autoUpdateInput": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "dateLimit": {
            "days": 7
        },
        "ranges" : {  
        '今日': [moment().startOf('day'), moment()],  
        '昨日': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],  
        '最近3日': [moment().subtract('days', 2).startOf('day'), moment()],  
        '最近7日': [moment().subtract('days', 6).startOf('day'), moment()] 
        }, 
        "locale": {
            "direction": "ltr",
            "format": "YYYY-MM-DD HH:mm:ss",
            "separator": " - ",
            "applyLabel": "确定",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel" : '自定义',  
            "daysOfWeek": [ '日', '一', '二', '三', '四', '五', '六' ],
            "monthNames": [ '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            "firstDay": 1
        },
        "alwaysShowCalendars": true,
        "opens": "right",
    }, function(start, end, label) {
       var s = start.format('YYYY-MM-DD HH:mm:ss');
       var e = end.format('YYYY-MM-DD HH:mm:ss');
       $('#stime').val(s);
       $('#etime').val(e);
       console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });
});
</script>

