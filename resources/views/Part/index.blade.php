<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-wrench font-dark"></i>
                    <span class="caption-subject bold uppercase"> 角色管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/part/add"> 新增
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
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 分配权限 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>

                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->id }}</td>
                                    <td>{{ $resources->name }}</td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->status == 1)
                                           有效
                                        @else
                                           无效
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->addtime }}</td>
                                    <td>
                                        @if($resources->id !=1)
                                            <a class="ajaxify btn sbold green" href="/part/access?id={{ $resources->id }}"> 权限分配
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/part/update?id={{ $resources->id }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/part/delete?id={{ $resources->id }}"> 删除
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
