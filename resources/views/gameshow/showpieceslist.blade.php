<div class="tab-content">

    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>展示方案详细
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#"  class="form-horizontal" method="post">
                    <div class="form-body">
                        <a class="ajaxify btn sbold green" href="/gameshow/list"> 返回方案列表
                            <i class="fa fa-reply"></i>
                        </a>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" name="gameshow_id" value="{{ $data->gameshow_id }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">方案名称</label>
                            <div class="col-md-4">
                                <input type="text" name="gameshow_name" class="form-control input-circle" value="{{ $data->gameshow_name }}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">允许版本</label>
                            <div class="col-md-4">
                                <textarea name="allowVersion" class="form-control" disabled>{{ $data->allowVersion }}</textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁止版本</label>
                            <div class="col-md-4">
                                <textarea name="denyVersion" class="form-control" disabled>{{ $data->denyVersion }}</textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">允许渠道</label>
                            <div class="col-md-4">
                                <textarea name="allowChannel" class="form-control" disabled>{{ $data->allowChannel }}</textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">禁止渠道</label>
                            <div class="col-md-4">
                                <textarea name="denyChannel" class="form-control" disabled>{{ $data->denyChannel }}</textarea>
                                <span class="help-block">  </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">配置添加</label>
                            <div class="col-md-4">
                                <a class="ajaxify btn sbold green" href="/showpieces/add?id={{ $data->gameshow_id }}"> 配置添加
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>


<div class="tab-content">
    <div class="tab-pane active" id="tab_1">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-navicon"></i>配置详细
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>名称</th>
                        <th>类型</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>集合（下级）操作</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($showpieces as  $k=>$v)
                        <tr>
                            <td>{{ $v->ShowpiecesId }}</td>
                            <td>{{ $v->ShowpiecesName }}</td>
                            <td>
                                @if($v->ShowpiecesType==0)
                                    单个游戏
                                @elseif($v->ShowpiecesType==1)
                                    快速开始
                                @else
                                    集合
                                @endif
                            </td>
                            <td>{{ $v->SortNum }}</td>
                            <td>
                                @if($v->Available==1)
                                    可用
                                @else
                                    禁用
                                @endif
                            </td>
                            <td>
                                @if($v->ShowpiecesType==2 &&$v->ParentId==0)
                                    <a class="ajaxify btn sbold green" href="/showpieces/addpart?pid={{ $v->ShowpiecesId }}&gid={{$v->gameshow_id}}"> 增加集合子集
                                        <i class="fa fa-plus"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a class="ajaxify btn sbold green" href="/showpieces/edit?id={{ $v->ShowpiecesId }}"> 修改
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="ajaxify btn sbold green" href="/showpieces/del?id={{ $v->ShowpiecesId }}"> 删除
                                    <i class="fa fa-minus"></i>
                                </a>
                            </td>
                        </tr>
                        @if(isset($v->gamelist))

                            @foreach($v->gamelist as $vs)
                                <tr>
                                    <td>|-{{ $vs->ShowpiecesId }}</td>
                                    <td>{{ $vs->ShowpiecesName }}</td>
                                    <td>
                                        @if($vs->ShowpiecesType==0)
                                            单个游戏
                                        @elseif($vs->ShowpiecesType==1)
                                            快速开始
                                        @else
                                            集合
                                        @endif
                                    </td>
                                    <td>{{ $vs->SortNum }}</td>
                                    <td>
                                        @if($vs->Available==2)
                                            展示
                                        @elseif($vs->Available==1)
                                            可用
                                        @elseif($vs->Available==0)
                                            禁用
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/showpieces/edit?id={{ $vs->ShowpiecesId }}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/showpieces/del?id={{ $vs->ShowpiecesId }}"> 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>



