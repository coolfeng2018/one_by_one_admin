<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 提现申请记录列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-10 col-sm-10">
                                <div id="sample_1_filter" class="dataTables_filter">
                                    游戏id:&nbsp;&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{$search['uid']}}" >&nbsp;&nbsp;
                                    状态:&nbsp;&nbsp;
                                    <select id="Status" class=" form-control input-circle input-inline" name="select_status">
                                        <option value="0"></option>
                                        <option value="1" @if($search['Status']==1) selected @endif>已处理</option>
                                        <option value="2" @if($search['Status']==2) selected @endif>拒绝</option>
                                        <option value="3" @if($search['Status']==3) selected @endif>已驳回</option>
                                    </select>
                                    <a class="btn green ajaxify" id="search"  href="">查找</a>
                                    <a class="btn green" data-toggle="modal" data-target="#stopMusic" id="stopMyMusic">关闭声音提示</a>
                                    <div class="modal fade" id="stopMusic" tabindex="100" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <!-- <h4 class="modal-title" id="myModalLabel">关闭声音提示</h4> -->
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in">
                                                            
                                                            <h3 class="modal-title text-center" id="myModalLabel">关闭声音提示?</h3>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn green" onclick="closeMusic()">确认</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
        <br/>
        <br/>
        <br/>
                            <div class="col-md-10 col-sm-10">
                                <div id="sample_1_filter" class="dataTables_filter">
                                    <select id="refresh" class=" form-control input-circle input-inline">
                                        <option value="10" @if($search['refresh']==10) selected @endif>10秒自动刷新</option>
                                        <option value="30" @if($search['refresh']==30) selected @endif>30秒自动刷新</option>
                                        <option value="60" @if($search['refresh']==60) selected @endif>60秒自动刷新</option>
                                    </select>&nbsp;&nbsp;
                                    <a class="btn green" onclick="startCount()">自动刷新</a>
                                    <a class="btn green" onclick="stopCount()">停止刷新</a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 编号 </th>
                        <th> 游戏ID </th>
                        <th> 申请提现金额 </th>
                        <th> 余额 </th>
                        <th> 需转金额 </th>
                        <th> 手续费 </th>
                        <th> 兑换方式 </th>
                        <th> 兑换信息 </th>
                        <th> 申请兑换时间 </th>
                        <th> 上次兑换时间 </th>
                        <th width="450px"> 标记 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->WithdrawId }}</td>
                                    <td><a href="/goldrecord/list?uid={{ $resources->uid }}&page={{ $search["page"] }}&Status={{ $search["Status"] }}" class="ajaxify" style="display: inline;">{{ $resources->uid }}</a></td>
                                    <td><p class="invoice-desc grand-total "><b style="color: red;">{{ $resources->Amount }}元</p></b></td>
                                    <td>{{ $resources->Balance }}元</td>
                                    <!-- <td bgcolor="green"> -->
                                    <td>
                                        {{ $resources->Amount - $resources->Fees }}元
                                    </td>
                                    <td>
                                        {{ $resources->Fees }}元
                                    </td>
                                    <td>
                                        @if($resources->WithdrawChannel == 1)
                                            银行
                                        @elseif($resources->WithdrawChannel == 0)
                                            支付宝
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->WithdrawId }}">详情</button>
                                        <div class="modal fade" id="myModal_{{ $resources->WithdrawId }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">兑换账号信息-@if($resources->WithdrawChannel == 1)银行@elseif($resources->WithdrawChannel == 0)支付宝@endif</h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in">
                                                            <div class="pay">
                                                                    @if($resources->WithdrawChannel==1)
                                                                        <div>银行卡卡号:<span>{{ $resources->WithdrawInfo->account }}</span></div>
                                                                        <div>持卡人姓名:<span>{{ $resources->WithdrawInfo->Name }}</span></div>
                                                                        <div>身份证号码:<span>{{ $resources->WithdrawInfo->idCard }}</span></div>
                                                                        <div>开户行:<span>{{ $resources->WithdrawInfo->originBank }}</span></div>
                                                                        <div>开户省份城市:<span>{{ $resources->WithdrawInfo->originProvince }}<span>{{ $resources->WithdrawInfo->originCity }}</span></div>
                                                                        <div>开户行:<span>{{ $resources->WithdrawInfo->branchBank }}</span></div>
                                                                    @elseif($resources->WithdrawChannel==0)
                                                                        <div>支付宝账号:<span>{{ $resources->WithdrawInfo->account }}</span></div>
                                                                        <div>姓名:<span>{{ $resources->WithdrawInfo->Name }}</span></div>
                                                                    @endif
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    
                                    <td>
                                        {{ $resources->CreateAt }}
                                    </td>
                                    <td>{{ $resources->LastCreateAt }}</td>
                                    <td id="{{ $resources->WithdrawId }}">
                                        @if($resources->Status == 0)
                                            <a class="edit" href="javascript:void(0)" onclick="updateapply({{ $resources->WithdrawId }},1)"> 通过 </a>|
                                            <a class="edit" href="javascript:void(0)" onclick="updateapply({{ $resources->WithdrawId }},2)"> 拒绝 </a>|
                                            <a class="edit" href="javascript:void(0)" onclick="updateapply({{ $resources->WithdrawId }},3)"> 驳回 </a>
                                        @elseif($resources->Status == 1)
                                        <span class="label label-sm label-success">
                                            已处理
                                        @elseif($resources->Status == 2)
                                        <span class="label label-sm label-danger">
                                            拒绝
                                        @elseif($resources->Status == 3)
                                        <span class="label label-sm label-warning">
                                            已驳回
                                        @endif
                                        </span>
                                        <a data-toggle="modal" data-target="#myModal_{{ $resources->uid }}" id="confirmation{{ $resources->uid }}" class="back" style="margin-left:10px;"> 备注 
                                        </a>
                                        <div class="modal fade" id="myModal_{{ $resources->uid }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h3 class="modal-title text-center" id="myModalLabel">备注信息</h3>
                                                        <h4 class="modal-title" id="myModalLabel">玩家昵称:{{ $resources->nickName }} &nbsp;&nbsp;玩家id:{{ $resources->uid }}</h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in">
                                                            <div class="pay">
                                                                <form></form>
                                                                        <div><textarea id="remark_{{ $resources->uid }}" style="width: 100%;height: 100px" placeholder="请输入备注信息!" maxlength="32" onchange="this.value=this.value.substring(0, 32)" onkeydown="this.value=this.value.substring(0, 32)" onkeyup="this.value=this.value.substring(0, 32)">{{ $resources->remark }}</textarea></div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn green" onclick="saveRemark({{ $resources->uid }})">保存</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($resources->remarkNew)
                                            <a style="position: relative;">
                                                <div class="popover confirmation fade right in confirmation{{ $resources->uid }}" style="top:-15px;position:absolute;display: block;text-overflow: ellipsis;white-space: nowrap;">
                                                    <div class="arrow" style="top: 50%;"></div>
                                                    <!-- <h3 class="popover-title">备注</h3> -->
                                                    <div class="popover-content text-center">
                                                        <span style="padding-right:5px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 120px;">{{ $resources->remarkNew }}</span>
                                                        @if($resources->Substr == true)
                                                            <button type="button" class="btn blue btn-outline" data-toggle="modal" data-target="#myModal_{{ $resources->uid }}">查看更多</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                </table>
                <div id="record">共<span>{{$res['total']}}</span>条记录</div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style type="text/css">
