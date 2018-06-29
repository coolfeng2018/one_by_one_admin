
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>签到修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">连续签到天数</label>
                            <div class="col-md-4">
                                <input type="text" id="month" class=" form-control input-circle " value="{{ $res->month }}" placeholder="连续签到天数">
                                <input type="hidden" id="SigningId" class="form-control input-circle" value="{{$res->SigningId}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">奖励列表</label>
                            <div class="col-md-9">
                                    <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list">
                                            @foreach(json_decode($res->awards_list,true) as $v)
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">奖励ID</label>
                                                    <input type="text" name="awards_list_id" placeholder="eg:100" class="form-control awards_list_id" value=" {{ $v['id']}}"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">奖励数量</label>
                                                    <input type="text" name="awards_list_count" placeholder="eg:100" class="form-control awards_list_count" value=" {{ $v['count']}}"/>
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
                                            <i class="fa fa-plus"></i> 增加奖励项</a>
                                        <br>
                                        <br> </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/signing/index"> 返回上一页
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
                var SigningId= $("#SigningId").val();
                var month= $("#month").val();
                var awards_list= $("#awards_list").val();
                //验证
                if(month==''){
                    alert('连续签到天数不能为空,请检查');
                    return false;
                }
                if(month=='' || isNaN(month)){
                    alert('连续签到天数必须为数字');
                    return false;
                }
                var json=new Array;
                $("#list .row").each(function(i,item){
                    //获取奖励ID，数量
                    awards_list_id=$(item).find(".awards_list_id").val();
                    awards_list_count=$(item).find(".awards_list_count").val();
                    // console.log(awards_list_id);
                    // console.log(awards_list_count);
                    //判定是否未空
                    if(typeof(awards_list_id)==""){
                        alert("奖励id不能为空");
                        return false;
                    }
                    if(awards_list_count==''){
                        alert("奖励数量不能为空,如需要请置零");
                        return false;
                    }
                    //组字串
                    mystr={id:parseInt(awards_list_id),count:parseInt(awards_list_count)};
                    json.push(mystr);
                });
                var award=JSON.stringify(json);
              // console.log(award);
                $.ajax( {
                    type : "post",
                    url : "/signing/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',SigningId:SigningId,awards_list:award,month:month},
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