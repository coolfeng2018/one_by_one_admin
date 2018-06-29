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
                        	<div class="col-md-12">
                                <a class="ajaxify btn sbold green" href="{{$actions['add']}}?backurl={{$nowurl}}"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            
                            <div class="col-md-12">  
                            代理昵称:&nbsp;<input type="text" id="agentname" class="form-control  input-inline" value="{{$search['agentname']}}" >&nbsp;  
                            代理ID:&nbsp;<input type="text" id="agentid" class="form-control  input-inline" value="{{$search['agentid']}}" >&nbsp;
                                手机号:&nbsp;<input type="text" id="mobile" class="form-control  input-inline" value="{{$search['mobile']}}" >&nbsp;
                                游戏ID:&nbsp;<input type="text" id="uid" class="form-control  input-inline" value="{{$search['uid']}}" >&nbsp;                  
                                状态:&nbsp;
                                <select id="status" class="form-control  input-inline">
                                    <option value ="0"></option>
                                    @foreach($u_status as $k=>$v)
                                    <option value='{{$k}}' @if($search['status']==$k)selected @endif >{{$v}}</option>
                                    @endforeach
                                </select>
                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </div>
                            <div class="col-md-12">
                                <span id="demo">日期区间:&nbsp;
                                <input type="text" id="stime" class=" form-control  input-inline" value="{{$search['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control  input-inline" value="{{$search['etime']}}">&nbsp;
                                </span>
                             </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 代理ID </th>
                        <th> 代理昵称 </th>
                        <th> 游戏ID </th>
                        <th> 手机号码 </th>
                        <th> 代理级别 </th>
                        <th> 提成比率 </th>
                        <th> 二级代理/所有代理数</th>
                        <th> 下级玩家人数 </th>
                          
                        <th> 创建时间 </th>
                        <th> 状态 </th>
<!--                         <th> 二维码 </th> -->
                        <th> 最后修改时间 </th>
                        <th> 最后修改人  </th>
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
                                <td>{{$resources->depth}}级代理</td>
                                <td> {{ $resources->Ratio }} </td>
                                <td><a class="ajaxify  sbold green" href="{{$actions['level']}}?pid={{ $resources->AgentId }}&fid=0&tel={{ $resources->Telephone }}&name={{ $resources->AgentName }}&backurl={{$nowurl}}"> {{ $resources->num }}/{{ $resources->num_all }}</a></td>
                                <td><a class="ajaxify  sbold green" href="{{$actions['user']}}?aid={{ $resources->AgentId }}&backurl={{$nowurl}}"> {{ $resources->players }} </a></td>
                                
                                <td>{{ $resources->CreateAt }}</td>
                                <td>
                                    @if(isset($u_status[$resources->Status])) {{ $u_status[$resources->Status] }} @else {{$resources->Status}} @endif
                                </td>
                                
<!-- <td class="qrimg"  data-aid="{{ $resources->AgentId }}" data-aname="{{ $resources->AgentName }}"  data-url="{{ sprintf($url, $resources->AgentId) }} "> -->
<!-- {!! QrCode::size(200)->generate(sprintf($url, $resources->AgentId)); !!} -->
<!-- </td> -->
                  
                                <td>{{ $resources->AdminName }}</td>
                                <td>{{ $resources->UpdateAt }}</td>
                                <td><a class="ajaxify btn sbold green" href="{{$actions['update']}}?id={{ $resources->AgentId }}&backurl={{$nowurl}}">修改 <i class="fa fa-pencil"></i> </a></td>
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
$(function() {
    //查找
    var href = "{{$actions['index']}}?";
    var backurl = "{{$nowurl}}";
    $("#search").click(function () {
        $("#search").attr("href", href + "&status=" + $("#status option:selected").val() +"&mobile=" + $("#mobile").val() + "&agentid=" + $("#agentid").val()+ "&agentname=" + $("#agentname").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+"&backurl="+backurl);
    });
    var aobj = $(".pagination").find("a");
    aobj.each(function () {
        $(this).attr("href", $(this).attr("href") + "&status=" + $("#status option:selected").val()+"&mobile=" + $("#mobile").val()+ "&agentid=" + $("#agentid").val()+ "&agentname=" + $("#agentname").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+"&backurl="+backurl);
    });
});
</script>
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker_zh.js"></script>

