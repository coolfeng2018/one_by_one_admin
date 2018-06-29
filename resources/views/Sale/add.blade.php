
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>优惠规则添加
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
                                <input type="text" id="name" class="form-control input-circle" placeholder="优惠名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">优惠类型</label>
                            <div class="col-md-4">
                                <select id="kind" class="form-control input-circle">
                                    @foreach ($res['props'] as $key =>$val)
                                        <option value ="{{ $key }}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">触发条件</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    <option value ="0">无</option>
                                    <option value ="1">区间触发</option>
                                    <option value ="2">用户ID触发</option>
                                </select>
                            </div>
                        </div>
                        <div id="conditionX">
                            <div id="limitNum">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">触发区间</label>
                                    <div class="col-md-4">
                                        <input  type="text" id="low" class="form-control input-circle input-inline" placeholder="eg:100">-
                                        <input  type="text" id="high" class="form-control input-circle input-inline" placeholder="eg:1000">
                                    </div>
                                </div>
                            </div>
                            <div id="limitUid">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">用户ID触发</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" id="idset" rows="3" style="margin: 0px -1px 0px 0px; height: 150px; width: 500px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="0">有效</option>
                                    <option value ="1">无效</option>
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
        $('#conditionX').hide();
        //点击改变页面显示内容
        $('#type').change(function(){
            if($('#type').val() == 0){
                $('#conditionX').hide();
            }else{
                $('#conditionX').show();
                if($('#type').val() == 1){
                    $('#limitNum').show();
                    $('#limitUid').hide();
                }else{
                    $('#limitNum').hide();
                    $('#limitUid').show();
                }
            }
        });
        //ajax提交
        $("#save").click(function(){
            var name= $("#name").val();
            var kind= $("#kind").val();
            var type= $("#type").val();
            var status= $("#status").val();

            if(type == 0){

                var low =0;
                var high =0;
                var idset='';

            }else if(type == 1){

                var idset='';
                var low= $("#low").val();
                var high= $("#high").val();
                var reg=/^\d+$/;
                if(!reg.test(String(low)) || !reg.test(String(high))){
                    alert('触发区间请输入非负整数');
                    return false;
                }

                if(Number(low) >= Number(high)){
                    alert('触发区间设置错误');
                    return false;
                }

            }else if(type == 2){

                var low =0;
                var high =0;
                var idset= $("#idset").val();

            }

            $.ajax( {
                type : "post",
                url : "/sale/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,kind:kind,type:type,low:low,high:high,idset:idset,status:status},
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
