
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>首充礼包修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label"> 上线时间 </label>
                            <div class="col-md-4">
                                <input type="text" id="stime" class="form-control input-circle" value="{{$res['charge']['stime']}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"> 下线时间 </label>
                            <div class="col-md-4">
                                <input type="text" id="etime" class="form-control input-circle" value="{{$res['charge']['etime']}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"> 售价 </label>
                            <div class="col-md-4">
                                <input type="text" id="price" class="form-control input-circle" value="{{$res['charge']['price']}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">礼包详细</label>
                            <div class="col-md-9">
                                <div class="mt-repeater">
                                    <div data-repeater-list="group-b" id="list">
                                        @foreach($res['charge']['saling'] as $k=>$v)

                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">STYLE</label>
                                                    <select class="form-control kind" name="group-b[0][kind]">
                                                        @foreach($res['kind'] as $kk =>$vv)
                                                            @if($v['type']==$kk)
                                                                <option value="{{$kk}}" selected>{{$vv}}</option>
                                                            @else
                                                                <option value="{{$kk}}">{{$vv}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">NUM</label>
                                                    <input type="text" name="num" placeholder="显示内容" class="form-control num" value="{{ $v['number']}}"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="control-label">DEL</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                        <i class="fa fa-plus"></i> 增加配置项</a>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>



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
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();

        FormRepeater.init();
        //ajax提交
        $("#save").click(function(){
            var json=new Array;
            $("#list .row").each(function(i,item){
                //获取道具名称，数量
                mykey=$(item).find(".kind").find('option:selected').val();
                myname=$(item).find(".kind").find('option:selected').text();
                myval=$(item).find(".num").val();
                //判定是否未空
                if(typeof(mykey)=="undefined"){
                    alert("奖励类型不能为空");
                    return false;
                }
                if(myval<0){
                    alert("奖励数量不能为空,如需要请置零");
                    return false;
                }
                //组字串
                mystr={type:parseInt(mykey),name:myname,number:parseInt(myval)};
                json.push(mystr);
            });
            var detail=JSON.stringify(json);

            if(detail.length<=2){
                alert("礼包内容错误");
                return false;
            }

            var stime=$("#stime").val();
            var etime=$("#etime").val();
            var price=$("#price").val();

            var reg = /^\d+(?=\.{0,1}\d+$|$)/
            if(!reg.test(price)){
                alert("售价出错");
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/saleGift/saveCharge",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',stime:stime,etime:etime,price:price,detail:detail},
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

