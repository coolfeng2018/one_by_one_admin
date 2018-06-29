
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>修改好友房配置
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">场次</label>
                            <div class="col-md-4">
                                 <select id="ID_name" class=" form-control input-circle input-inline">
                                        <option value=""></option>
                                        <option value="100000" @if($res->table_type==100000) selected @endif>普通炸金花私人房</option>
                                        <option value="100001" @if($res->table_type==100001) selected @endif>俱乐部炸金花私人房</option>
                                        <option value="100002" @if($res->table_type==100002) selected @endif>俱乐部炸金花金币房</option>
                                        <option value="100003" @if($res->table_type==100003) selected @endif>俱乐部炸金花元宝房</option>
                                </select>
                                <input type="hidden" id="FriendRoomdataId" class=" form-control input-circle " value="{{ $res->FriendRoomdataId }}" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">是否俱乐部玩法</label>
                            <div class="col-md-4">
                                <select id="is_club" class=" form-control input-circle input-inline">
                                        <option value="2" @if($res->is_club==2) selected @endif>false</option>
                                        <option value="1" @if($res->is_club==1) selected @endif>true</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">房间内消耗</label>
                            <div class="col-md-4">
                                <input type="text" id="cost_type" class=" form-control input-circle " value="{{ $res->cost_type }}" placeholder="房间内消耗">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">消耗</label>
                            <div class="col-md-4">
                                <input type="text" id="cost" class=" form-control input-circle " value="{{ $res->cost }}" placeholder="消耗">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">AA消耗</label>
                            <div class="col-md-4">
                                <input type="text" id="aa_cost" class=" form-control input-circle " value="{{ $res->aa_cost }}" placeholder="AA消耗">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大局数</label>
                            <div class="col-md-4">
                                <input type="text" id="max_count" class=" form-control input-circle " value="{{ $res->max_count }}" placeholder="最大局数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏人数</label>
                            <div class="col-md-4">
                                <input type="text" id="play_num" class=" form-control input-circle " value="{{ $res->play_num }}" placeholder="游戏人数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最小底分</label>
                            <div class="col-md-4">
                                <input type="text" id="min_dizhu" class=" form-control input-circle " value="{{ $res->min_dizhu }}" placeholder="最小底分">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大底分</label>
                            <div class="col-md-4">
                                <input type="text" id="max_dizhu" class=" form-control input-circle " value="{{ $res->max_dizhu }}" placeholder="最大底分">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">白名单最小底分</label>
                            <div class="col-md-4">
                                <input type="text" id="min_white_dizhu" class=" form-control input-circle " value="{{ $res->min_white_dizhu }}" placeholder="白名单最小底分">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">白名单最大底分</label>
                            <div class="col-md-4">
                                <input type="text" id="max_white_dizhu" class=" form-control input-circle " value="{{ $res->max_white_dizhu }}" placeholder="白名单最大底分">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">单注最小倍数</label>
                            <div class="col-md-4">
                                <input type="text" id="min_ration" class=" form-control input-circle " value="{{ $res->min_ration }}" placeholder="单注最小倍数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">单注最大倍数</label>
                            <div class="col-md-4">
                                <input type="text" id="max_ration" class=" form-control input-circle " value="{{ $res->max_ration }}" placeholder="单注最大倍数">
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
                            <label class="col-md-3 control-label">最大可看轮数</label>
                            <div class="col-md-4">
                                <input type="text" id="max_look_round" class=" form-control input-circle " value="{{ $res->max_look_round }}" placeholder="最大可看轮数">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最大携带</label>
                            <div class="col-md-4">
                                <input type="text" id="max_need_money" class=" form-control input-circle " value="{{ $res->max_need_money }}" placeholder="最大携带">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">白名单</label>
                            <div class="col-md-4">
                                <input type="text" id="white_list" class=" form-control input-circle " value="{{ $res->white_list }}" placeholder="白名单">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">台费配置系数<span style="color: red;font-size: 1px;">(精确到一位小数)</span></label>
                            <div class="col-md-4">
                                <input type="text" id="ration" class=" form-control input-circle " value="{{ $res->ration }}" placeholder="台费配置系数">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/friendroomdata/index"> 返回上一页
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
                var FriendRoomdataId= $("#FriendRoomdataId").val();
                var table_type= $("#ID_name").val();
                var name= $("#ID_name").find("option:selected").text();
                var is_club= $("#is_club").val();
                var cost_type= $("#cost_type").val();
                var cost= $("#cost").val();
                var aa_cost= $("#aa_cost").val();
                var max_count= $("#max_count").val();
                var play_num= $("#play_num").val();
                var min_dizhu= $("#min_dizhu").val();
                var max_dizhu= $("#max_dizhu").val();
                var min_white_dizhu= $("#min_white_dizhu").val();
                var max_white_dizhu= $("#max_white_dizhu").val();
                var min_ration= $("#min_ration").val();
                var max_ration= $("#max_ration").val();
                var comparable_bet_round= $("#comparable_bet_round").val();
                var max_bet_round= $("#max_bet_round").val();
                var max_look_round= $("#max_look_round").val();
                var max_need_money= $("#max_need_money").val();
                var white_list= $("#white_list").val();
                var ration= $("#ration").val();
                //验证
                if(table_type==''){
                    alert('请选择场次,请检查');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/friendroomdata/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',FriendRoomdataId:FriendRoomdataId,table_type:table_type,name:name,is_club:is_club,cost_type:cost_type,cost:cost,aa_cost:aa_cost,max_count:max_count,play_num:play_num,min_dizhu:min_dizhu,max_dizhu:max_dizhu,min_white_dizhu:min_white_dizhu,max_white_dizhu:max_white_dizhu,min_ration:min_ration,max_ration:max_ration,comparable_bet_round:comparable_bet_round,max_bet_round:max_bet_round,max_look_round:max_look_round,max_need_money:max_need_money,white_list:white_list,ration:ration},
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