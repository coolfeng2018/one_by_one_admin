
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>活动添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="活动名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">开始时间</label>
                            <div class="col-md-4">
                                <input type="text" id="stime" class=" form-control input-circle " placeholder="活动开始时间">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">结束时间</label>
                            <div class="col-md-4">
                                <input type="text" id="etime" class=" form-control input-circle" placeholder="活动结束时间">
                            </div>
                        </div>

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
    $(function(){

        $('#stime').datetimepicker();
        $('#etime').datetimepicker();

        //ajax提交
        $("#save").click(function(){
            var name= $("#name").val();
            var stime= $("#stime").val();
            var etime= $("#etime").val();


            //时间节点校验
            if(stime==""||etime =="") {
                alert("封号时间段未正确选取");
                return false;
            }
            var s = new Date(stime.replace(/\-/g, "\/"));
            var e = new Date(etime.replace(/\-/g, "\/"));
            if(s>e){
                alert("结束时间小于开始时间，请重新选取");
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/party/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,stime:stime,etime:etime},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data.msg);
                    }
                }
            });
        })

    })
</script>
