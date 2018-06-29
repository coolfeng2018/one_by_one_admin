<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>展示方案-配置添加
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="myform" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="gid"  class="form-control input-circle" value="{{$data['id']}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">名称</label>
                            <div class="col-md-4">
                                <input type="text" id="name" class="form-control input-circle" placeholder="名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">排序</label>
                            <div class="col-md-4">
                                <input type="text" id="num" class="form-control input-circle" placeholder="eg:100">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">游戏分类</label>
                            <div class="col-md-4">
                                <select id="gameid" class="form-control input-circle">
                                    @foreach($data['game'] as $k => $v)
                                        <option value ="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">展示类型</label>
                            <div class="col-md-4">
                                <select id="type" class="form-control input-circle">
                                    <option value ="2">集合</option>
                                    <option value ="1">快速开始</option>
                                    <option value ="0">单个游戏</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-4">
                                <select id="status" class="form-control input-circle">
                                    <option value ="2">展示</option>
                                    <option value ="1">可用</option>
                                    <option value ="0">禁用</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="sub" type="button" class="btn btn-circle green">保存</button>
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
        $("#sub").click(function(){
            var gid=$('#gid').val();
            var name=$('#name').val();
            var num=$('#num').val();
            var gameid=$('#gameid').val();
            var type=$('#type').val();
            var status=$('#status').val();
            $.ajax({
                type : "post",
                url : "/showpieces/postshowpieces",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',gid:gid,name:name,num:num,gameid:gameid,type:type,status:status},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('添加失败');
                    }
                }

            });
        });
    });
</script>

