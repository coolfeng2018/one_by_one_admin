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
                                <label>
                                    <select name="" id="type" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
                                        <option value="-1" @if($search['type']<0) selected="true" @endif >全部</option>
                                        <option value="2" @if($search['type']==2) selected="true" @endif>微信</option>
                                        <option value="1" @if($search['type']==1) selected="true" @endif>支付宝</option>
                                        <option value="0" @if($search['type']==0) selected="true" @endif>银行卡</option>
                                    </select>
                                </label>
                                <div class="input-inline">
                                    时间范围:&nbsp;
                                    <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{ $search['starttime'] }}">
                                    &nbsp;-&nbsp;
                                    <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{ $search['endtime'] }}">&nbsp;
                                    账号ID:&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{ $search['uid']==0?'':$search['uid'] }}">&nbsp;
                                    {{--Mobile:&nbsp;<input type="text" id="mobile" class="form-control input-circle input-inline" value="">&nbsp;--}}
                                    <a class="btn green ajaxify" id="search"  href="">搜索</a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> ID </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 账号ID </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 一级提成 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 二级提成 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 三级提成 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 总提成 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 提现金额 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 余额 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 150px;"> 申请时间 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> 详情 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> 提现方式 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 编辑 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td class="sorting_1"> {{ $v->withdraw_id }} </td>
                                    <td> {{ $v->gameuserid }} </td>
                                    {{--<td> @if($v->withdraw_type==0) 银行卡 @elseif($v->withdraw_type==1) 支付宝 @else 微信 @endif </td>--}}
                                    <td> {{ $v->balance1 }}</td>
                                    <td> {{ $v->balance2 }} </td>
                                    <td> {{ $v->balance3 }} </td>
                                    <td> {{ $v->balance1+$v->balance2+$v->balance3 }} </td>
                                    <td> {{ $v->withdraw_amount }} </td>
                                    <td> {{ $v->balance }} </td>
                                    <td> {{ $v->addtime }}</td>
                                    <td>
                                        <a class="btn green btn-outline sbold findlist" data-toggle="modal" href="#find_{{ $v->withdraw_id }}" duid="{{ $v->duser_id }}">查看</a>
                                        <div class="modal fade draggable-modal" id="find_{{ $v->withdraw_id }}" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">提成详细信息</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-scrollable">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col"> 编号 </th>
                                                                    <th scope="col"> 账号id </th>
                                                                    <th scope="col"> 注册时间 </th>
                                                                    <th scope="col"> 等级 </th>
                                                                    <th scope="col"> 充值金额 </th>
                                                                    <th scope="col"> 充值方式 </th>
                                                                    <th scope="col"> 充值日期 </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="datalist_{{ $v->duser_id }}">

                                                                </tbody>

                                                            </table>

                                                        </div>
                                                        <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                                            <ul class="pagination pag_{{ $v->duser_id }}">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn green btn-outline sbold" data-toggle="modal" href="#withdrawtype_{{ $v->withdraw_id }}">查看</a>
                                        <div class="modal fade draggable-modal" id="withdrawtype_{{ $v->withdraw_id }}" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">提现账号信息</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <label>提现方式:</label>@if($v->withdraw_type==0) 银行卡 @elseif($v->withdraw_type==1) 支付宝 @else 微信 @endif
                                                        </p>
                                                        <p>
                                                            <label>提现金额:</label>{{ $v->withdraw_amount }}
                                                        </p>
                                                        <p>
                                                            <label>提现账号:</label>{{ $v->account }}
                                                        </p>
                                                        <p>
                                                            <label>姓名:</label>{{ $v->realname }}
                                                        </p>
                                                        <p>
                                                            <label>开户行:</label>{{ $v->open_can }}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                    <td>
                                        @if($v->status==0)
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/generalize/withdrawstatus?id={{ $v->withdraw_id }}&status=2');"> 处理中 </a>|
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/generalize/withdrawstatus?id={{ $v->withdraw_id }}&status=1');"> 处理完成 </a>|
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/generalize/withdrawstatus?id={{ $v->withdraw_id }}&status=3');"> 提现失败 </a>
                                        @elseif($v->status==1)
                                            处理完成
                                        @elseif($v->status==2)
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/generalize/withdrawstatus?id={{ $v->withdraw_id }}&status=1');"> 处理完成 </a>|
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/generalize/withdrawstatus?id={{ $v->withdraw_id }}&status=3');"> 提现失败 </a>
                                        @elseif($v->status==3)
                                            提现失败
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite">（当前共有3条提现记录，总提现355元）</div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {{ $data->links() }}
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
        var href="/generalize/withdrawlist?";
        var types="";
        var starttime="";
        var endtime="";
        var uid="";
        $("#type").change(function(){
            types="&type="+$(this).val();
            $("#search").attr("href",href+types+starttime+endtime+uid);
        });
        $("#stime").change(function(){
            starttime="&starttime="+$(this).val();
            $("#search").attr("href",href+types+starttime+endtime+uid);
        });
        $("#etime").change(function(){
            endtime="&endtime="+$(this).val();
            $("#search").attr("href",href+types+starttime+endtime+uid);
        });
        $("#uid").change(function(){
            uid="&uid="+$(this).val();
            $("#search").attr("href",href+types+starttime+endtime+uid);
        });
        $("#search").attr("href",href+"type="+$("#type").val()+"&starttime="+$("#stime").val()+"&endtime="+$("#etime").val()+"&uid="+ $("#uid").val());
        var aobj=$(".pagination").find("a");
        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&type="+$("#type").val()+"&starttime="+$("#stime").val()+"&endtime="+$("#etime").val()+"&uid="+ $("#uid").val());
        });
        $(".findlist").click(function(){
            var duid=$(this).attr("duid");
               pages(duid);
            });

            function  pages(duid) {
                var size=10;
                var currentPage = 1;
                $.getJSON("/generalize/findbyidmap?duid=" + duid + "&page=" + 1 + "&size=" + size, function (data) {
                    var datalist=data.data;
                    if (datalist != null) {
                        var datalists=data.data;
                        var datastr="";
                        $.each(datalist, function (index, obj) { //遍历返回的json
                            datastr+="<tr><td> "+obj.order_id+" </td> <td> "+obj.gameuser_id+" </td> <td> "+obj.gameuser_id+" </td> <td> "+(parseInt(obj.level)-parseInt(data.duserinfo.level))+" </td> <td> "+obj.amount+" </td> <td> 暂定 </td> <td> "+obj.addtime+" </td> </tr>";
                        });
                        $(".datalist_"+duid).html("");
                        $(".datalist_"+duid).append(datastr);
                        var pageCount = Math.ceil(data.count/size);
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
                                $.getJSON("/generalize/findbyidmap?duid=" + duid + "&page=" + page + "&size=" + size,function(listdata){
                                    var datalists=listdata.data;
                                    if (datalists != null) {
                                        $(".datalist_"+duid).html("");
                                        var datastrs="";
                                        $.each(datalists, function (index, obj) { //遍历返回的json
                                            datastrs+="<tr><td> "+obj.order_id+" </td> <td> "+obj.gameuser_id+" </td> <td> "+obj.gameuser_id+" </td> <td> "+(parseInt(obj.level)-parseInt(data.duserinfo.level))+" </td> <td> "+obj.amount+" </td> <td> 暂定 </td> <td> "+obj.addtime+" </td> </tr>";
                                        });
                                        $(".datalist_"+duid).append(datastrs);
                                    }
                                });
                            }
                        };
                        $(".pag_"+duid).bootstrapPaginator(options);
                    }
                });
            }
    })
</script>


