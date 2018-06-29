
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>添加人工充值订单
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">用户ID</label>
                            <div class="col-md-4">
                                <input type="text" id="uid" name="uid" class=" form-control input-circle " value="" placeholder="用户ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">订单号</label>
                            <div class="col-md-4">
                                <input type="text" id="order_id" name="order_id" class=" form-control input-circle " value="" placeholder="订单号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">付款方式</label>
                            <div class="col-md-4">
                                <input type="text" name="payname" class=" form-control input-circle " value="人工充值" placeholder="付款方式" readonly="true">
                                <input type="hidden" name="pay_channel" class=" form-control input-circle " value="gm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">平台</label>
                            <div class="col-md-4">
                                <select name="channel" id="channel" class="form-control input-circle">
                                    <option value="z">请选择</option>
                                    <option value="android">安卓</option>
                                    <option value="ios">ios</option>
                                    <option value="window">window</option>
                                </select>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-3 control-label">优惠方案</label>
                            <div class="col-md-4">
                                <input type="text" id="ID" class=" form-control input-circle " value="无" placeholder="优惠方案">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-3 control-label">商品类型</label>
                            <div class="col-md-4">
                                <select name="product_id" id="product_id" class="form-control input-circle">
                                    <option value='1001'>金币</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">数量</label>
                            <div class="col-md-4">
                                <input type="text" id="quantity" name="quantity" class=" form-control input-circle " value="0" placeholder="数量">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">金额</label>
                            <div class="col-md-4">
                                <input type="text" id="amount" name="amount" class=" form-control input-circle " value="0" placeholder="金额">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-3 control-label">折扣</label>
                            <div class="col-md-4">
                                <input type="text" id="ID" class=" form-control input-circle " value="" placeholder="金额">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-3 control-label">购买时间</label>
                            <div class="col-md-4">
                                <input type="text" id="create_time" class=" form-control input-circle " value="{{ date('Y-m-d H:i:s') }}" placeholder="购买时间" readonly="true">
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" id="goback" href="/order/index"> 返回上一页
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
        $("#save").click(function(){
            a = beforeSave();
            if ( ! a) {
                return;
            }
            $.ajax( {
                type : "post",
                url : "/order/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',uid:a.uid,channel:a.channel,amount:a.amount,order_id:a.order_id,pay_channel:a.pay_channel,create_time:a.create_time},
                success : function(data) {
                    if(data.status){
                        alert('添加成功');
                        $('#goback').click();
                    }else{
                        alert('添加失败');
                    }
                }
            });
        });
        
        beforeSave = function() {
            uid = $('#uid').val();
            channel = $('#channel').val(); // 平台
            amount = $('#amount').val(); // 金额
            order_id = $('#order_id').val(); // 订单id
            pay_channel = 'gm';
            create_time = $('#create_time').val(); // 创建订单时间
            if (uid == '') {
                alert('用户id不能为空');
                return false;
            }
            if (channel == 'z') {
                alert('请选择平台');
                return false;
            }
            if (amount == '0' || amount == '') {
                alert('金额不能为0');
                return false;
            }
            return {'uid':uid, 'channel':channel, 'amount':amount, 'order_id':order_id, 'pay_channel':pay_channel, 'create_time':create_time};
        }

        $('#uid').change(function(){
            uid = $(this).val();
            //if (uid.length == 6 && /^\d{6}$/.test(uid)) {
            if (uid.length > 10 || ! /^\d+$/.test(uid)) {
                alert("请输入10位以内数字");
                return;
            }
            if (/^\d+$/.test(uid)) {
                $.ajax( {
                    type : "post",
                    url : "/order/getUser",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',uid:uid},
                    success : function(data) {
                        if(data.success){
                            if (data.channel == 'ios' || data.channel == 'iphone') {
                                $('#channel').val(data.channel);
                            } else if(data.channel == 'android') {
                                $('#channel').val(data.channel);
                            }else {
                                $('#channel').val('z'); // 获取不到平台
                            }
                        } else {
                            $('#channel').val('z'); // 获取不到平台
                        }
                        $('#order_id').val(data.orderId);
                    }
                });
            } else if(uid == "") {
                alert('用户id不能为空');
            }
        })
        
        $('#amount').change(function(){
            num = $(this).val();
            if (/^\d+$/.test(num)) {
                quantity = num*100;
                $('#quantity').val(quantity);
            } else {
                alert('请输入纯阿拉伯数字');
            }
        })
    })
    </script>