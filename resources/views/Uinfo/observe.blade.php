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
                        <input type="text" id="uid" name="uid" class="form-control input-inline input-medium"  @if(isset($uid)) value="{{$uid}}" @endif>
                        
                    </div>
                </div>
                <div class="form-group">  
                    <label class="col-md-3 control-label">操作类型</label>
                    <div class="col-md-9">
                    	<select class="bs-select form-control  input-medium " id="otype" name="otype">
                     		@foreach($observecnf['otype'] as $key=>$val)
                            <option value='{{$key}}' @if(isset($otype) && $otype ==$key) selected  @endif >{{$val}}</option>
                            @endforeach   
                        </select>
                        <span class="help-inline">增：概率和目标值同为正； 减 ：概率和目标值同为负</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">概率</label>
                    <div class="col-md-9">
                        <input type="text" id="percent" name="percent" class="form-control input-inline input-medium"   @if(isset($percent)) value="{{$percent}}" @endif>
                        <span class="help-inline">1-100</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-3 control-label">目标值</label>
                    <div class="col-md-9">
                        <input type="text" id="goal_num" name="goal_num" class="form-control input-inline input-medium"   @if(isset($goal_num)) value="{{$goal_num}}" @endif>
                        <span class="help-inline"></span>
                    </div>
                </div>

                      
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    
                        <button type="submit" id="save" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                        <button type="button" class="ajaxify btn default" href="{{sprintf($actions['observelist'],$page)}}">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
   
</div>
</div>
</div>
<script type="text/javascript">
$(function(){
    $("#save").click(function(){
        var url = "{{sprintf($actions['observeadd'],$page)}}";
        var req_url = url+"&act=do";
        var percent = $('#percent').val();
        var goal_num = $('#goal_num').val();
        var uid = $('#uid').val();
        if(!/^\d+$/.test(uid)){
            alert("uid只能为数字");
            return false;
        }
        if(!/^\d+$/.test(goal_num)){
            alert("目标值只能为数字");
            return false;
        }
        if(!/^\d+$/.test(percent)){
            alert("概率只能为数字");
            return false;
        }
        if(percent>100 || percent<0){
            alert("概率超出范围1-100");
            return false;
        }
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : req_url,
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status == 0){ 
                	alert(data.msg);
                	Layout.loadAjaxContent("{{sprintf($actions['observelist'],$page)}}");                   
                }else{
                    //alert(data.msg);     
                    Layout.loadAjaxContent(url+"&tipmsg="+data.msg+"&"+$('#myform').serialize());
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