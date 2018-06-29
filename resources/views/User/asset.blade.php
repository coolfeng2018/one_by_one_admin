<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase">资产管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> UID </th>
                        <th> 金币数量 </th>
                        <th> 房卡数量 </th>
                        <th> 钻石数量 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            <tr class="odd gradeX">
                                <td>{{ $res['UserId'] }}</td>
                                <td>{{ $res['coin'] }}</td>
                                <td>{{ $res['card'] }}</td>
                                <td>{{ $res['gem'] }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/user/asset_update?id={{ $res['UserId'] }}"> 修改
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
