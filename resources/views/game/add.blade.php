<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">添加游戏</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">游戏名称</label>
                    <div class="col-md-4">
                        <input name="game_name" type="text" class="form-control" placeholder="游戏名称" value="">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">游戏类型</label>
                    <div class="col-md-4">
                        <input name="game_type" type="text" class="form-control" placeholder="游戏类型" value="">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">保存</button>
                        <button class="ajaxify btn btn green-madison" href="/game/list"> 返回
                                    <i class="fa fa-reply"></i>
                        </button>
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
                url:"/game/add/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    console.log(obj);
                    if(obj.status==200){
                        alert("添加成功");
                        Layout.loadAjaxContent("/game/list");
                    }else{
                        alert(obj.msg);
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
                    $("#game_icon_url").attr("src", data.RemoteDir+data.msg);
                    $("input[name='game_icon_url']").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
    });
</script>

