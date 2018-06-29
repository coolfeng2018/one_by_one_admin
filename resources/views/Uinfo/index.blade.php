<link href="/hsgm/plugins/profile/profile.min.css" rel="stylesheet" type="text/css" />
<div class="row">
	<div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                	<i class="fa fa-user font-dark"></i>
                	<span class="caption-subject bold uppercase">用户信息查询</span> 
                </div>
            </div>
            <div class="portlet-body">
            	<div class="row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-icon">
                            	<i class="fa"></i>
                            	<input type="text" name="uid" id="uid" class="form-control" value="{{ $uid }}" placeholder="UID">
                            </div>
                            <span class="input-group-btn">
                                <a class="btn green-soft uppercase bold  ajaxify" id="search"><i class="fa fa-search"></i> 查找</a>
                            </span>
                            
                         </div>
                         	<div class="input-icon">
                                <span class="label label-m label-danger" >{{ $msg }}</span>
                            </div>
                     </div>
                 </div><!-- end row -->
                 <div class="row">
                 <br/>
                 </div>
                 
                 <div class="portlet light bordered" >
				@if(!empty($data))
                	<div class="row">
                        <!-- BEGIN PROFILE SIDEBAR -->
                        <div class="profile-sidebar">
                            <!-- PORTLET MAIN -->
                            <div class="portlet light profile-sidebar-portlet ">
                                <!-- SIDEBAR USERPIC -->
                                <div class="profile-userpic">
                                    <img src="/hsgm/plugins/profile/avatar.png" class="img-responsive" alt=""> 
                                </div> 
                                <!-- END SIDEBAR USERPIC -->
                                <!-- SIDEBAR USER TITLE -->
                                <div class="profile-usertitle">
                                    <div class="profile-usertitle-name"> {{$data['nickname']}} </div>
                                    <div class="profile-usertitle-job"> 现在状态：@if($data['lockstatus']==1) <span class="label label-sm label-danger"> 已被封</span>   @else 正常 @endif </div>
                                </div>
                                <!-- END SIDEBAR USER TITLE -->
                                <!-- SIDEBAR BUTTONS -->
                                <div class="profile-userbuttons">
                                    <!-- <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                    <button type="button" class="btn btn-circle red btn-sm">Message</button> -->
                                </div>
                                <!-- END SIDEBAR BUTTONS -->
                                
                            </div>
                            <!-- END PORTLET MAIN -->
                            <!-- PORTLET MAIN -->
                            <div class="portlet light ">
                                <!-- STAT -->
                                <div class="row list-separated">
  
   								<div class="uppercase profile-stat-title"><a id="editstatus" data-uidstatus="{{$data['lockstatus_id']}}" data-uid="{{$data['uid']}}" data-edithref="/uinfo/lock?act_type=act&id={{$data['lockstatus_id']}}&type={{$data['lockstatus']}}&uid={{$data['uid']}}">@if($data['lockstatus']==1) <span class="btn blue"> 解封 </span>  @else<span class="btn blue"> 封号 </span> @endif </a></div>
                                    <!-- <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="uppercase profile-stat-title"> 51 </div>
                                        <div class="uppercase profile-stat-text"> 金币 </div>
                                    </div> -->
                                    <!-- <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="uppercase profile-stat-title"> 封号  </div>
                                        <div class="uppercase profile-stat-text"> 解封</div>
                                    </div> -->
                                   
                                </div>
                                <!-- END STAT -->
                            </div>
                            <!-- END PORTLET MAIN -->
                        </div>
                        <!-- END BEGIN PROFILE SIDEBAR -->
                        <!-- BEGIN PROFILE CONTENT -->
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">用户信息详情</span>
                                            </div>
                                             <ul class="nav nav-tabs">
                                               <!--  <li class="active">
                                                    <a href="#tab_1_1" data-toggle="tab">基本信息</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_1_2" data-toggle="tab">更改头像</a>
                                                </li> 
                                                <li>
                                                    <a href="#tab_1_3" data-toggle="tab">代理商信息</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_1_4" data-toggle="tab">封号解号</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <form role="form" action="#" class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">UID</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> {{ $data['uid'] }} </p>
                                                            	
                                                            </div>
                                                            
                                                            <label class="col-md-2 control-label">上次登录地点</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> <i class="fa fa-map-marker"></i> &nbsp;&nbsp;{{ $data['last_login_addr'] }}  {{ $data['last_login_ip'] }} </p>
                                                            	
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">昵称</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['nickname'] }}  </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">注册时间</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> {{ $data['regist_time'] }}  </p>
                                                            	
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label"> 性别</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['sex'] }}  </p>
                                                            	<!-- <input type="text" placeholder="1111111" class="form-control"> -->
                                                            	<!-- <span class="help-inline">sdfsdf </span> -->
                                                            </div>
                                                            
                                                            <label class="col-md-2 control-label"> 累计充值</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['deposit_sum'] }}  </p>
                                                            	<!-- <input type="text" placeholder="1111111" class="form-control"> -->
                                                            	<!-- <span class="help-inline">sdfsdf </span> -->
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">累计兑换</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['exch_sum'] }}  </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">累计扣台费</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['cost_sum'] }}  </p>
                                                            	
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">最后登陆时间</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['last_login_time'] }}  </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">累计押注</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['lose_sum'] }}  </p>
                                                            	
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">金币数量</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['coins'] }}  </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">累计赢金币</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static">  {{ $data['win_sum'] }}  </p>
                                                            	
                                                            </div>

                                                        </div>

                                                    </form>
                                                </div>
                                                <!-- END PERSONAL INFO TAB -->
                                                <!-- CHANGE AVATAR TAB -->
                                                <div class="tab-pane" id="tab_1_2">
                                                    <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                                        eiusmod. </p>
                                                    <form action="#" role="form">
                                                        <div class="form-group">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new"> Select image </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="..."> </span>
                                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix margin-top-10">
                                                                <span class="label label-danger">NOTE! </span>
                                                                <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                            </div>
                                                        </div>
                                                        <div class="margin-top-10">
                                                            <a href="javascript:;" class="btn green"> Submit </a>
                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- END CHANGE AVATAR TAB -->
                                                <!-- CHANGE PASSWORD TAB -->
                                                <div class="tab-pane" id="tab_1_3">
                                                    <form role="form" action="#" class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">代理商ID</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> 1111 </p>
                                                            	
                                                            </div>
                                                            
                                                            <label class="col-md-2 control-label">代理商状态</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> 封号 </p>
                                                            	
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">代理商昵称</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> daili </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">上级代理</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> <a>nickname11</a> </p>
                                                            	
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                           <label class="col-md-2 control-label">手机号</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> 13846621977 </p>
                                                            	
                                                            </div>
                                                            <label class="col-md-2 control-label">下级人数</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> 55 </p>
                                                            	
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">成为代理时间</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> email@example.com2222 </p>
                                                            	
                                                            </div>
                                                            
                                                            <label class="col-md-2 control-label">游戏类型</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> 牛牛 </p>
                                                            	
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">最后登陆时间</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> email@example.com2222 </p>
                                                            	
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">返利比率</label>
                                                            <div class="col-md-2">
                                                            	<p class="form-control-static"> email@example.com </p>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- END CHANGE PASSWORD TAB -->
                                                <!-- PRIVACY SETTINGS TAB -->
                                                <div class="tab-pane" id="tab_1_4">
                                                    <form action="#">
                                                        <table class="table table-light table-hover">
                                                            <tbody><tr>
                                                                <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                                <td>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios1" value="option1"> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios1" value="option2" checked=""> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios11" value="option1"> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios11" value="option2" checked=""> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios21" value="option1"> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios21" value="option2" checked=""> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios31" value="option1"> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios31" value="option2" checked=""> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                        <!--end profile-settings-->
                                                        <div class="margin-top-10">
                                                            <a href="javascript:;" class="btn red"> Save Changes </a>
                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- END PRIVACY SETTINGS TAB -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE CONTENT -->
                </div>
                @endif
 
               </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
        
	</div>                    

