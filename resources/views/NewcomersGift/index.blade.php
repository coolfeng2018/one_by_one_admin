<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-heart font-dark"></i>
                    <span class="caption-subject bold uppercase">新手奖励</span>
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
                        <th> 新手礼包 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>
                        <tr class="odd gradeX">
                            <td>
                                <button class=" btn sbold green " data-toggle="modal" data-target="#myModal">新手礼包</button>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">新手礼包</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                @foreach($res as $k => $v)
                                                        <tr><td>{{ $v['name'] }}</td><td>{{ $v['number'] }}</td></tr>
                                                @endforeach
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a class="ajaxify btn sbold green" href="/newcomersGift/update"> 修改
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
