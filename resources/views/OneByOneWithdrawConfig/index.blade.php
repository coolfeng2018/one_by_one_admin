<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 兑换下线配置</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 兑换最小额度 </th>
                        <th> 兑换后最少保留额度 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                                <tr class="odd gradeX">
                                    <td>{{ $rangeCurrentAmount }}元</td>
                                    <td>{{ $minAmount }}元</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/withdrawconfig/update"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                        </div>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
