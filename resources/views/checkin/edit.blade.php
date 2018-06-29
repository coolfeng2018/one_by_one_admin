<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">修改签到奖励方案</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="checkin_id" type="hidden" value="{{ $data->checkin_id }}">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">方案名称</label>
                    <div class="col-md-4">
                        <input name="checkin_name" type="text" class="form-control" placeholder="Enter text" value="{{ $data->checkin_name }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group" >
                    <label class="col-md-3 control-label">方案内容</label>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control" id="frequency">
                                    @foreach($frequency as $key=>$v)
                                        <option value="{{ $key }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="type">
                                    @foreach($type as $key=>$v)
                                        <option value="{{$key}}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" placeholder="" class="form-control" id="num">
                            </div>
                            <div class="col-md-3">
                                <a href="javascript:;" class="btn btn-danger">
                                    <i class="fa fa-save"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bankc">
                            @foreach(json_decode($data->items) as $key=>$val)
                                <div id="{{ $key }}">
                                    <label class=\"control-label\">&nbsp;</label>
                                    <div class="row rows" data="{{ json_encode($val) }}">
                                        <div class="col-md-3">
                                            {{ $frequency[$val->frequency] }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $type[$val->type] }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $val->num }}
                                        </div>
                                        <div class="col-md-3">
                                            <a href="javascript:;" key="{{ $key }}" class="btn btn-default">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">状态</label>
                    <div class="col-md-4">
                        <select class="form-control" name="status">
                            <option value="0" @if($data->status==0) selected @endif>关闭</option>
                            <option value="1" @if($data->status==1) selected @endif>开启</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>


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
        <input type="hidden" name="frequencys" value="{{ json_encode($frequency) }}">
        <input type="hidden" name="types" value="{{ json_encode($type) }}">
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var items=[];
        var frequencys=JSON.parse($("input[name='frequencys']").val());
        var types=JSON.parse($("input[name='types']").val());
        $(".rows").each(function () {
            items.push(JSON.parse($(this).attr("data")));
        });
        $("#sub").click(function(){
            var json={
                _token:$("input[name='_token']").val(),
                checkin_id:$("input[name='checkin_id']").val(),
                checkin_name:$("input[name='checkin_name']").val(),
                items:JSON.stringify(items),
                status:$("select[name='status'] option:selected").val()
            };
            $.ajax({
                type:"post",
                url:"/checkin/post",
                data:json,
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/checkin/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
        $(".btn-danger").click(function () {
            if($(this).parents().parents().find("#num").val()==""){
                alert("请输入数量");
                return false;
            }
            var json={
                frequency:parseInt($(this).parents().parents().find("#frequency option:selected").val()),
                type:parseInt($(this).parents().parents().find("#type option:selected").val()),
                num:parseInt($(this).parents().parents().find("#num").val())
            };
            var akey=$(this).parents().parents().find("#frequency option:selected").val();
            items[akey-1]=(json);
            $(".bankc").html("");
            for(var i=0;i<items.length;i++){

                $(".bankc").append("<div id=\""+i+"\"><label class=\"control-label\">&nbsp;</label><div class=\"row\"><div class=\"col-md-3\">"+frequencys[items[i].frequency]+"</div><div class=\"col-md-3\">"+types[items[i].type]+"</div><div class=\"col-md-3\">"+items[i].num+"</div><div class=\"col-md-3\"><a href=\"javascript:;\" key=\""+i+"\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i></a></div></div></div>");
            }
            //$("#bankc").append("<div id=\""+(items.length-1)+"\"><label class=\"control-label\">&nbsp;</label><div class=\"row\"><div class=\"col-md-3\">"+frequencytext+"</div><div class=\"col-md-3\">"+typetext+"</div><div class=\"col-md-3\">"+json.num+"</div><div class=\"col-md-3\"><a href=\"javascript:;\" key=\""+(items.length-1)+"\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i></a></div></div></div>");
            $(".btn-default").click(function () {
                var key=$(this).attr("key");
                items.splice(key,1);
                $("#"+key).remove();
            });
        });

        $(".btn-default").click(function () {
            var key=$(this).attr("key");
            items.splice(key,1);
            console.log(items);
            $("#"+key).remove();
        });
    });
</script>

