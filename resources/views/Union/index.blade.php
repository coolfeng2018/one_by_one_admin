<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 联运列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/union/add"> 新增
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
                        <th> 编号 </th>
                        <th> 分成比例 </th>
                        <th> 结算方式 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->UnionId }}</td>
                                    <td>{{ $resources->UnionName }}</td>
                                    <td>{{ $resources->UnionCode }}</td>
                                    <td>{{ $resources->SharingRatio }}</td>

                                    <td>
                                        @if($resources->SharingType==0)
                                            <span class="label label-sm label-success">先给代理在分成</span>
                                        @elseif($resources->SharingType==1)
                                            <span class="label label-sm label-info">先分成再给代理</span>
                                        @endif
                                    </td>
                                    <td>{{ $resources->CreateAt }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/union/update?id={{ $resources->UnionId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/union/delete?id={{ $resources->UnionId }}"> 删除
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
