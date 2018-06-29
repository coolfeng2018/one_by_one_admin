
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>商品修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->



                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res['results'] as $resources)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $resources->SaleId }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">优惠名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" value="{{$resources->SaleName}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">优惠类型</label>
                            <div class="col-md-4">
                                <select id="kind" class="form-control input-circle">
                                    @foreach ($res['props'] as $key =>$val)
                                        @if($resources->PropsId == $key)
                                            <option value ="{{ $key }}" selected>{{$val}}</option>
                                        @else
                                            <option value ="{{ $key }}" >{{$val}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">触发条件</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    <option value ="0" @if($resources->Termtype ==0) selected @endif>无</option>
                                    <option value ="1" @if($resources->Termtype ==1) selected @endif>区间触发</option>
                                    <option value ="2" @if($resources->Termtype ==2) selected @endif>ID触发</option>
                                </select>
                            </div>
                        </div>
                        <div id="conditionX">
                            <div id="limitNum">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">触发区间</label>
                                    <div class="col-md-4">
                                        <input  type="text" id="low" class="form-control input-circle input-inline" value="{{$resources->TermMin}}">-
                                        <input  type="text" id="high" class="form-control input-circle input-inline" value="{{$resources->TermMax}}">
                                    </div>
                                </div>
                            </div>
                            <div id="limitUid">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">用户ID触发</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" id="idset" rows="3" style="margin: 0px -1px 0px 0px; height: 150px; width: 500px;">{{ $resources->TermUid }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    @if($resources->Status ==0)
                                        <option value ="0" selected>有效</option>
                                        <option value ="1">无效</option>
                                    @else
                                        <option value ="0">有效</option>
                                        <option value ="1" selected>无效</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">修改</button>
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
            var id=$("#id").val();
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
                data : {'_token':'{{csrf_token()}}',id:id,name:name,kind:kind,type:type,low:low,high:high,idset:idset,status:status},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('修改失败');
                    }
                }
            });
        })

    })
</script>

