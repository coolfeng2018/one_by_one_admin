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
                    <span class="caption-subject bold uppercase"> 商城管理列表 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/shop/add"> 新增
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
                                任务id:&nbsp;<input type="text" id="id" class="form-control input-sm input-small input-inline" value="{{$search['id']}}" aria-controls="sample_1">
                                商品名称:&nbsp;<input type="text" id="name" class="form-control input-sm input-small input-inline" value="{{$search['name']}}" aria-controls="sample_1">
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table" class="table table-striped table-bordered table-hover table-checkable order-column" style="word-break:break-all; word-wrap:break-all;table-layout:fixed">
                    <thead>
                    <tr>
                        <th> 任务id </th>
                        <th> 商品名称 </th>
                        <th> 价格 </th>
                        <th> 商品 </th>
                        <th> 显示序号 </th>
                        <th> 特惠标识 </th>
                        <th> 贴图名称 </th>
                        <th> 苹果id </th>
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
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="price" id="server_price">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="price" id="customer_price">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="goods" id="server_goods">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="goods" id="customer_goods">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="index" id="server_index">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="index" id="customer_index">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="discount" id="server_discount">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="discount" id="customer_discount">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="icon_name" id="server_icon_name">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="icon_name" id="customer_icon_name">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="ios_goods_id" id="server_ios_goods_id">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="ios_goods_id" id="customer_ios_goods_id">客户端 
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
                                <td>{{ $resources->name }}</td>
                                <td>
                                    @if(count(json_decode($resources->price,true))>=1)
                                        @foreach(json_decode($resources->price,true) as $k=>$v)
                                            {{ $v['amount'] }}
                                                @foreach($item as $n) 
                                                    @if($n->id==$v['currency']) {{ $n->name }} @endif
                                                @endforeach
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(count(json_decode($resources->goods,true))>=1)
                                        @foreach(json_decode($resources->goods,true) as $k=>$v)
                                            {{ $v['item_count'] }}
                                                @foreach($item as $n) 
                                                    @if($n->id==$v['item_id']) {{ $n->name }} @endif
                                                @endforeach
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $resources->index }}</td>
                                <td>{{ $resources->discount }}</td>
                                <td>
                                        <img src="{{config('suit.ImgRemoteUrl').$resources->icon_name}}" style="width:60px;height: 60px;">
                                </td>
                                <td>{{ $resources->ios_goods_id }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/shop/edit?ShopId={{ $resources->ShopId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/shop/delete?ShopId={{ $resources->ShopId }}"> 删除
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
    var href="/shop/index?";
    //搜索
    $("#search").click(function(){
        $("#search").attr("href",href+"id="+$("#id").val()+"&name="+$("#name").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&id="+$("#id").val()+"&name="+$("#name").val());
    });
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#lua_content").html();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/shop/lua",
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
        alert_array['id']="任务id";
        alert_array['price']="价格";
        alert_array['goods']="商品";
        var must_array = ["id","price","goods"];
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
        url = '/shop/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/shop/lua?type=customer&select='+select+'&type=customer';
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
    	var succesurl = '/shop/index';
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
