<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 封号管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/user/black_add?uid={{$res['uid']}}"> 新增
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
                        <th> UID </th>
                        <th> 原因 </th>
                        <th> 封号时间（起）</th>
                        <th> 封号时间（止）</th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>

                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->BlockId }}</td>
                                    <td>{{ $resources->UserId }}</td>
                                    <td>{{ $resources->Reason }}</td>
                                    <td>{{ $resources->StartTime }}</td>
                                    <td>{{ $resources->EndTime }}</td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->Status == 0)
                                            无效
                                        @else
                                            有效
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/user/black_update?id={{ $resources->BlockId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/user/black_delete?id={{ $resources->BlockId }}"> 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
