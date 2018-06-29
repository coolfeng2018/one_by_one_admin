<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 订单管理</span>
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
                        <div class="col-md-15">
                            平台:&nbsp;&nbsp;
                            <select id="channel" class=" form-control input-circle input-inline">
                                <option value ="z">所有</option>
                                <option value ="ios">ios</option>
                                <option value ="window">window</option>
                                <option value ="android">安卓</option>
                            </select>&nbsp;&nbsp;
                            支付方式:&nbsp;&nbsp;
                            <select id="payment_channel" class=" form-control input-circle input-inline">
                                <option value ="z">所有</option>
                                <option value ="alipay">支付宝</option>
                                <option value ="wx">微信支付</option>
                                <option value ="qq">QQ支付</option>
                                <option value ="union">银联</option>
                                <option value ="gm">人工订单</option>
                            </select>
                            状态:&nbsp;&nbsp;
                            <select id="status" class=" form-control input-circle input-inline">
                                <option value ="z">所有</option>
                                <option value ="0">已下单</option>
                                <option value ="1">已支付未处理</option>
                                <option value ="2">已支付已处理完成</option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                            用户ID:&nbsp;&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{$search['uid']}}" >&nbsp;&nbsp;
                            日期:&nbsp;&nbsp;<input type="text" id="stime" class=" form-control input-circle input-inline" value="{{ $search['stime'] }}">-<input type="text" id="etime" class=" form-control input-circle input-inline" value="{{ $search['etime'] }}">&nbsp;&nbsp;
                            
                            <a class="btn green ajaxify" id="search"  href="">查找</a>&nbsp;&nbsp;
                            <a class="btn green ajaxify" href="/order/addArtificialOrder">添加人工订单</a>
                            <a class="btn red" id="export"  href="">导出excel</a>&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 用户ID </th>
                        <th> 昵称 </th>
                        <th> 订单号 </th>
                        <!--<th> 渠道订单号 </th>-->
                        <th> 付款方式 </th>
                        <th> 支付结果 </th>
                        <th> 平台 </th>
                        <th> 商品名称 </th>
                        <th> 金额 </th>
                        <th> 购买时间 </th>
                        <!--<th> 发货时间 </th>-->
                        <th> 人工订单操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->uid }}</td>
                                    <td>{{ $resources->nickname }}</td>
                                    <td>{{ $resources->order_id }}</td>
                                    <!--<td>{{ $resources->channel_order }}</td>-->
                                    <td><span class="label label-sm label-success">
                                        @php
                                            switch ($resources->payment_channel) {
                                                case 'xiaoqian_qq':
                                                case 'qq':
                                                    echo "QQ支付";
                                                    break;
                                                case 'xiaoqian_alipay':
                                                case 'alipay':
                                                    echo "支付宝";
                                                    break;                                                   
                                                case 'xiaoqian_wx':
                                                case 'wx':
                                                    echo "微信支付";
                                                    break;
                                                case 'xiaoqian_union':
                                                case 'union':
                                                    echo '银联支付';
                                                    break;
                                                case 'gm':
                                                    echo '人工订单';
                                                    break;
                                                default:
                                                    echo '未知';
                                                    break;
                                                }
                                        @endphp
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            switch ($resources->status) {
                                                case 0:
                                                    $msg = "已下单";
                                                    $type = 1;
                                                    break;
                                                case 1:
                                                    $msg = "已支付未处理";
                                                    $type = 1;
                                                    break;
                                                case 2:
                                                    $msg = "已支付已处理完成";
                                                    $type = 2;
                                                    break;
                                                }
                                        @endphp
                                        @if ($type ==1)
                                        <span class="label label-sm label-danger">
                                        @else
                                        <span class="label label-sm label-success">
                                        @endif
                                        {{$msg}}
                                        </span>
                                    </td>
                                    <td>{{ $resources->channel }}</td>
                                    <td>{{ $resources->productName }}</td>
                                    <td>{{ $resources->amount }}</td>
                                    <td>{{ date('Y-m-d H:i:s', $resources->create_time) }}</td>
                                    <!--<td>@php if ( ! empty($resources->paid_time)){echo date('Y-m-d H:i:s', $resources->paid_time);}@endphp</td>-->
                                    <td>@if ($resources->payment_channel == 'gm' && $type == 1)<button class="btn green publicorder" oid="{{$resources->order_id}}">订单发布</button>@endif</td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                    <div >
                            <input type="hidden" id="current" value="">
                            <input type="hidden" id="total" value="">
                            <ul id="page">
                            </ul>
                    </div>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();
        
        $('#status').val('{{$search["status"]}}');
        $('#channel').val('{{$search["channel"]}}');
        $('#payment_channel').val('{{$search["payment_channel"]}}');
        $('#uid').val('{{$search["uid"]}}');

        var href="/order/index?";

        $("#search").click(function(){
            $("#search").attr("href",href+"&status="+$("#status").val()+"&channel="+$("#channel").val()+"&payment_channel="+$("#payment_channel").val()+"&uid="+$("#uid").val()+"&stime="+$("#stime").val()+"&etime="+ $("#etime").val());
        });
        
        $("#export").click(function(){
            $("#export").attr("href",href+"&status="+$("#status").val()+"&channel="+$("#channel").val()+"&payment_channel="+$("#payment_channel").val()+"&uid="+$("#uid").val()+"&stime="+$("#stime").val()+"&etime="+ $("#etime").val() + "&export=1");
        })

        var aobj=$(".pagination").find("a");

        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&status="+$("#status").val()+"&channel="+$("#channel").val()+"&payment_channel="+$("#payment_channel").val()+"&uid="+$("#uid").val()+"&stime="+$("#stime").val()+"&etime="+ $("#etime").val());
        });
        
        $(".publicorder").click(function(){
            oid = $(this).attr('oid');
            if (oid == '') {
                return;
            }
            $.ajax( {
                type : "post",
                url : "/order/public",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',oid:oid},
                success : function(data) {
                    if(data.status){
                        alert('人工订单发布成功');
                        Layout.loadAjaxContent('/order/index');
                    } else {
                        alert('发布失败');
                    }

                }
            });
        })
    });
</script>
