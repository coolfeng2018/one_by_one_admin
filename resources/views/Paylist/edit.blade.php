<div class="tab-content">

<div class=" portlet light bordered" >
<div class="tab-pane active" id="tab_0">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase">{{ $pagename }}修改</span>
        </div>
        
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal"  id="myform">
        	 {{ csrf_field() }}
            <div class="form-body">
            @foreach($res as $k=>$v)
             	@if(isset($tipmsg))
                <div class="form-group" id="tipmsg">
                	<span class="alert alert-danger tipshow"><strong>{{$tipmsg}}</strong></span> 
                </div>
                @endif
            	<div class="form-group">
                    <label class="col-md-3 control-label">ID</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control input-inline input-medium" value="{{$v->id}}" readonly>
                        <input type="hidden" id="modid" name="modid" class="form-control input-inline input-medium" value="{{$v->id}}" >
                        <span class="help-inline"><!--  A block of help text. --> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">排序id </label>
                    <div class="col-md-9">
                        <input type="text" id="sort_id" name="sort_id" class="form-control input-inline input-medium" value="{{$v->sort_id}}">
                        <span class="help-inline"><!--  A block of help text. --> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">支付方式名称 </label>
                    <div class="col-md-9">
                        <input type="text" id="name" name="name" class="form-control input-inline input-medium" value="{{$v->name}}">
                        <span class="help-inline"><!--  A block of help text. --> </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label" >支付代码 </label>
                    <div class="col-md-9">
                        <input type="text" id="payment_channels" name="payment_channels"  class="form-control input-inline input-medium" value="{{$v->payment_channels}}" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">支付方式</label>
                    <div class="col-md-2">
                        <select id="payment_ways" name="payment_ways" class="form-control">
                            @foreach($cfg_list['payment_ways'] as $key => $val)
                            <option value ="{{$key}}" @if($key == $v->payment_ways) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">固定充值金额</label>
                    <div class="col-md-9">
                        <input type="text" id="money_list" name="money_list" class="form-control input-inline input-medium" value="{{$v->money_list}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">是否支持手动输入金额</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline" id="status">
                            <label class="mt-radio">
                                <input type="radio" name="status"  value="0"  @if($v->status==0) checked="checked" @endif > 固定金额
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="status" id="udefined" value="1" @if($v->status==1) checked="checked" @endif > 自定义
                                <span></span>
                            </label>
                        </div>
                    </div> 

                </div>
                
                <div class="form-group" id="defined_range">
                    <label class="col-md-3 control-label">自定义范围</label>
                    <div class="col-md-9">
                        <input type="text" id="udefined_min" name="udefined_min" data-val="{{$v->udefined_min}}" class="defined_range form-control input-inline input-medium"  value="{{$v->udefined_min}}" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">自定义上限
                        <p class="help-block"> </p>
                        <input type="text" id="udefined_max" name="udefined_max" data-val="{{$v->udefined_max}}" class="defined_range form-control input-inline input-medium" value="{{$v->udefined_max}}" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">自定义上限
                        <p class="help-block"> </p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">备注</label>
                    <div class="col-md-9">
                        <input type="text" id="memo" name="memo" class="form-control input-inline input-medium"   value="{{$v->memo}}" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">是否生效</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline" id="o_status">
                            <label class="mt-radio">
                                <input type="radio" name="o_status"  value="2"  @if($v->o_status==2) checked="checked" @endif > 生效
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="o_status"  value="1" @if($v->o_status==1) checked="checked" @endif > 不生效
                                <span></span>
                            </label>
                        </div>
                    </div> 

                 </div>
                @endforeach               
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    
                        <button type="submit" id="save" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                        <button type="button" class="ajaxify btn default" href="/paylist/list?page={{$page}}">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</button>
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
        $(".tipshow").remove();
        var page='{{$page}}';
        if($("#tipshow").length > 0) {
    		$(".tipshow").remove();
    	}    
        var o_status = $("input[name='o_status']:checked").val();
        var status = $("input[name='status']:checked").val();
		var succesurl="/paylist/list?page="+page;
		var tipshow = '<span class="alert alert-danger tipshow"><strong>xxxxx</strong></span>';
        if(o_status ==null) {
            tipshow=tipshow.replace('xxxxx','请选择是否生效');
            $("#o_status").append(tipshow);
            return false;
        }
        if(status ==null) {
            
        	tipshow=tipshow.replace('xxxxx','是否支持手动输入金额');
        	$("#status").append(tipshow);
        	return false;
        }
        if(status == 1) { 
        	var min = $("#udefined_min").val();
        	var max = $("#udefined_max").val();
        	if(min<1){
        		tipshow=tipshow.replace('xxxxx','下线不能小于1');
            	$("#defined_range").append(tipshow);
            	return false;
        	}
        	if(max<min){
        		tipshow=tipshow.replace('xxxxx','上线不能小于下线');
            	$("#defined_range").append(tipshow);
            	return false;
        	}
        }
              
    	$.ajax({
        	async: false,
        	cache: false,
            type : "get",
            url : "/paylist/save",      
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status==0){ 
                	alert(' 修改成功');
                    Layout.loadAjaxContent(succesurl);
                }else{     
                    Layout.loadAjaxContent("/paylist/mod?page="+page+"&tipmsg="+data.msg+"&"+$('#myform').serialize());                    
                }
            },
            
            
        });     	
        
        

    });

})
</script>
<script>
$(function(){
	   var chkd_status = $("input[name='status']:checked").val();
	   if(chkd_status == 0){
		   $("#defined_range").hide();
	       $(".defined_range").each(function(i){
	           $(this).attr("disabled",'disabled');  
	       });
	   }
	   if(chkd_status == 1){
	       $("#defined_range").show();
	       $(".defined_range").each(function(i){
	           var val = $(this).attr("data-val");
	           $(this).removeAttr("disabled");  
	       });

	       
	   }
    $("#status").change(function(){
       var chkd_status = $("input[name='status']:checked").val();
       if(chkd_status == 0){
    	   $("#defined_range").hide();
           $(".defined_range").each(function(i){
               $(this).attr("disabled",'disabled');  
           });
       }
       if(chkd_status == 1){
           $("#defined_range").show();
           $(".defined_range").each(function(i){
               var val = $(this).attr("data-val");
               $(this).removeAttr("disabled");  
           });
    
           
       }

	}); 
})
</script>
