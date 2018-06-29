<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 商品管理-渠道商品类</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/goodsCategory/add"> 新增
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
                        <th> 允许版本 </th>
                        <th> 禁止版本 </th>
                        <th> 允许渠道 </th>
                        <th> 禁止渠道 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    <tr>ps: * all allow</tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->CategoryId }}</td>
                                    <td>{{ $resources->CategoryName }}</td>
                                    <td>{{ $resources->AllowVersion }}</td>
                                    <td>{{ $resources->DenyVersion }}</td>
                                    <td>{{ $resources->AllowChannel }}</td>
                                    <td>{{ $resources->DenyChannel }}</td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/goodsCategory/update?id={{ $resources->CategoryId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/goodsCategory/delete?id={{ $resources->CategoryId }}"> 删除
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
