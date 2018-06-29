
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>停机维护修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res['results'] as $resources)

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{$resources->id}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">标题</label>
                            <div class="col-md-4">
                                <input type="text" id="title" class="form-control input-circle" value="{{$resources->title}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">内容</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="detail" rows="3" style="margin: 0px -1px 0px 0px; ">{{$resources->content}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">停机开始时间</label>
                            <div class="col-md-4">
                                <input type="text" id="stime" class="form-control input-circle" value="{{$resources->stime}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">停机结束时间</label>
                            <div class="col-md-4">
                                <input type="text" id="etime" class="form-control input-circle" value="{{$resources->etime}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    @if($resources->etime==0)
                                        <option value ="1">有效</option>
                                        <option value ="0" selected>无效</option>
                                    @else
                                        <option value ="1" selected>有效</option>
                                        <option value ="0">无效</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endforeach
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
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();

        //ajax提交
        $("#save").click(function(){
            var id= $("#id").val();
            var title= $("#title").val();
            var detail= $("#detail").val();
            var stime= $("#stime").val();
            var etime= $("#etime").val();
            var status= $("#status").val();

            $.ajax( {
                type : "post",
                url : "/close/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,title:title,detail:detail,stime:stime,etime:etime,status:status},
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
