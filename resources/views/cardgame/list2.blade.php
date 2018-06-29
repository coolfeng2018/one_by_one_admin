<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">牌局详情</span>
                </div>
            </div>

            <div class="portlet-body">
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="dataTables_length" id="sample_1_length">
                                <input type="hidden" value="{{ $sTime }}" id="sTime" name="sTime" >
                                <input type="hidden" value="{{ $tableGid }}" id="tableGid" name="tableGid">
                            </div>

                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_editable_1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 50px;"> 玩家id </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 玩家昵称 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 游戏前金币 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 游戏后金币 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 100px;"> 输赢金额 </th>
                                <th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1"  style="width: 150px;"> 税收 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="odd" @else class="even" @endif >
                                    <td class="sorting_1"> {{ $v->uid }} </td>
                                    <td @if($v->nickname == '机器人') style="color:red" @else style="color:green;" @endif> {{ $v->nickname }} </td>
                                    <td> {{ round(($v->left_score - $v->add_score + $v->pay_fee)/100, 2) }} </td>
                                    <td> {{ round($v->left_score/100, 2) }} </td>
                                    <td @if($v->add_score<0) style="color:green" @else style="color:red" @endif> {{ round($v->add_score/100, 2) }} 元 </td>
                                    <!--<td> <button class="btn btn-primary btn-lg detail2" data-toggle="modal" data-target="#myModal" tableid="{{ $v->table_gid }}">详情</button> </td>-->
                                    <td>{{ round($v->pay_fee/100, 2) }} 元</td>
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
<script>
        var aobj=$(".pagination").find("a");
        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&sTime="+$("#sTime").val()+"&tableGid="+$("#tableGid").val());
        });
</script>