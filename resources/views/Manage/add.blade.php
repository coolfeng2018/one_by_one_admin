
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>管理员添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">用户名</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="用户名">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">密码</label>
                            <div class="col-md-4">
                                <input type="password" id="pwds" class="form-control input-circle" placeholder="密码">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">

                                    <option value ="1">有效</option>
                                    <option value ="0">无效</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">管理员类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    @foreach($res as  $k=>$v)
                                        <option value ="{{$k}}">{{$v}}</option>
                                    @endforeach
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
        $("#save").click(function(){
            var name= $("#name").val();
            var pwds= $("#pwds").val();
            var status= $("#status").val();
            var type= $("#type").val();
            if(pwds.length < 6 || pwds.length >18 ){
                alert('密码格式错误');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/manage/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,pwds:pwds,type:type,status:status},
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
