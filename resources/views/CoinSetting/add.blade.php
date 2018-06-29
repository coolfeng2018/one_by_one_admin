
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>金币房配置添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏类型</label>
                            <div class="col-md-4">
                                <select id="game" class="form-control input-circle">
                                    @foreach ($res['games'] as $k =>$v)
                                        <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="infoNN">

                            <div class="form-group">
                                <label class="col-md-3 control-label">场次类型</label>
                                <div class="col-md-4">
                                    <select id="level" class="form-control input-circle">
                                        <option value ="1">初级</option>
                                        <option value ="2">中级</option>
                                        <option value ="3">高级</option>
                                    </select>
                                </div>
                            </div>

                            <span>庄家配置</span>
                            <hr/>
                            <div class="form-group">
                                <label class="col-md-3 control-label">1倍庄</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id1" class="form-control input-circle input-inline" value="1">
                                    <input type="text" id="low1" class="form-control input-circle input-inline" placeholder="eg:100">-
                                    <input type="text" id="high1" class="form-control input-circle input-inline" placeholder="eg:400">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">2倍庄</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id2" class="form-control input-circle input-inline" value="2">
                                    <input type="text" id="low2" class="form-control input-circle input-inline" placeholder="eg:400">-
                                    <input type="text" id="high2" class="form-control input-circle input-inline" placeholder="eg:800">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">3倍庄</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id3" class="form-control input-circle input-inline" value="3">
                                    <input type="text" id="low3" class="form-control input-circle input-inline" placeholder="eg:800">-
                                    <input type="text" id="high3" class="form-control input-circle input-inline" placeholder="eg:1200">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">4倍庄</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id4" class="form-control input-circle input-inline" value="4">
                                    <input type="text" id="low4" class="form-control input-circle input-inline" placeholder="eg:1200">-
                                    <input type="text" id="high4" class="form-control input-circle input-inline" placeholder="eg:1600">
                                </div>
                            </div>

                            <span>闲家配置</span>
                            <hr/>
                            <div class="form-group">
                                <label class="col-md-3 control-label">5倍</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="ids1" class="form-control input-circle input-inline" value="5">
                                    <input type="text" id="lows1" class="form-control input-circle input-inline" placeholder="eg:100">-
                                    <input type="text" id="highs1" class="form-control input-circle input-inline" placeholder="eg:400">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">10倍</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="ids2" class="form-control input-circle input-inline" value="10">
                                    <input type="text" id="lows2" class="form-control input-circle input-inline" placeholder="eg:400">-
                                    <input type="text" id="highs2" class="form-control input-circle input-inline" placeholder="eg:800">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">15倍</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="ids3" class="form-control input-circle input-inline" value="15">
                                    <input type="text" id="lows3" class="form-control input-circle input-inline" placeholder="eg:800">-
                                    <input type="text" id="highs3" class="form-control input-circle input-inline" placeholder="eg:1200">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">20倍</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="ids4" class="form-control input-circle input-inline" value="20">
                                    <input type="text" id="lows4" class="form-control input-circle input-inline" placeholder="eg:1200">-
                                    <input type="text" id="highs4" class="form-control input-circle input-inline" placeholder="eg:1600">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">25倍</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="ids5" class="form-control input-circle input-inline" value="25">
                                    <input type="text" id="lows5" class="form-control input-circle input-inline" placeholder="eg:1200">-
                                    <input type="text" id="highs5" class="form-control input-circle input-inline" placeholder="eg:1600">
                                </div>
                            </div>
                        </div>

                        <div id="infoJH">
                            <div class="form-group">
                                <label class="col-md-3 control-label">上庄MIN</label>
                                <div class="col-md-4">
                                    <input type="text" id="up" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">下庄MIN</label>
                                <div class="col-md-4">
                                    <input type="text" id="down" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">抽水</label>
                                <div class="col-md-4">
                                    <input type="text" id="pump" class="form-control input-circle" placeholder="eg:10">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="1">启用</option>
                                    <option value ="0">禁用</option>
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
        $('#infoNN').show();
        $('#infoJH').hide();
        //点击改变页面显示内容
        $('#game').change(function(){
            if($('#game').val() == 1001){
                $('#infoNN').show();
                $('#infoJH').hide();
            }else{
                $('#infoJH').show();
                $('#infoNN').hide();
            }
        });

        //ajax提交
        $("#save").click(function(){

            var game= $("#game").val();
            var status= $("#status").val();
            var json=new Array;
            if(game == 1001){
                //庄家配置
                var id1=$('#id1').val();
                var low1=$('#low1').val();
                var high1=$('#high1').val();

                var id2=$('#id2').val();
                var low2=$('#low2').val();
                var high2=$('#high2').val();

                var id3=$('#id3').val();
                var low3=$('#low3').val();
                var high3=$('#high3').val();

                var id4=$('#id4').val();
                var low4=$('#low4').val();
                var high4=$('#high4').val();
                //闲家配置
                var ids1=$('#ids1').val();
                var lows1=$('#lows1').val();
                var highs1=$('#highs1').val();

                var ids2=$('#ids2').val();
                var lows2=$('#lows2').val();
                var highs2=$('#highs2').val();

                var ids3=$('#ids3').val();
                var lows3=$('#lows3').val();
                var highs3=$('#highs3').val();

                var ids4=$('#ids4').val();
                var lows4=$('#lows4').val();
                var highs4=$('#highs4').val();

                var ids5=$('#ids5').val();
                var lows5=$('#lows5').val();
                var highs5=$('#highs5').val();



                var level=$('#level').val();


                var reg=/^\d+$/;
                if(!reg.test(String(low1)) || !reg.test(String(high1)) || !reg.test(String(low2)) || !reg.test(String(high2)) || !reg.test(String(low3)) || !reg.test(String(high3)) || !reg.test(String(low4)) || !reg.test(String(high4))){
                    alert('请输入非负整数');
                    return false;
                }
                if(Number(high1)<=Number(low1)){
                    alert('1倍庄区间错误');
                    return false;
                }
                if(Number(high2)<=Number(low2)){
                    alert('2倍庄区间错误');
                    return false;
                }
                if(Number(high3)<=Number(low3)){
                    alert('3倍庄区间错误');
                    return false;
                }
                if(Number(high4)<=Number(low4)){
                    alert('4倍庄区间错误');
                    return false;
                }
                if(!reg.test(String(lows1)) || !reg.test(String(highs1)) || !reg.test(String(lows2)) || !reg.test(String(highs2)) || !reg.test(String(lows3)) || !reg.test(String(highs3)) || !reg.test(String(lows4)) || !reg.test(String(highs4))){
                    alert('请输入非负整数');
                    return false;
                }
                if(Number(highs1)<=Number(lows1)){
                    alert('5倍区间错误');
                    return false;
                }
                if(Number(highs2)<=Number(lows2)){
                    alert('10倍区间错误');
                    return false;
                }
                if(Number(highs3)<=Number(lows3)){
                    alert('15倍区间错误');
                    return false;
                }
                if(Number(highs4)<=Number(lows4)){
                    alert('20倍区间错误');
                    return false;
                }
                var m=new Array;
                mstr1={type:parseInt(id1),min:parseInt(low1),max:parseInt(high1)};
                mstr2={type:parseInt(id2),min:parseInt(low2),max:parseInt(high2)};
                mstr3={type:parseInt(id3),min:parseInt(low3),max:parseInt(high3)};
                mstr4={type:parseInt(id4),min:parseInt(low4),max:parseInt(high4)};
                m.push(mstr1);
                m.push(mstr2);
                m.push(mstr3);
                m.push(mstr4);
                var s=new Array;
                sstr1={type:parseInt(ids1),min:parseInt(lows1),max:parseInt(highs1)};
                sstr2={type:parseInt(ids2),min:parseInt(lows2),max:parseInt(highs2)};
                sstr3={type:parseInt(ids3),min:parseInt(lows3),max:parseInt(highs3)};
                sstr4={type:parseInt(ids4),min:parseInt(lows4),max:parseInt(highs4)};
                sstr5={type:parseInt(ids5),min:parseInt(lows5),max:parseInt(highs5)};
                s.push(sstr1);
                s.push(sstr2);
                s.push(sstr3);
                s.push(sstr4);
                s.push(sstr5);
                newstr={master:m,slave:s};
                json.push(newstr);
            }else{
                var up=$('#up').val();
                var down=$('#down').val();
                var pump=$('#pump').val();

                var level=0;

                var reg=/^\d+$/;
                if(!reg.test(String(up)) || !reg.test(String(down)) || !reg.test(String(pump))){
                    alert('请输入非负整数');
                    return false;
                }

                mystr={up:parseInt(up),down:parseInt(down),pump:parseInt(pump)};
                json.push(mystr);
            }
            var rule=JSON.stringify(json);

            $.ajax( {
                type : "post",
                url : "/coinSetting/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',game:game,level:level,rule:rule,status:status},
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
