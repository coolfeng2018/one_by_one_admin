
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>道具修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="/props/save" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach ($res as $resources)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $resources->PropsId }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" value="{{ $resources->PropsName }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-4">
                                <input type="text" id="describe" class="form-control input-circle" value="{{ $resources->PropsDescription }}">
                            </div>
                        </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">类型</label>
                                <div class="col-md-4">
                                    <select id="type">
                                        @if($resources->PropsType == 0)
                                            <option value ="0" selected>货币</option>
                                            <option value ="1" >其他</option>
                                        @else
                                            <option value ="0" >货币</option>
                                            <option value ="1" selected>其他</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">状态</label>
                                <div class="col-md-4">
                                    <select id="status">
                                        @if($resources->Status == 0)
                                            <option value ="0" selected>下架</option>
                                            <option value ="1" >上架</option>
                                        @else
                                            <option value ="0" >下架</option>
                                            <option value ="1" selected>上架</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">更新</button>
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
    $(function() {
        //ajax提交
        $("#save").click(function() {
            var id= $("#id").val();
            var name= $("#name").val();
            var describe=  $("#describe").val();
            var type=$('#type option:selected') .val();//选中的值
            var status=$('#status option:selected') .val();//选中的值

            if(name==''){
                alert('道具名称不能为空');
                return false;
            }

            if(describe==''){
                alert('道具描述不能为空');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/props/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,name:name,describe:describe,type:type,status:status},
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