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
        <form class="form-horizontal" method="post">
        	 {{ csrf_field() }}
            <div class="form-body">
 
                <div class="form-group">
                    <label class="col-md-3 control-label">用户UID</label>
                    <div class="col-md-9">
                        <input type="text" id="uid" name="uid" class="form-control input-inline input-medium" >
                        
                    </div>
                </div>
                <div class="form-group">  
                    <label class="col-md-3 control-label">修改类型</label>
                    <div class="col-md-9">
                    	<select class="bs-select form-control  input-medium " id="type" name="type">
                     		<option value="" >请选择</option>
                     		@foreach($typelist as $tid=>$name)
                            <option value="{{ $tid }}" @if($tid==$type) selected="selected" @endif>{{ $name }}</option>
                        	@endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">修改数额</label>
                    <div class="col-md-9">
                        <input type="text" id="num" name="num" class="form-control input-inline input-medium" >
                        <span class="help-inline"></span>
                    </div>
                </div>
                
                      
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    
                        <button type="submit" id="save" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                       <!--  <button type="button" class="ajaxify btn default" href="/setgamecfg/robotlist?typeid=">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</button> -->
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
        var uid = $("#uid").val();
        var type = $("#type").val();
        var num = $("#num").val();  
            
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : "/uinfo/modgold",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',act:'act',uid:uid,type:type,num:num},
            success : function(data) {
                if(data.status = 0){ 
                	alert(data.msg);
                	Layout.loadAjaxContent("/uinfo/modgold");                   
                }else{
                    alert(data.msg);
                    Layout.loadAjaxContent("/uinfo/modgold");  
                }
            }, 
            error: function(data) {
                console.log(data);
                alert("sys wrong");
                Layout.loadAjaxContent("/uinfo/modgold");  
            }
            
        });

    })
})
</script>

