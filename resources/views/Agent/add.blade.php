
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
                <form action="#" class="form-horizontal" method="post" id="myform">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">代理昵称</label>
                            <div class="col-md-4">
                                <input type="text" id="agentname"  name="agentname" class="form-control input" placeholder="昵称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">手机号码</label>
                            <div class="col-md-4">
                                <input type="text" id="mobile"   name="mobile" class="form-control input" maxlength="11" placeholder="11位手机号码">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">密码</label>
                            <div class="col-md-4">
                                <input type="password" id="pwd"  name="pwd" class="form-control input " maxlength="6" placeholder="6位数密码">
                                <span class="help-inline" style="color:red;">请输入6位字符串（字母，数字，下划线）</span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏ID</label>
                            <div class="col-md-4">
                                <input type="text" id="uid"  name="uid" class="form-control input" placeholder="游戏ID">
                            </div>
                        </div>
					   <div class="form-group">
                            <label class="col-md-3 control-label">提成比率</label>
                            <div class="col-md-4">
                                <input type="text" id="ratio"  name="ratio" class="form-control input" placeholder="提成比率">
                                <span class="help-inline" >0-100</span>
                            </div>
                        </div>
                       
<div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="status"  name="status" value="1">
                            </div>
                        </div>
 

                     

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" id="backurl"  value="@urldecode($backurl)" > 
                                <button id="save" type="button" class="btn  green">&nbsp;&nbsp;保&nbsp;&nbsp;存&nbsp;&nbsp;</button>
                                <a type="button" class="ajaxify btn default" href="{{urldecode($backurl)}}">&nbsp;&nbsp;返&nbsp;&nbsp;回&nbsp;&nbsp;</a>
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
		var succesurl = "{{urldecode($backurl)}}";
        var agentname= $("#agentname").val();
        var mobile= $("#mobile").val();
        var pwd= $("#pwd").val();
        var uid= $("#uid").val();
        var ratio= $("#ratio").val();
        var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;

		var posturl = "{{ $actions['save'] }}";
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
            alert("手机号码有误，请重填");
            return false;
        }

        if(!/^[a-zA-Z0-9_]{6}$/.test(pwd)){
            alert("密码格式错误");
            return false;
        }
        if(!/^\d+$/.test(uid)){
            alert("游戏ID格式错误");
            return false;
        }
        if(ratio==''){
            alert("分成比不能为空");
            return false;
        }
        if(ratio>100 || ratio<0){
            alert("分成比超出范围");
            return false;
        }
        $.ajax( {
            type : "post",
            url : posturl,
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status==0){
                	alert('添加成功！');
                    Layout.loadAjaxContent(succesurl);
                }else{
                    alert(data.msg);
                }
            }
        });
    })

})
</script>
