<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">添加活动公告</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="CampaignId" type="hidden" value="0">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">活动标题</label>
                    <div class="col-md-4">
                        <input name="title" type="text" class="form-control" placeholder="Enter text">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">活动简介</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="des" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 757px;"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">标签</label>
                    <div class="col-md-4">
                        <select class="form-control" name="tag">
                            <option value="0" >没有标签</option>
                            <option value="1" >新</option>
                            <option value="2" >热门</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">活动图片</label>
                    <div class="col-md-4">
                        <span class="btn green fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span> 上传图片... </span>
                            <input type="hidden" name="imageurl">
                            <input type="file" name="file" id="file"> </span>
                        <span class="help-block"> <img id="imageurl" src=""> </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">开始时间</label>
                    <div class="col-md-4">
                        <input name="starttime" id="starttime" type="text" class="form-control" data-date-format="yyyy-mm-dd hh:ii">
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
                    <label class="col-md-3 control-label">触发类型</label>
                    <div class="col-md-4">
                        <select class="form-control" name="actiontype">
                            <option value="0">没有效果</option>
                            <option value="1">网页链接</option>
                            <option value="2">app跳转</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">触发内容</label>
                    <div class="col-md-4">
                        <input name="action" type="text" class="form-control" placeholder="Enter text">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">排序</label>
                    <div class="col-md-4">
                        <input name="sort" type="text" class="form-control">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">状态</label>
                    <div class="col-md-4">
                        <select class="form-control" name="status">
                            <option value="0">展示</option>
                            <option value="1">隐藏</option>
                        </select>
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
                url:"/campaign/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/campaign/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
        $("input[name='file']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $("#file")[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/imguploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imageurl").attr("src", data.RemoteDir+data.msg);
                    $("input[name='imageurl']").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });

        $('#starttime').datetimepicker();
        $('#endtime').datetimepicker();

    });
</script>

