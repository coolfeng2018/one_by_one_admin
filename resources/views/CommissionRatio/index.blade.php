<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">代理金返水配置</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 返水配置类型 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div>
                        @foreach($agentCommission as $k => $v)
                        <tr class="odd gradeX">
                            <td>
                                <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $k }}">
                                    @if($k == 'ExchangeRate')
                                        交换比例
                                    @elseif($k == 'CommissionRatio')
                                        提成比例
                                    @elseif($k == 'SuperiorCommissionRatio')
                                        上层代理比例
                                    @endif
                                </button>
                                <div class="modal fade" id="myModal_{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                    @if($k == 'ExchangeRate')
                                                        交换比例
                                                    @elseif($k == 'CommissionRatio')
                                                        提成比例
                                                    @elseif($k == 'SuperiorCommissionRatio')
                                                        上层代理比例
                                                    @endif
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    @if(count($v->RoomCard)>1)
                                                        <p align="left">RoomCard:
                                                        @for($i=0;$i<count($v->RoomCard)+1;$i++)
                                                            @if($i==0)一级:{{ $v->RoomCard[$i] }}
                                                            @elseif($i==1)二级:{{ $v->RoomCard[$i] }}
                                                            @elseif($i==2)三级:{{ $v->RoomCard[$i] }}
                                                            @endif
                                                        @endfor
                                                        <p>
                                                        <p align="left">
                                                        {{ isset($v->Coin) ? 'Coin:'.$v->Coin : '' }}
                                                    </p>
                                                    @else
                                                        <p align="left">RoomCard:{{ $v->RoomCard }}</p>
                                                        <p align="left">Coin:{{ $v->Coin }}</p>
                                                    @endif

                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a class="ajaxify btn sbold green" href="/commissionRatio/edit?type={{ $k }}"> 修改
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </div>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
