<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">修改更新版本</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="release_id" type="hidden" value="{{ $data->release_id }}">
            <input name="version_id" type="hidden" value="{{ $data->version_id }}">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">允许更新版本</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="allow_version" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->allow_version }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">允许更新渠道</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="allow_channel" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->allow_channel }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">不允许更新版本</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="deny_version" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->deny_version }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">不允许更新渠道</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="deny_channel" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->deny_channel }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新时间</label>
                    <div class="col-md-4">
                        <input name="release_time" id="starttime" type="text" class="form-control" data-date-format="yyyy-mm-dd hh:ii" value="{{ $data->release_time }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新版本号</label>
                    <div class="col-md-4">
                        <input name="version" type="text" class="form-control" placeholder="Enter text" value="{{ $data->version }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新方式</label>
                    <div class="col-md-4">
                        <select class="form-control" name="update_type" id="update_type">
                            <option value="0" @if($data->update_type==0) selected @endif>apk更新</option>
                            <option value="1" @if($data->update_type==1) selected @endif>热更</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body apkupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新说明</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="description" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->description }}</textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body hotupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新模块</label>
                    <div class="col-md-4">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio_-1" name="game_id" class="md-check" value="-1" @if('-1'==$data->game_id) checked="true" @endif>
                                <label for="radio_-1">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> 大厅 </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="radio_1" name="game_id" class="md-check" value="1" @if('1'==$data->game_id) checked="true" @endif>
                                <label for="radio_1">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>拼三张</label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="radio_200000" name="game_id" class="md-check" value="200000" @if('200000'==$data->game_id) checked="true" @endif>
                                <label for="radio_200000">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> 虎豹大战 </label>
                            </div>
                        </div>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body hotupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">游戏编号</label>
                    <div class="col-md-4">
                        <input name="game_code" type="text" class="form-control" placeholder="Enter text" value="{{ $data->game_code }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>



            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新类型</label>
                    <div class="col-md-4">
                        <select class="form-control" name="is_force">
                            <option value="1" @if($data->is_force==1) selected @endif>强更</option>
                            <option value="0" @if($data->is_force==0) selected @endif>非强更</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body apkupdate">
                <div class="form-group" >
                    <label class="col-md-3 control-label">更新补偿方案</label>
                    <div class="col-md-4" id="bankc">
                        <div class="row">
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
                            <input type="hidden" name="allowance">
                        </div>
                        <div class="bankc">
                            @foreach(json_decode($data->allowance??'{}') as $key=>$val)
                                <div id="{{ $key }}">
                                    <label class=\"control-label\">&nbsp;</label>
                                    <div class="row rows" data="{{ json_encode($val) }}">
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
                        <input type="hidden" name="allowance" value="{{ $data->allowance }}">
                    </div>
                </div>
            </div>
            {{--<div class="form-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-3 control-label">更新补偿json</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<textarea class="form-control" name="allowance" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;">{{ $data->allowance }}</textarea>--}}
                        {{--<span class="help-block">  </span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新资源地址</label>
                    <div class="col-md-4">
                        <input name="update_url" type="text" class="form-control" placeholder="Enter text" value="{{ $data->update_url }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body apkupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新包大小</label>
                    <div class="col-md-4">
                        <input name="size" type="text" class="form-control" placeholder="Enter text" value="{{ $data->size }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body hotupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新描述文件</label>
                    <div class="col-md-4">
                        <input name="version_manifest" type="text" class="form-control" placeholder="Enter text" value="{{ $data->version_manifest }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>



            <div class="form-body hotupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">工程描述文件地址</label>
                    <div class="col-md-4">
                        <input name="manifest_url" type="text" class="form-control" placeholder="Enter text" value="{{ $data->manifest_url }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>


            <div class="form-body hotupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新检索目录</label>
                    <div class="col-md-4">
                        <input name="search_path" type="text" class="form-control" placeholder="Enter text"  value="{{ $data->search_path }}">
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
        <input type="hidden" name="types" value="{{ json_encode($type) }}">
    </div>
</div>
<script type="text/javascript">
    $(function(){
        if($("#update_type").val()==0){
            $(".apkupdate").show();
        }else{
            $(".apkupdate").hide();
        }

        var items=[];
        var types=JSON.parse($("input[name='types']").val());
        $(".rows").each(function () {
            items.push(JSON.parse($(this).attr("data")));
        });

        $("#sub").click(function(){
            console.log($('#myform').serialize());
            $.ajax({
                type:"post",
                url:"/gameupdata/postdata",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/gameupdata/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
        console.log($("#update_type").val());
        if($("#update_type").val()==0){
            $(".hotupdate").hide();
        }else if($("#update_type").val()==1){
            $(".hotupdate").show();
        }

        $('#starttime').datetimepicker();
        var strs1="http://resource.suit.wang/packages/psz/versions/gamebm";
        var strs2="http://resource.suit.wang/packages/psz/versions/gamebm/version_dev.manifest";
        var strs3="http://resource.suit.wang/packages/psz/versions/gamebm/project_dev.manifest";
        var strs4='["src/","src/","src/game/","src/Lobby/","src/Lobby/src/","src/Lobby/res/"]';

        var changestrs1="";
        var changestrs2="";
        var changestrs3="";
        $("input[name='version']").change(function(){
            var v=$(this).val();
            strs1=strs1.replace("versions",v);
            strs2=strs2.replace("versions",v);
            strs3=strs3.replace("versions",v);
            $("input[name='update_url']").val(strs1);
            $("input[name='version_manifest']").val(strs2);
            $("input[name='manifest_url']").val(strs3);
            $("input[name='search_path']").val(strs4);
        });
        $("#update_type").change(function(){
            var update_type=$(this).val();
            if(update_type==0){
                $(".hotupdate").hide();
                $(".apkupdate").show();
                $("input[name='update_url']").val("");
                $("input[name='version_manifest']").val("");
                $("input[name='manifest_url']").val("");
                $("input[name='search_path']").val("");
            }else if(update_type==1){
                $(".hotupdate").show();
                $(".apkupdate").hide();
                $("input[name='update_url']").val(strs1);
                $("input[name='version_manifest']").val(strs2);
                $("input[name='manifest_url']").val(strs3);
                $("input[name='search_path']").val(strs4);
            }
        });
        $("input[name='game_id']").change(function(){
            var v=$(this).val();
            var bh="";
            if(v==-1){
                bh="Lobby";
            }else if(v==1001){
                bh="niuniu";
            }else if(v==1002){
                bh="brnn";
            }
            changestrs1=strs1.replace("gamebm",bh);
            changestrs2=strs2.replace("gamebm",bh);
            changestrs3=strs3.replace("gamebm",bh);

            $("input[name='game_code']").val(bh);

            $("input[name='update_url']").val(changestrs1);
            $("input[name='version_manifest']").val(changestrs2);
            $("input[name='manifest_url']").val(changestrs3);
            $("input[name='search_path']").val(strs4);
        });

        $(".btn-danger").click(function () {
            if($(this).parents().parents().find("#num").val()==""){
                alert("请输入数量");
                return false;
            }
            var json={
                name:$(this).parents().parents().find("#type option:selected").text(),
                type:$(this).parents().parents().find("#type option:selected").val(),
                num:$(this).parents().parents().find("#num").val()
            };
            var typetext=$(this).parents().parents().find("#type option:selected").text();
            items.push(json);
            $("#bankc").append("<div id=\""+(items.length-1)+"\"><label class=\"control-label\">&nbsp;</label><div class=\"row\"><div class=\"col-md-3\">"+typetext+"</div><div class=\"col-md-3\">"+json.num+"</div><div class=\"col-md-3\"><a href=\"javascript:;\" key=\""+(items.length-1)+"\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i></a></div></div></div>");
            $("input[name='allowance']").val(JSON.stringify(items));
            $(".btn-default").click(function () {
                var key=$(this).attr("key");
                items.splice(key,1);
                $("#"+key).remove();
                $("input[name='allowance']").val(JSON.stringify(items));
            });
        });

        $(".btn-default").click(function () {
            var key=$(this).attr("key");
            items.splice(key,1);
            $("#"+key).remove();
            $("input[name='allowance']").val(JSON.stringify(items));
        });
    });
</script>

