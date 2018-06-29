
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>商城添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " value="" placeholder="任务id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">商品名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class=" form-control input-circle " value="" placeholder="商品名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">价格</label>
                            <div class="col-md-9">
                                    <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list">
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <!-- <label class="control-label">货币类型</label> -->
                                                <!--     <input type="text" name="price_currency" placeholder="eg:100" class="form-control price_currency" value=""/> -->
                                                    <select id="price_currency" class=" form-control input-circle price_currency">
                                                            <option value=""></option>
                                                        @foreach($items as $v)
                                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="price_amount" placeholder="货币数量" class="form-control input-circle price_amount" value=""/>
                                                </div>
                                               <!--  <div class="col-md-1">
                                                    <label class="control-label">DEL</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>
                                        <hr>
                                      <!--   <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                            <i class="fa fa-plus"></i> 增加价格</a>
                                        <br> -->
                                        <br> </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">商品</label>
                            <div class="col-md-9">
                                    <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list_shop">
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                   <!--  <label class="control-label">道具id</label>
                                                    <input type="text" name="goods_item_id" placeholder="道具id" class="form-control goods_item_id" value=""/> -->
                                                    <select id="goods_item_id" class=" form-control input-circle goods_item_id">
                                                            <option value=""></option>
                                                        @foreach($items as $v)
                                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <label class="control-label">道具数量</label> -->
                                                    <input type="text" name="goods_item_count" placeholder="道具数量" class="form-control input-circle goods_item_count" value=""/>
                                                </div>
                                              <!--   <div class="col-md-1">
                                                    <label class="control-label">DEL</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>
                                        <hr>
                                   <!--      <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                            <i class="fa fa-plus"></i> 增加商品</a>
                                        <br> -->
                                        <!-- <br>  --></div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">显示序号</label>
                            <div class="col-md-4">
                                <input type="text" id="index" class=" form-control input-circle " value="" placeholder="显示序号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">特惠标识</label>
                            <div class="col-md-4">
                                <input type="text" id="discount" class=" form-control input-circle " value="" placeholder="特惠标识">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">贴图名称</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="" >
                                <input type="hidden"  id="icon_name" class="form-control input-circle" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">苹果id</label>
                            <div class="col-md-4">
                                <input type="text" id="ios_goods_id" class=" form-control input-circle " value="" placeholder="苹果id">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/shop/index"> 返回上一页
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
            FormRepeater.init();
            //file
            $("input[name='file']").change(function(){
                var token=$("input[name='_token']").val();
                var file = $(this)[0].files[0];
                var obj=new FormData();
                obj.append("_token", token);
                obj.append("file", file);
                $.ajax({
                    url: "/shop/uploads",
                    type: "POST",
                    data: obj,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#imgUrl").attr("src", data.RemoteDir+data.msg);
                        $("#icon_name").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var SigningId= $("#SigningId").val();
                var id= $("#id").val();
                var name= $("#name").val();
                var index= $("#index").val();
                var discount= $("#discount").val();
                var icon_name= $("#icon_name").val();
                var ios_goods_id= $("#ios_goods_id").val();
                //验证
                if(id==''){
                    alert('任务id不能为空,请检查');
                    return false;
                }
                if(id=='' || isNaN(id)){
                    alert('任务id必须为数字');
                    return false;
                }
                var json_o=new Array;
                var json_t=new Array;
                var tag = true;
                $("#list .row").each(function(i,item){
                    //获取道具ID，数量
                    price_currency=$(item).find(".price_currency").val();
                    price_amount=$(item).find(".price_amount").val();
                    //判定是否未空
                    if(price_currency==""){
                        alert("货币类型不能为空");
                        tag = false;
                        return false;
                    }
                    if(price_amount==''){
                        alert("货币数量不能为空,如需要请置零");
                        tag = false;
                        return false;
                    }
                    //组字串
                    mystr_o={currency:parseInt(price_currency),amount:parseInt(price_amount)};
                    json_o.push(mystr_o);
                });
                // console.log(mystr_o);return false;
                if(tag==false){
                    return false;
                }
                $("#list_shop .row").each(function(i,item){
                    //获取道具ID，数量
                    goods_item_id=$(item).find(".goods_item_id").val();
                    goods_item_count=$(item).find(".goods_item_count").val();
                    //判定是否未空
                    if(goods_item_id==""){
                        alert("道具id不能为空");
                        tag = false;
                        return false;
                    }
                    if(goods_item_count==''){
                        alert("道具数量不能为空,如需要请置零");
                        tag = false;
                        return false;
                    }
                    //组字串
                    mystr_t={item_id:parseInt(goods_item_id),item_count:parseInt(goods_item_count)};
                    json_t.push(mystr_t);
                });
                if(tag==false){
                    return false;
                }
                var award_o=JSON.stringify(json_o);
                var award_t=JSON.stringify(json_t);
              // console.log(award);return false;
                $.ajax( {
                    type : "post",
                    url : "/shop/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',SigningId:SigningId,price:award_o,goods:award_t,id:id,name:name,index:index,discount:discount,icon_name:icon_name,ios_goods_id:ios_goods_id},
                    success : function(data) {
                        if(data.status){
                            alert('添加成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('添加失败');
                        }
                    }
                });
            });
        })
    </script>