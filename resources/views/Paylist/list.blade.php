<link href="/hsgm/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">

                    <i class="fa fa-edit font-dark"></i>
                    <span class="caption-subject bold uppercase">{{ $pagename }}</span>
                </div>
                
            </div>
            
            <div class="portlet-body">
                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                             	<a class="ajaxify btn btn-xs" href="/paylist/add?page={{$page}}">
                                <button id="sample_editable_1_new" class="btn sbold green"> 
                                		<i class="fa fa-plus"></i>&nbsp;&nbsp;添加新配置
                                </button>
                                </a>
                            </div>
                            
							<div class="btn-group">
                                <button id="sample_editable_1_new" class="btn sbold green showprevbtn" data-showid="valid_prev"> 
                                		<!-- <i class="fa fa-plus"></i>&nbsp;&nbsp; -->查看生效配置结构
                                </button>
                                
                            </div>
                            
                            <div class="btn-group">
                                <button id="sample_editable_1_new" class="btn sbold green showprevbtn" data-showid="all_prev"> 
                                		<!-- <i class="fa fa-plus"></i>&nbsp;&nbsp; --> 查看全部配置结构
                                </button> 
                            </div>
                            <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green hideprevbtn" > 
                                    		<!-- <i class="fa fa-plus"></i>&nbsp;&nbsp; --> 不显示结构
                                    </button> 
                             </div>
                         </div>
                         
                    
                    </div>
                
                <div class="table-scrollable">
              
                <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">

                    <thead>
                        <tr class="" role="row">
							<th > ID </th>
							<th > 上下架状态</th>
							<th > 展示顺序(升序)</th>							
                            <th > 支付方式名称 </th>
                            <th > 支付代码 </th>
                            <th > 支付方式 </th>
                            <th > 固定充值金额 </th>
                            <th > 是否支持手动输入金额 </th>
                            <th>  备注  </th>                             
                            <th > 最后操作人 </th>
                            <th > 最后操作时间 </th>
                            <th > 操作</th>
                        </tr>                
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="even" @else class="odd" @endif >
                                	 <td> {{ $v->id }} </td> 
                                	<td> @if(isset($cfg_list['o_status'][$v->o_status]['tip']))<span class="label {{$cfg_list['o_status'][$v->o_status]['css']}}"> {{$cfg_list['o_status'][$v->o_status]['tip']}} </span>@else {{$v->o_status}} @endif </td>
                                	<td> {{ $v->sort_id }} </td>
                                    <td> {{ $v->name }} </td>
                                    <td> {{ $v->payment_channels }} </td>
                                    <td> @if(isset($cfg_list['payment_ways'][$v->payment_ways]))  {{ $cfg_list['payment_ways'][$v->payment_ways] }} @else 未知  @endif </td>
                                    <td> {{ $v->money_list }} </td>
                                    <td> @if(isset($cfg_list['status'][$v->status]['tip'])) {{$cfg_list['status'][$v->status]['tip']}} @else {{$v->status}}  @endif  </td>
                                    <td> {{ $v->memo }}  </td>
                                    <td> {{ $v->op_name }} </td>
                                    <td> {{ $v->op_time }}  </td>
                                    <td>
                                         <a class="ajaxify btn btn-xs blue" href="/paylist/mod?page={{$page}}&id={{ $v->id }}" > <i class="fa fa-edit">&nbsp;&nbsp;修改</i></a> 
                                         
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
<div class="panel-body">
	<div id="valid_prev" class="showprev" >
		<h2> 生效的配置结构如下：</h2>
		{!! $valid_prev !!}
	</div>
	<div id="all_prev" class="showprev" >
		<h2>所有配置结构如下：</h2>
		{!! $all_prev !!}
	</div>
</div>
<script type="text/javascript">
$(function(){
	$(".showprev").hide();
	$(".hideprevbtn").click(function(){
		$(".showprev").hide();
	});
	$(".showprevbtn").click(function(){
		var showid=$(this).data('showid');
		$(".showprev").hide();
		$("#"+showid).show();
	});
	

});


</script>     
<script src="/hsgm/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>                   
<script src="/hsgm/plugins/bootstrap-sweetalert/ui-sweetalert.min.js" type="text/javascript"></script>                           