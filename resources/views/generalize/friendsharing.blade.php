<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">好友分享信息配置</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">分享标题</label>
                    <div class="col-md-4">
                        <input name="sharing_title" type="text" class="form-control" placeholder="Enter text" value="{{  $data->sharing_title??'' }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">分享标题图片</label>
                    <div class="col-md-4">
                         <span class="btn green fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span> 上传图标... </span>
                            <input type="hidden" name="sharing_img" value="{{  $data->sharing_img??'' }}">
                            <input type="file" name="file" id="file"> </span>
                        <span class="help-block"> <img id="sharing_img" src="{{  isset($data->sharing_img)?config('suit.ImgRemoteUrl').$data->sharing_img:'' }}"> </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">分享描述</label>
                    <div class="col-md-4">
                        <textarea name="sharing_content" class="form-control" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{  $data->sharing_content??'' }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">保存</button>
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
                url:"/friend/share/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/friend/share");
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
            obj.append("repath", "resource");
            $.ajax({
                url: "/imguploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#sharing_img").attr("src", data.RemoteDir+data.msg);
                    $("input[name='sharing_img']").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
    });
</script>

