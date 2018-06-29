
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>常量添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">id类型</label>
                            <div class="col-md-4">
                                <select id="id" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    @foreach($valuecfg as $k=>$v)
                                    <option value="{{ $k }}" >{{ $v['name'] }}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">value</label>
                            <div class="col-md-4">
                                <input type="text" id="value" class=" form-control input-circle " placeholder="value">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/gamevalue/index"> 返回上一页
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
            var value= $("#value").val();
            var id= $("#id").val();

            //校验
            if(value==""||id =="") {
                alert("id类型和value不能为空");
                return false;
            }
            $.ajax( {
                type : "post",
                url : "/gamevalue/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',value:value,id:id},
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
