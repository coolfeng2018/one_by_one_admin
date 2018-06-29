
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>任务修改
                </div>
            </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="form-body">
                            @foreach ($res['results'] as $resources)
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id" class="form-control input-circle" value="{{$resources->TaskId}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">任务描述</label>
                                <div class="col-md-4">
                                    <input type="text" id="name" class="form-control input-circle" value="{{$resources->TaskName}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">游戏类型</label>
                                <div class="col-md-4">

                                    <select id="game" class="form-control input-circle">
                                        @foreach ($res['games'] as $k =>$v)
                                            @if($resources->KindId == $k)
                                            <option value ="{{ $k }}" selected>{{$v}}</option>
                                            @else
                                            <option value ="{{ $k }}" >{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">房间类型</label>
                                <div class="col-md-4">

                                    <select id="scenes" class="form-control input-circle">
                                        @foreach ($res['scenes'] as $k =>$v)
                                            @if($resources->GameType == $k)
                                                <option value ="{{ $k }}" selected>{{$v}}</option>
                                            @else
                                                <option value ="{{ $k }}" >{{$v}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">场次类型</label>
                                <div class="col-md-4">
                                    <select id="level" class="form-control input-circle">
                                        @foreach ($res['level'] as $key =>$val)
                                            @if($resources->DeskSetLevel == $key)
                                                <option value ="{{ $key }}" selected>{{$val}}</option>
                                            @else
                                                <option value ="{{ $key }}" >{{$val}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">任务类型</label>
                                <div class="col-md-4">
                                    <select id="tag" class="form-control input-circle">
                                            <option value ="1" @if($resources->Tag == 1) selected @endif>日常</option>
                                            {{--<option value ="2" @if($resources->Tag == 2) selected @endif>新手</option>--}}
                                            {{--<option value ="3" @if($resources->Tag == 3) selected @endif>活动</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">任务条件</label>
                                <div class="col-md-4">
                                    <select id="type" class="form-control input-circle">

                                            <option value ="0" @if($resources->Type == 0) selected @endif>总局数</option>
                                            <option value ="1" @if($resources->Type == 1) selected @endif>赢局数</option>
                                            {{--<option value ="2" @if($resources->Type == 2) selected @endif>充值</option>--}}
                                            {{--<option value ="3" @if($resources->Type == 3) selected @endif>牌型</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">次数</label>
                                <div class="col-md-4">
                                    <input type="text" id="number" class="form-control input-circle" value="{{$resources->Count}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">奖励明细</label>
                                <div class="col-md-9">
                                    <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list">
                                            @foreach(json_decode($resources->Award,true) as $v)

                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">STYLE</label>
                                                    <select class="form-control kind" name="kind">
                                                        @foreach ($res['props'] as $key =>$val)
                                                            @if($v['PropsId'] ==$key)
                                                            <option value ="{{ $key }}" selected>{{$val}}</option>
                                                            @else
                                                            <option value ="{{ $key }}" >{{$val}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">NUM</label>
                                                    <input type="text" name="num" placeholder="eg:100" class="form-control num" value=" {{ $v['number']}}"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="control-label">DEL</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                            <i class="fa fa-plus"></i> 增加奖励项</a>
                                        <br>
                                        <br> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">状态</label>
                                <div class="col-md-4">
                                    <select id="status" class="form-control input-circle">
                                        |@if($resources->Status == 1)
                                            <option value ="1" selected>生效</option>
                                            <option value ="2">失效</option>
                                        @else
                                            <option value ="1">生效</option>
                                            <option value ="2" selected>失效</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button id="save" type="button" class="btn btn-circle green">保存</button>
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
            FormRepeater.init();

            $("#save").click(function(){
                var json=new Array;
                $("#list .row").each(function(i,item){
                    //获取道具名称，数量
                    mykey=$(item).find(".kind").find('option:selected').val();
                    myname=$(item).find(".kind").find('option:selected').text();
                    myval=$(item).find(".num").val();
                    //判定是否未空
                    if(typeof(mykey)=="undefined"){
                        alert("奖励类型不能为空");
                        return false;
                    }
                    if(myval==''){
                        alert("奖励数量不能为空,如需要请置零");
                        return false;
                    }
                    //组字串
                    mystr={PropsId:parseInt(mykey),number:parseInt(myval),name:myname};
                    json.push(mystr);
//                console.log($(item).find(".kind").find('option:selected').val());
//                console.log($(item).find(".num").val());
                });
                var award=JSON.stringify(json);
//               console.log(award);
                //ajax提交

                var id= $("#id").val();
                var name= $("#name").val();
                var game= $("#game").val();
                var scenes= $("#scenes").val();
                var level= $("#level").val();
                var tag= $("#tag").val();
                var type= $("#type").val();
                var number= $("#number").val();
                var status= $("#status").val();

                if(name==''){
                    alert('任务描述不能为空');
                    return false;
                }
                if(number=='' || isNaN(number)){
                    alert('次数必须为数字');
                    return false;
                }

                $.ajax( {
                    type : "post",
                    url : "/task/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',id:id,name:name,game:game,scenes:scenes,level:level,tag:tag,type:type,number:number,award:award,status:status},
                    success : function(data) {
                        if(data.status){
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('添加失败');
                        }
                    }
                });
            });




        })
    </script>

