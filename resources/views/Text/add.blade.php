
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>文本配置添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " placeholder="id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">通知消息类型</label>
                            <div class="col-md-4">
                                <select id="type" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="1">俱乐部解散</option>
                                    <option value="2">提升为俱乐部管理员</option>
                                    <option value="3">撤销俱乐部管理员</option>
                                    <option value="4">被踢出俱乐部</option>
                                    <option value="5">加入俱乐部</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">通知消息类型</label>
                            <div class="col-md-4">
                                <input type="text" id="content" class=" form-control input-circle " placeholder="通知消息类型">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/text/index"> 返回上一页
                                    <i class="fa fa-reply"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger" id="error_ul" style="display: none">
                        
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){


        //ajax提交
        $("#save").click(function(){
            var id= $("#id").val();
            var type= $("#type").val();
            var content= $("#content").val();

            //校验
            if(type==""||content ==""||id=="") {
                alert("id和通知消息类型和通知内容不能为空");
                return false;
            }
            $.ajax( {
                type : "post",
                url : "/text/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,type:type,content:content},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data);
                    }
                },
                //校验信息
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // alert(XMLHttpRequest.responseText);
                    var dataError = XMLHttpRequest.responseText;
                    obj = JSON.parse(dataError);
                    tbody = '<ul>';
                     $.each(obj, function (n, value) {
                           // alert(n + ' ' + value);
                           var trs = "";
                           trs += "<li>" + value + "</li>";
                           tbody += trs;
                    });
                    tbody += '</ul>';
                    $("#error_ul").html(tbody);
                    $("#error_ul").show();
                }
            });
        })

    })
</script>
