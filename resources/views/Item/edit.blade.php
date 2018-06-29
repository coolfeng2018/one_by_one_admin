
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>道具修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">道具id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " value="{{ $res->id }}" placeholder="道具id">
                                <input type="hidden" id="ItemId" class=" form-control input-circle " value="{{ $res->ItemId }}" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">名字</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class=" form-control input-circle " value="{{ $res->name }}" placeholder="名字">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-4">
                                <input type="text" id="description" class=" form-control input-circle " value="{{ $res->description }}" placeholder="描述">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">icon</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="{{config('suit.ImgRemoteUrl').$res->icon}}" >
                                <input type="hidden"  id="icon" class="form-control input-circle" value="{{$res->icon}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/item/index"> 返回上一页
                                    <i class="fa fa-reply"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger" id="error_ul" style="display: none">
                        
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
        $(function(){
            FormRepeater.init();
            //file
            $("input[name='file']").change(function(){
                var token=$("input[name='_token']").val();
                var file = $(this)[0].files[0];
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
                        $("#imgUrl").attr("src", data.RemoteDir+data.msg);
                        $("#icon").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var ItemId= $("#ItemId").val();
                var id= $("#id").val();
                var name= $("#name").val();
                var description= $("#description").val();
                var icon= $("#icon").val();
                //验证
                if(id==''){
                    alert('id不能为空,请检查');
                    return false;
                }
                if(id=='' || isNaN(id)){
                    alert('id必须为数字');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/item/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',ItemId:ItemId,id:id,name:name,description:description,icon:icon},
                    success : function(data) {
                        if(data.status){
                            alert('修改成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('修改失败');
                        }
                    }
                });
            });
        })
    </script>