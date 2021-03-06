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
                </pre>
            </div>
        </div>
        <!-- end加载内容-->
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 任务设置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/task/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                           @if(isset($sntcfg_btn) && !empty($sntcfg_btn))
                            <div class="btn-group">
                             	<!-- <a class="btn btn-xs" href=""> -->
                                <button id="sntcfg" class="btn sbold red" data-snt="{{$sntcfg_btn}}" > 
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
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table" class="table table-striped table-bordered table-hover table-checkable order-column" style="word-break:break-all; word-wrap:break-all;table-layout:fixed">
                    <thead>
                    <tr>
                        <th> 任务ID </th>
                        <th> 任务类型 </th>
                        <th> 参数 </th>
                        <th> 游戏类型 </th>
                        <th> 周期 </th>
                        <th> 总体进度 </th>
                        <th> 任务名称 </th>
                        <th> 奖励列表 </th>
                        <th> 下一个任务id </th>
                        <th width="130px"> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="id" id="server_id">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="id" id="customer_id">客户端 </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="type" id="server_type">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="type" id="customer_type">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="param" id="server_param">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="param" id="customer_param">客户端 </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="game_type" id="server_game_type">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="game_type" id="customer_game_type">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="cycle" id="server_cycle">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="cycle" id="customer_cycle">客户端 </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="process" id="server_process">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="process" id="customer_process">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="name" id="server_name">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="name" id="customer_name">客户端 </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="award_list" id="server_award_list">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="award_list" id="customer_award_list">客户端 
                        </th>

                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="next_id" id="server_next_id">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="next_id" id="customer_next_id">客户端 
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
                                <td>{{ $resources->id }}</td>
                                <td>
                                        @if($resources->type==1)
                                            日常任务
                                        @elseif($resources->type==2)
                                            周常任务
                                        @elseif($resources->type==3)
                                            月常任务
                                        @elseif($resources->type==4)
                                            每日首次分享
                                        @else
                                            {{ $resources->type }}
                                        @endif
                                </td>
                                <td>{{ $resources->param }}</td>
                                <td>{{ $resources->game_name }}</td>
                                <td>
                                    @if($resources->cycle==1)
                                        对局数
                                    @elseif($resources->cycle==2)
                                        赢局数
                                    @elseif($resources->cycle==3)
                                        拿到指定牌型次数
                                    @endif
                                </td>
                                <td>{{ $resources->process }}</td>
                                <td>{{ $resources->name }}</td>
                                <td>
                                    <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->TaskId }}">奖励列表</button>
                                        <div class="modal fade" id="myModal_{{ $resources->TaskId }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">奖励列表</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    @if(count(json_decode($resources->award_list,true))>=1)
                                                        @foreach(json_decode($resources->award_list,true) as $k=>$v)
                                                            <p>[{{ $k+1 }}]奖励ID:{{ $v['id'] }}
                                                            奖励ID:{{ $v['count'] }}</p>
                                                        @endforeach
                                                    @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <td>{{ $resources->next_id }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/task/edit?TaskId={{ $resources->TaskId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/task/delete?TaskId={{ $resources->TaskId }}"> 删除
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
    var href="/task/index?";
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#lua_content").html();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/task/lua",
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
        url = '/task/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/task/lua?type=customer&select='+select+'&type=customer';
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
    	var succesurl = '/task/index';
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

