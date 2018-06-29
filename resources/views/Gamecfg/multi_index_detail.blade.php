
<div class="tab-content">

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase">{{ $pagename }}修改</span>
        </div>
        
    </div>
    
    <div class="portlet-body">
        <div class="row">
    		
            <div class="col-md-12">
                @if(isset($tipmsg)&&!empty($tipmsg))
    
                <div class="form-group" id="tipmsg">
                	<span class="alert alert-danger tipshow"><strong>{{$tipmsg}}</strong></span> 
                </div>
    
                @endif
            	<table id="user" class="table table-bordered table-striped">
            		<thead>
                        <tr class="" role="row">
							<th> 名称 </th>
							<th> 数值</th>
							<th> 操作</th>
							<th> 描述</th>
							<th> 最后操作人 </th>
							<th> 最后操作时间 </th>
                        </tr>
                  
                    </thead>
                    <tbody>
                    @foreach($cfgdata as $k=>$v)
                    	@foreach($tabname as $key=>$val)
                    		@if(isset($v[$key]))
                    			@if(is_array(current($v[$key])))
                    				
                                    	@foreach($v[$key] as $ks=>$vs)
                                    		
                                    		
                                    			@if(is_array(current($vs)))
                                    			
                                    				@foreach($vs as $kss=>$vss)
                                    				<tr class="far">
                                    	<td class="spannum" > {{$val['name']}} / {{$key}} @if(isset($val['tips'])) <br/> {{$val['tips']}} @endif </td>
                    								<td> 
                    									<a href="#" data-type="text" data-url="{{$actions['multi_save']}}"  data-name="{{$key}}"  data-pk="{{$vss['id']}}" data-original-title="输入修改信息" class="editable editable-click ed_eliments">{{ $vss['val_col'] }} </a>
                    								</td>
                    								<td> 
                    									<a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['mod'],$page,$vss['id'],$filter)}}" > <i class="fa fa-edit"> edit</i></a> 
                                                        @if(isset($actions['del']))
                                                        <button class="btn red btn-xs delcfg" data-delurl="{{$actions['del']}}?id={{$vss['id']}}" data-backurl="{{sprintf($actions['list'],$page,$filter)}}" data-toggle="confirmation" data-original-title="Are you sure ?" title="">
                                                        <i class="fa fa-times"> delete</i>
                                                        </button>
                                                        @endif
                                                        @if($kss == count($v[$key][$ks]))
                                                        <input type="hidden" class="rowspannum" value="{{count($v[$key][$ks])}}">
                                                        <a class="ajaxify btn btn-xs green" href="{{sprintf($actions['add'],$page,$ks,$k.'>'.$key.'>'.($ks+1).'>'.($kss+1))}}&desc={{$val['name']}}" > <i class="fa fa-edit"> add</i></a> 
                                                    	@endif
                                                    </td>
                            						<td> {{ $vss['desc'] }} </td>
                            						<td> {{ $vss['op_name'] }} </td>
                            						<td> {{ $vss['op_time'] }} </td>
                            						</tr>
                            						@endforeach
                            					 @else
                            					 
                                					 <tr>
                                        	<td class="spannum"  > {{$val['name']}} / {{$key}} @if(isset($val['tips'])) <br/> {{$val['tips']}} @endif </td>
                        								<td> 
                        									<a href="#" data-type="text" data-url="{{$actions['multi_save']}}"  data-name="{{$key}}"  data-pk="{{$vs['id']}}" data-original-title="输入修改信息" class="editable editable-click ed_eliments">{{ $vs['val_col'] }} </a>
                        								</td>
                        								<td> 
                        									<a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['mod'],$page,$vs['id'],$filter)}}" > <i class="fa fa-edit"> edit</i></a> 
                                                            @if(isset($actions['del']))
                                                            <button class="btn red btn-xs delcfg" data-delurl="{{$actions['del']}}?id={{$vs['id']}}" data-backurl="{{sprintf($actions['list'],$page,$filter)}}" data-toggle="confirmation" data-original-title="Are you sure ?" title="">
                                                            <i class="fa fa-times"> delete</i>
                                                            </button>
                                                            @endif
                                                            @if($ks == count($v[$key]))
                                                            <input type="hidden" class="rowspannum" value="{{ count($v[$key])+1}}">
                                                            <a class="ajaxify btn btn-xs green" href="{{sprintf($actions['add'],$page,$k,$k.'>'.$key.'>'.($ks+1))}}&desc={{$val['name']}}" > <i class="fa fa-edit"> add</i></a> 
                                                        	@endif
                                                        </td>
                                						<td> {{ $vs['desc'] }} </td>
                                						<td> {{ $vs['op_name'] }} </td>
                                						<td> {{ $vs['op_time'] }} </td>
                                					</tr>
                                    			 @endif
                                    		 
                                    		
                                    			
                                    		
                                    		
                                    		
                                    		
                                    		
                                    	
                						
                                    	
                                    	
                                    		
                                    	
                                    		
                						
                						@endforeach
                    			@else
                    					
                                        	
                                        	<tr class="far">
                                        	<td > {{$val['name']}} / {{$key}} @if(isset($val['tips'])) <br/> {{$val['tips']}} @endif </td>
            								<td> 
            									<a href="#" data-type="text" data-url="{{$actions['multi_save']}}"  data-name="{{$key}}"  data-pk="{{$v[$key]['id']}}" data-original-title="输入修改信息" class="editable editable-click ed_eliments">{{ $v[$key]['val_col'] }} </a>
            								</td>
            								<td> 
            									<a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['mod'],$page,$v[$key]['id'],$filter)}}" > <i class="fa fa-edit"> edit</i></a> 
                                                @if(isset($actions['del']))
                                                <button class="btn red btn-xs delcfg" data-delurl="{{$actions['del']}}?id={{$v[$key]['id']}}" data-backurl="{{sprintf($actions['list'],$page,$filter)}}" data-toggle="confirmation" data-original-title="Are you sure ?" title="">
                                                <i class="fa fa-times"> delete</i>
                                                </button>
                                                @endif
                                                
                                            </td>
                    						<td> {{ $v[$key]['desc'] }} </td>
                    						<td> {{ $v[$key]['op_name'] }} </td>
                    						<td> {{ $v[$key]['op_time'] }} </td>
                    						</tr>
                    						
                    			@endif
                						
                    			
                    		@else
                    			@if($key=='first_tab')
										<tr>
                                			<td > {{$val['name']}} </td>
            								<td> 
            									 {{ $k }}
            								</td>
                    						<td>  </td>
                    						<td>  </td>
                    						<td>  </td>
                    						<td>  </td>
                    					</tr>
                    		 	@else
                    		 			<tr>
                    						<td> {{$val['name']}}/{{$key}} @if(isset($val['tips'])) <br/> {{$val['tips']}} @endif</td>
            								<td> <a href="#" data-type="text" data-url="{{$actions['multi_save']}}"  data-name="{{$k.'>'.$key}}" data-desc="{{$val['name']}}" data-pk=" " data-original-title="输入添加的值" class="editable editable-click editable-empty add_eliments">   </a> </td>
            								<td> 
            									<a class="ajaxify btn btn-xs green" href="{{sprintf($actions['add'],$page,$k,$k.'>'.$key)}}&desc={{$val['name']}}" > <i class="fa fa-edit"> add</i></a> 
                                            </td>
                    						<td> </td>
                    						<td> </td>
                    						<td> </td>
                						</tr>
                    		 	@endif
                    		@endif
                    	@endforeach
                    @endforeach
                     
                    
                        
                    </tbody>
                </table>
            
            </div><!-- col-md-12 -->
        </div><!-- row -->   
    </div><!-- portlet-body -->
    		<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    	<a type="button" class="ajaxify btn default" id="refreshbtn" href="{{sprintf($actions['list'],$page,$filter)}}" > &nbsp;&nbsp;刷新页面&nbsp; </a> 
                        <a type="button" class="ajaxify btn default" href="{{sprintf($actions['list'],$page,'')}}">&nbsp;&nbsp;返&nbsp;&nbsp;回&nbsp;&nbsp;</a>
                    </div>
                </div>
            </div>

