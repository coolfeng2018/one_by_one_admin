
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>场次添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">场次名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="场次名称">
                            </div>
                        </div>

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

                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏名称</label>
                            <div class="col-md-4">
                                <select id="game" class="form-control input-circle">
                                    @foreach ($res['games'] as $k =>$v)
                                        <option value ="{{ $k }}" >{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">背景</label>
                            <div class="col-md-4">
                                <input type="file" name="file1" class="form-control input-circle" >
                                <img id="imgUrl1" src="" >
                                <input type="hidden"  id="img1" class="form-control input-circle" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">底分img</label>
                            <div class="col-md-4">
                                <input type="file" name="file2" class="form-control input-circle" >
                                <img id="imgUrl2" src="" >
                                <input type="hidden"  id="img2" class="form-control input-circle" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">gif</label>
                            <div class="col-md-4">
                                <input type="file" name="file3" class="form-control input-circle" >
                                <img id="imgUrl3" src="" >
                                <input type="hidden"  id="img3" class="form-control input-circle" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">入场限制</label>
                            <div class="col-md-4">
                                <input  type="text" id="low" class="form-control input-circle input-inline" placeholder="eg:100">-
                                <input  type="text" id="high" class="form-control input-circle input-inline" placeholder="eg:1000">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">台费</label>
                            <div class="col-md-4">
                                <input type="text" id="fee" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>
                        <div id="infoNN">

                            <div class="form-group">
                                <label class="col-md-3 control-label">结算方式</label>
                                <div class="col-md-4">
                                    <select id="way" class="form-control input-circle">
                                        <option value ="0">自动</option>
                                        <option value ="1">手动</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">底分</label>
                                <div class="col-md-4">
                                    <input type="text" id="base" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                        </div>

                        <div id="infoJH">
                            <div class="form-group">
                                <label class="col-md-3 control-label">底注</label>
                                <div class="col-md-4">
                                    <input type="text" id="min" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">顶注</label>
                                <div class="col-md-4">
                                    <input type="text" id="max" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">max轮</label>
                                <div class="col-md-4">
                                    <input type="text" id="maxRing" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">可比轮</label>
                                <div class="col-md-4">
                                    <input type="text" id="useRing" class="form-control input-circle" placeholder="eg:100">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="0">禁用</option>
                                    <option value ="1">启用</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">排序</label>
                            <div class="col-md-4">
                                <input type="text" id="sort" class="form-control input-circle" placeholder="eg:99">
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
        //file
        $("input[name='file1']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this)[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/desk/uploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imgUrl1").attr("src",data.RemoteDir+data.msg);
                    $("#img1").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
        $("input[name='file2']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this)[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/desk/uploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imgUrl2").attr("src",data.RemoteDir+data.msg);
                    $("#img2").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
        $("input[name='file3']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this)[0].files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("file", file);
            $.ajax({
                url: "/desk/uploads",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#imgUrl3").attr("src",data.RemoteDir+data.msg);
                    $("#img3").val(data.msg);
                },
                error: function(data){console.log(data);}
            });
        });
        //ajax提交
        $("#save").click(function(){
            var name= $("#name").val();
            var game= $("#game").val();
            var level= $("#level").val();
            var img1= $("#img1").val();
            var img2= $("#img2").val();
            var img3= $("#img3").val();
            var low = $("#low").val();
            var high= $("#high").val();
            var fee = $("#fee").val();
            var status= $("#status").val();
            var sort= $("#sort").val();

            if(img1=='' || img2=='' || img3==''){
                alert('缺乏上传资源');
                return false;
            }
            var reg=/^\d+$/;
            if(!reg.test(String(low)) || !reg.test(String(fee)) || !reg.test(String(sort))){
                alert('请输入非负整数');
                return false;
            }
//            if(Number(low) >= Number(high)){
//                alert('区间设置错误');
//                return false;
//            }

            if(game == 1001){
                var way=$('#way').val();
                var base=Number($('#base').val());
                if(!reg.test(String(base))){
                    alert('NN数据请输入非负整数');
                    return false;
                }
//                var rule = '{'+"'way'"+':'+way+",'base'"+':'+base+",'min'"+':'+0+",'max'"+':'+0+",'maxRing'"+':'+0+",'useRing'"+':'+0+'}';
                var rule = '{'+"'way'"+':'+way+",'base'"+':'+base+'}';
            }else{
                var min=Number($('#min').val());
                var max=Number($('#max').val());
                var maxRing=Number($('#maxRing').val());
                var useRing=Number($('#useRing').val());
                if(!reg.test(String(min)) || !reg.test(String(max)) || !reg.test(String(maxRing)) || !reg.test(String(useRing))){
                    alert('JH数据请输入非负整数');
                    return false;
                }
//                var rule = '{'+"'way'"+':'+0+",'base'"+':'+0+",'min'"+':'+min+",'max'"+':'+max+",'maxRing'"+':'+maxRing+",'useRing'"+':'+useRing+'}';
                var rule = '{'+"'min'"+':'+min+",'max'"+':'+max+",'maxRing'"+':'+maxRing+",'useRing'"+':'+useRing+'}';
            }
            $.ajax( {
                type : "post",
                url : "/desk/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',name:name,game:game,level:level,img1:img1,img2:img2,img3:img3,low:low,high:high,fee:fee,status:status,sort:sort,rule:rule},
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
