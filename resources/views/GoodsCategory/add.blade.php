
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>渠道商品类添加
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
                                <input type="text" id="name" class="form-control input-circle" placeholder="分类名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">适用版本</label>
                            <div class="col-md-4">
                                <input type="text" id="suitTag" class="form-control input-circle" placeholder="适用版本">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁用版本</label>
                            <div class="col-md-4">
                                <input type="text" id="banTag" class="form-control input-circle" placeholder="禁用版本">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">适用渠道</label>
                            <div class="col-md-4">
                                <input type="text" id="suitSign" class="form-control input-circle" placeholder="适用渠道">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">禁用渠道</label>
                            <div class="col-md-4">
                                <input type="text" id="banSign" class="form-control input-circle" placeholder="禁用渠道">
                            </div>
                        </div>

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
            var name= $("#name").val();
            var suitTag= $("#suitTag").val();
            var banTag= $("#banTag").val();
            var suitSign= $("#suitSign").val();
            var banSign= $("#banSign").val();


            $.ajax( {
                type : "post",
                url : "/goodsCategory/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,suitTag:suitTag,banTag:banTag,suitSign:suitSign,banSign:banSign},
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
