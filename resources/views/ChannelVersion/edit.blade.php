
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>任务分享公告修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道</label>
                            <div class="col-md-4">
                                <select id="id" class=" form-control input-circle input-inline">
                                    <option value=""></option>
                                    <option value="default_default" @if('default_default'==$res->id) selected @endif>default_default</option>
                                    <option value="guoqing_default" @if('guoqing_default'==$res->id) selected @endif>guoqing_default</option>
                                    <option value="vivo_default" @if('vivo_default'==$res->id) selected @endif>vivo_default</option>
                                    <option value="ios_default" @if('ios_default'==$res->id) selected @endif>ios_default</option>
                                </select>
                                <input type="hidden" id="ChannelVersionId" class="form-control input-circle" value="{{$res->ChannelVersionId}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">当前配置版本号</label>
                            <div class="col-md-4">
                                <input type="text" id="curr_version" class=" form-control input-circle " value="{{ $res->curr_version }}" placeholder="当前配置版本号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">标题</label>
                            <div class="col-md-4">
                                <input type="text" id="title" class=" form-control input-circle " value="{{ $res->title }}" placeholder="标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-4">
                                <input type="text" id="des" class=" form-control input-circle " value="{{ $res->des }}" placeholder="描述">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">URL</label>
                            <div class="col-md-4">
                                <input type="text" id="targetUrl" class=" form-control input-circle " value="{{ $res->targetUrl }}" placeholder="URL">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">图片地址</label>
                            <div class="col-md-4">
                                <input type="text" id="img" class=" form-control input-circle " value="{{ $res->img }}" placeholder="图片地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">分享图片和链接</label>
                            <div class="col-md-4">
                                <input type="text" id="shareImg" class=" form-control input-circle " value="{{ $res->shareImg }}" placeholder="分享图片和链接">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">分享类型</label>
                            <div class="col-md-4">
                                <input type="text" id="sharetype" class=" form-control input-circle " value="{{ $res->sharetype }}" placeholder="分享类型">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">那种分享</label>
                            <div class="col-md-4">
                                <input type="text" id="sharetab" class=" form-control input-circle " value="{{ $res->sharetab }}" placeholder="那种分享">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务分享标题</label>
                            <div class="col-md-4">
                                <input type="text" id="task_share_title" class=" form-control input-circle " value="{{ $res->task_share_title }}" placeholder="任务分享标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务分享内容</label>
                            <div class="col-md-4">
                                <input type="text" id="task_share_content" class=" form-control input-circle " value="{{ $res->task_share_content }}" placeholder="任务分享内容">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">任务分享链接</label>
                            <div class="col-md-4">
                                <input type="text" id="task_share_url" class=" form-control input-circle " value="{{ $res->task_share_url }}" placeholder="任务分享链接">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">公告地址</label>
                            <div class="col-md-4">
                                <input type="text" id="announcement_url" class=" form-control input-circle " value="{{ $res->announcement_url }}" placeholder="公告地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">客服地址</label>
                            <div class="col-md-4">
                                <input type="text" id="kefu_url" class=" form-control input-circle " value="{{ $res->kefu_url }}" placeholder="客服地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">代理商地址</label>
                            <div class="col-md-4">
                                <input type="text" id="agent_url" class=" form-control input-circle " value="{{ $res->agent_url }}" placeholder="代理商地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">支付方式</label>
                            <div class="col-md-4">
                                <input type="text" id="payment_ways" class=" form-control input-circle " value="{{ $res->payment_ways }}" placeholder="支付方式">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">支付渠道</label>
                            <div class="col-md-4">
                                <input type="text" id="payment_channels" class=" form-control input-circle " value="{{ $res->payment_channels }}" placeholder="支付渠道">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/channelVersion/index"> 返回上一页
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
        //ajax提交
        $("#save").click(function(){
            var ChannelVersionId = $("#ChannelVersionId").val();
            var id = $("#id").val();
            var curr_version = $("#curr_version").val();
            var title = $("#title").val();
            var des = $("#des").val();
            var targetUrl = $("#targetUrl").val();
            var img = $("#img").val();
            var shareImg = $("#shareImg").val();
            var sharetype = $("#sharetype").val();
            var sharetab = $("#sharetab").val();
            var task_share_title = $("#task_share_title").val();
            var task_share_content = $("#task_share_content").val();
            var task_share_url = $("#task_share_url").val();
            var announcement_url = $("#announcement_url").val();
            var kefu_url = $("#kefu_url").val();
            var agent_url = $("#agent_url").val();
            var payment_ways = $("#payment_ways").val();
            var payment_channels = $("#payment_channels").val();
            $.ajax({
                type : "post",
                url : "/channelVersion/save",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',ChannelVersionId:ChannelVersionId,id:id,curr_version:curr_version,title:title,des:des,targetUrl:targetUrl,img:img,shareImg:shareImg,sharetype:sharetype,sharetab:sharetab,task_share_title:task_share_title,task_share_content:task_share_content,task_share_url:task_share_url,announcement_url:announcement_url,kefu_url:kefu_url,agent_url:agent_url,payment_ways:payment_ways,payment_channels:payment_channels},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert(data);
                    }
                }
            });
        })

    })
</script>
