
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>修改新手奖励
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">id</label>
                            <div class="col-md-4">
                                <input type="text" id="id" class=" form-control input-circle " value="{{ $res->id }}" placeholder="id">
                                <input type="hidden" id="NewbieAwardId" class=" form-control input-circle " value="{{ $res->NewbieAwardId }}" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">名字</label>
                            <div class="col-md-4">
                                <select id="item_id" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    @foreach($item as $v)
                                        <option value="{{ $v->id }}" @if($v->id==$res->item_id) selected @endif>{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">数量</label>
                            <div class="col-md-4">
                                <input type="text" id="count" class=" form-control input-circle " value="{{ $res->count }}" placeholder="数量">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/newbieaward/index"> 返回上一页
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
            $("#save").click(function(){
                //ajax提交
                var NewbieAwardId= $("#NewbieAwardId").val();
                var id= $("#id").val();
                var item_id= $("#item_id").val();
                var count= $("#count").val();
                //验证
                if(id==''){
                    alert('id不能为空,请检查');
                    return false;
                }
                if(id=='' || isNaN(id)){
                    alert('id必须为数字');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/newbieaward/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',NewbieAwardId:NewbieAwardId,id:id,item_id:item_id,count:count},
                    success : function(data) {
                        if(data.status){
                            alert('修改成功');
                            Layout.loadAjaxContent(data.url);
                        }else{
                            alert('修改失败');
                        }
                    }
                });
            });
        })
    </script>