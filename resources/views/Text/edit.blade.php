
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>文本配置修改
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
                                <input type="hidden" id="TextId" class="form-control input-circle" value="{{$v->TextId}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle "  value="{{$v->id}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">通知消息类型</label>
                            <div class="col-md-4">
                                <select id="type" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="1" @if('1'==$v->type) selected @endif>俱乐部解散</option>
                                    <option value="2" @if('2'==$v->type) selected @endif>提升为俱乐部管理员</option>
                                    <option value="3" @if('3'==$v->type) selected @endif>撤销俱乐部管理员</option>
                                    <option value="4" @if('4'==$v->type) selected @endif>被踢出俱乐部</option>
                                    <option value="5" @if('5'==$v->type) selected @endif>加入俱乐部</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">通知内容</label>
                            <div class="col-md-4">
                                <input type="text" id="content" class=" form-control input-circle "  value="{{$v->content}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/text/index"> 返回上一页
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
        var TextId= $("#TextId").val();
        var id= $("#id").val();
        var type= $("#type").val();
        var content= $("#content").val();

        $.ajax( {
            type : "post",
            url : "/text/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',type:type,content:content,TextId:TextId,id:id},
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
