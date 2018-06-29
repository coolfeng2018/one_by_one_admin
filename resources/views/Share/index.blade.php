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
                    <span class="caption-subject bold uppercase"> 游戏分享 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/share/add"> 新增
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
                        <th width="160px"> 渠道 </th>
                        <th width="160px"> 标题 </th>
                        <th width="160px"> 描述 </th>
                        <th width="160px"> URL </th>
                        <th width="160px"> 图片地址 </th>
                        <th width="160px"> 分享图片和链接 </th>
                        <th width="160px"> 分享类型 </th>
                        <th width="160px"> 那种分享 </th>
                        <th width="160px"> 任务分享标题 </th>
                        <th width="160px"> 任务分享内容 </th>
                        <th width="160px"> 任务分享链接 </th>
                        <th width="130px"> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="channel" id="server_channel">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="channel" id="customer_channel">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="title" id="server_title">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="title" id="customer_title">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="des" id="server_des">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="des" id="customer_des">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="targetUrl" id="server_targetUrl">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="targetUrl" id="customer_targetUrl">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="shareImg" id="server_shareImg">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="shareImg" id="customer_shareImg">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="sharetype" id="server_sharetype">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="sharetype" id="customer_sharetype">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="sharetab" id="server_sharetab">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="sharetab" id="customer_sharetab">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="task_share_title" id="server_task_share_title">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="task_share_title" id="customer_task_share_title">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="task_share_content" id="server_task_share_content">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="task_share_content" id="customer_task_share_content">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="task_share_url" id="server_task_share_url">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="task_share_url" id="customer_task_share_url">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="img" id="server_img">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="img" id="customer_img">客户端 
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
                                    {{ $resources->channel }}
                                   <!--  <select id="item_id" class=" form-control input-circle input-inline">
                                        <option value=""></option>
                                        <option value="default">default</option>
                                        <option value="guoqing">guoqing</option>
                                        <option value="vivo">vivo</option>
                                    </select> -->
                                </td>
                                <td>{{ $resources->title }}</td>
                                <td>{{ $resources->des }}</td>
                                <td>{{ $resources->targetUrl }}</td>
                                <td>
                                    @if($resources->img)
                                        <img src="{{config('suit.ImgRemoteUrl').$resources->img}}" style="width:60px;height: 60px;">
                                    @endif
                                </td>
                                <td>{{ $resources->shareImg }}</td>
                                <td>{{ $resources->sharetype }}</td>
                                <td>{{ $resources->sharetab }}</td>
                                <td>{{ $resources->task_share_title }}</td>
                                <td>{{ $resources->task_share_content }}</td>
                                <td>{{ $resources->task_share_url }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/share/edit?ShareId={{ $resources->ShareId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/share/delete?ShareId={{ $resources->ShareId }}"> 删除
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
    var href="/share/index?";
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#lua_content").html();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/share/lua",
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
        url = '/share/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/share/lua?type=customer&select='+select+'&type=customer';
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
    	var succesurl = '/share/index';
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
