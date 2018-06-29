<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">修改破产补助方案</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="bankruptcy_id" type="hidden" value="{{ $data->bankruptcy_id }}">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">方案名称</label>
                    <div class="col-md-4">
                        <input name="bankruptcy_name" type="text" class="form-control" placeholder="Enter text" value="{{ $data->bankruptcy_name }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">发放条件</label>
                    <div class="col-md-4">
                        <input name="below" type="text" class="form-control" placeholder="Enter text" value="{{ $data->below }}">
                        <span class="help-block">金币低于该值时发放</span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group" >
                    <label class="col-md-3 control-label">补助次数</label>
                    <div class="col-md-4">
                        <input name="number" type="text" class="form-control" placeholder="Enter text" value="{{ $data->number }}">
                        <span class="help-block"></span>
                    </div>
                    {{--<div class="col-md-4" id="bankc">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-3">--}}
                                {{--<select class="form-control" id="frequency">--}}
                                    {{--@foreach($frequency as $key=>$v)--}}
                                    {{--<option value="{{ $key }}">{{ $v }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3">--}}
                                {{--<select class="form-control" id="type">--}}
                                    {{--@foreach($type as $key=>$v)--}}
                                    {{--<option value="{{$key}}">{{ $v }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3">--}}
                                {{--<input type="text" placeholder="" class="form-control" id="num">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3">--}}
                                {{--<a href="javascript:;" class="btn btn-danger">--}}
                                    {{--<i class="fa fa-save"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@foreach(json_decode($data->items) as $key=>$val)--}}
                            {{--<div id="{{ $key }}">--}}
                                {{--<label class=\"control-label\">&nbsp;</label>--}}
                                {{--<div class="row rows" data="{{ json_encode($val) }}">--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--{{ $frequency[$val->frequency] }}--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--{{ $type[$val->type] }}--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--{{ $val->num }}--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--<a href="javascript:;" key="{{ $key }}" class="btn btn-default">--}}
                                            {{--<i class="fa fa-close"></i>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">补助金额</label>
                    <div class="col-md-4">
                        <input name="amount" type="text" class="form-control" placeholder="Enter text" value="{{ $data->amount }}">
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">状态</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<select class="form-control" name="status">--}}
                            {{--<option value="0">关闭</option>--}}
                            {{--<option value="1">开启</option>--}}
                        {{--</select>--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">保存</button>
                        <button type="button" class="btn default">重置</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
<script type="text/javascript">
    $(function(){
//        var items=[];
//        $(".rows").each(function () {
//            items.push(JSON.parse($(this).attr("data")));
//        });
        $("#sub").click(function(){
//            var json={
//                _token:$("input[name='_token']").val(),
//                bankruptcy_id:$("input[name='bankruptcy_id']").val(),
//                bankruptcy_name:$("input[name='bankruptcy_name']").val(),
//                below:$("input[name='below']").val(),
//                items:JSON.stringify(items),
//                status:$("select[name='status'] option:selected").val()
//            };
            $.ajax({
                type:"post",
                url:"/bankruptcy/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/bankruptcy/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
//        $(".btn-danger").click(function () {
//            if($(this).parents().parents().find("#num").val()==""){
//                alert("请输入数量");
//                return false;
//            }
//            var json={
//                frequency:$(this).parents().parents().find("#frequency option:selected").val(),
//                type:$(this).parents().parents().find("#type option:selected").val(),
//                num:$(this).parents().parents().find("#num").val()
//            };
//            var frequencytext=$(this).parents().parents().find("#frequency option:selected").text();
//            var typetext=$(this).parents().parents().find("#type option:selected").text();
//            items.push(json);
//            $("#bankc").append("<div id=\""+(items.length-1)+"\"><label class=\"control-label\">&nbsp;</label><div class=\"row\"><div class=\"col-md-3\">"+frequencytext+"</div><div class=\"col-md-3\">"+typetext+"</div><div class=\"col-md-3\">"+json.num+"</div><div class=\"col-md-3\"><a href=\"javascript:;\" key=\""+(items.length-1)+"\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i></a></div></div></div>");
//            $(".btn-default").click(function () {
//                var key=$(this).attr("key");
//                items.splice(key,1);
//                $("#"+key).remove();
//            });
//        });
//
//        $(".btn-default").click(function () {
//            var key=$(this).attr("key");
//            items.splice(key,1);
//            $("#"+key).remove();
//        });
    });
</script>

