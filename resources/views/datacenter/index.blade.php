<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-basket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 综合信息</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div id="sample_1_filter" class="dataTables_filter">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-15">
                            日期:&nbsp;&nbsp;<input type="text" id="stime" class=" form-control input-circle input-inline" value="{{ date('Y-m-d H:i', $search['stime']) }}">-<input type="text" id="etime" class=" form-control input-circle input-inline" value="{{ date('Y-m-d H:i', $search['etime']) }}">&nbsp;&nbsp;
                            &nbsp;&nbsp;
                            @if ($showChannel)
                        	类型选择  : 
                            <div class="btn-group bootstrap-select bs-select ">
                             	<select class="bs-select form-control " id="channel" name="channel">
                                    <option value="all" @if($sChannel=='all') selected @endif >所有渠道</option>
                             	@foreach($chList as $ch)
                                    <option value="{{ $ch }}" @if($sChannel==$ch) selected @endif >{{ $ch }} </option>
                                @endforeach
                                </select>
                            </div>  &nbsp;&nbsp;
                            @endif
                            <input type="hidden"  name="showchannel" value="{{ $showChannel }}">
                            <a class="btn green ajaxify" id="search"  href="">查找</a>&nbsp;&nbsp;
                        </div>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 日期 </th>
                        <th> 新增用户数 </th>
                        <th> 活跃用户数 </th>
                        @if ($showChannel == 1 || $sChannel == 'guanwang' || $sChannel == 'seo01')
                        <th> 次日留存 </th>
                        <!--<th> 7日留存 </th>
                        <th> 30日留存 </th>-->
                        <th> 总收入 </th>
                        <th> 总兑换 </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @if ($showTaday == true)
                                <tr class="odd gradeX">
                                    <td>{{ date('Y-m-d') }}</td>
                                    <td>{{ $today['dnu'] }}</td>
                                    <td>{{ $today['dau'] }}</td>
                                    @if ($showChannel == 1 || $sChannel == 'guanwang' || $sChannel == 'seo01')
                                    <td>{{ $today['rn1']*100 }}%</td>
                                    <td>{{ $today['paysum']/100 }}</td>
                                    <td>{{ $today['ecoin'] }}</td>
                                    @endif
                                </tr>
                            @endif
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ date('Y-m-d', $resources->time) }}</td>
                                    <td>{{ $resources->dnu }}</td>
                                    <td>{{ $resources->dau }}</td>
                                    @if ($showChannel == 1 || $sChannel == 'guanwang' || $sChannel == 'seo01')
                                    <td>{{ $resources->rn1*100 }}%</td>
                                    <!--<td>{{ $resources->rn7 }}</td>
                                    <td>{{ $resources->rn30 }}</td>-->
                                    <td>{{ $resources->paysum/100 }}</td>
                                    <td>{{ $resources->ecoin }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                    <div >
                            <input type="hidden" id="current" value="">
                            <input type="hidden" id="total" value="">
                            <ul id="page">
                            </ul>
                    </div>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();
        
        var href="/datacenter/information?";
        showchannel = $("input[name='showchannel']").val();
        
        $("#search").click(function(){
            if (showchannel) {
                $("#search").attr("href",href+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&channel="+$('#channel').val());
            } else {
                $("#search").attr("href",href+"&stime="+$("#stime").val()+"&etime="+$("#etime").val());
            }
        });
        
        var aobj=$(".pagination").find("a");
        aobj.each(function(){
            if (showchannel) {
                $(this).attr("href",$(this).attr("href")+"&stime="+$("#stime").val()+"&etime="+$("#etime").val()+"&channel="+$('#channel').val());
            } else {
                $(this).attr("href",$(this).attr("href")+"&stime="+$("#stime").val()+"&etime="+$("#etime").val());
            }
        });


    });
</script>
