<style>
#log_window {
    width:700px;
    height:500px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
    position: absolute;
    z-index:3;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display:none;
    overflow: scroll;
}
#table a{
    display: inline-block;
    margin-top: 5px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <!-- start加载内容-->
        <div class="portlet light bordered" id="log_window">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 确认数据 </span>
                    <button id="proConfig" class="btn btn-circle blue-madison">发送api</button>
                    <button class="btn btn-circle green-madison" onclick="cancel_shield()"> 关闭
                        <i class="fa fa-reply"></i>
                    </button>
                </div>
            </div>
            <div class="portlet-body">
                <pre>                     
                    <div id="lua_content"></div>
                    <input type="hidden" id="request_lua" value="">
                </pre>
            </div>
        </div>
        <!-- end加载内容-->
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 好友房配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/friendroomdata/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            @if(isset($sntcfg_btn) && !empty($sntcfg_btn))
                            <div class="btn-group">
                             	<!-- <a class="btn btn-xs" href=""> -->
                                <button id="sntcfg" class="btn sbold red"  > 
                                    <!-- <i class="fa fa-plus"></i> --> 发送服务器配置
                                </button>
                                <!-- </a> -->
                            </div>
                          	@endif
                        </div>
                        <div class="row">
                            <div class="  input-inline ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
                <table id="table" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <thead>
                    <tr>
                        <th width="160px"> 场次 </th>
                        <th width="160px"> 场次名称 </th>
                        <th width="160px"> 是否俱乐部玩法 </th>
                        <th width="160px"> 消耗货币类型 </th>
                        <th width="160px"> 房主支付 </th>
                        <th width="160px"> AA消耗 </th>
                        <th width="160px"> 最大局数 </th>
                        <th width="160px"> 游戏人数 </th>
                        <th width="160px"> 最小底分 </th>
                        <th width="160px"> 最大底分 </th>
                        <th width="160px"> 白名单最小底分 </th>
                        <th width="160px"> 白名单最大底分 </th>
                        <th width="160px"> 单注最小倍数 </th>
                        <th width="160px"> 单注最大倍数 </th>
                        <th width="160px"> 最大可比轮数 </th>
                        <th width="160px"> 可比轮数 </th>
                        <th width="160px"> 最大可看轮数 </th>
                        <th width="160px"> 最大携带 </th>
                        <th width="160px"> 白名单 </th>
                        <th width="160px"> 台费配置系数 </th>
                        <th width="130px"> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="table_type" id="server_table_type">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="table_type" id="customer_table_type">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="name" id="server_name">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="name" id="customer_name">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="is_club" id="server_is_club">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="is_club" id="customer_is_club">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="cost_type" id="server_cost_type">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="cost_type" id="customer_cost_type">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="cost" id="server_cost">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="cost" id="customer_cost">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="aa_cost" id="server_aa_cost">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="aa_cost" id="customer_aa_cost">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_count" id="server_max_count">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_count" id="customer_max_count">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="play_num" id="server_play_num">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="play_num" id="customer_play_num">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="min_dizhu" id="server_min_dizhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="min_dizhu" id="customer_min_dizhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_dizhu" id="server_max_dizhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_dizhu" id="customer_max_dizhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="min_white_dizhu" id="server_min_white_dizhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="min_white_dizhu" id="customer_min_white_dizhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_white_dizhu" id="server_max_white_dizhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_white_dizhu" id="customer_max_white_dizhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="min_ration" id="server_min_ration">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="min_ration" id="customer_min_ration">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_ration" id="server_max_ration">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_ration" id="customer_max_ration">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="comparable_bet_round" id="server_comparable_bet_round">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="comparable_bet_round" id="customer_comparable_bet_round">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_bet_round" id="server_max_bet_round">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_bet_round" id="customer_max_bet_round">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_look_round" id="server_max_look_round">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_look_round" id="customer_max_look_round">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_need_money" id="server_max_need_money">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_need_money" id="customer_max_need_money">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="white_list" id="server_white_list">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="white_list" id="customer_white_list">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="ration" id="server_ration">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="ration" id="customer_ration">客户端 
                        </th>
                        <th>  
                            <a  style="table-layout:fixed" href="#" onclick="verify('customer')" class=" btn sbold blue" >转Lua(客户端)</a>
                            <a  style="table-layout:fixed" href="#" onclick="verify('server')" class=" btn sbold yellow" >转Lua(服务端)</a>
                            <input type="hidden" id="check_server_data" name="check_server_data" value="{{$checkServerData}}" />
                            <input type="hidden" id="check_customer_data" name="check_customer_data" value="{{$checkCustomerData}}" />
                        </th>
                    </thead>
                    <tbody>
                    <div>

                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>
                                    {{ $resources->table_type }}
                                </td>
                                <td>{{ $resources->name }}</td>
                                <td>
                                    @if($resources->is_club==1)
                                        true
                                    @else
                                        false
                                    @endif
                                </td>
                                <td>{{ $resources->cost_type }}</td>
                                <td>{{ $resources->cost }}</td>
                                <td>{{ $resources->aa_cost }}</td>
                                <td>{{ $resources->max_count }}</td>
                                <td>{{ $resources->play_num }}</td>
                                <td>{{ $resources->min_dizhu }}</td>
                                <td>{{ $resources->max_dizhu }}</td>
                                <td>
                                    {{ $resources->min_white_dizhu }}
                                </td>
                                <td>
                                    {{ $resources->max_white_dizhu }}
                                </td>
                                <td>
                                    {{ $resources->min_ration }}
                                </td>
                                <td>
                                    {{ $resources->max_ration }}
                                </td>
                                <td>
                                    {{ $resources->comparable_bet_round }}
                                </td>
                                <td>
                                    {{ $resources->max_bet_round }}
                                </td>
                                <td>
                                    {{ $resources->max_look_round }}
                                </td>
                                <td>
                                    {{ $resources->max_need_money }}
                                </td>
                                <td>
                                    {{ $resources->white_list }}
                                </td>
                                <td>
                                    {{ $resources->ration }}
                                </td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/friendroomdata/edit?FriendRoomdataId={{ $resources->FriendRoomdataId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/friendroomdata/delete?FriendRoomdataId={{ $resources->FriendRoomdataId }}"> 删除
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </div>
                    {!! $res->links() !!}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>



<script>
$(function(){
    var href="/friendroomdata/index?";
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#request_lua").val();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/friendroomdata/lua",
            dataType : 'json',
            data : lua,
            success : function(data) {
                if(data.status){
                    $("#Add").show();
                    alert(data.msg);
                }else{
                    alert('发布失败');
                }
            }
        });
    });
    //复选框选择 拿到分隔符数据，转成数组，数组
    var checkserverData = <?php echo $recordData->server_record?$recordData->server_record:"''" ?>;
    var checkcustomerData = <?php echo $recordData->customer_record?$recordData->customer_record:"''" ?>;
    $(document).ready(function( ){ 
        $.each(checkserverData,function(index,value){
            $("#"+value).attr("checked",true);
        });
        $.each(checkcustomerData,function(index,value){
            $("#"+value).attr("checked",true);
        });
    })
});

