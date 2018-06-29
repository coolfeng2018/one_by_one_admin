<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">牌局记录</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="dataTables_length" id="sample_1_length">
                                <label>场次:&nbsp;
                                    <select name="tableType" id="tableType" aria-controls="sample_1" class="form-control input-circle input-inline">
                                        <option value="-1" @if($search['tableType']==-1) selected="true" @endif >全部</option>
                                        @foreach ($tablelist as $k => $table)
                                        <option value="{{ $k }}" @if($search['tableType'] == $k) selected @endif>{{ $table }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <div class="input-inline">
                                    时间范围:&nbsp;
                                    <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{ date('Y-m-d H:i',$search['sTime']) }}">
                                    &nbsp;-&nbsp;
                                    <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{ date('Y-m-d H:i',$search['eTime']) }}">&nbsp;
                                    账号ID:&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{ empty($search['uid'])?'':$search['uid'] }}">&nbsp;
                                    <a class="btn green ajaxify" id="search"  href="javascript:void()">搜索</a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> 牌局号 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 房间类型 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 游戏时间（开始） </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 参与人数/机器人 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 系统总输赢 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 150px;"> 操作 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td class="sorting_1"> {{ $v->table_gid }} </td>
                                    <td> {{ $tablelist[$v->table_type] }} </td>
                                    <td> {{ date('Y-m-d H:i:s',$v->begin_time) }} </td>
                                    <td> {{ $v->userNum }} </td>
                                    <td @if($v->winCount < 0) style="color:green;" @else style="color:red" @endif> {{ round($v->winCount/100, 2) }} 元</td>
                                    <!--<td> <button class="btn btn-primary btn-lg detail2" data-toggle="modal" data-target="#myModal" tableid="{{ $v->table_gid }}">详情</button> </td>-->
                                    <td><a class="btn green ajaxify detail2" href="javascript:void()" tableid="{{ $v->table_gid }}">详情</button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>


<script type="text/javascript">
    $(function(){
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();
        var href="/cardgame/log?";
        var types="";
        var starttime="";
        var endtime="";
        var uid="";

        $('#search').click(function(){
            url = "/cardgame/log?uid="+ $("#uid").val() +"&sTime="+ $('#stime').val() + "&eTime=" + $('#etime').val() + "&tableType=" + $('#tableType').val();
            Layout.loadAjaxContent(url);
        })
        
        var aobj=$(".pagination").find("a");
        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&tableType="+$("#tableType").val()+"&sTime="+$("#stime").val()+"&eTime="+$("#etime").val()+"&uid="+ $("#uid").val());
        });

        function htmlspecialchars_decode(str){           
                  str = str.replace(/&amp;/g, '&'); 
                  str = str.replace(/&lt;/g, '<');
                  str = str.replace(/&gt;/g, '>');
                  str = str.replace(/&quot;/g, "''");  
                  str = str.replace(/&#039;/g, "'");  
                  str = str.replace(/&laquo;/g, "<<");  
                  str = str.replace(/&raquo;/g, ">>"); 
                  return str;  
        }
        
        $('.detail2').click(function(){
            tableGid = $(this).attr('tableid');
            stime = $("#stime").val();
            url = "/cardgame/list?tableGid="+ tableGid +"&sTime="+stime;
            Layout.loadAjaxContent(url);
        })
        
        
        $('.detail').click(function(){
            $.ajax( {
                type : "get",
                url : "/cardgame/list",
                dataType:"json",
                data : {'_token':'{{csrf_token()}}','sTime':$('#stime').val(), 'uid':$('#uid').val(), 'tableGid':$(this).attr('tableid')},
                success : function(e) {
                    str = '                    <div class="table-scrollable">'+
                        '<table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">'+
                        '    <thead>'+
                        '    <tr role="row">'+
                        '        <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> 玩家ID </th>'+
                        '        <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 玩家昵称 </th>'+
                        '        <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 游戏的金币 </th>'+
                        '        <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 游戏后的金币 </th>'+
                        '        <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 输赢金额 </th>'+
                        '        <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 税收 </th>'+
                        '    </tr>'+
                        '    </thead>'+
                        '    <tbody>';
                    //for(info in e.data.data) {
                    for(c=0;c<e.data.data.length;c++) {
                            str += '    <tr role="row" >'+
                                '    <td class="sorting_1">' + e.data.data[c].nickname + '</td>'+
                                '    <td>' + e.data.data[c].time + '</td>'+
                                '    <td> ' + e.data.data[c].time + ' </td>'+
                                '    <td> ' + e.data.data[c].time + ' </td>'+
                                '    <td> ' + e.data.data[c].time + ' </td>'+
                                '    <td> ' + e.data.data[c].time + ' </td>'+
                            '    </tr>';
                    };
                str += '    </tbody>'+
                        '</table>'+
                    '</div>';
                str += '<div class="row">'+
                        '<div class="col-md-7 col-sm-7">'+
                        '    <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">'+
                        
                        '    </div>'+
                        '</div>'+
                    '</div>';
                    $('.modal-body').html(str);
                },
                error: function(){
                    alert("failure");
                }
            });
        })

        
    })
</script>


