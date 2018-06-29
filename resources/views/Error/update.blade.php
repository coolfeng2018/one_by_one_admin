
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>错误码修改
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
                                <input type="hidden" id="ErrorCodeId" class="form-control input-circle" value="{{$v->ErrorCodeId}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">错误码id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class="form-control input-circle" value="{{$v->id}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">语句</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class=" form-control input-circle "  value="{{$v->name}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/error/index"> 返回上一页
                                    <i class="fa fa-reply"></i>
                                </button>
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
        var ErrorCodeId= $("#ErrorCodeId").val();
        var id= $("#id").val();
        var name= $("#name").val();

        $.ajax( {
            type : "post",
            url : "/error/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',id:id,name:name,ErrorCodeId:ErrorCodeId},
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
