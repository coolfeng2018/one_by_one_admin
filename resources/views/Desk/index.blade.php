<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-home font-dark"></i>
                    <span class="caption-subject bold uppercase"> 场次管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/desk/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 游戏名称 </th>
                        <th> 场次名称 </th>
                        <th> 场次类型 </th>
                        <th> 背景img </th>
                        <th> 底分img </th>
                        <th> gif </th>
                        <th> 入场限制 </th>
                        <th> 台费 </th>
                        <th> 特殊规则 </th>
                        <th> 状态 </th>
                        <th> 排序 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->deskset_id }}</td>
                                    <td>{{ $res['games'][$resources->kind_id] }}</td>
                                    <td>{{ $resources->deskset_name }}</td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->level == 1)
                                            初级
                                        @elseif($resources->level == 2)
                                            中级
                                        @elseif($resources->level == 3)
                                            高级
                                        @endif
                                        </span>
                                    </td>
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->logo_url}}" style="width:60px;height: 60px;"></td>
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->score_url}}" style="width:60px;height: 60px;"></td>
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->gif_url}}" style="width:60px;height: 60px;"></td>
                                    <td>{{ $resources->least_bet }}-{{ $resources->maximum_bet }}</td>
                                    <td>{{ $resources->fee }}</td>
                                    <td>
                                        <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->deskset_id }}">特殊规则</button>
                                        <div class="modal fade" id="myModal_{{ $resources->deskset_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">特殊规则</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        @if($resources->kind_id == 1001)
                                                            <tr>
                                                                <td>底分</td>
                                                                <td>{{ json_decode($resources->rule)->base }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>算牛方式</td>
                                                                <td>
                                                                    @if(json_decode($resources->rule)->way == 0)
                                                                        自动算牛
                                                                    @else
                                                                        手动算牛
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>底注</td>
                                                                <td>{{ json_decode($resources->rule)->min }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>顶注</td>
                                                                <td>{{ json_decode($resources->rule)->max }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>max轮</td>
                                                                <td>{{ json_decode($resources->rule)->maxRing }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>可比轮</td>
                                                                <td>{{ json_decode($resources->rule)->useRing }}</td>
                                                            </tr>
                                                        @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="label label-sm label-warning">
                                        @if($resources->status == 0)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->sort_id }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/desk/update?id={{ $resources->deskset_id }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/desk/delete?id={{ $resources->deskset_id }}"> 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
