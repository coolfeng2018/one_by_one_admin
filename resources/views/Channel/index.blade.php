<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 商品管理-渠道列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/channel/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 名称 </th>
                        <th>编号</th>
                        <th>类型</th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->ChannelId }}</td>
                                    <td>{{ $resources->ChannelName }}</td>
                                    <td>{{ $resources->ChannelCode }}</td>
                                    <td>
                                        @if($resources->IsOnline==1)
                                            <span class="label label-sm label-success">线上渠道</span>
                                        @else
                                            <span class="label label-sm label-info">线下渠道</span>
                                        @endif
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/channel/update?id={{ $resources->ChannelId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/channel/delete?id={{ $resources->ChannelId }}"> 删除
                                            <i class="fa fa-minus"></i>
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
