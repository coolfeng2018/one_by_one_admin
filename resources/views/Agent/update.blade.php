
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>代理修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post" id="myform">
                    {{ csrf_field() }}
                    <div class="form-body">

                        @foreach($res as $k=>$v)
                            

                            <div class="form-group">
                                <label class="col-md-3 control-label">代理ID</label>
                                <div class="col-md-4">
                                    <input type="text" id="agentid" name="agentid" class="form-control " value="{{$v->AgentId}}" readonly>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-4">
                                    <input type="hidden" id="parentid" name="parentid"  class="form-control " value="{{$v->ParentId}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">代理昵称</label>
                                <div class="col-md-4">
                                    <input type="text" id="agentname" name="agentname"  class="form-control " value="{{$v->AgentName}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">手机号码</label>
                                <div class="col-md-4">
                                    <input type="text" id="mobile"  name="mobile" class="form-control "  value="{{$v->Telephone}}">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-md-3 control-label">提成比例</label>
                                <div class="col-md-4">
                                    <input type="text" id="ratio"  name="ratio" class="form-control "  value="{{$v->Ratio}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">新密码</label>
                                <div class="col-md-4">
                                    <input type="password" id="pwd"  name="pwd"  class="form-control " placeholder="新密码">
                                    <span class="help-inline" style="color:red;">如需更新密码，则输入新密码，格式6位字符串（字母，数字，下划线）</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">游戏ID</label>
                                <div class="col-md-4">
                                    <input type="text" id="uid"  name="uid"  class="form-control " value="{{$v->UserId}}" readonly>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-md-3 control-label">状态</label>
                                <div class="col-md-4">
                                    <select id="status" name="status"  class="form-control ">
                                        @foreach($u_status as $key=>$val)
                                        <option value='{{$key}}' @if($v->Status==$key)selected @endif >{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn  green">&nbsp;&nbsp;保&nbsp;&nbsp;存&nbsp;&nbsp;</button>
                                <a type="button" class="ajaxify btn default" href="{{urldecode($backurl)}}">&nbsp;&nbsp;返&nbsp;&nbsp;回&nbsp;&nbsp;</a>
                                <input type="hidden" id="backurl" value="{{urldecode($backurl)}}">
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
            var agentid = $("#agentid").val();
            var newpwd= $("#pwd").val();
            var repwd= $("#repwd").val();
            var agentname= $("#agentname").val();
            var mobile= $("#mobile").val();
            var status= $("#status").val();
            var uid= $("#uid").val();
            var parentid = $("#parentid").val();

            var backurl = $("#backurl").val();
			var posturl = "{{$actions['save']}}";
            var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
            

            if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))){
                alert("手机号码有误，请重填");
                return false;
            }
            if(newpwd.length>0){
                if(!/^[a-zA-Z0-9_]{6}$/.test(newpwd)){
                    alert("新密码格式错误,6 位数字，字母下划线");
                    return false;
                }
            }
            $.ajax( {
                type : "post",
                url : posturl,
                dataType : 'json',
                data:$('#myform').serialize(),
                success : function(data) {
                    if(data.status == 0){
                    	alert("修改成功！");
                        Layout.loadAjaxContent(backurl);
                    }else{
                        alert('修改失败--'+data.msg);
                    }
                }
            });
        })

    })
</script>
