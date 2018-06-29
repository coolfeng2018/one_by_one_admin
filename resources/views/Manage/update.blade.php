
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>商品修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->



                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res['results'] as $resources)
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{$resources->id}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="psd" class="form-control input-circle" value="{{$resources->password}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">用户名</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" value="{{$resources->username}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">密码</label>
                            <div class="col-md-3">
                                <input type="password" id="pwds" class="form-control input-circle input-inline">
                                <span class="help-inline" style="color:red">如需重置密码，请输入新密码  </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">

                                    <option value ="1" @if($resources->status==1) selected @endif>有效</option>
                                    <option value ="0" @if($resources->status==0) selected @endif>无效</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">管理员类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    @foreach($res['role'] as  $k=>$v)
                                        @if($resources->part_id==$k)
                                            <option value ="{{$k}}" selected>{{$v}}</option>
                                        @else
                                            <option value ="{{$k}}">{{$v}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">修改</button>
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
        var id=$("#id").val();
        var psd= $("#psd").val();

        var name= $("#name").val();
        var pwds= $("#pwds").val();
        var status= $("#status").val();
        var type= $("#type").val();

        if(pwds != ''){
            if(pwds.length < 6 || pwds.length >18 ){
                alert('密码格式错误');
                return false;
            }
        }

        $.ajax( {
            type : "post",
            url : "/manage/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',id:id,psd:psd,name:name,pwds:pwds,type:type,status:status},
            success : function(data) {
                if(data.status){
                    Layout.loadAjaxContent(data.url);
                }else{
                    alert('修改失败');
                }
            }
        });
    })

})
</script>

