<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">游戏列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn green ajaxify" href="/game/add/show"> 添 加
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer"><div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div id="sample_editable_1_filter" class="dataTables_filter">
                          <!--       <label>Search:<input type="search" class="form-control input-sm input-small input-inline" placeholder="" aria-controls="sample_editable_1"></label> -->
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table id="table" class="table table-striped table-bordered table-hover table-checkable order-column" style="word-break:break-all; word-wrap:break-all;table-layout:fixed">
                            <thead>
                            <tr role="row">
                                <th> 游戏名称 </th>
                                <th> 游戏类型 </th>
                  <!--               <th> 游戏图片 </th> -->
                                <th> 创建时间 </th>
                                <th> 操作 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $k=>$v)
                            <tr>
                                <td> {{ $v->game_name }} </td>
                                <td> {{ $v->game_type }} </td>
                                <td> {{ $v->created_at }} </td>
                                <td>
                                    <a class="ajaxify btn sbold green" href="/game/edit?id={{ $v->game_id }}"> 修改
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="ajaxify btn sbold green" href="/game/del?id={{ $v->game_id }}"> 删除
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                        </div>
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