
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
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        @foreach($res as $k=>$v)
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{$v->AgentId}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">账号</label>
                            <div class="col-md-4">
                                <input type="text" id="mobile" class="form-control input-circle"  value="{{$v->Mobile}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="psd" class="form-control input-circle"  value="{{$v->Psd}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">昵称</label>
                            <div class="col-md-4">
                                <input type="text" id="nick" class="form-control input-circle" value="{{$v->NickName}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">绑定游戏ID</label>
                            <div class="col-md-4">
                                <input type="text" id="uid" class="form-control input-circle" value="{{$v->UserId}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">QQ</label>
                            <div class="col-md-4">
                                <input type="text" id="qq" class="form-control input-circle" value="{{$v->QQ}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Wechat</label>
                            <div class="col-md-4">
                                <input type="text" id="wechat" class="form-control input-circle" value="{{$v->Wechat}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    @if($v->Status == 0)
                                        <option value ="0" selected>正常</option>
                                        <option value ="1" >禁用</option>
                                    @else
                                        <option value ="0" >正常</option>
                                        <option value ="1" selected>禁用</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endforeach
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
            var id=$("#id").val();
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
            if(uid){
                if(isNaN(uid)){
                    alert('绑定游戏ID格式有误,请输入数字');
                    return false;
                }
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
                data : {'_token':'{{csrf_token()}}',id:id,mobile:mobile,psd:psd,nick:nick,uid:uid,qq:qq,wechat:wechat,status:status},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('修改失败--'.data.msg);
                    }
                }
            });
        })

    })
</script>
