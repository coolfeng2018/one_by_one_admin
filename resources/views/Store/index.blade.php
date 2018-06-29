<link href="/hsgm/plugins/profile/profile.min.css" rel="stylesheet" type="text/css" />
<div class="row">
	<div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                	<i class="fa fa-user font-dark"></i>
                	<span class="caption-subject bold uppercase">{{ $pagename }}</span> 
                </div>
            </div>
            <div class="portlet-body">

                   <div class="row">  
                     <form class="form-horizontal"  id="myform">
                    	 {{ csrf_field() }}
                        <div class="form-body">
                        	<div class="form-group">  
                                <label class="col-md-3 control-label">游戏类型</label>
                                <div class="col-md-9">
                                
                                	<div class="input-group   input-medium">
                                        <select class="bs-select form-control " id="gid" name="gid">
                                     		@foreach($gamelist as $gameid=>$gamename)
                                            <option value="{{ $gameid }}" @if($gameid==$gid) selected="selected" @endif>{{ $gamename }}</option>
                                        	@endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <a class="btn green-soft uppercase bold  ajaxify" id="search"><i class="fa fa-search"></i> 查找</a>
                                        </span>
                                        
                                     </div>
                                	
                                    
                                </div>
                                
                                
                            </div>
              				@if(isset($tipmsg)&&!empty($tipmsg))
                            <div class="form-group" id="tipmsg">
                            	<span class="alert alert-danger tipshow"><strong>{{$tipmsg}}</strong></span> 
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-3 control-label">库存额度</label>
                                <div class="col-md-9">
                                    <input type="text" id="store_num" name="store_num" class="form-control input-inline input-medium" @if(isset($store_num))value="{{$store_num}}" @endif readonly>
                                    
                                </div>
                            </div>
                            <div class="form-group">  
                                <label class="col-md-3 control-label">修改类型</label>
                                <div class="col-md-9">
                                	<select class="bs-select form-control  input-medium " id="type" name="type">
                                 		@foreach($typelist as $tid=>$name)
                                        <option value="{{ $tid }}" @if($tid==$type) selected="selected" @endif>{{ $name }}</option>
                                    	@endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">修改数额</label>
                                <div class="col-md-9">
                                    <input type="text" id="num" name="num" class="form-control input-inline input-medium"  @if(isset($num))value="{{$num}}" @endif>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            
                                  
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                
                                    <button type="submit" id="save" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                                   
                                </div>
                            </div>
                        </div>
                    </form>
                     
                 </div><!-- end row -->

                 

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
        
	</div>                    

</div>
<script type="text/javascript">
$(function() {    
    var href = "/store/lfdj/modstore?act=search";    
    $("#search").click(function () {
    	if ($('#gid option:selected').val() == "") {
            alert('选择游戏');
        }
        $("#search").attr("href", href + "&gid=" + $('#gid option:selected').val());
    });

}); 
</script>  
<script type="text/javascript">
$(function(){
    $("#save").click(function(){
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : "/store/lfdj/modstore?act=act",
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status == 0){ 
                	alert('修改成功！');
                	Layout.loadAjaxContent("/store/lfdj/modstore");                   
                }else{
                    Layout.loadAjaxContent("/store/lfdj/modstore?tipmsg="+data.msg+'&'+$('#myform').serialize());  
                }
            }, 
            error: function(data) {
                console.log(data);
                alert("sys wrong");
                Layout.loadAjaxContent("/store/lfdj/modstore");  
            }
            
        });

    })
})
</script>              