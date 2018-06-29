<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-home font-dark"></i>
                    <span class="caption-subject bold uppercase"> 首充礼包配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    </thead>
                    <tbody>
                        <div>
                            <tr class="odd gradeX">
                                <td> 上线时间 </td>
                                <td>{{ $res['charge']['stime'] }}</td>
                            </tr>
                            <tr class="odd gradeX">
                                <td> 下线时间 </td>
                                <td>{{ $res['charge']['etime']}}</td>
                            </tr>
                            @foreach($res['charge']['saling'] as $kk=> $vv)
                                <tr class="odd gradeX">
                                    <td>礼包详细-{{  $res['kind'][$vv['type']] }}</td>
                                    <td>{{ $vv['number'] }}</td>
                                </tr>
                            @endforeach
                            <tr class="odd gradeX">
                                <td> 售价 </td>
                                <td>{{ $res['charge']['price'] }}</td>
                            </tr>
                            <tr class="odd gradeX">
                                <td>操作</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/saleGift/updateCharge"> 修改
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-home font-dark"></i>
                    <span class="caption-subject bold uppercase"> 超值礼包配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    </thead>
                    <tbody>
                    <div>
                        <tr class="odd gradeX">
                            <td> 上线时间 </td>
                            <td>{{ $res['gift']['stime'] }}</td>
                        </tr>
                        <tr class="odd gradeX">
                            <td> 下线时间 </td>
                            <td>{{ $res['gift']['etime']}}</td>
                        </tr>
                        @foreach($res['gift']['saling'] as $k=> $v)
                            <tr class="odd gradeX">
                                <td>礼包详细-{{  $res['kind'][$v['type']] }}</td>
                                <td>{{ $v['number'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="odd gradeX">
                            <td> 售价 </td>
                            <td>{{ $res['gift']['price'] }}</td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>操作</td>
                            <td>
                                <a class="ajaxify btn sbold green" href="/saleGift/updateGift"> 修改
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    </div>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>