//遍历复选框
function check_s(){
    var s_checkboxes = $("input[name='check_s']");
    var str = [];
    for(i=0;i<s_checkboxes.length;i++){
        if(s_checkboxes[i].checked){
            str.push(s_checkboxes[i].value);
        }
    }
    $("#check_server_data").val(str);
}
function check_c(){
    var s_checkboxes = $("input[name='check_c']");
    var str = [];
    for(i=0;i<s_checkboxes.length;i++){
        if(s_checkboxes[i].checked){
            str.push(s_checkboxes[i].value);
        }
    }
    $("#check_customer_data").val(str);
}
//检查字段与个数
function verify(type){
    var slength = $("input[name='check_s']:checked").length;
    var clength = $("input[name='check_c']:checked").length;
    if(type=='server'){
        var select = $("#check_server_data").val();
        if(slength==''){
            alert('请至少选择一项');return false;
        }
        url = '/friendroomdata/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/friendroomdata/lua?type=customer&select='+select+'&type=customer';
    }
    //异步加载，返回数据拼装
    $.ajax( {
        type : "get",
        url : url,
        dataType : 'json',
        data : {'_token':'{{csrf_token()}}'},
        success : function(data) {
            if(data.status==1){
                $("#lua_content").html(data.lua_data);
                $("#request_lua").val(data.lua_data);
                $("#log_window").show();
            }else{
                alert('发送失败');
            }
        }
    });
}

//关闭窗体
function cancel_shield(){
    $("#log_window").hide();
}
</script>
@if(isset($sntcfg_btn) && !empty($sntcfg_btn))
<script type="text/javascript">
$(function(){
    $("#sntcfg").click(function(){
    	var succesurl = '/friendroomdata/index';
    	var select = $("#check_server_data").val();
    	swal({
    	  title: "你确定要发送服务器配置?",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "确定发送！",
    	  cancelButtonText: "取消！~",
    	  confirmButtonClass: "btn-danger",
    	  closeOnConfirm: false,
    	  showLoaderOnConfirm: true
    	}, function () {
     	  setTimeout(function () {
      		 $.ajax( {
  	        	async: false,
  	        	cache: false,
  	            type : "get",
  	            url : "/setcfg/{{$sntcfg_btn}}/sntcfg?select="+select,	            
  	            dataType : 'json',
  	            data : {'_token':'{{csrf_token()}}'},
  	            success : function(data) {
  	                if(data.status==0){ 
  	                	swal("Success", data.msg, "success");
  	                	Layout.loadAjaxContent(succesurl);
  	                }else{
  	                	swal("Fail",data.msg);
  	                }
  	            }, 
  	            error: function(request) {
  	            	swal(request);
  	            }
  	        });
     	  }, 100);
    	});
    });
});
</script> 
@endif 
