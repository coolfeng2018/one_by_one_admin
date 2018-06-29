
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
                                <input type="hidden" id="ValueId" class="form-control input-circle" value="{{$v->ValueId}}">
                            </div>
                        </div>

<!--                         <div class="form-group">
                            <label class="col-md-3 control-label">id类型</label>
                            <div class="col-md-4">
                                <select id="id" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    
                                    @foreach($valuecfg as $key=>$val)
                                    <option value="{{ $k }}" @if($key==$v->id) selected @endif>{{ $val['name'] }}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle "  value="{{$v->id}}">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label">name</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle "  value="{{$valuecfg[$v->id]['name']}}" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">value</label>
                            <div class="col-md-4">
                                <input type="text" id="value" class=" form-control input-circle "  value="{{$v->value}}">
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
        var ValueId= $("#ValueId").val();
        var id= $("#id").val();
        var value= $("#value").val();

        $.ajax( {
            type : "post",
            url : "/gamevalue/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',id:id,value:value,ValueId:ValueId},
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
