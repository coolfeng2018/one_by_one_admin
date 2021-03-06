
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>修改房间配置
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                        <input type="hidden" id="RoomdataId" class=" form-control input-circle " value="{{ $res->RoomdataId }}" placeholder="">
                            <label class="col-md-3 control-label">场次ID</label>
                            <div class="col-md-4">
                                <input type="text" id="ID_id" class=" form-control input-circle " value="{{ $res->ID }}" placeholder="场次名称" >
                            </div>
                        </div> 
                       <div class="form-group">
                            <label class="col-md-3 control-label">场次名称</label>
                            <div class="col-md-4">
                                <input type="text" id="ID_name" class=" form-control input-circle " value="{{ $res->name }}" placeholder="场次名称">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 control-label">场次进入最小限制</label>
                            <div class="col-md-4">
                                <input type="text" id="min" class=" form-control input-circle " value="{{ $res->min }}" placeholder="场次进入最小限制">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">场次进入最大限制</label>
                            <div class="col-md-4">
                                <input type="text" id="max" class=" form-control input-circle " value="{{ $res->max }}" placeholder="场次进入最大限制">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">台费</label>
                            <div class="col-md-4">
                                <input type="text" id="cost" class=" form-control input-circle " value="{{ $res->cost }}" placeholder="台费">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">底注</label>
                            <div class="col-md-4">
                                <input type="text" id="dizhu" class=" form-control input-circle " value="{{ $res->dizhu }}" placeholder="底注">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">顶注</label>
                            <div class="col-md-4">
                                <input type="text" id="dingzhu" class=" form-control input-circle " value="{{ $res->dingzhu }}" placeholder="顶注">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大看牌轮数</label>
                            <div class="col-md-4">
                                <input type="text" id="max_look_round" class=" form-control input-circle " value="{{ $res->max_look_round }}" placeholder="最大看牌轮数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大可比轮数</label>
                            <div class="col-md-4">
                                <input type="text" id="comparable_bet_round" class=" form-control input-circle " value="{{ $res->comparable_bet_round }}" placeholder="最大可比轮数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">可比轮数</label>
                            <div class="col-md-4">
                                <input type="text" id="max_bet_round" class=" form-control input-circle " value="{{ $res->max_bet_round }}" placeholder="可比轮数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">底图名字</label>
                            <div class="col-md-4">
                                <input type="text" id="img_bg" class=" form-control input-circle " value="{{ $res->img_bg }}" placeholder="底图名字">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">场次标识图片名字</label>
                            <div class="col-md-4">
                                <input type="text" id="img_icon" class=" form-control input-circle " value="{{ $res->img_icon }}" placeholder="场次标识图片名字">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">抢庄区间配置</label>
                            <div class="col-md-4">
                                <input type="text" id="grab_banker_times" class=" form-control input-circle " value="{{ $res->grab_banker_times }}" placeholder="抢庄区间配置">
                            	<span>格式例如：{"1":"5,10","2":"11,20","3":"21,30","4":"31,40"}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">是否开放机器人</label>
                            <div class="col-md-4">
                                <select id="open_robot" class=" form-control input-circle input-inline">
                                        <option value="2" @if($res->open_robot==2) selected @endif>false</option>
                                        <option value="1" @if($res->open_robot==1) selected @endif>true</option>
                                </select>
                            </div>
                        </div>
<!--                         <div class="form-group">
                            <label class="col-md-3 control-label">机器人类型</label>
                            <div class="col-md-4">
                                <input type="text" id="robot_type" class=" form-control input-circle " value="{{ $res->robot_type }}" placeholder="机器人类型">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">机器人类型</label>
                            <div class="col-md-9">
                            	<select id="robot_type" class=" form-control input-circle input-inline">
                            	@foreach($rtype as $k=>$v)
                                        <option value="{{ $k }}" @if($res->robot_type==$k) selected @endif>{{ $v }}---{{ $k }}</option>
                                @endforeach
                                        
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/roomdata/index"> 返回上一页
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
                        $("#img").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var RoomdataId= $("#RoomdataId").val();
                var ID= $("#ID_id").val();
                var name= $("#ID_name").val();
                var min= $("#min").val();
                var max= $("#max").val();
                var cost= $("#cost").val();
                var dizhu= $("#dizhu").val();
                var dingzhu= $("#dingzhu").val();
                var max_look_round= $("#max_look_round").val();
                var comparable_bet_round= $("#comparable_bet_round").val();
                var max_bet_round= $("#max_bet_round").val();
                var img_bg= $("#img_bg").val();
                var img_icon= $("#img_icon").val();
                var open_robot= $("#open_robot").val();
                var robot_type= $("#robot_type").val();
                var grab_banker_times =$("#grab_banker_times").val();
               // var robot_type= $("option[name='robot_type']:selected").val();
                //验证
                if(ID==''){
                    alert('ID不能为空,请检查');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/roomdata/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',RoomdataId:RoomdataId,ID:ID,name:name,min:min,max:max,cost:cost,dizhu:dizhu,dingzhu:dingzhu,max_look_round:max_look_round,comparable_bet_round:comparable_bet_round,max_bet_round:max_bet_round,img_bg:img_bg,img_icon:img_icon,grab_banker_times:grab_banker_times,open_robot:open_robot,robot_type:robot_type},
                    success : function(data) {
                        if(data.status){
                            alert('修改成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('修改失败');
                        }
                    }
                });
            });
        })
    </script>