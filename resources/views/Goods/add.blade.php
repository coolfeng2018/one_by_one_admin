
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>商品添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">商品名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="商品名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">商品描述</label>
                            <div class="col-md-4">
                                <input type="text" id="detail" class="form-control input-circle" placeholder="商品描述">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道分类</label>
                            <div class="col-md-4">
                                <select id="kind" class="form-control input-circle">
                                    @foreach ($res['kind'] as $k =>$v)
                                    <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">分类</label>
                            <div class="col-md-4">
                                <select id="goodsType" class="form-control input-circle">
                                    <option value ="1">金币</option>
                                    <option value ="2">钻石</option>
                                    <option value ="3">房卡</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">商品图像</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="" >
                                <input type="hidden"  id="img" class="form-control input-circle" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">角标</label>
                            <div class="col-md-4">
                                <select id="tag" class="form-control input-circle">
                                    <option value ="0">无</option>
                                    <option value ="1">房卡免费</option>
                                    <option value ="2">专属优惠</option>
                                    <option value ="3">限时优惠</option>
                                    <option value ="4">4</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">平台</label>
                            <div class="col-md-4">
                                <select id="platform" class="form-control input-circle">
                                    <option value ="0">全平台</option>
                                    <option value ="1">安卓</option>
                                    <option value ="2">苹果</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">促销方案</label>
                            <div class="col-md-4">
                                <select id="sale" class="form-control input-circle">
                                    @foreach ($res['sale'] as $k =>$v)
                                        <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">赠送（%）</label>
                            <div class="col-md-4">
                                <input type="text" id="gift" class="form-control input-circle" placeholder="eg:10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">货币类型</label>
                            <div class="col-md-4">
                                <select id="costTag" class="form-control input-circle">
                                    <option value ="1" >RMB</option>
                                    <option value ="2" >钻石</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">售价</label>
                            <div class="col-md-4">
                                <input type="text" id="amount" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">购买获取道具</label>
                            <div class="col-md-4">
                                <select id="gainTag" class="form-control input-circle">
                                    @foreach ($res['props'] as $key =>$val)
                                        <option value ="{{ $key }}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">购买获取数量</label>
                            <div class="col-md-4">
                                <input type="text" id="number" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">优先级</label>
                            <div class="col-md-4">
                                <input type="text" id="level" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">苹果商品标识</label>
                            <div class="col-md-4">
                                <input type="text" id="appMark" class="form-control input-circle" placeholder="苹果商品标识">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">支付渠道</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="icheck-inline">
                                        <label class="">
                                            <div class="icheckbox_minimal" style="position: relative;">
                                                <input type="checkbox" class="icheck" id="wx" value="wx" style="position: absolute; opacity: 0;">
                                                {{--<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                            </div>
                                            微信
                                        </label>
                                        <label class="">
                                            <div class="icheckbox_minimal" style="position: relative;">
                                                <input type="checkbox" class="icheck" id="alipay" value="alipay" style="position: absolute; opacity: 0;">
                                                {{--<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                            </div>
                                            支付宝
                                        </label>
                                        <label class="">
                                            <div class="icheckbox_minimal" style="position: relative;">
                                                <input type="checkbox" class="icheck" id="union" value="union" style="position: absolute; opacity: 0;">
                                                {{--<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                            </div>
                                            银行卡
                                        </label>
                                        <label class="">
                                            <div class="icheckbox_minimal" style="position: relative;">
                                                <input type="checkbox" class="icheck" id="iap" value="iap" style="position: absolute; opacity: 0;">
                                                {{--<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                            </div>
                                           苹果
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">下架时间</label>
                            <div class="col-md-4">
                                <input type="text" value="" id="endTime" class="form-control input-circle" placeholder="下架时间">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">道具有效期</label>
                            <div class="col-md-9">
                                <input type="text"  id="term" class="form-control input-inline input-circle" placeholder="eg:10">
                                <span class="help-inline">天</span>
                                <span class="help-inline" style="color:red;">只针对房卡或其他道具不包含（钻石、金币）</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="0">上架</option>
                                    <option value ="1">下架</option>
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
        //time
        $('#endTime').datetimepicker();
        //file
        $("input[name='file']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this)[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/goods/uploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imgUrl").attr("src", data.RemoteDir+data.msg);
                    $("#img").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
        //ajax提交
        $("#save").click(function(){
            var name= $("#name").val();
            var kind= $("#kind").val();
            var sale= $("#sale").val();
            var gainTag= $("#gainTag").val();
            var number= $("#number").val();
            var costTag= $("#costTag").val();
            var amount= $("#amount").val();
            var img= $("#img").val();
            var status= $("#status").val();
            var platform= $("#platform").val();
            var gift= $("#gift").val();
            var level= $("#level").val();
            var appMark= $("#appMark").val();
            var tag= $("#tag").val();
            var endTime= $("#endTime").val();

            var detail =$('#detail').val();
            var term =$('#term').val();
            var goodsType =$('#goodsType').val();

            var arr =new Array();
            if($('#wx').is(":checked")){
               var wx=$('#wx').val();
                arr.push(wx);
            }
            if($('#alipay').is(":checked")){
                var alipay=$('#alipay').val();
                arr.push(alipay);
            }
            if($('#union').is(":checked")){
                var union=$('#union').val();
                arr.push(union);
            }
            if($('#iap').is(":checked")){
                var iap=$('#iap').val();
                arr.push(iap);
            }
            var payment=arr.join("|");

            if(name==''){
                alert('商品名称不能为空');
                return false;
            }
            if(img==''){
                alert('缺乏上传资源');
                return false;
            }
            if(!number || !amount || !gift || !level){
                alert('请输入数字');
                return false;
            }
            if(isNaN(number)|| isNaN(amount)|| isNaN(gift) || isNaN(gift)){
                alert('请输入数字');
                return false;
            }
            if(endTime==''){
                alert('请输入下架时间');
                return false;
            }
            $.ajax( {
                type : "post",
                url : "/goods/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,kind:kind,sale:sale,gainTag:gainTag,number:number,costTag:costTag,amount:amount,img:img,status:status,platform:platform,gift:gift,level:level,appMark:appMark,tag:tag,endTime:endTime,detail:detail,term:term,payment:payment,goodsType:goodsType},
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