</div>
<script type="text/javascript">
$(function() {    
    var href = "/uinfo/index?act=search";    
    $("#search").click(function () {
    	if ($('input[name="uid"]').val() == "") {
            alert('请填写uid');
        }
        $("#search").attr("href", href + "&uid=" + $('input[name="uid"]').val());
    });

}); 
</script>  
<script type="text/javascript">

$(function(){	
    $("#editstatus").click(function(){
    	var edithref = $(this).data("edithref");  
    	var uid=$(this).data("uid");  
    	var uidstatus=$(this).data("uidstatus");  
    	if(uidstatus==0) {
    		Layout.loadAjaxContent("/uinfo/lock?act_type=add&page=1&uid="+uid);         
    	}else{
    		$.ajax({
            	async: false,
            	cache: false,
                type : "get",
                url : edithref,
                dataType : 'json',
                data:'',
                success : function(data) {
                    if(data.status = 0){ 
                    	alert(data.msg);
                    	Layout.loadAjaxContent("/uinfo/index?act=search&uid="+uid);                   
                    }else{
                        alert(data.msg);
                        Layout.loadAjaxContent("/uinfo/index?act=search&uid="+uid);     
                    }
                }, 
                error: function(data) {
                    console.log(data);
                    alert("sys wrong"); 
                }
                
            });
    	}
        

    })
})
</script>                            
                               