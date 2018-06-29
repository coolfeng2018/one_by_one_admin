
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>任务管理修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " value="{{ $res->id }}" placeholder="任务id">
                                <input type="hidden" id="TaskId" class="form-control input-circle" value="{{$res->TaskId}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务类型</label>
                            <div class="col-md-4">
                                <select id="type" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="1" @if('1'==$res->type) selected @endif>日常任务</option>
                                    <option value="2" @if('2'==$res->type) selected @endif>周常任务</option>
                                    <option value="3" @if('3'==$res->type) selected @endif>月常任务</option>
                                    <option value="4" @if('4'==$res->type) selected @endif>每日首次分享</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">参数</label>
                            <div class="col-md-4">
                                <input type="text" id="param" class=" form-control input-circle " value="{{ $res->param }}" placeholder="参数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏类型</label>
                            <div class="col-md-4">
                                <select id="game_type" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    @foreach($datagame as $v)
                                        <option value="{{ $v->game_type }}" @if($v->game_type==$res->game_type) selected @endif>{{ $v->game_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">周期</label>
                            <div class="col-md-4">
                                <select id="cycle" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="1" @if('1'==$res->cycle) selected @endif>对局数</option>
                                    <option value="2" @if('2'==$res->cycle) selected @endif>赢局数</option>
                                    <option value="3" @if('3'==$res->cycle) selected @endif>拿到指定牌型次数</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">总体进度</label>
                            <div class="col-md-4">
                                <input type="text" id="process" class=" form-control input-circle " value="{{ $res->process }}" placeholder="总体进度">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class=" form-control input-circle " value="{{ $res->name }}" placeholder="任务名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">奖励列表</label>
                            <div class="col-md-9">
                                    <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list">
                                            @foreach(json_decode($res->award_list,true) as $v)
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">奖励ID</label>
                                                    <input type="text" name="award_list_id" placeholder="eg:100" class="form-control award_list_id" value=" {{ $v['id']}}"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">奖励数量</label>
                                                    <input type="text" name="award_list_count" placeholder="eg:100" class="form-control award_list_count" value=" {{ $v['count']}}"/>
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
                            <label class="col-md-3 control-label">下一个任务id</label>
                            <div class="col-md-4">
                                <input type="text" id="next_id" class=" form-control input-circle " value="{{ $res->next_id }}" placeholder="下一个任务id">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/task/index"> 返回上一页
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
                var TaskId= $("#TaskId").val();
                var id= $("#id").val();
                var type= $("#type").val();
                var param= $("#param").val();
                var game_type= $("#game_type").val();
                var cycle= $("#cycle").val();
                var data_process= $("#process").val();
                var award_list= $("#award_list").val();
                var next_id= $("#next_id").val();
                var name= $("#name").val();
                //验证
                if(id==''){
                    alert('任务id不能为空,请检查');
                    return false;
                }
                if(game_type==''){
                    alert('请选择游戏类型');
                    return false;
                }
                if(id=='' || isNaN(id)){
                    alert('任务id必须为数字');
                    return false;
                }
                var json=new Array;
                $("#list .row").each(function(i,item){
                    //获取奖励ID，数量
                    award_list_id=$(item).find(".award_list_id").val();
                    award_list_count=$(item).find(".award_list_count").val();
                    // console.log(award_list_id);
                    // console.log(award_list_count);
                    //判定是否未空
                    if(typeof(award_list_id)==""){
                        alert("奖励id不能为空");
                        return false;
                    }
                    if(award_list_count==''){
                        alert("奖励数量不能为空,如需要请置零");
                        return false;
                    }
                    //组字串
                    mystr={id:parseInt(award_list_id),count:parseInt(award_list_count)};
                    json.push(mystr);
                });
                var award=JSON.stringify(json);
              // console.log(award);
                $.ajax( {
                    type : "post",
                    url : "/task/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',TaskId:TaskId,id:id,type:type,param:param,game_type:game_type,cycle:cycle,process:data_process,award_list:award,next_id:next_id,name:name},
                    success : function(data) {
                        if(data.status){
                            alert('添加成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('添加失败');
                        }
                    }
                });
            });
        })
    </script>