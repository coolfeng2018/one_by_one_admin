<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">提现申请列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="dataTables_length" id="sample_1_length">
                                <div class="input-inline">
                                    提现渠道:
                                    <select id="type" class="form-control input-circle input-inline">
                                        @foreach($res['type'] as $k =>$v)
                                            @if($k==$search['type'])
                                                <option value ="{{$k}}" selected>{{$v}}</option>
                                            @else
                                                <option value ="{{$k}}">{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    申请时间:&nbsp;
                                    <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{ $search['stime'] }}">
                                    &nbsp;-&nbsp;
                                    <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{ $search['etime'] }}">&nbsp;
                                    游戏ID:&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{ $search['uid'] }}">&nbsp;
                                    <a class="btn green ajaxify" id="search"  href="">搜索</a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th> 记录ID </th>
                                <th> 代理ID </th>
                                <th> 游戏ID </th>
                                <th> 手机号码 </th>
                                <th> 代理级别 </th>
                                <th> 提现渠道 </th>
                                <th> 提现账号</th>
                                <th> 申请金额 </th>
                                <th> 余额 </th>
                   
                                <th> 申请时间 </th>
                                <th> 操作 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($res['result'] as $k => $v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td>{{ $v->AgentWithdrawId }}</td>
                                    <td>{{ $v->AgentId }}</td>
                                    <td>{{ $v->UserId }}</td>
                                    <td>{{ $v->Telephone }}</td>
                                    <td>{{ $v->depth }}级代理</td>
                                    
                                    <td>@if(isset($res['type'][$v->WithdrawChannel])) {{  $res['type'][$v->WithdrawChannel] }} @else {{$v->WithdrawChannel}} @endif</td>
                                    <td>{{ $v->WithdrawInfo }}</td>
                                    <td>{{ $v->Amount }}</td>
                                    <td>{{ $v->CurrentBalance }}</td>
                                    
                                    <td>{{ $v->acreate }}</td>
                                    <td>
                                        @if($v->w_status==0)
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/cash/updateStatus?id={{ $v->AgentWithdrawId }}&status=1');"> 通过 </a>|
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/cash/updateStatus?id={{ $v->AgentWithdrawId }}&status=2');"> 拒绝 </a>
                                        @elseif($v->w_status==1)
                                            已通过
                                        @elseif($v->w_status==2)
                                            已拒绝
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {{ $res['result']->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#stime').datetimepicker();
    $('#etime').datetimepicker();
    var href="/cash/index?";

    $("#search").click(function(){
        $("#search").attr("href",href+"type="+$("#type").val()+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&uid="+ $("#uid").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&type="+$("#type").val()+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&uid="+ $("#uid").val());
    });

    //提成信息
    $(".findlist").click(function(){
        var duid=$(this).attr("duid");
        pages(duid);
    });
    function  pages(duid) {
        var size=10;
        var currentPage = 1;
        $.getJSON("/cash/findRecord?id=" + duid + "&page=" + 1 + "&size=" + size, function (data) {
            var datalist=data.res;

            if (datalist != null) {
                console.log(datalist.counts);
                var datalists=datalist.data;
                var datastr="";
                $.each(datalists, function (index, obj) { //遍历返回的json
                    if(obj.CommissionType==0){
                        type='玩家充值';
                    }else{
                        type='下级代理提成';
                    }
                    datastr+="<tr><td> "+obj.AgentCommissionId+" </td> <td> "+obj.SourceUserId+" </td> <td> "+type+" </td> <td> "+obj.Amount+" </td> <td> "+obj.CommissionAmount+" </td> <td> "+obj.CreateAt+" </td> </tr>";
                });
                $(".datalist_"+duid).html("");
                $(".datalist_"+duid).append(datastr);
                var pageCount = Math.ceil(datalist.counts/size);
                var options = {
                    bootstrapMajorVersion: 3, //版本
                    currentPage: currentPage, //当前页数
                    totalPages: pageCount, //总页数
                    itemTexts: function (type, page, current) {
                        switch (type) {
                            case "first":
                                return "首页";
                            case "prev":
                                return "上一页";
                            case "next":
                                return "下一页";
                            case "last":
                                return "末页";
                            case "page":
                                return page;
                        }
                    },//点击事件，用于通过Ajax来刷新整个list列表
                    onPageClicked: function (event, originalEvent, type, page) {
                        $.getJSON("/cash/findRecord?id=" + duid + "&page=" + page + "&size=" + size,function(listdata){

                            var datalist=listdata.res;

                            if (datalist != null) {

                                var datalists = datalist.data;
                                var datastr = "";
                                $.each(datalists, function (index, obj) { //遍历返回的json
                                    if(obj.CommissionType==0){
                                        type='玩家充值';
                                    }else{
                                        type='下级代理提成';
                                    }
                                    datastr += "<tr><td> " + obj.AgentCommissionId + " </td> <td> " + obj.SourceUserId + " </td> <td> " + type + " </td> <td> " + obj.Amount + " </td> <td> " + obj.CommissionAmount + " </td> <td> " + obj.CreateAt + " </td> </tr>";
                                });
                                $(".datalist_" + duid).html("");
                                $(".datalist_" + duid).append(datastr);
                            }
                        });
                    }

                };
                $(".pag_"+duid).bootstrapPaginator(options);
            }
        });
    }

});

</script>


