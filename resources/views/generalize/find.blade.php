<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">推广提成比例配置</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">每日分享金币</label>
                    <div class="col-md-4">
                        <input name="everyday" type="text" class="form-control" placeholder="Enter text" value="{{ $data->everyday??0 }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">一级会员抽成比例(%)</label>
                    <div class="col-md-4">
                        <input name="one" type="text" class="form-control" placeholder="Enter text" value="{{ $data->s1??0 }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">二级会员抽成比例(%)</label>
                    <div class="col-md-4">
                        <input name="two" type="text" class="form-control" placeholder="Enter text" value="{{ $data->s2??0 }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">三级会员抽成比例(%)</label>
                    <div class="col-md-4">
                        <input name="three" type="text" class="form-control" placeholder="Enter text" value="{{  $data->s3??0 }}">
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
            var one=parseInt($("input[name='one']").val());
            var two=parseInt($("input[name='two']").val());
            var three=parseInt($("input[name='three']").val());
            if(one<0 || one>100){
                alert("一级会员抽成不能小于0或者大于100");
                return false;
            }
            if(two<0 || two>100){
                alert("二级会员抽成不能小于0或者大于100");
                return false;
            }
            if(three<0 || three>100){
                alert("三级会员抽成不能小于0或者大于100");
                return false;
            }
            $.ajax({
                type:"post",
                url:"/generalize/save",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/generalize/find");
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
                    $("#sharing_img").attr("src", data.RemoteDir+data.msg);
                    $("input[name='sharing_img']").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
    });
</script>

