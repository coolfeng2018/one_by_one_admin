<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">修改网关</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="gateway_id" type="hidden" value="{{ $data->GateWay_ID }}">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">网关名称</label>
                    <div class="col-md-4">
                        <input name="gamewayname" type="text" class="form-control" placeholder="Enter text" value="{{ $data->GameWayName }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">网关IP</label>
                    <div class="col-md-4">
                        <input name="ip" type="text" class="form-control" placeholder="Enter text" value="{{ $data->IP }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">网关端口</label>
                    <div class="col-md-4">
                        <input name="prot" type="text" class="form-control" placeholder="Enter text" value="{{ $data->prot }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">权重、排序</label>
                    <div class="col-md-4">
                        <input name="sortid" type="text" class="form-control" placeholder="Enter text" value="{{ $data->SortID }}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">状态</label>
                    <div class="col-md-4">
                        <select class="form-control" name="islock">
                            <option value="0" @if($data->IsLock==0) selected="selected" @endif> 未启用 </option>
                            <option value="1" @if($data->IsLock==1) selected="selected" @endif> 启用</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">服务器</label>
                    <div class="col-md-4">
                        <div class="md-checkbox-list">
                            @foreach($server as $v)
                                <div class="md-radio">
                                    <input type="radio" id="radio_{{ $v->server_id }}" name="server_id" class="md-check" value="{{ $v->server_id }}" @if(isset($server_id[$v->server_id])) checked @endif >
                                    <label for="radio_{{ $v->server_id }}">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ $v->server_name }} </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">添加</button>
                        <button type="button" class="btn default">重置</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#sub").click(function(){
            console.log('ok');
            $.ajax({
                type:"post",
                url:"/gateway/post",
                data:$('#myform').serialize(),
                async: false,
                error: function(request) {
                    alert("出现错误");
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    console.log(obj);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/gateway/list");
                    }else{
                        alert("添加失败");
                    }
                }

            });
        });
    });
</script>

