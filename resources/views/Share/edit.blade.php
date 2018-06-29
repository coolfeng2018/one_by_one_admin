
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>修改游戏分享
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
                                 <select id="channel" class=" form-control input-circle input-inline">
                                        <option value=""></option>
                                        <option value="default" @if($res->channel=='default') selected @endif>default</option>
                                        <option value="guoqing" @if($res->channel=='guoqing') selected @endif>guoqing</option>
                                        <option value="vivo" @if($res->channel=='vivo') selected @endif>vivo</option>
                                </select>
                                <input type="hidden" id="ShareId" class=" form-control input-circle " value="{{ $res->ShareId }}" placeholder="">
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
                       <!--  <div class="form-group">
                            <label class="col-md-3 control-label">图片地址</label>
                            <div class="col-md-4">
                                <input type="text" id="img" class=" form-control input-circle " value="" placeholder="图片地址">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">图片地址</label>
                            <div class="col-md-4">
                                <input type="file" name="file" class="form-control input-circle" >
                                <img id="imgUrl" src="{{config('suit.ImgRemoteUrl').$res->img}}" >
                                <input type="hidden"  id="img" class="form-control input-circle" >
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
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                                <button class="ajaxify btn btn-circle green-madison" href="/share/index"> 返回上一页
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
            //file
            $("input[name='file']").change(function(){
                var token=$("input[name='_token']").val();
                var file = $(this)[0].files[0];
                var obj=new FormData();
                obj.append("_token", token);
                obj.append("file", file);
                $.ajax({
                    url: "/imguploads",
                    type: "POST",
                    data: obj,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#imgUrl").attr("src", data.RemoteDir+data.msg);
                        $("#img").val(data.msg);
                    },
                    error: function(data){console.log(data);}
                });
            });
            $("#save").click(function(){
                //ajax提交
                var ShareId= $("#ShareId").val();
                var channel= $("#channel").val();
                var title= $("#title").val();
                var des= $("#des").val();
                var targetUrl= $("#targetUrl").val();
                var img= $("#img").val();
                var shareImg= $("#shareImg").val();
                var sharetype= $("#sharetype").val();
                var sharetab= $("#sharetab").val();
                var task_share_title= $("#task_share_title").val();
                var task_share_content= $("#task_share_content").val();
                var task_share_url= $("#task_share_url").val();
                //验证
                if(channel==''){
                    alert('channel不能为空,请检查');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/share/save",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',ShareId:ShareId,channel:channel,title:title,des:des,targetUrl:targetUrl,img:img,shareImg:shareImg,sharetype:sharetype,sharetab:sharetab,task_share_title:task_share_title,task_share_content:task_share_content,task_share_url:task_share_url},
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