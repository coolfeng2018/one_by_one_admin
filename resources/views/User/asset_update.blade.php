
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>道具修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="/props/save" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $res['UserId'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="oldCoin" class="form-control input-circle" value="{{ $res['coin'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">金币</label>
                            <div class="col-md-4">
                                <input type="text" id="coin" class="form-control input-circle" value="{{ $res['coin'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="oldCard" class="form-control input-circle" value="{{ $res['card'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">房卡</label>
                            <div class="col-md-4">
                                <input type="text" id="card" class="form-control input-circle" value="{{ $res['card'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="oldGem" class="form-control input-circle" value="{{ $res['gem'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">钻石</label>
                            <div class="col-md-4">
                                <input type="text" id="gem" class="form-control input-circle" value="{{ $res['gem'] }}">
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
            var id= $("#id").val();
            var coin=  $("#coin").val();
            var card=  $("#card").val();
            var gem=  $("#gem").val();
            var oldCoin=  $("#oldCoin").val();
            var oldCard=  $("#oldCard").val();
            var oldGem=  $("#oldGem").val();

            var reg=/^\d+$/;


            if(!reg.test(String(coin)) || !reg.test(String(card))){
                alert('请输入非负整数');
                return false;
            }
            $.ajax( {
                type : "post",
                url : "/user/asset_save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,coin:coin,card:card,gem:gem,oldCoin:oldCoin,oldCard:oldCard,oldGem:oldGem},
                success : function(data) {
                    if(data.status){
                        alert('修改成功');
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data.msg);
                    }
                }
            });
        })
    })
</script>