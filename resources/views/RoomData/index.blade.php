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
                    <span class="caption-subject bold uppercase"> 房间配置 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/roomdata/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
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
                        <th width="160px"> 场次进入最小限制 </th>
                        <th width="160px"> 场次进入最大限制 </th>
                        <th width="160px"> 台费 </th>
                        <th width="160px"> 底注 </th>
                        <th width="160px"> 顶注 </th>
                        <th width="160px"> 最大看牌轮数 </th>
                        <th width="160px"> 最大可比轮数 </th>
                        <th width="160px"> 可比轮数 </th>
                        <th width="160px"> 底图名字 </th>
                        <th width="160px"> 场次标识图片名字 </th>
                        <th width="160px"> 是否开放机器人 </th>
                        <th width="160px"> 机器人类型 </th>
                        <th width="130px"> 操作 </th>
                    </tr>
                    <tr>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="ID" id="server_ID">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="ID" id="customer_ID">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="name" id="server_name">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="name" id="customer_name">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="min" id="server_min">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="min" id="customer_min">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max" id="server_max">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max" id="customer_max">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="cost" id="server_cost">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="cost" id="customer_cost">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="dizhu" id="server_dizhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="dizhu" id="customer_dizhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="dingzhu" id="server_dingzhu">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="dingzhu" id="customer_dingzhu">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="max_look_round" id="server_max_look_round">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="max_look_round" id="customer_max_look_round">客户端 
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
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="img_bg" id="server_img_bg">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="img_bg" id="customer_img_bg">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="img_icon" id="server_img_icon">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="img_icon" id="customer_img_icon">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="open_robot" id="server_open_robot">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="open_robot" id="customer_open_robot">客户端 
                        </th>
                        <th> 
                            <input type="checkbox"  name="check_s" onclick="check_s()" value="robot_type" id="server_robot_type">服务端<br>
                            <input type="checkbox"  name="check_c" onclick="check_c()" value="robot_type" id="customer_robot_type">客户端 
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
                                    {{ $resources->ID }}
                                </td>
                                <td>{{ $resources->name }}</td>
                                <td>{{ $resources->min }}</td>
                                <td>{{ $resources->max }}</td>
                                <td>{{ $resources->cost }}</td>
                                <td>{{ $resources->dizhu }}</td>
                                <td>{{ $resources->dingzhu }}</td>
                                <td>{{ $resources->max_look_round }}</td>
                                <td>{{ $resources->comparable_bet_round }}</td>
                                <td>{{ $resources->max_bet_round }}</td>
                                <td>
                                    {{ $resources->img_bg }}
                                </td>
                                <td>
                                    {{ $resources->img_icon }}
                                </td>
                                <td>
                                    @if($resources->open_robot==1)
                                        true
                                    @else
                                        false
                                    @endif
                                </td>
                                <td>{{ $resources->robot_type }}</td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/roomdata/edit?RoomdataId={{ $resources->RoomdataId }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/roomdata/delete?RoomdataId={{ $resources->RoomdataId }}"> 删除
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
    var href="/roomdata/index?";
    //转Lua
    $('#proConfig').click(function(){
        var lua = $("#request_lua").val();
        if(lua==''){
            alert('no data.');return false;
        }
        $.ajax( {
            type : "post",
            url : "/roomdata/lua",
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
        url = '/roomdata/lua?select='+select+'&type=server';
    }else{
        var select = $("#check_customer_data").val();
        if(select==''){
            alert('请至少选择一项');return false;
        }
        url = '/roomdata/lua?type=customer&select='+select+'&type=customer';
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

