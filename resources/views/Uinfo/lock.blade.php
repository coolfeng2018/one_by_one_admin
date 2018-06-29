<link href="/hsgm/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<div class="tab-content">

<div class=" portlet light bordered" >
<div class="tab-pane active" id="tab_0">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase"> {{ $pagename }}</span>
        </div>
        
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" method="post" id="myform">
        	 {{ csrf_field() }}
            <div class="form-body">
 				@if(isset($tipmsg))
                <div class="form-group" id="tipmsg">
                	<span class="alert alert-danger tipshow"><strong>{{$tipmsg}}</strong></span> 
                </div>
				@endif
                <div class="form-group">
                    <label class="col-md-3 control-label">用户UID</label>
                    <div class="col-md-9">
                        <input type="text" id="uid" name="uid" class="form-control input-inline input-medium"  @if(isset($data[0]->uid)) value="{{$data[0]->uid}}" @endif @if(isset($uid)) value="{{$uid}}" @endif>
                        
                    </div>
                </div>
                <div class="form-group">  
                    <label class="col-md-3 control-label">修改类型</label>
                    <div class="col-md-9">
                    	<select class="bs-select form-control  input-medium " id="type" name="type" readonly >
                     		<option value="0"  selected="selected" >封号</option>
                        </select>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">原因</label>
                    <div class="col-md-9">
                        <input type="text" id="reason" name="reason" class="form-control input-inline input-medium" >
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">结束时间</label>
                    <div class="input-group date form_datetime bs-datetime">
                    <div class="col-md-2">
                        <input type="text" id="endtime" name="endtime" class="input-group form-control input-inline input-medium" readonly>
                        <span class="input-group-addon" >
                            <button class="btn default date-reset" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                        <span class="input-group-addon" >
                            <button class="btn default date-set" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                    </div>
                    

                </div>

                      
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    
                        <button type="submit" id="save" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                        <button type="button" class="ajaxify btn default" href="{{sprintf($actions['locklist'],$page)}}">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
   
</div>
</div>
</div>

<script src="/hsgm/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" charset="UTF-8"></script> 
<script src="/hsgm/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
    $(".form_datetime").datetimepicker({
    	language: "zh-CN",
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep: 10
    });
</script>   
<script type="text/javascript">

$(function(){
	
    $("#save").click(function(){
        var noticeurl = "{{sprintf($actions['mod'],$page)}}";
       
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : "{{$actions['lock']}}",
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status = 0){ 
                	alert(data.msg);
                	Layout.loadAjaxContent("{{sprintf($actions['locklist'],$page)}}");                   
                }else{
                    alert(data.msg);
                    Layout.loadAjaxContent("{{sprintf($actions['locklist'],$page)}}");     
                    //Layout.loadAjaxContent(noticeurl+"&tipmsg="+data.msg+"&"+$('#myform').serialize());
                }
            }, 
            error: function(data) {
                console.log(data);
                alert("sys wrong"); 
            }
            
        });

    })
})
</script>