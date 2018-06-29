<div class="tab-content">

<div class=" portlet light bordered" >
<div class="tab-pane active" id="tab_0">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase">{{ $pagename }}修改</span>
        </div>
        
    </div>
    <form class="form-horizontal" method="post" id="myform">
    <div class="portlet-body form">
        
        	 {{ csrf_field() }}
            <div class="form-body">
            @foreach($res as $key=>$val)
                @if(isset($tipmsg))
                <div class="form-group" id="tipmsg">
                	<span class="alert alert-danger tipshow"><strong>{{$tipmsg}}</strong></span> 
                </div>
                @endif
            	<div class="form-group">
                    <label class="col-md-3 control-label">ID</label>
                    <div class="col-md-9">
                    	<input  type="hidden" id="modid" name="modid" value="{{$val->id}}">
                        <input type="text" id="mid" data-noticeurl="{{sprintf($actions['mod'],$page,$val->id,$filter)}}" class="form-control input-inline input-large" value="{{$val->id}}" readonly>
                        <p class="help-block">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">描述信息</label>
                    <div class="col-md-9">
                        <input type="text" id="desc" name="desc" class="form-control input-inline input-large" value="{{$val->desc}}">
                        @if(is_array(current($tips_col['desc'])))
                            @foreach($tips_col['desc'] as $k=>$v)
                            <span class="help-block {{$v['color']}}"> {{$v['tip']}} </span>
                            @endforeach
                        @else
                        	<span class="help-block {{$tips_col['desc']['color']}}"> {{$tips_col['desc']['tip']}} </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" >key</label>
                    <div class="col-md-9">
                        <input type="text" id="key_col" name="key_col"  class="form-control input-inline input-large" value="{{$val->key_col}}" readonly>
                        @if(is_array(current($tips_col['key_col'])))
                            @foreach($tips_col['key_col'] as $k=>$v)
                            <span class="help-block {{$v['color']}}"> {{$v['tip']}} </span>
                            @endforeach
                        @else
                        	<span class="help-block {{$tips_col['key_col']['color']}}"> {{$tips_col['key_col']['tip']}} </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">val</label>
                    <div class="col-md-9">
                        <input type="text" id="val_col" name="val_col" class="form-control input-inline input-large" value="{{$val->val_col}}">
                        <span class="help-block font-green-sharp bold">原来数据：  {{$val->val_col}}</span>
                    	@if(is_array(current($tips_col['val_col'])))
                            @foreach($tips_col['val_col'] as $k=>$v)
                            <span class="help-block {{$v['color']}}"> {{$v['tip']}} </span>
                            @endforeach
                        @else
                        	<span class="help-block {{$tips_col['val_col']['color']}}"> {{$tips_col['val_col']['tip']}} </span>
                        @endif
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">备注</label>
                    <div class="col-md-9">
                        <input type="text" id="memo" name="memo" class="form-control input-inline input-large" value="{{$val->memo}}">
                        @if(is_array(current($tips_col['memo'])))
                            @foreach($tips_col['memo'] as $k=>$v)
                            <span class="help-block {{$v['color']}}"> {{$v['tip']}} </span>
                            @endforeach
                        @else
                        	<span class="help-block {{$tips_col['memo']['color']}}"> {{$tips_col['memo']['tip']}} </span>
                        @endif
                    </div>
                </div>


                </div>
                @endforeach               
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    
                        <button type="submit" id="save" data-url="{{sprintf($actions['list'],$page,$filter)}}" class="btn green">&nbsp;&nbsp;确&nbsp;&nbsp;定&nbsp;&nbsp;</button>
                        <a type="button" class="ajaxify btn default" href="{{sprintf($actions['list'],$page,$filter)}}">&nbsp;&nbsp;取&nbsp;&nbsp;消&nbsp;&nbsp;</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
   
</div>
</div>

<script type="text/javascript">
$(function(){	
    $("#save").click(function(){
        var noticeurl = $("#mid").data("noticeurl");
        if($("#tipshow").length > 0) {
    		$(".tipshow").remove();
    	}    
        var succesurl=  $("#save").data('url');  
    	$.ajax({
        	async: false,
        	cache: false,
            type : "post",
            url : "{{$actions['save']}}",
            dataType : 'json',
            data:$('#myform').serialize(),
            success : function(data) {
                if(data.status==0){ 
                	alert('修改成功');
                    Layout.loadAjaxContent(succesurl);
                }else{
               	 	Layout.loadAjaxContent(noticeurl+"&tipmsg="+data.msg+"&"+$('#myform').serialize());
                }
            }
        });     	

    })
})
</script>

