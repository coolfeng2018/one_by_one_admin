<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">添加系统通知</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="message_id" type="hidden" value="0">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">通知内容</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="concent" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 757px;"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">开始时间</label>
                    <div class="col-md-4">
                        <input name="statrtime" id="starttime" type="text" class="form-control" data-date-format="yyyy-mm-dd hh:ii">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">结束时间</label>
                    <div class="col-md-4">
                        <input name="endtime" id="endtime" type="text" class="form-control" data-date-format="yyyy-mm-dd hh:ii">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">轮播间隔时间</label>
                    <div class="col-md-4">
                        <input name="interval" type="text" class="form-control" placeholder="Enter text">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">添加</button>
                        <button type="button" class="btn default">重置</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#sub").click(function(){
            console.log('ok');
            $.ajax({
                type:"post",
                url:"/message/postdata",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/message/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
        $('#starttime').datetimepicker();
        $('#endtime').datetimepicker();

    });
</script>

