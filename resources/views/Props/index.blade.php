<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 商品管理-道具管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/props/add"> 新增
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
                        <th> 描述 </th>
                        <th> 类型 </th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>

                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->PropsId }}</td>
                                    <td>{{ $resources->PropsName }}</td>
                                    <td>{{ $resources->PropsDescription }}</td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->PropsType == 0)
                                           货币
                                        @else
                                           其他
                                        @endif
                                        </span>
                                    </td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->Status == 1)
                                            已上架
                                        @else
                                            已下架
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/props/update?id={{ $resources->PropsId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/props/delete?id={{ $resources->PropsId }}"> 删除
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
