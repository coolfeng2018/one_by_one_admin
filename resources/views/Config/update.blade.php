
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>系统配置修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->



                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res as $resources)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $resources->Id }}">
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">显示条目</label>
                            <div class="col-md-9">
                                <div class="mt-repeater">
                                    <div data-repeater-list="group-b" id="list">
                                        @foreach(json_decode($resources->ActiveDetail,true) as $v)

                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">STYLE</label>
                                                    <input type="text" name="num" placeholder="显示名称" class="form-control kind" value="{{ $v['key']}}"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">NUM</label>
                                                    <input type="text" name="num" placeholder="显示内容" class="form-control num" value="{{ $v['value']}}"/>
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
                                    <br> </div>
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
        FormRepeater.init();
        //ajax提交
        $("#save").click(function(){
            var json=new Array;
            $("#list .row").each(function(i,item){
                //获取道具名称，数量
                mykey=$(item).find(".kind").val();
                myval=$(item).find(".num").val();
                //判定是否未空
                if(typeof(mykey)=="undefined"){
                    alert("奖励类型不能为空");
                    return false;
                }
                if(myval==''){
                    alert("奖励数量不能为空,如需要请置零");
                    return false;
                }
                //组字串
                mystr={key:mykey,value:myval};
                json.push(mystr);
            });
            var detail=JSON.stringify(json);

            var id=$("#id").val();
            // var max= $("#max").val();

            // if(!Number(max)){
            //     alert('好友上线应为数字');
            //     return false;
            // }

            $.ajax( {
                type : "post",
                url : "/config/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,detail:detail},
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

