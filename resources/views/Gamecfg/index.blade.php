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
                             	<a class="ajaxify btn btn-xs" href="{{sprintf($actions['add'],$page,$filter,'')}}">
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
                                <button id="downlua" class="btn sbold blue" data-snt="{{$actions['down']}}" > 
                                    <!-- <i class="fa fa-plus"></i> --> 下载这项配置
                                </button>
                                <!-- </a> -->
                            </div>
                          	@endif
                          	
                         	@if(isset($keys) && !empty($keys))
                            <div class="btn-group">
                        		  
                                <label class="col-md-6 control-label">配置项选择</label>
                                <div class="col-md-2 btn-group">
                                	<select id="robot_type" class=" form-control input-inline">
                                	@foreach($keys as $k=>$v)
                                            <option value="{{ $k }}">{{ $v['desc'] }}</option>
                                    @endforeach           
                                    </select>
                                    
                                </div>

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
							<th > ID </th>
                            <th > key </th>
                            <th > val </th>
                            <th > 描述 </th>
                            <th > 备注 </th>
                            <th > 最后修改的操作人 </th>
                            <th > 操作时间 </th>
                            <!-- <th > 状态</th> -->
                            <th > 操作 </th>
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="even" @else class="odd" @endif >
                                	<td> {{ $v->id }} </td>
                                    <td> {{ $v->key_col }} </td>
                                    <td> {{ $v->val_col }} </td>
                                    <td> {{ $v->desc }} </td>
                                    <td> {{ $v->memo }} </td>
                                    <td> {{ $v->op_name }}  </td>
                                    <td> {{ $v->op_time }}  </td>
                                    <!-- <th> @if($v->o_status==2)<span class="label list-group-item-success"> <a href="javascript:;" class="list-group-item-success"> 生效中</a> </span>  @else<span class="label list-group-item-danger"> <a href="javascript:;" class="list-group-item-danger"> 未启用</a> </span> @endif </th> -->
                                    <td>
                                         <a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['mod'],$page,$v->id,$filter)}}" > <i class="fa fa-edit"> edit</i></a> 
                                         @if(isset($actions['del']))<button class="btn red btn-xs delcfg" data-delid="{{ $v->id }}"  data-toggle="confirmation" data-original-title="Are you sure ?" title=""><i class="fa fa-times"> delete</i></button>@endif
                                    </td>
                                </tr>
                            @endforeach
                    	
                    </tbody>
                </table>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
 {!! $data->links() !!}
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
    	var succesurl = $("#url").data("listurl");
        var delid = $(this).data('delid');
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
    $("#sntcfg").click(function(){
    	var succesurl = $("#url").data("listurl");
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
    $("#downlua").click(function(){
    	var url = "{{$actions['down']}}";
    	window.open(url);
    });
});
</script> 
@endif                         