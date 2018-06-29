
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>代理添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">账号</label>
                            <div class="col-md-4">
                                <input type="text" id="mobile" class="form-control input-circle" placeholder="手机号码">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">密码</label>
                            <div class="col-md-4">
                                <input type="password" id="psd" class="form-control input-inline input-circle" placeholder="密码">
                                <span class="help-inline" style="color:red;">请输入6-15位字符串（字母，数字，下划线）</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">昵称</label>
                            <div class="col-md-4">
                                <input type="text" id="nick" class="form-control input-circle" placeholder="昵称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">绑定游戏ID</label>
                            <div class="col-md-4">
                                <input type="text" id="uid" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">QQ</label>
                            <div class="col-md-4">
                                <input type="text" id="qq" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Wechat</label>
                            <div class="col-md-4">
                                <input type="text" id="wechat" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="0">正常</option>
                                    <option value ="1">禁用</option>
                                </select>
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

        //ajax提交
        $("#save").click(function(){
            var mobile= $("#mobile").val();
            var psd= $("#psd").val();
            var nick= $("#nick").val();
            var uid= $("#uid").val();
            var qq= $("#qq").val();
            var wechat= $("#wechat").val();
            var status= $("#status").val();


            if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
                alert("手机号码有误，请重填");
                return false;
            }

            if(!/^[a-zA-Z0-9_-]{6,15}$/.test(psd)){
                alert("密码格式错误");
                return false;
            }
            if(uid){
                if(isNaN(uid)){
                    alert('绑定游戏ID格式有误,请输入数字');
                    return false;
                }
            }else{
                alert('绑定游戏ID格式有误,请输入');
                return false;
            }
            if(qq){
                if(isNaN(qq)){
                    alert('qq格式有误,请输入数字');
                    return false;
                }
            }

            $.ajax( {
                type : "post",
                url : "/proxy/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',mobile:mobile,psd:psd,nick:nick,uid:uid,qq:qq,wechat:wechat,status:status},
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
