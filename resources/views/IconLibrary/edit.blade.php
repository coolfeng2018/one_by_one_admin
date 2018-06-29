
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>机器人头像修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " value="{{ $res->id }}" placeholder="id">
                                <input type="hidden" id="IconLibraryId" class=" form-control input-circle " value="{{ $res->IconLibraryId }}" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">语句</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="{{ config('suit.ImgRemoteUrl').$res->name }}" >
                                <input type="hidden"  id="name" class="form-control input-circle" >
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/iconlibrary/index"> 返回上一页
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
                        $("#name").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var IconLibraryId= $("#IconLibraryId").val();
                var id= $("#id").val();
                var name= $("#name").val();
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
                    url : "/iconlibrary/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',IconLibraryId:IconLibraryId,id:id,name:name},
                    success : function(data) {
                        if(data.status){
                            alert('添加成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('添加失败');
                        }
                    }
                });
            });
        })
    </script>