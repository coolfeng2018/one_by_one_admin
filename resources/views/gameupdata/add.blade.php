<style>
    .help-block2m{margin-top: 8px;}
</style>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">更新新版本</span>
            <span class="caption-helper">(**)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="" id="myform" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <input name="release_id" type="hidden" value="0">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">允许更新版本</label>
                    <div class="col-md-4 help-block2m">
                        <input type="radio" name="allow_version_select" value="1" class="md-radiobtn ganme" checked="true"> &nbsp;&nbsp;所有版本
                        <input type="radio" name="allow_version_select" value="2" class="md-radiobtn ganme"> &nbsp;&nbsp;自定义
                        <span class="help-block">  </span>
                        <textarea class="form-control allow_version" name="allow_version" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;" placeholder="多版本用逗号分隔"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">允许更新渠道</label>
                    <div class="col-md-4 help-block2m">
                        <input type="radio" name="allow_channel_select" value="1" class="md-radiobtn ganme" checked="true"> &nbsp;&nbsp;所有版本
                        <input type="radio" name="allow_channel_select" value="2" class="md-radiobtn ganme"> &nbsp;&nbsp;自定义
                        <span class="help-block">  </span>
                        <textarea class="form-control" name="allow_channel" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;" placeholder="多渠道用逗号分隔"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">不允许更新版本</label>
                    <div class="col-md-4 help-block2m">
                        <input type="radio" name="deny_version_select" value="1" class="md-radiobtn ganme" checked="true"> &nbsp;&nbsp;无
                        <input type="radio" name="deny_version_select" value="2" class="md-radiobtn ganme"> &nbsp;&nbsp;自定义
                        <span class="help-block">  </span>
                        <textarea class="form-control" name="deny_version" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;" placeholder="多版本用逗号分隔"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">不允许更新渠道</label>
                    <div class="col-md-4 help-block2m">
                        <input type="radio" name="deny_channel_select" value="1" class="md-radiobtn ganme" checked="true"> &nbsp;&nbsp;无
                        <input type="radio" name="deny_channel_select" value="2" class="md-radiobtn ganme"> &nbsp;&nbsp;自定义
                        <span class="help-block">  </span>
                        <textarea class="form-control" name="deny_channel" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;" placeholder="多渠道用逗号分隔"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">是否公开</label>
                    <div class="col-md-4 help-block2m">
                        <input type="radio" name="is_public_select" value="1" class="md-radiobtn ganme" checked="true"> &nbsp;&nbsp;所有人更新
                        <input type="radio" name="is_public_select" value="2" class="md-radiobtn ganme"> &nbsp;&nbsp;内部ip更新[自定义]
                        <span class="help-block">  </span>
                        <textarea class="form-control" name="is_public" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;" placeholder="多ip用逗号分隔"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>


            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新时间</label>
                    <div class="col-md-4">
                        <input name="release_time" id="starttime" type="text" class="form-control" data-date-format="yyyy-mm-dd hh:ii" value="{{date('Y-m-d H:i:s')}}">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新版本号</label>
                    <div class="col-md-4">
                        <input name="version" type="text" class="form-control" placeholder="Enter text">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新类型</label>
                    <div class="col-md-4">
                        <select class="form-control" name="is_force">
                            <option value="1">强更</option>
                            <option value="0">非强更</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新方式</label>
                    <div class="col-md-4">
                        <select class="form-control" name="update_type" id="update_type">
                            <option value="1">热更</option>
                            <option value="0">apk更新</option>
                        </select>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            <div class="form-body apkupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新说明</label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="description" rows="3" style="margin: 0px -1px 0px 0px; height: 143px; width: 510px;"></textarea>
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body apkupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新资源地址</label>
                    <div class="col-md-4">
                        <input name="apk_update_url" type="text" class="form-control" placeholder="Enter text" value="">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>
            <div class="form-body apkupdate">
                <div class="form-group">
                    <label class="col-md-3 control-label">更新包大小</label>
                    <div class="col-md-4">
                        <input name="size" type="text" class="form-control" placeholder="Enter text" value="">
                        <span class="help-block">  </span>
                    </div>
                </div>
            </div>

            
            <div class="form-group" id="uploadFile">
                <label class="col-md-3 control-label">上传包资源</label>
                <div class="col-md-4">
                    <input type="file" name="file" class="form-control input-circle" >
                    <input type="hidden"  name="is_upload" class="form-control input-circle" >
                </div>
                <span class="help-block loading"> <img id="imgUrl" src="../hsgm/layouts/layout/img/timg.gif" style="height:100px;position: relative;margin-top: -40px;"> </span>
            </div>
            

            <input type="hidden" value="" name="game_list">

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" id="sub" class="btn green">添加</button>
                        <button type="button" class="btn default">重置</button>
                        <img id="save-loading" src="../hsgm/layouts/layout/img/timg.gif" style="height:100px;position: relative;">
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
        
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var items=[];
        $(".apkupdate").hide();
        $('#starttime').datetimepicker();
        $("#sub").click(function(){
            // 版本校验
            cRet = vercheck($('input[name="version"]').val()); 
            if (! cRet) {
                alert('版本号格式有误');
                return;
            }
            if($('#update_type').val() == 1 && $('.add-game').length == 0) {
                alert('还未上传资源包');
                return;
            }
            $("#save-loading").show();
            $.ajax({
                type:"post",
                url:"/gameupdata/postdata",
                data:$('#myform').serialize(),
                async: true,
                error: function(request) {
                    alert("出现错误");
                    $("#save-loading").hide();
                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if(obj.status==200){
                        Layout.loadAjaxContent("/gameupdata/list");
                    }else{
                        alert(obj.msg);
                    }
                    $("#save-loading").hide();
                }

            });
        });

        tabList = ['allow_version', 'allow_channel', 'deny_version', 'deny_channel', 'is_public'];
        for (i=0; i<tabList.length; i++) {
            $("textarea[name='" + tabList[i] + "']").hide();
            E = {key:i};
            $("input[name='" + tabList[i] + "_select']").click(E, function(event){
                if ($(this).val() == 1) {
                    $("textarea[name='" + tabList[event.data.key] + "']").hide();
                } else {
                    $("textarea[name='" + tabList[event.data.key] + "']").show();
                }
            })
        }
        
        $("#psz-body").hide();
        $("#hhdz-body").hide();
        $("#lobby-body").hide();
        $(".loading").hide();
        $("#save-loading").hide();
        
        $("input[name='file']").change(function(){
            var token=$("input[name='_token']").val();
            var file = $(this).get(0).files[0];
            var obj=new FormData();
            obj.append("_token", token);
            obj.append("myfile", file);
            $(".loading").show();
            $.ajax({
                url: "/gameupdata/uploadzip",
                type: "POST",
                data: obj,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.success == false) {
                        alert(data.errmsg);
                        $(".loading").hide();
                        return;
                    }
                    var gamelist = "";
                    $('.add-game').remove();
                    $('input[name="version"]').val(data.ver);
                    $('input[name="is_upload"]').val(1);
                    for(t=0; t<data.retArr.length; t++) {
                        setTab(data.retArr[t], data.ver);
                        if (gamelist == "") {
                            gamelist = data.retArr[t];
                        } else {
                            gamelist += "," + data.retArr[t];
                        }
                        $('input[name="game_list"]').val(gamelist);
                    }
                    $(".loading").hide();
                },
                error: function(data){console.log(data);$(".loading").hide();}
            });
        });
        
        
        function setTab(tabName, ver) {
            tabStr = '<div class="form-body add-game" id="lobby-body">'+
                '<div class="form-group">'+
                '    <label class="col-md-3 control-label">' + tabName + '</label>'+
                '    <div class="col-md-4">'+
                '        <textarea class="form-control" name="' + tabName + '" rows="4" style="margin: 0px -1px 0px 0px; height: 103px; width:750px;" readonly="true"></textarea>'+
                '        <input type="hidden" value="" name="' + tabName + '_source">'+
                '        <input type="hidden" value="" name="' + tabName + '_detail">'+
                '        <input type="hidden" value="" name="' + tabName + '_project">'+
                '        <span class="help-block">  </span>'+
                '    </div>'+
                '</div>'+
            '</div>';
            
            $('#uploadFile').after(tabStr);
            source = "http://res.lixuanjie.com/packages/psz/" + ver + "/manifests/" + tabName;
            detail = "http://res.lixuanjie.com/packages/psz/" + ver + "/manifests/" + tabName + "/version.manifest";
            project = "http://res.lixuanjie.com/packages/psz/" + ver + "/manifests/" + tabName + "/project.manifest";
            info = "更新资源地址：" + source + "\r\n" + 
                   "更新描述文件：" + detail + "\r\n" + 
                   "工程描述文件地址：" + project;
            $("input[name='" + tabName + "_source']").val(source);
            $("input[name='" + tabName + "_detail']").val(detail);
            $("input[name='" + tabName + "_project']").val(project);
            $('#' + tabName + '-body').show();
            $('textarea[name="'+tabName+'"]').val(info);
        }


        $('#update_type').change(function(){
            if ($(this).val() == '1') {
                $('.apkupdate').hide();
                $('#uploadFile').show();
                $('.add-game').show();
            } else {
                $('.apkupdate').show();
                $('#uploadFile').hide();
                $('.add-game').hide();
            }
        })
        
        function vercheck(s){
            var r; 
            r = /^\d+\.\d+\.\d+$/.test(s); // 字符串 s 查找匹配
            return r;
        }

    });
    
    

</script>

