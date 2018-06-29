
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>渠道商品类修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="/props/save" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res as $resources)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $resources->CategoryId }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" value="{{ $resources->CategoryName }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">适用版本</label>
                            <div class="col-md-4">
                                <input type="text" id="suitTag" class="form-control input-circle" value="{{ $resources->AllowVersion }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁用版本</label>
                            <div class="col-md-4">
                                <input type="text" id="banTag" class="form-control input-circle" value="{{ $resources->DenyVersion }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">适用渠道</label>
                            <div class="col-md-4">
                                <input type="text" id="suitSign" class="form-control input-circle" value="{{ $resources->AllowChannel }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁用渠道</label>
                            <div class="col-md-4">
                                <input type="text" id="banSign" class="form-control input-circle" value="{{ $resources->DenyChannel }}">
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
            var suitTag= $("#suitTag").val();
            var banTag= $("#banTag").val();
            var suitSign= $("#suitSign").val();
            var banSign= $("#banSign").val();

            $.ajax( {
                type : "post",
                url : "/goodsCategory/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,name:name,suitTag:suitTag,banTag:banTag,suitSign:suitSign,banSign:banSign},
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