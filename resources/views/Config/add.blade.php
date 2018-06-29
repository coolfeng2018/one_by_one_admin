
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>系统配置添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">


                        <div class="form-group">
                            <label class="col-md-3 control-label">玩家客服QQ</label>
                            <div class="col-md-4">
                                <input  type="text" id="qq" class="form-control input-circle" placeholder="eg:21547896">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">代理商客服QQ</label>
                            <div class="col-md-4">
                                <input  type="text" id="qqProxy" class="form-control input-circle" placeholder="eg:21547896">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">联运商客服微信</label>
                            <div class="col-md-4">
                                <input  type="text" id="wxProxy" class="form-control input-circle" placeholder="eg:wechat001">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">预警号码</label>
                            <div class="col-md-4">
                                <input  type="text" id="tel" class="form-control input-circle" placeholder="eg:13012349876">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">预警消息</label>
                            <div class="col-md-4 ">
                                <input  type="text" id="msg" class="form-control input-circle" placeholder="eg:你妹，出来修复问题">
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

    $("#save").click(function(){
        // var max= $("#max").val();
        var qq= $("#qq").val();
        var qqProxy= $("#qqProxy").val();
        var wxProxy= $("#wxProxy").val();
        var tel= $("#tel").val();
        var msg= $("#msg").val();

        // if(!Number(max)){
        //     alert('好友上限应为数字');
        //     return false;
        // }

        $.ajax( {
            type : "post",
            url : "/config/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',qq:qq,qqProxy:qqProxy,wxProxy:wxProxy,tel:tel,msg:msg},
            success : function(data) {
                if(data.status){
                    Layout.loadAjaxContent(data.url);
                }else{
                    alert('添加失败');
                }
            }
        });
    })

})
</script>
