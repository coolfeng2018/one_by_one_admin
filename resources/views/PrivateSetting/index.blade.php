<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-home font-dark"></i>
                    <span class="caption-subject bold uppercase"> 私房配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 局数 </th>
                        <th> 房卡 </th>
                        <th> 同时最大创建房间数 </th>
                        <th> 授权信息 </th>
                        <th> 收费消息 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                        @foreach ($res['setting'] as $k=>$v)
                            <tr class="odd gradeX">
                                <td>{{ $res['kind'][$k] }}</td>
                                <td>{{ $v['round'] }}</td>
                                <td>{{ $v['spend'] }}</td>
                                <td>{{ $v['max_exist'] }}</td>
                                <td>
                                    <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_permission{{ $k }}">授权信息</button>
                                    <div class="modal fade" id="myModal_permission{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">授权信息</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table style="width:100%;">
                                                        <tr> <td class="inline"  style="width:10%;">状&nbsp;&nbsp;&nbsp;&nbsp;态：</td>
                                                            <td style="width:90%;">
                                                                @if($v['options']['permission']['status'] ==0)
                                                                    未开启
                                                                @elseif($v['options']['permission']['status'] ==1)
                                                                    开启
                                                                @elseif($v['options']['permission']['status'] ==2)
                                                                    白名单开启
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="inline" style="width:10%;">白名单：</td>
                                                            <td style="width:90%;"><textarea class="form-control" disabled>{{ $v['options']['permission']['List'] }}</textarea></td>
                                                        </tr>
                                                        </tbody>
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
                                    <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_toll{{ $k }}">收费信息</button>
                                    <div class="modal fade" id="myModal_toll{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">收费信息</h4>
                                                </div>
                                                <div class="modal-body">
                                                <table style="width:100%;">
                                                    <tr> <td class="inline"  style="width:10%;">状&nbsp;&nbsp;&nbsp;&nbsp;态：</td>
                                                        <td style="width:90%;">
                                                            @if($v['options']['toll']['status'] ==0)
                                                                未开启
                                                            @elseif($v['options']['toll']['status'] ==1)
                                                                开启
                                                            @elseif($v['options']['toll']['status'] ==2)
                                                                白名单开启
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="inline" style="width:10%;">白名单：</td>
                                                        <td style="width:90%;"><textarea class="form-control" disabled>{{$v['options']['toll']['List']}}</textarea></td>
                                                    </tr>
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
                                    <a class="ajaxify btn sbold green" href="/privateSetting/update?id={{$k}}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </div>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>