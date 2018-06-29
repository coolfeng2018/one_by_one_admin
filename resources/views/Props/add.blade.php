
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>道具添加
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
                                <input type="text" id="name" class="form-control input-circle" placeholder="道具名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-4">
                                <input type="text" id="describe" class="form-control input-circle" placeholder="道具描述">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">类型</label>
                            <div class="col-md-4">
                                <select id="type">
                                    <option value ="0">货币</option>
                                    <option value ="1">其他</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status">
                                    <option value ="0">下架</option>
                                    <option value ="1">上架</option>
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
    $(function() {
        //ajax提交
        $("#save").click(function() {
            var name= $("#name").val();
            var describe=  $("#describe").val();
            var type=$('#type option:selected') .val();//选中的值
            var status=$('#status option:selected') .val();//选中的值

            if(name==''){
                alert('道具名称不能为空');
                return false;
            }

            if(describe==''){
                alert('道具描述不能为空');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/props/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,describe:describe,type:type,status:status},
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
