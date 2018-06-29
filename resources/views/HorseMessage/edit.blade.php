
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>跑马灯修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                    	<input type="hidden" id="HorseMessageId" class=" form-control input-circle " value="{{ $res->HorseMessageId }}" >
                        <div class="form-group">
                            <label class="col-md-3 control-label">广播ID</label>
                            <div class="col-md-4">
                                <input type="text" id="ID" class=" form-control input-circle " value="{{ $res->ID }}" placeholder="广播ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">广播内容</label>
                            <div class="col-md-4">
                                <input type="text" id="content" class=" form-control input-circle " value="{{ $res->content }}" placeholder="广播内容">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最小间隔</label>
                            <div class="col-md-4">
                                <input type="text" id="min_time" class=" form-control input-circle " value="{{ $res->min_time }}" placeholder="最小间隔">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大间隔</label>
                            <div class="col-md-4">
                                <input type="text" id="max_time" class=" form-control input-circle " value="{{ $res->max_time }}" placeholder="最大间隔">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/horsemessage/index"> 返回上一页
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
            $("#save").click(function(){
                //ajax提交
                var HorseMessageId= $("#HorseMessageId").val();
                var ID= $("#ID").val();
                var content= $("#content").val();
                var min_time= $("#min_time").val();
                var max_time= $("#max_time").val();
                //验证
                if(ID==''){
                    alert('广播ID不能为空,请检查');
                    return false;
                }
                if(isNaN(ID)){
                    alert('广播ID必须为数字');
                    return false;
                }
                if(isNaN(min_time)){
                    alert('最小间隔必须为数字');
                    return false;
                }
                if(isNaN(max_time)){
                    alert('最大间隔必须为数字');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/horsemessage/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',HorseMessageId:HorseMessageId,ID:ID,content:content,min_time:min_time,max_time:max_time},
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