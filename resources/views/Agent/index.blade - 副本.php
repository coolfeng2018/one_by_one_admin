<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/agent/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="input-inline">
                                <span id="demo">日期区间:&nbsp;
                                <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{$search['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{$search['etime']}}">&nbsp;</span>
                                手机号:&nbsp;<input type="text" id="mobile" class="form-control input-circle input-inline" value="{{$search['mobile']}}" >&nbsp;
                                游戏ID:&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{$search['uid']}}" >&nbsp;
                                销售人员:&nbsp;<input type="text" id="adminname" class="form-control input-circle input-inline" value="{{$search['AdminName']}}" >&nbsp;
                                代理昵称:&nbsp;<input type="text" id="agentname" class="form-control input-circle input-inline" value="{{$search['AgentName']}}" >&nbsp;
                                状态:&nbsp;
                                <select id="status" class="form-control input-circle input-inline">
                                    <option value ="1" @if($search['Status']==1) selected @endif>正常</option>
                                    <option value ="2" @if($search['Status']==2) selected @endif>禁用</option>
                                </select>
                                <!-- <input type="text" id="demo" class="form-control"> -->
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 代理昵称 </th>
                        <th> 游戏ID </th>
                        <th> 手机号码 </th>
                        <th> 代理级别 </th>
                        <th> 下级代理信息 </th>
                        <th> 下级代理人数 </th>
                        <th> 下级玩家信息 </th>
                        <th> 下级玩家人数 </th>
                        <th> 销售人员 </th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 最后登录时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody  id="info">
                    <div>
                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>{{ $resources->AgentId }}</td>
                                <td>{{ $resources->AgentName }}</td>
                                <td>{{ $resources->UserId }}</td>
                                <td>{{ $resources->Telephone }}</td>
                                <td>
                                    @if($resources->Level==1)
                                        一级代理
                                    @elseif($resources->Level==2)
                                        二级代理
                                    @elseif($resources->Level==3)
                                        三级代理
                                    @endif
                                </td>
                                <!-- <a class="btn sbold green" href="javascript:loadme(1);">123</a> -->
                                <td><a class="btn sbold green" href="javascript:agentDetail({{ $resources->AgentId }});"> 下级代理信息 </a></td>
                                <td>{{ $resources->num }}</td>
                                <td><a class="btn sbold green" href="javascript:agentUserDetail({{ $resources->AgentId }});"> 下级用户信息 </a></td>
                                <td>{{ $resources->players }}</td>
                                <td>{{ $resources->AdminName }}</td>
                                <td>
                                    @if($resources->Status==1)
                                        正常
                                    @elseif($resources->Status==2)
                                        禁用
                                    @endif
                                </td>
                                <td>{{ $resources->CreateAt }}</td>
                                <td>{{ $resources->LastLoginTime }}</td>
                                <td><a class="ajaxify btn sbold green" href="/agent/update?id={{ $resources->AgentId }}">修改 <i class="fa fa-pencil"></i> </a></td>
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


<!-- Modal start-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 50%;">
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-body" id="contentBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal end-->
<script>
$(function() {
    // $('#stime').datetimepicker();
    // $('#etime').datetimepicker();

    //查找
    var href = "/agent/index?";

    $("#search").click(function () {
        $("#search").attr("href", href + "&status=" + $("#status option:selected").val() +"&mobile=" + $("#mobile").val() + "&adminname=" + $("#adminname").val()+ "&agentname=" + $("#agentname").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val());
    });
    var aobj = $(".pagination").find("a");

    aobj.each(function () {
        $(this).attr("href", $(this).attr("href") + "&status=" + $("#status option:selected").val()+"&mobile=" + $("#mobile").val()+ "&adminname=" + $("#adminname").val()+ "&agentname=" + $("#agentname").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val());
    });
});

//代理信息
function agentDetail(AgentId){
  $.ajax({url: "/agent/level?pid="+AgentId, success: function(result){
        $("#contentBody").html(result);
        $("#myModal").modal('show'); 
  }});
}

//用户信息
function agentUserDetail(AgentId){
  $.ajax({url: "/agent/user?aid="+AgentId, success: function(result){
        $("#contentBody").html(result);
        $("#myModal").modal('show'); 
  }});
}
</script>
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker_zh.js"></script>
