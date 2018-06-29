<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-rocket font-dark"></i>
            <span class="caption-subject font-black-sunglo bold uppercase">代理充值配置</span>
            <span class="caption-helper">(*各项指标填写正整数*)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">充值周期（天）</label>
                    <div class="col-md-4">
                        <input name="term" type="text" class="form-control" placeholder="Enter text" value="{{ $res->term??0 }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">充值金额（元）</label>
                    <div class="col-md-4">
                        <input name="money" type="text" class="form-control" placeholder="Enter text" value="{{ $res->money??0 }}">
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
            var term=$("input[name='term']").val();
            var money=$("input[name='money']").val();

            if(!(/^\d+$/.test(term))){
                alert("充值周期错误");
                return false;
            }

            if(!(/^\d+$/.test(money))){
                alert("充值金额错误");
                return false;
            }
            $.ajax({
                type:"post",
                url:"/proxy/saveConfig",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data.msg);
                    }
                }

            });
        });
    });
</script>

