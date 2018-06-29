<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">服务器配置</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="subtype" value="edit">
            <input type="hidden" name="games_server_id" value="{{ $data->games_server_id }}">
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">SERVER_ID</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_id" type="text" class="form-control" placeholder="Enter text"  value="{{ $data->server_id }}">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">服务器名称</label>
                    <div class="col-md-4">
                        <input name="server_name" type="text" class="form-control" placeholder="Enter text" value="{{ $data->server_name }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器ip</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_ip" type="text" class="form-control" placeholder="Enter text" value="{{ $data->server_ip }}">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器端口</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="server_port" type="text" class="form-control" placeholder="Enter text" value="{{ $data->server_port }}">--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">服务器承载人数</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input name="online_quantity" type="text" class="form-control" placeholder="Enter text" value="{{ $data->online_quantity }}">--}}
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
                                    <input type="radio" id="checkbox2_{{ $v->game_id }}" name="kind_id" value="{{ $v->kind_id }}" @if($data->kind_id==$v->kind_id&&$v->scene_id==1)checked="checked"@endif class="md-radiobtn ganme" game-type="{{ $v->scene_id }}">
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
            <input type="hidden" id="level" value="{{ $data->deskset_level }}">
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
            var level=$("#level").val();
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
        if($("input[name='kind_id'][checked='checked']").attr("game-type")==1){
            var kind_id=$("input[name='kind_id'][checked='checked']").val();
            var level=$("#level").val();
            var str="";
            $.get("/gameserver/find/deskset?id="+kind_id, function(result){
                for(v in result){
                    levelstr=level==result[v].level?"selected='selected'":"";
//                         str+="<div class=\"md-checkbox\"><input type=\"checkbox\" id=\"checkbox1"+result[v].deskset_id+"\" name=\"game_id\" class=\"md-check\" value=\"\">"
//                              +"<label for=\"checkbox1"+result[v].deskset_id+"\"><span class=\"inc\"></span><span class=\"check\"></span><span class=\"box\"></span>"+result[v].deskset_name+"</label></div>"
                    str+="<option value=\""+result[v].level+"\" "+levelstr+">"+result[v].deskset_name+"</option>";
                }
                $("#desksets").html("<select class=\"form-control\" name=\"level\">"+str+"</select>");
                $("#pdesksets").show();
            });
        }else{
            $("#pdesksets").hide();
        }

    });
</script>

