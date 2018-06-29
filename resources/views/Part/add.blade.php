
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>角色添加
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
                                <input type="text" id="name" class="form-control input-circle" placeholder="角色名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="1">有效</option>
                                    <option value ="0">无效</option>
                                </select>
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
$(function(){
    $("#save").click(function(){
        var name= $("#name").val();
        var status= $("#status").val();

        $.ajax( {
            type : "post",
            url : "/part/save",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',name:name,status:status},
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
