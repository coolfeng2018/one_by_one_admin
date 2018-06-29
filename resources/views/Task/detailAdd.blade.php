
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>活动详细添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="pid" class="form-control input-circle" value="{{ $pid }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品等级</label>
                            <div class="col-md-4">
                                <select id="level" class="form-control input-circle">
                                    @foreach ($award['levels'] as $k =>$v)
                                        <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="奖品名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    @foreach ($award['types'] as $k =>$v)
                                        <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品单价</label>
                            <div class="col-md-4">
                                <input type="text" id="price" class=" form-control input-circle " placeholder="奖品单价">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品数量</label>
                            <div class="col-md-4">
                                <input type="text" id="total" class=" form-control input-circle" placeholder="奖品数量">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">奖品投放数量</label>
                            <div class="col-md-4">
                                <input type="text" id="number" class=" form-control input-circle" placeholder="奖品投放数量">
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
        //ajax提交
        $("#save").click(function(){
            var pid= $("#pid").val();
            var level= $("#level").val();
            var name= $("#name").val();
            var type= $("#type").val();
            var price= $("#price").val();
            var total= $("#total").val();
            var number= $("#number").val();

            var f=/^\d+(?=\.{0,1}\d+$|$)/;
            var i=/^\d+$/;
            if(!f.test(price)){
                alert('奖品单价设置错误');
                return false;
            }
　　　　　　if(!i.test(total)){
                alert('奖品数量设置错误');
                return false;
            }
            if(!i.test(number)){
                alert('奖品投放数量设置错误');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/party/detailSave",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',pid:pid,level:level,name:name,type:type,price:price,total:total,number:number},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data.msg);
                    }
                }
            });
        })

    })
</script>
