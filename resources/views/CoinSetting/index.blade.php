<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-home font-dark"></i>
                    <span class="caption-subject bold uppercase"> 金币房配置</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/coinSetting/add"> 新增
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
                        <th> 游戏类型 </th>
                        <th> 场次类型 </th>
                        <th> 特殊规则 </th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                        <div>

                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->Id }}</td>
                                    <td>{{ $res['games'][$resources->KindId] }}</td>

                                    <td>@if($resources->KindId==1001)
                                        <span class="label label-sm label-warning">
                                        @if($resources->Level == 1)
                                            初级
                                        @elseif($resources->Level == 2)
                                            中级
                                        @elseif($resources->Level == 3)
                                            高级
                                        @endif
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->Id }}">特殊规则</button>
                                        <div class="modal fade" id="myModal_{{ $resources->Id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                        @if($resources->KindId == 1001)

                                                            @foreach(json_decode($resources->Config) as $k => $v)

                                                                @foreach($v as $key =>$val)
                                                                    @if($key=='master')
                                                                        <tr>
                                                                            <td>庄家倍数</td>
                                                                            <td>min</td>
                                                                            <td>max</td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td>闲家倍数</td>
                                                                            <td>min</td>
                                                                            <td>max</td>
                                                                        </tr>
                                                                    @endif
                                                                    @foreach($val as $kk=>$vv)
                                                                        <tr>
                                                                            <td>{{$vv->type}}</td>
                                                                            <td>{{$vv->min}}</td>
                                                                            <td>{{$vv->max}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>上庄min</td>
                                                                <td>下庄min</td>
                                                                <td>抽水</td>
                                                            </tr>
                                                            @foreach(json_decode($resources->Config) as $k => $v)
                                                                <tr>
                                                                    <td>{{$v->up}}</td>
                                                                    <td>{{$v->down}}</td>
                                                                    <td>{{$v->pump}}</td>
                                                                </tr>
                                                            @endforeach
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
                                        @if($resources->Status == 1)
                                            启用
                                        @elseif($resources->Status == 0)
                                            禁用
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/coinSetting/update?id={{ $resources->Id }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/coinSetting/delete?id={{ $resources->Id }}"> 删除
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