</div>    

   
</div>

@if(isset($actions['del']))
<script type="text/javascript">
$(function(){	
    $(".delcfg").click(function(){
        var del_url = $(this).data('delurl');
        var backurl = $(this).data('backurl');
    	swal({
    	  title: "你确定要删除 这条记录吗?",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "删除！",
    	  cancelButtonText: "取消！~",
    	  confirmButtonClass: "btn-danger",
    	  closeOnConfirm: false,
    	  showLoaderOnConfirm: true,
    	}, function () {
     	  setTimeout(function () {
       		$.ajax({
  	        	async: false,
  	        	cache: false,
  	            type : "get",
  	            url : del_url,	  
    	        dataType: 'json',    
  	            success : function(data) {
  	            	if(data.status==1){ 
	                	swal("Deleted!", data.msg, "success");
	                	Layout.loadAjaxContent(backurl);
	                }else{
	                	swal("删除失败!");
	                }
  	            }, 
  	            error: function(request) {
  	            	swal(request);
  	            }
  	        });

     	  }, 100);
    	});
    });
    
});
</script> 
@endif  
<script type="text/javascript">
$(function(){	
    $("#save").click(function(){
        var noticeurl = $("#modid").data("noticeurl");
        if($("#tipshow").length > 0) {
    		$(".tipshow").remove();
    	}    
        var succesurl= "{{sprintf($actions['list'],$page,$filter)}}";  
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
            }, 
        });     	

    })
})
</script>
<script>
$(document).ready(function() {
	//var spannum = $(".rowspannum").val();
	//$(".rowspannum").parrent(".far").prev(".spannum").attr("rowspan",spannum);

	var sucurl = $("#refreshbtn").attr("href");
	$('.ed_eliments').editable({  
        type : 'text',  
        placeholder: '请输入修改值', 
        emptytext:'已设置,但值为空', 
        params: function(params) {
            //originally params contain pk, name and value
            params._token = '{{csrf_token()}}';
            params.act_type = 'multi_save';
            return params;
        },  
        validate : function(value) {  
            if (value == '') {  
                return '不能为空';  
            }  
        }  
    });
	$('.add_eliments').editable({  
		
        type : 'text',  
        placeholder: '请输入添加值',
        emptytext:'未设置',   
        
        params: function(params) {
            //originally params contain pk, name and value
            params._token = '{{csrf_token()}}';
            params.act_type = 'multi_save';
            params.desc = $(this).data('desc');
            return params;
        },  
        ajaxOptions: {
            dataType: 'json'
        },
        validate : function(value) {  
            if (value == '') {  
                return '不能为空';  
            }  
        },
        success: function(response) {
            if(response.status != 0){
            	return response.msg; //msg will be shown in editable form
              	//Layout.loadAjaxContent(succesurl);
            }
                 
        } 
    });  
});
</script>

