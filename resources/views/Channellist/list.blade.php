<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 统计渠道管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/channellist/add"> 新增
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
                        <th> 渠道名 </th>
                        <th> 代码 </th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->id }}</td>
                                    <td>{{ $resources->name }}</td>
                                    <td>{{ $resources->code }}</td>
                                    <!--<td>
                                        @if($resources->status==1)
                                            <span class="label label-sm label-success">正常</span>
                                        @else
                                            <span class="label label-sm label-info">失效</span>
                                        @endif
                                    </td>-->
                                    <td>{{ $resources->created_time }}</td>
                                    <td>{{ $resources->modified_time }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/channellist/update?id={{ $resources->id }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/channellist/delete?id={{ $resources->id }}"> 删除
                                            <i class="fa fa-minus"></i>
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
