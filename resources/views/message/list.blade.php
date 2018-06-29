<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">系统广播列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn green ajaxify" href="/message/addshow"> 添 加
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer"><div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div id="sample_editable_1_filter" class="dataTables_filter">
                                <label>Search:<input type="search" class="form-control input-sm input-small input-inline" placeholder="" aria-controls="sample_editable_1"></label>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 263px;"> ID </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 292px;"> 广播内容 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 292px;"> 开始时间 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 192px;">  结束时间 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 轮播间隔 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 添加时间 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 编辑 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 195px;"> 删除 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td class="sorting_1"> {{ $v->message_id }} </td>
                                    <td> {{ $v->concent }} </td>
                                    <td> {{ $v->statrtime }} </td>
                                    <td> {{ $v->endtime }} </td>
                                    <td> {{ $v->interval }} </td>
                                    <td> {{ $v->createtime }} </td>
                                    <td>
                                        <a class="edit" href="javascript:Layout.loadAjaxContent('/message/edit?id={{ $v->message_id }}');"> 编辑 </a>
                                    </td>
                                    <td>
                                        <a class="delete" href="javascript:Layout.loadAjaxContent('/message/del?id={{ $v->message_id }}')"> 删除 </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite">Showing 1 to 5 of 8 entries</div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>