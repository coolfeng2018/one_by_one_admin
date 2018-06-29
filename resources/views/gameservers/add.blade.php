<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">添加服务器</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="subtype" value="add">
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">SERVER_ID</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_id" type="text" class="form-control" placeholder="Enter text">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">服务器名称</label>
                    <div class="col-md-4">
                        <input name="server_name" type="text" class="form-control" placeholder="Enter text">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器ip</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_ip" type="text" class="form-control" placeholder="Enter text">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器端口</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_port" type="text" class="form-control" placeholder="Enter text">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器承载人数</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="online_quantity" type="text" class="form-control" placeholder="Enter text">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">游戏</label>
                    <div class="col-md-4">
                        <div class="md-checkbox-list">
                            @foreach($games as $v)
                                <div class="md-radio">
                                    <input type="radio" id="checkbox2_{{ $v->game_id }}" name="kind_id" value="{{ $v->kind_id }}" class="md-radiobtn ganme" game-type="{{ $v->scene_id }}">
                                    <label for="checkbox2_{{ $v->game_id }}">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ $v->game_name }} ( {{ $v->scene_name }} )</label>
                                </div>
                            @endforeach
                        </div>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body" id="pdesksets" >
                <div class="form-group">
                    <label class="col-md-3 control-label">场次</label>
                    <div class="col-md-4">
                        <div class="md-checkbox-inline" id="desksets">

                        </div>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">添加</button>
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
        $("#sub").click(function(){
            console.log('ok');
            $.ajax({
                type:"post",
                url:"/gameserver/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    console.log(obj);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/gameserver/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
        $(".ganme").change(function () {
            var gametype=$(this).attr("game-type");
            if(gametype=="1"){
                var kind_id=$(this).val();
                var str="";
                $.get("/gameserver/find/deskset?id="+kind_id, function(result){
                     for(v in result){
//                         str+="<div class=\"md-checkbox\"><input type=\"checkbox\" id=\"checkbox1"+result[v].deskset_id+"\" name=\"game_id\" class=\"md-check\" value=\"\">"
//                              +"<label for=\"checkbox1"+result[v].deskset_id+"\"><span class=\"inc\"></span><span class=\"check\"></span><span class=\"box\"></span>"+result[v].deskset_name+"</label></div>"
                         str+="<option value=\""+result[v].level+"\">"+result[v].deskset_name+"</option>";
                     }
                    $("#desksets").html("<select class=\"form-control\" name=\"level\">"+str+"</select>");
                    $("#pdesksets").show();
                });
            }else{
               $("#desksets").html("");
               $("#pdesksets").hide();
            }
        });
        $("#pdesksets").hide();
    });
</script>

