<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 申请管理</span>
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
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 游戏ID </th>
                        <th> 手机号 </th>
                        <th> 图片 </th>
                        <th> 群成员ID </th>
                        <th> 群成员详细信息 </th>
                        <th> 优势 </th>
                        <th> 状态 </th>
                        <th> 申请时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->Id }}</td>
                                    <td>{{ $resources->UserId }}</td>
                                    <td>{{ $resources->Phone }}</td>
                                    <td><img class="img min {{ $resources->Id }}" src="{{ $resources->Img }}"></td>
                                    <td style="width:300px;">{{ $resources->Group }}</td>

                                    <td>
                                        <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->Id }}">查看</button>
                                        <div class="modal fade" id="myModal_{{ $resources->Id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">群成员详细信息</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>编号</th>
                                                                <th>游戏ID</th>
                                                                <th>是否绑定上级</th>
                                                                <th>注册时间</th>
                                                                <th>最后登录时间</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($resources->info)==0)
                                                                    <tr><td colspan="5">群成员为空</td></tr>
                                                                @else
                                                                    @foreach($resources->info as $k => $v)
                                                                        <tr>
                                                                            <td>{{ $k+1 }}</td>
                                                                            <td>{{ $v['UserId'] }}</td>
                                                                            <td>
                                                                                @if($v['AgentId']>0)
                                                                                    已绑定上级({{ $v['AgentId'] }})
                                                                                @else
                                                                                    未绑定上级
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $v['RegisterTime'] }}</td>
                                                                            <td>{{ $v['LastLoginTime'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $resources->Reason }}</td>
                                    <td><span class="label label-sm label-success">
                                        @if($resources->Status == 0)
                                            处理中
                                        @elseif($resources->Status == 1)
                                            已通过
                                        @elseif($resources->Status == 2)
                                            未通过
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        @if($resources->Status == 0)
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/applyAgent/updateStatus?id={{ $resources->Id }}&status=1');"> 通过 </a>|
                                            <a class="edit" href="javascript:Layout.loadAjaxContent('/applyAgent/updateStatus?id={{ $resources->Id }}&status=2');"> 拒绝 </a>
                                        @elseif($resources->Status == 1)
                                            已通过
                                        @elseif($resources->Status == 2)
                                            未通过
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                </table>
                <div id="record">共<span>{{$res['total']}}</span>条记录</div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .max{width:100%;height:auto;}
    .min{width:100px;height:auto;}
</style>
<script>
    $('.img').click(function(){
        $(this).toggleClass('min');
        $(this).toggleClass('max');
    });
</script>
