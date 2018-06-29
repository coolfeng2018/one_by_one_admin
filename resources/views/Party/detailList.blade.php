<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 活动管理-活动详细 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <div class="  input-inline ">
                                    <a class="ajaxify btn sbold green" href="/party/index"> 返回活动列表
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                                <a class="ajaxify btn sbold green" href="/party/detailAdd?pid={{ $pid }}"> 活动详细新增
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
                        <th> 等级</th>
                        <th> 名称 </th>
                        <th> 类型 </th>
                        <th> 价格 </th>
                        <th> 数量 </th>
                        <th> 投放数量 </th>
                        <th> 添加时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>

                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>{{ $resources->id }}</td>
                                <td>{{ config('suit.lotteryLevel')[$resources->level] }}</td>
                                <td>{{ $resources->name }}</td>
                                <td>
                                    <span class="label label-sm
                                    @php
                                        switch ($resources->type) {
                                            case 0:
                                                echo 'label-danger">';
                                                break;
                                            case 1:
                                                echo 'label-warning">';
                                                break;
                                            case 2:
                                                echo 'label-info">';
                                                break;
                                            case 3:
                                                echo 'label-success">';
                                                break;
                                        }
                                    @endphp
                                    {{ config('suit.lotteryType')[$resources->type] }}
                                    </span>
                                </td>
                                <td>{{ $resources->price }}</td>
                                <td>{{ $resources->total }}</td>
                                <td>{{ $resources->number }}</td>
                                <td>{{ $resources->addtime }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/party/detailUpdate?id={{ $resources->id }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/party/detailDelete?id={{ $resources->id }}&pid={{ $pid }}"> 删除
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </div>
                    {{--{!! $res->links() !!}--}}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

