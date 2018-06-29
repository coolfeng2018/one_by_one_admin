
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>代理金币返水修改-@if($type == 'ExchangeRate')
                                        交换比例
                                    @elseif($type == 'CommissionRatio')
                                        提成比例
                                    @elseif($type == 'SuperiorCommissionRatio')
                                        上层代理比例
                                    @endif
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post" id="agentCommission">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <div class="form-group">
                                    <label class="col-md-3 control-label">RoomCard:</label>
                                    <div class="col-md-9">
                                        @if(count($agentCommission->RoomCard)>1)
                                            @foreach($agentCommission->RoomCard as $k => $v)
                                                <input type="text" name="RoomCard" class="form-control input-circle input-inline roomcard" placeholder="eg:100" value="{{ $v }}">
                                            @endforeach
                                        @else
                                            <input type="text" name="RoomCard" class="form-control input-circle input-inline coin" placeholder="eg:100" value="{{ $agentCommission->RoomCard }}">
                                        @endif
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-md-3 control-label">Coin:</label>
                                    <div class="col-md-9">
                                        @if(count($agentCommission->Coin)>1)
                                            @foreach($agentCommission->Coin as $k => $v)
                                                <input type="text" name="Coin" class="form-control input-circle input-inline" placeholder="eg:100" value="{{ $v }}">
                                            @endforeach
                                        @else
                                            <input type="text" name="Coin" class="form-control input-circle input-inline" placeholder="eg:100" value="{{ $agentCommission->Coin }}">
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/commissionRatio/index"> 返回上一页
                                    <i class="fa fa-reply"></i>
                                </button>
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
        FormRepeater.init();

        $("#save").click(function(){
            var coinlength = $("#agentCommission input[name='Coin']").length;
            var roomCardlength = $("#agentCommission input[name='RoomCard']").length;
            var tag = true;
            var json=new Array;
            //RoomCard start
            if(roomCardlength>1){
                var roomcard=new Array;
                $("#agentCommission input[name='RoomCard']").each(function(){
                    var value = $(this).val();
                    if(!value.length){
                        alert('RoomCard不能为空');
                        tag = false;
                    }
                    roomcard.push(parseFloat(value));
                });
            }else{
                roomcard = $("#agentCommission input[name='RoomCard']").val();
                if(!roomcard){
                    alert('RoomCard不能为空');return false;
                }
                roomcard = parseFloat(roomcard);
            }
            //Coin start
            if(coinlength>1){
                var coin=new Array;
                $("#agentCommission input[name='Coin']").each(function(){
                    var value = $(this).val();
                    if(!value.length){
                        alert('Coin不能为空');
                        tag = false;
                    }
                    coin.push(parseFloat(value));
                });
            }else{
                var coin = $("#agentCommission input[name='Coin']").val();
                if(!coin){
                    alert('Coin不能为空');return false;
                }
                coin = parseFloat(coin);
            }
            if(!tag){
                return false;
            }
            result={RoomCard:roomcard,Coin:coin};
            json.push(result);
            var rule=JSON.stringify(json);
            //ajax提交
            $.ajax( {
                type : "post",
                url : "/commissionRatio/save",
                dataType : 'json',
                data : {_token:'{{csrf_token()}}',commissionRatio:rule,type:"<?php echo $type?>"},
                success : function(data) {
                    if(data.status){
                        alert("修改成功");
                        // Layout.loadAjaxContent(data.url);
                    }else{
                        alert('添加失败');
                    }
                }
            });
        });




    })
</script>

