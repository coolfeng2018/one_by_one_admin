
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>兑换下线修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">兑换最小额度</label>
                            <div class="col-md-4">
                                <input type="text" id="rangeCurrentAmount" class="form-control input-circle" value="{{ $rangeCurrentAmount }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">兑换后最少保留额度</label>
                            <div class="col-md-4">
                                <input type="text" id="minAmount" class="form-control input-circle" value="{{ $minAmount }}">
                            </div>
                        </div>
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
            var rangeCurrentAmount= $("#rangeCurrentAmount").val();
            var minAmount= $("#minAmount").val();

            if(rangeCurrentAmount==''){
                alert('兑换最小额度');
                return false;
            }
            if(minAmount==''){
                alert(' 兑换后最少保留额度');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/withdrawconfig/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',rangeCurrentAmount:rangeCurrentAmount,minAmount:minAmount},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent("/withdrawconfig/config");
                    }else{
                        alert('修改失败');
                    }
                }
            });
        })
    })
</script>