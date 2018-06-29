<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">网关列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn green" href="javascript:Layout.loadAjaxContent('/gateway/addshow','');"> 添 加
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="dataTables_length" id="sample_1_length">
                                <a class="btn green"  id="updateSortID" data-toggle="modal" href="#SortIDmodal">批量修改权重</a>
                                <a class="btn green"  id="updateStatus" data-toggle="modal" href="#statusmodal">批量修改状态</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 103px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes">
                                        <span></span>
                                    </label>
                                </th>
                                {{--<th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 263px;"> ID </th>--}}
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 292px;"> 网关名称 </th>
                                {{--<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 192px;">  数量 </th>--}}
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 网关IP </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 网关端口 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 权重 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 201px;"> 状态 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 148px;"> 编辑 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 195px;"> 删除 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="gateway_id" value="{{ $v->GateWay_ID }}">
                                            <span></span>
                                        </label>
                                    </td>
                                    {{--<td class="sorting_1"> {{ $v->GateWay_ID }} </td>--}}
                                    <td> {{ $v->GameWayName }} </td>
{{--                                    <td> {{ $v->Role_Num }} </td>--}}
                                    <td> {{ $v->IP }} </td>
                                    <td> {{ $v->prot }} </td>
                                    <td> {{ $v->SortID }} </td>
                                    <td> @if($v->IsLock) 启用 @else 未启用 @endif </td>
                                    <td>
                                        <a class="edit" href="javascript:Layout.loadAjaxContent('/gateway/edit?id={{ $v->GateWay_ID }}');"> 编辑 </a>
                                    </td>
                                    <td>
                                        <a class="delete" href="javascript:Layout.loadAjaxContent('/gateway/del?id={{ $v->GateWay_ID }}')"> 删除 </a>
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
<script type="text/javascript">
    $(function(){
        $("#updateSortID").attr('disabled',"true");
        $("#updateStatus").attr('disabled',"true");
        $(".group-checkable").change(function(){
            if($(this).is(":checked")){
                $(".checkboxes").attr("checked","checked");
                $("#updateSortID").removeAttr('disabled');
                $("#updateStatus").removeAttr('disabled');
            }else{
                $(".checkboxes").removeAttr("checked");
                $("#updateSortID").attr('disabled',"true");
                $("#updateStatus").attr('disabled',"true");
            }
        });
        $(".checkboxes").click(function(){
            var ischecked=false;
            $(".checkboxes").each(function(){
               if($(this).is(":checked")){
                   ischecked=true;
               }
            });
            if(ischecked){
                $("#updateSortID").removeAttr('disabled');
                $("#updateStatus").removeAttr('disabled');
            }else{
                $("#updateSortID").attr('disabled',"true");
                $("#updateStatus").attr('disabled',"true");
            }
        });
        $("#SortIDsave").click(function(){
            var id=new Array;
            $(".checkboxes").each(function(){
                if($(this).is(":checked")){
                    id.push($(this).val());
                }
            });
            var SortID=$("input[name='sortid']").val();
            var _token=$("input[name='_token']").val();
            $.ajax({
                type:"post",
                url:"/gateway/batchupdatesortid",
                data:{_token:_token,id:id,SortID:SortID},
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        $(".modal-backdrop").remove();
                        $("body").removeClass('modal-open');
                        Layout.loadAjaxContent("/gateway/list");
                    }else{
                        alert("添加失败");
                    }
                }
            });
        });
        $("#Statussave").click(function(){
            var id=new Array;
            $(".checkboxes").each(function(){
                if($(this).is(":checked")){
                    id.push($(this).val());
                }
            });
            var islock=$("select[name='islock']").val();
            var _token=$("input[name='_token']").val();
            $.ajax({
                type:"post",
                url:"/gateway/batchupdatestatus",
                data:{_token:_token,id:id,islock:islock},
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        $(".modal-backdrop").remove();
                        $("body").removeClass('modal-open');
                        Layout.loadAjaxContent("/gateway/list");
                    }else{
                        alert("添加失败");
                    }
                }
            });
        });
    });
</script>
{{ csrf_field() }}
<div id="statusmodal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Responsive & Scrollable</h4>
            </div>
            <div class="modal-body">
                <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible1="1">
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select class="form-control" name="islock">
                                    <option value="0">不启用</option>
                                    <option value="1">启用</option>
                                </select>
                                <span class="help-block">  </span>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                <button type="button" data-dismiss="modal" class="btn green" id="Statussave">修改</button>
            </div>
        </div>
    </div>
</div>
<div id="SortIDmodal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">批量修改权重、排序</h4>
            </div>
            <div class="modal-body">
                <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible1="1">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">权重、排序</label>
                            <div class="col-md-4">
                                <input name="sortid" type="text" class="form-control" placeholder="">
                                <span class="help-block">  </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                <button type="button" data-dismiss="modal" class="btn green" id="SortIDsave">修改</button>
            </div>
        </div>
    </div>
</div>