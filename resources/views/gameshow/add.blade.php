
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>展示方案添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="myform" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="subtype" value="add">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">方案名称</label>
                            <div class="col-md-4">
                                <input type="text" name="gameshow_name" class="form-control input-circle" placeholder="方案名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">允许版本</label>
                            <div class="col-md-4">
                                <textarea name="allowVersion" class="form-control" ></textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁止版本</label>
                            <div class="col-md-4">
                                <textarea name="denyVersion" class="form-control" ></textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">允许渠道</label>
                            <div class="col-md-4">
                                <textarea name="allowChannel" class="form-control" ></textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">禁止渠道</label>
                            <div class="col-md-4">
                                <textarea name="denyChannel" class="form-control" ></textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="sub" type="button" class="btn btn-circle green">保存</button>
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
        var json=[];
        $("#sub").click(function(){
            $.ajax({
                type:"post",
                url:"/gameshow/postdata",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    console.log(obj);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/gameshow/list");
                    }else{
                        alert("添加失败");
                    }
                }
            });
        });
    });
</script>

