
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>渠道添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="渠道名称" value="{{ $data->name }}">
                                <input type="hidden" id="id" class="form-control input-circle" placeholder="渠道名称" value="{{ $data->id }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">编号</label>
                            <div class="col-md-4">
                                <input type="text" id="code" class="form-control input-circle" placeholder="渠道编号" value="{{ $data->code }}">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道状态</label>
                            <div class="col-md-4">
                                <select id="status" id="status" class="form-control input-circle">
                                    <option value ="1">正常</option>
                                    <option value ="2">失效</option>
                                </select>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
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
        $("#save").click(function(){
            var name = $("#name").val();
            var code = $("#code").val();
            var status = $("#status").val();
            var id = $("#id").val();
            if(name==''){
                alert('名称不能为空');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/channellist/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,code:code,status:status, id:id},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('添加失败');
                    }
                }
            });
        })
   })
</script>
