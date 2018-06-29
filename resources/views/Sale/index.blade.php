<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 商品管理-促销管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/sale/add"> 新增
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
                        <th> 优惠类型 </th>
                        <th> 触发条件 </th>
                        <th> 门槛 </th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>

                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->SaleId }}</td>
                                    <td>{{ $resources->SaleName }}</td>
                                    <td>{{$res['props'][ $resources->PropsId ]}}</td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->Termtype == 0)
                                            无
                                        @elseif($resources->Termtype == 1)
                                            区间触发
                                        @elseif($resources->Termtype == 2)
                                            用户ID触发
                                        @endif
                                        </span>
                                    </td>
                                    @if($resources->Termtype == 0)
                                        <td></td>
                                    @elseif($resources->Termtype == 1)
                                        <td>{{ $resources->TermMin }}-{{ $resources->TermMax }}</td>
                                    @elseif($resources->Termtype == 2)
                                        <td>{{ $resources->TermUid }}</td>
                                    @endif

                                    <td><span class="label label-sm label-warning">
                                        @if($resources->Status == 0)
                                           有效
                                        @else
                                           无效
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/sale/update?id={{ $resources->SaleId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/sale/delete?id={{ $resources->SaleId }}"> 删除
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
