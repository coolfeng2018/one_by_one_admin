<link href="/hsgm/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">

                    <i class="fa fa-search font-dark"></i>
                    <span class="caption-subject bold uppercase">{{ $pagename }}</span>
                </div>
                
            </div>
            
            <div class="portlet-body">
                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                             	<a class="ajaxify btn btn-xs" href="{{sprintf($actions['add'],$page,$filter,empty($filter)? $filter: $filter.'>')}}">
                                <button id="sample_editable_1_new" class="btn sbold green"> 
                                    <i class="fa fa-plus"></i>添加新配置
                                </button>
                                </a>
                            </div>
                            @if(isset($actions['sntcfg']))
                            <div class="btn-group">
                             	<!-- <a class="btn btn-xs" href=""> -->
                                <button id="sntcfg" class="btn sbold red" data-snt="{{$actions['sntcfg']}}" > 
                                    <!-- <i class="fa fa-plus"></i> --> 发送到服务器
                                </button>
                                <!-- </a> -->
                            </div>
                          	@endif
                          	
                          	@if(isset($actions['down']))
                            <div class="btn-group">
                             	<!-- <a class="btn btn-xs" href=""> -->
                                <button id="downcfg" class="btn sbold blue" data-snt="{{$actions['down']}}" > 
                                    <!-- <i class="fa fa-plus"></i> --> 下载该项配置
                                </button>
                                <!-- </a> -->
                            </div>
                          	@endif
	
                          	
                          	<div class="form-group">
                            
                        	</div>
                         
                         </div>
                         
                    
                    </div>
                
                <div class="table-scrollable">
              
                <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">

                     <thead>
                     <tr class="" role="row">
                       @foreach($tabname as $key=>$val)
							<th > 
							@if($key!='first_tab' && $key!='edit_tab') {{ $key }} @endif<br/>
							{{ $val['name'] }}<br/>
							@if(isset($val['tips'])) {{ $val['tips'] }} @endif<br/>
							</th>           	
                       @endforeach
                       <th>操作</th>
                       </tr>
                    </thead> 
                    <tbody>
    						@foreach($cfgdata as $k=>$v)
    						<tr role="row" >
    								 @foreach($tabname as $key=>$val)
    								 	@if(isset($v[$key]))
    										@if(isset($v[$key]['str']))
            								<td> {{!! $v[$key]['str'] !!}} </td>
            								@elseif(isset($v[$key]['val_col']))
            								<td> {{$v[$key]['val_col']}} </td>
            								@else
        										<td> -- </td>
        									@endif
    									@else
    										@if($key == 'first_tab')
    										<td> {{$k}} </td>
    										@else
    										<td>  </td>
    										@endif
    									@endif
                                     @endforeach  
                                     <td>
                                 		<a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['list'],$page,$k)}}" > <i class="fa fa-edit"> edit</i></a> 
                            	 	</td>
                              </tr>                              
                            @endforeach                   	
                    </tbody>

                </table>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">

                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<div class="panel-body">

	<h2>配置结构如下：</h2>
	{!! $prev !!}
</div>
<div id="url" data-listurl="{{sprintf($actions['list'],$page,$filter)}}"></div>
@if(isset($actions['del']))
<script type="text/javascript">
$(function(){	
    $(".delcfg").click(function(){
        var delid = $(this).data('delid');
        var succesurl = $("#url").data("listurl");
    	swal({
    	  title: "你确定要删除 id为"+delid+" 这条记录吗?",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "删除！",
    	  cancelButtonText: "取消！~",
    	  confirmButtonClass: "btn-danger",
    	  closeOnConfirm: false,
    	  showLoaderOnConfirm: true
    	}, function () {
     	  setTimeout(function () {
      		 $.ajax( {
  	        	async: false,
  	        	cache: false,
  	            type : "get",
  	            url : "{{ $actions['del'] }}",	            
  	            dataType : 'json',
  	            data : {'_token':'{{csrf_token()}}',id:delid},
  	            success : function(data) {
  	                if(data.status){ 
  	                	swal("Deleted!", data.msg, "success");
  	                	Layout.loadAjaxContent(succesurl);
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
@if(isset($actions['sntcfg']))
<script type="text/javascript">
$(function(){
	var succesurl = $("#url").data("listurl");
    $("#sntcfg").click(function(){
    	swal({
    	  title: "你确定要生效{{ $pagename }}?",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "确定发送！",
    	  cancelButtonText: "取消！~",
    	  confirmButtonClass: "btn-danger",
    	  closeOnConfirm: false,
    	  showLoaderOnConfirm: true
    	}, function () {
     	  setTimeout(function () {
      		 $.ajax( {
  	        	async: false,
  	        	cache: false,
  	            type : "get",
  	            url : "{{sprintf($actions['sntcfg'],'do')}}",	            
  	            dataType : 'json',
  	            data : {'_token':'{{csrf_token()}}'},
  	            success : function(data) {
  	                if(data.status==0){ 
  	                	swal("Success", data.msg, "success");
  	                	Layout.loadAjaxContent(succesurl);
  	                }else{
  	                	swal("Fail",data.msg);
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
@if(isset($actions['down']))
<script type="text/javascript">
$(function(){
	var openurl = "{{$actions['down']}}";
    $("#downcfg").click(function(){
    	window.open(openurl);
    });
});
</script> 
@endif 
<script src="/hsgm/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>                   
<script src="/hsgm/plugins/bootstrap-sweetalert/ui-sweetalert.min.js" type="text/javascript"></script>              
                        