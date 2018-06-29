
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>机器人添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">昵称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="昵称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">头像</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="" >
                                <input type="hidden"  id="img" class="form-control input-circle" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">性别</label>
                            <div class="col-md-4">
                                <select id="sex" class="form-control input-circle">
                                    <option value ="0">保密</option>
                                    <option value ="1">男</option>
                                    <option value ="2">女</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">登录类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    <option value ="0">游客</option>
                                    <option value ="1">微信</option>
                                    <option value ="2">QQ</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">登录平台</label>
                            <div class="col-md-4">
                                <select id="os" class="form-control input-circle">
                                    <option value ="0">安卓</option>
                                    <option value ="1">苹果</option>
                                </select>
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
        //file
        $("input[name='file']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this)[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/robit/uploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imgUrl").attr("src",data.RemoteDir+data.msg);
                    $("#img").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });

        //ajax提交
        $("#save").click(function(){
            var name= $("#name").val();
            var img= $("#img").val();

            var sex = $("#sex").val();
            var type= $("#type").val();
            var os = $("#os").val();
            var status= $("#status").val();

            if(name=='' ){
                alert('昵称不空');
                return false;
            }

            if(img=='' ){
                alert('缺乏上传资源');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/robit/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,img:img,sex:sex,type:type,os:os,status:status},
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