.pay div{
    padding:5px 5px 5px 25px;
}
.pay span{
    color:red;
}
.test{clear:both;}
</style>
<script>
    function updateapply(id,status)
    {
        var result = '';
        $.ajax({
                type : "get",
                url : "/withdraw/updateStatus?WithdrawId="+id+"&status="+status,
                dataType : 'json',
                // data : {'_token':'{{csrf_token()}}',pid:pid,name:name,url:url,type:type,status:status},
                success : function(data) {
                    if(data.status==200){
                        alert('ok');
                        if(status==1){
                            result = '<span class="label label-sm label-success">已处理</span>';
                        }else if(status==3){
                            result = '<span class="label label-sm label-warning">已驳回</span>';
                        }else{
                            result = '<span class="label label-sm label-danger">拒绝</span>';
                        }
                        $("#"+id+"").html(result);
                    }else{
                        alert(data.msg);
                    }
                }
        });
    }

    $(function(){
        // $('#stime').datetimepicker();
        // $('#etime').datetimepicker();
        
        $('#uid').val('{{$search["uid"]}}');
        // $('#Status').val('{{$search["Status"]}}');

        var href="/withdraw/index?";

        $("#search").click(function(){
            $("#search").attr("href",href+"&uid="+$("#uid").val()+"&Status="+$("#Status").val());
        });

        var aobj=$(".pagination").find("a");

        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&uid="+$("#uid").val()+"&Status="+$("#Status").val()+"&refresh="+$("#refresh").val());
        });
    });

    var t;
    function timedCount() {
        //获取设置值
        var refresh_time = $("#refresh option:selected").val()*1000;
        var url="/withdraw/index?refresh="+$("#refresh option:selected").val();
        Layout.loadAjaxContent(url, $(this));
        t = setTimeout(function(){ timedCount() }, refresh_time);
    }

    function startCount() {
        clearTimeout(t);
        timedCount();
    }

    function stopCount() {
        clearTimeout(t);
    }

    function saveRemark(uid){ 
        var remark=$('#remark_'+uid).val();
        var uid=uid;
        var colse_uid = 'myModal_'+uid;
        $.ajax( {
            type : "post",
            url : "/withdraw/saveRemark",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',remark:remark,uid:uid},
            success : function(data) {
                if(data.code==200){
                    alert(data.msg);
                    $("#"+colse_uid).modal({show:false});
                    var url="/withdraw/index?refresh="+$("#refresh option:selected").val();
                    setTimeout(function(){
                        Layout.loadAjaxContent(url, $(this));
                    },1000);
                    
                }else{
                    alert(data.msg);
                }
            }
        });
    } 

    function closeMusic(){
        $.ajax( {
            type : "get",
            url : "/withdraw/getNewWithdraw?update=1",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}'},
            success : function(data) {
                if(data.code==200){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                }
            }
        });
    }
</script>
