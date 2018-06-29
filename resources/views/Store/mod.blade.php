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
    </div>
   
</div>
</div>
</div>
<script type="text/javascript">
$(function(){
    $("#save").click(function(){
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : "/store/brnn/modstore?act=act",
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status == 0){ 
                	alert('success');
                	Layout.loadAjaxContent("/store/brnn/modstore");                   
                }else{
                    Layout.loadAjaxContent("/store/brnn/modstore?tipmsg="+data.msg+'&'+$('#myform').serialize());  
                }
            }, 
            error: function(data) {
                console.log(data);
                alert("sys wrong");
                Layout.loadAjaxContent("/store/brnn/modstore");  
            }
            
        });

    })
})
</script>

