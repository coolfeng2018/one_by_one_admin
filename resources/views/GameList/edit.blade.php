
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>大厅列表修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">大厅位置排序</label>
                            <div class="col-md-4">
                                <input type="hidden" id="GameListId" class=" form-control input-circle " value="{{ $res->GameListId }}" placeholder="">
                                <input type="text" id="id" class=" form-control input-circle " value="{{ $res->id }}" placeholder="大厅位置排序">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏</label>
                            <div class="col-md-4">
                                <select id="game_type_name" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    @foreach($datagame as $v)
                                        <option value="{{ $v->game_type }}" @if($v->game_type==$res->game_type) selected  @endif>
                                            {{ $v->game_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">显示图标</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="{{config('suit.ImgRemoteUrl').$res->icon}}" >
                                <input type="hidden"  id="icon" class="form-control input-circle" value="{{$res->icon}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">类型</label>
                            <div class="col-md-4">
                                <select id="shown_type" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="1" @if($res->shown_type==1) selected @endif>主界面</option>
                                    <option value="2" @if($res->shown_type==2) selected @endif>私人房</option>
                                    <option value="3" @if($res->shown_type==3) selected @endif>快速开始</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="0" @if($res->status==0) selected @endif>正常</option>
                                    <option value="1" @if($res->status==1) selected @endif>敬请期待</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/gamelist/index"> 返回上一页
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
            //file
            $("input[name='file']").change(function(){
                var token=$("input[name='_token']").val();
                var file = $(this)[0].files[0];
                var obj=new FormData();
                obj.append("_token", token);
                obj.append("file", file);
                $.ajax({
                    url: "/imguploads",
                    type: "POST",
                    data: obj,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#imgUrl").attr("src", data.RemoteDir+data.msg);
                        $("#icon").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var GameListId= $("#GameListId").val();
                var id= $("#id").val();
                var game_type= $("#game_type_name").val();
                var name= $("#game_type_name").find("option:selected").text();
                var icon= $("#icon").val();
                var shown_type= $("#shown_type").val();
                var status= $("#status").val();
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
                $.ajax( {
                    type : "post",
                    url : "/gamelist/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',GameListId:GameListId,id:id,game_type:game_type,name:name,name:name,icon:icon,shown_type:shown_type,status:status},
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