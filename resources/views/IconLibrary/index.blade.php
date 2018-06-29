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
                    <span class="caption-subject bold uppercase"> 机器人头像 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/iconlibrary/add"> 新增
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
                            <div>
                                id:&nbsp;<input type="text" id="id" class="form-control input-sm input-small input-inline" value="{{$search['id']}}" aria-controls="sample_1">
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table" class="table table-striped table-bordered table-hover table-checkable order-column">
                    <thead>
                    <tr>
                        <th width="160px"> id </th>
                        <th width="160px"> 语句 </th>
                        <th width="130px"> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="id" id="server_id">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="id" id="customer_id">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="name" id="server_name">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="name" id="customer_name">客户端 
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
                                    <img src="{{config('suit.ImgRemoteUrl').$resources->name}}" style="width:60px;height: 60px;">
                                </td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/iconlibrary/edit?IconLibraryId={{ $resources->IconLibraryId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/iconlibrary/delete?IconLibraryId={{ $resources->IconLibraryId }}"> 删除
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
    var href="/iconlibrary/index?";
    //搜索
    $("#search").click(function(){
        $("#search").attr("href",href+"id="+$("#id").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&id="+$("#id").val());
    });
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#lua_content").html();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/iconlibrary/lua",
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
        //必填项验证start
        var alert_array=new Array();
        alert_array['id']="id";
        var must_array = ["id"];
        var select_array = select.split(",");
        var flag = true;
        $.each(must_array,function(n,value){
            // alert(n);
            // alert(value);
            var index = $.inArray(value, select_array);
            if(index==-1){
                flag = false;
                var error = alert_array[value]+'是必填项哦';
                alert(error);
            }
        });
        if(!flag){
            return false;
        }
        //必填项验证end
        url = '/iconlibrary/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/iconlibrary/lua?type=customer&select='+select+'&type=customer';
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
    	var succesurl = '/iconlibrary/index';
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
