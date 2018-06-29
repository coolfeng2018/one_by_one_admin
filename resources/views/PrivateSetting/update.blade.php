
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i>私房修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->



                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{ $res['id']}}">
                            </div>
                        </div>
                        <span>基础信息</span>
                        <hr/>
                        <div class="base">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> 局数 </label>
                                <div class="col-md-4">
                                    <input type="text" id="score" class="form-control input-circle" value="{{ $res['round']}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> 房卡 </label>
                                <div class="col-md-4">
                                    <input type="text" id="card" class="form-control input-circle" value="{{ $res['spend']}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> 同时最大创建房间数 </label>
                                <div class="col-md-4">
                                    <input type="text" id="max" class="form-control input-circle" value="{{ $res['max_exist']}}">
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <span>授权信息</span>
                        <hr/>
                        <div class="grant">
                            <div class="form-group">
                                <label class="col-md-3 control-label">状态</label>
                                <div class="col-md-4">
                                    <select id="ptype" class="form-control input-circle">
                                        @if($res['options']['permission']['status'] == 0)
                                            <option value ="0" selected> 未开启</option>
                                            <option value ="1" > 开启</option>
                                            <option value ="2" > 白名单开启</option>
                                        @elseif($res['options']['permission']['status'] == 1)
                                            <option value ="0" > 未开启</option>
                                            <option value ="1" selected > 开启</option>
                                            <option value ="2" > 白名单开启</option>
                                        @elseif($res['options']['permission']['status'] == 2)
                                            <option value ="0" > 未开启</option>
                                            <option value ="1" > 开启</option>
                                            <option value ="2" selected> 白名单开启</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">白名单</label>
                                <div class="col-md-4">
                                    <textarea  id="plist" class="form-control" rows="4">{{ $res['options']['permission']['List'] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <span>收费信息</span>
                        <hr/>
                        <div class="access">
                            <div class="form-group">
                                <label class="col-md-3 control-label">状态</label>
                                <div class="col-md-4">
                                    <select id="atype" class="form-control input-circle">
                                        @if($res['options']['toll']['status'] == 0)
                                            <option value ="0" selected> 未开启</option>
                                            <option value ="1" > 开启</option>
                                            <option value ="2" > 白名单开启</option>
                                        @elseif($res['options']['permission']['status'] == 1)
                                            <option value ="0" > 未开启</option>
                                            <option value ="1" selected > 开启</option>
                                            <option value ="2" > 白名单开启</option>
                                        @elseif($res['options']['permission']['status'] == 2)
                                            <option value ="0" > 未开启</option>
                                            <option value ="1" > 开启</option>
                                            <option value ="2" selected> 白名单开启</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">白名单</label>
                                <div class="col-md-4">
                                    <textarea  id="alist" class="form-control" rows="4">{{ $res['options']['toll']['List'] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr/>
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
        //ajax提交
        $("#save").click(function(){
            var id=$("#id").val();
            var score= $("#score").val();
            var card= $("#card").val();
            var max= $("#max").val();
            var ptype= $("#ptype").val();
            var plist= $("#plist").val();
            var atype= $("#atype").val();
            var alist= $("#alist").val();

            if(!Number(score) || !Number(card) || !Number(max)){
                alert('基础信息必须为数字');
                return false;
            }

            $.ajax( {
                type : "post",
                url : "/privateSetting/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',id:id,score:score,card:card,max:max,ptype:ptype,plist:plist,atype:atype,alist:alist},
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

