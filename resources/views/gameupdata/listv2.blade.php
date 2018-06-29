<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">版本更新列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn green ajaxify" href="/gameupdata/showv2"> 添 加
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                    <!--<div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div id="sample_editable_1_filter" class="dataTables_filter">
                                <label>Search:<input type="search" class="form-control input-sm input-small input-inline" placeholder="" aria-controls="sample_editable_1"></label>
                            </div>
                        </div>
                    </div>-->
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 80px;"> ID </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 更新版本 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 292px;"> 更新时间 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 80px;">  是否强更 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 80px;">  更新类型 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 允许版本 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 允许渠道 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 平台 </th>
                                <!--<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 编辑 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 195px;"> 删除 </th>-->
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 是否公开版本 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 状态 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 300px;"> 操作 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td class="sorting_1"> {{ $v->id }} </td>
                                    <td> {{ $v->version }}</td>
                                    <td> {{ $v->release_time }} </td>
                                    <td> @if($v->is_force) 强更 @else 非强更 @endif </td>
                                    <td> @if($v->update_type) 热更 @else 整包更新 @endif </td>
                                    <td> @if ($v->allow_version=='*') 所有版本 @else {{$v->allow_version}} @endif</td>
                                    <td> @if ($v->allow_channel=='*') 所有渠道 @else {{$v->allow_channel}} @endif</td>
                                    <td>{{ $v->pf }}</td>
                                    <!--<td>
                                        <a class="edit" href="javascript:Layout.loadAjaxContent('/gameupdata/showv2?id={{ $v->id }}');"> 编辑 </a>
                                    </td>
                                    <td>
                                        <a class="delete" href="javascript:Layout.loadAjaxContent('/gameupdata/delv2?id={{ $v->id }}&vid={{ $v->id }}')"> 删除 </a>
                                    </td>-->
                                    <td> @if($v->is_public == "*") 是 @else 否 @endif </td>
                                    <td> @if ($v->status=='1') 启用 @else 禁用  @endif </td>
                                    
                                    <td>@if  ($v->status=='2') 
                                        <a class="btn sbold green upStatus" href="#" status="1" tid="{{ $v->id }}"> 启用</a>
                                        @elseif($v->status=='1')
                                        <a class="btn sbold red upStatus" href="#" status="2" tid="{{ $v->id }}"> 禁用</a>
                                        @endif

                                        <a class="btn sbold green" href="javascript:Layout.loadAjaxContent('/gameupdata/showv2?id={{ $v->id }}');" > 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn sbold green" href="javascript:Layout.loadAjaxContent('/gameupdata/delv2?id={{ $v->id }}&vid={{ $v->id }}')" > 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
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

<script>
    $(function(){
        $('.upStatus').click(function(){
            $.ajax( {
                type : "post",
                url : "/gameupdata/updateStatus",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:$(this).attr('tid'), status:$(this).attr('status')},
                success : function(data) {
                    if(data.success == 1){
                        Layout.loadAjaxContent('/gameupdata/listv2');
                    } else {
                        alert('参数错误');
                    }

                }
            });
        })

    })
</script>