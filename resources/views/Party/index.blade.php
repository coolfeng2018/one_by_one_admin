<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 活动管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/party/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> id </th>
                        <th> 名称 </th>
                        <th> 开始时间 </th>
                        <th> 结束时间 </th>
                        <th> 查看活动配置 </th>
                        <th> 添加时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>

                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>{{ $resources->id }}</td>
                                <td>{{ $resources->name }}</td>
                                <td>{{ $resources->start }}</td>
                                <td>{{ $resources->end }}</td>
                                <td><a class="ajaxify btn sbold green" href="/party/detailList?pid={{ $resources->id }}"> 查看活动配置 </a>
                                </td>
                                <td>{{ $resources->addtime }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/party/update?id={{ $resources->id }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/party/delete?id={{ $resources->id }}"> 删除
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

