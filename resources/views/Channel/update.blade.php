
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>渠道修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res as $resources)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $resources->ChannelId }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" value="{{ $resources->ChannelName }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">编号</label>
                            <div class="col-md-4">
                                <input type="text" id="code" class="form-control input-circle" value="{{ $resources->ChannelCode }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    <option value ="1" @if($resources->IsOnline==1) selected @endif>线上渠道</option>
                                    <option value ="0" @if($resources->IsOnline==0) selected @endif>线下渠道</option>
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">更新</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        //ajax提交
        $("#save").click(function() {
            var id= $("#id").val();
            var name= $("#name").val();
            var code = $("#code").val();
            var type = $("#type").val();

            if(name==''){
                alert('名称不能为空');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/channel/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,name:name,code:code,type:type},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('修改失败');
                    }
                }
            });
        })
    })
</script>