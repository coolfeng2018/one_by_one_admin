<style>
#log_window {
    width:700px;
    height:500px;
    /*background-color:#FF0;    */
    /*margin: auto;*/
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
                    <span class="caption-subject bold uppercase"> 文本配置列表 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/text/add"> 新增
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
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                通知消息类型:&nbsp;
                                <select id="type" class=" form-control input input-inline">
                                    <option value=""></option>
                                    <option value="1" @if('1'==$search['type']) selected @endif>俱乐部解散</option>
                                    <option value="2" @if('2'==$search['type']) selected @endif>提升为俱乐部管理员</option>
                                    <option value="3" @if('3'==$search['type']) selected @endif>撤销俱乐部管理员</option>
                                    <option value="4" @if('4'==$search['type']) selected @endif>被踢出俱乐部</option>
                                    <option value="5" @if('5'==$search['type']) selected @endif>加入俱乐部</option>
                                </select>
                                    通知内容:&nbsp;
                                <input type="text" id="content" class="form-control input-sm input-small input-inline" value="{{$search['content']}}" aria-controls="sample_1">
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> id </th>
                        <th> 通知消息类型 </th>
                        <th> 通知内容 </th>
                        <th> 添加时间 </th>
                        <th> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="id" id="server_id">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="id" id="customer_id">客户端 
                        </th>
                        <th> </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="content" id="server_content">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="content" id="customer_content">客户端 
                        </th>
                        <th> 
                            <input type="hidden" id="check_server_data" name="check_server_data" value="{{$checkServerData}}" />
                            <input type="hidden" id="check_customer_data" name="check_customer_data" value="{{$checkCustomerData}}" />
                        </th>
                        <!-- <th> </th> -->
                        <th>  
                            <a  href="#" onclick="verify('customer')" class=" btn sbold blue" >转Lua(客户端)</a>
                            <a  href="#" onclick="verify('server')" class=" btn sbold yellow" >转Lua(服务端)</a>
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>

                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>{{ $resources->id }}</td>
                                <td>
                                    @php
                                        switch ($resources->type) {
                                            case '1':
                                                echo '俱乐部解散';
                                                break;
                                            case '2':
                                                echo '提升为俱乐部管理员';
                                                break;
                                            case '3':
                                                echo '撤销俱乐部管理员';
                                                break;
                                            case '4':
                                                echo '被踢出俱乐部';
                                                break;
                                            case '5':
                                                echo '加入俱乐部';
                                                break;
                                        }
                                    @endphp
                                </td>
                                <td>{{ $resources->content }}</td>
                                <td>{{ $resources->created_at }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/text/edit?TextId={{ $resources->TextId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/text/delete?TextId={{ $resources->TextId }}"> 删除
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
    var href="/text/index?";
    $("#search").click(function(){
        $("#search").attr("href",href+"type="+$("#type").val()+"&content="+$("#content").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&type="+$("#type").val()+"&content="+$("#content").val());
    });
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#lua_content").html();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/text/lua",
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
    var checkserverData = <?php echo $recordData->server_record;?>;
    var checkcustomerData = <?php echo $recordData->customer_record;?>;
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
        url = '/text/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/text/lua?type=customer&select='+select+'&type=customer';
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
    	var succesurl = '/text/index';
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
