<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理-{{$pid}}:{{$name}}下级代理    </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="  input-inline ">
                            <a class="ajaxify btn sbold green" href="{{urldecode($backurl)}}"> 返回
                                <i class="fa fa-reply"></i>
                            </a>

                            
                        </div>
                        <div class="row">
                        
                        	<div class="input-inline" style="float:right;">
                                <span id="demo">创建代理时间:&nbsp;
                                <input type="text" id="stime" class=" form-control  input-inline" value="{{$search['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control  input-inline" value="{{$search['etime']}}">&nbsp;
                                </span>
                               代理 游戏ID:&nbsp;<input type="text" id="uid" class="form-control  input-inline" value="{{$search['uid']}}" >&nbsp;
                                <input type="hidden" id="pid" class="form-control  input-inline" value="{{$search['pid']}}" >&nbsp;&nbsp;

                                <a class="btn green ajaxify" id="search"  href="">查找</a>
                                <input type="hidden" id="backurl" value="@if(empty($backurl)) {{$actions['index']}} @else {{urldecode($backurl)}} @endif">
                             </div>
                        
                        

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                    	<th class="col-md-4"> 层级 </th>
                        <th> 代理ID <br/>点击查看下级信息</th>
                        <th> 游戏ID </th>
                        <th> 对局数 </th>
                        <th> 充值信息 </th>
                        <th> 成为代理创建时间 </th>
                        <th> 手机号码 </th>
                    </tr>
                    </thead>
                    <tbody  id="info">
                    <div>
                        @foreach ($res as $resources)
                            <tr class="odd gradeX">
                                <td>
                                {{$resources->depth}}级代理
<!--                                 @for($i=1;$i<=$resources->depth;$i++)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                	{{sprintf(" %s ","\t")}}
                                @endfor -->
                                
                                </td>
                                <td>
                                <a class="ajaxify  sbold green" href="{{$actions['level']}}?pid={{ $resources->AgentId }}&fid={{$pid}}&name={{$resources->AgentName}}&tel={{$resources->Telephone}}&backurl={{$backurl}}"> {{ $resources->AgentId }}</a>
                                
                                </td>
                                <td><a class=" ajaxify" href="/uinfo/index?act=search&uid={{ $resources->UserId }}">{{ $resources->UserId }}</a></td>
                                <td>{{ $resources->num }}</td>
                                <td><a class="ajaxify" href="/order/index?&status=z&channel=z&payment_channel=z&stime=&etime=&uid={{ $resources->UserId }}">{{ $resources->amount }}</a></td>
                                <td>{{ $resources->CreateAt }}</td>
                                <td>{{ $resources->Telephone }}</td>
                            </tr>
                        @endforeach
                    </div>
                    
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                 {!! $paginator->render() !!}  
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function() {
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();
        var backurl = $('#backurl').val();
        var pid = "{{$pid}}";
        var fid = "{{$fid}}";
        var name = "{{$name}}";
        var tel = "{{$tel}}";
        //查找
        var href = "{{$actions['level']}}";
        $("#search").click(function () {
            $("#search").attr("href", href + "&pid=" + $("#pid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+ "&backurl=" +backurl+"&pid="+pid+"&fid="+fid+"&name="+name+"&tel="+tel);
        });
        var aobj = $(".pagination").find("a");

        aobj.each(function () {
            $(this).attr("href", $(this).attr("href") + "&pid=" + $("#pid").val() + "&uid=" + $("#uid").val() + "&stime=" + $("#stime").val()+ "&etime=" + $("#etime").val()+"&backurl=" +backurl+"&pid=" +pid+"&fid=" +fid+"&name=" +name+"&tel=" +tel );
        });
    });
</script>
