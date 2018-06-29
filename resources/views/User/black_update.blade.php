
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>封号修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res as $resources)
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id" class="form-control input-circle" value="{{$resources->BlockId}}">
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="uid" class="form-control input-circle" value="{{$resources->UserId}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">封号原因</label>
                            <div class="col-md-4">
                                <input type="text" id="reason" class="form-control input-circle" value="{{$resources->Reason}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">封号时间（起）</label>
                            <div class="col-md-4">
                                <input type="text" value="{{$resources->StartTime}}" id="startTime" class="form-control input-circle" placeholder="封号时间（起）">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">封号时间（止）</label>
                            <div class="col-md-4">
                                <input type="text" value="{{$resources->EndTime}}" id="endTime" class="form-control input-circle" placeholder="封号时间（止）">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    @if($resources->Status == 0)
                                        <option value ="0" selected>无效</option>
                                        <option value ="1" >有效</option>
                                    @else
                                        <option value ="0" >无效</option>
                                        <option value ="1" selected>有效</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        //time
        $('#startTime').datetimepicker();
        $('#endTime').datetimepicker();


        //ajax提交
        $("#save").click(function() {
            var id= $("#id").val();
            var uid= $("#uid").val();
            var reason=  $("#reason").val();
            var start=  $("#startTime").val();
            var end=  $("#endTime").val();
            var status=$('#status option:selected') .val();//选中的值

            //时间节点校验
            if(start==""||end =="") {
                alert("封号时间段未正确选取");
                return false;
            }
            var s = new Date(start.replace(/\-/g, "\/"));
            var e = new Date(end.replace(/\-/g, "\/"));
            if(s>e){
                alert("结束时间小于开始时间，请重新选取");
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/user/black_save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,uid:uid,reason:reason,start:start,end:end,status:status},
                success : function(data) {
                    if(data.status){
                        alert('修改成功');
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('添加失败');
                    }
                }
            });
        })
    })
</script>
