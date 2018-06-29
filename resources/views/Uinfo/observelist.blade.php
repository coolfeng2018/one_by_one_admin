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
                             	<a class="ajaxify btn btn-xs" href="{{sprintf($actions['observeadd'],$page)}}">
                                <button id="sample_editable_1_new" class="btn sbold green"> 
                                    <i class="fa fa-plus"></i>添加新配置
                                </button>
                                </a>
                            </div>
                            
							<div class="btn-group">
                            	<input type="text" name="uid" id="uid" class="form-control" @if(isset($uid)) value="{{$uid}}" @endif placeholder="UID">
                            </div>
                             
                                <span id="demo">创建时间:&nbsp;
                                <input type="text" id="start" class=" form-control  input-inline" @if(isset($start)) value="{{$start}}" @else value="{{date('Y-m-d H:i:s',strtotime('-1 week'))}}"  @endif >
                                &nbsp;-&nbsp;
                                <input type="text" id="end" class=" form-control  input-inline" @if(isset($end)) value="{{$end}}" @else value="{{date('Y-m-d H:i:s',time())}}"  @endif >&nbsp;
                                </span>
                            <div class="btn-group">
                            	<select class="bs-select form-control  input-medium " id="o_status" name="o_status">
                 					<option value="">状态</option>
                 		            @foreach($observecnf['o_status'] as $key=>$val)
                                    <option value='{{$key}}' @if(isset($o_status) && $o_status ==$key) selected  @endif >{{$val}}</option>
                                    @endforeach        
                    	    	</select>
                            </div>
 							<div class="btn-group">
                            	<select class="bs-select form-control  input-medium " id="otype" name="otype">
                 					<option value="">调控类型</option>
                 		            @foreach($observecnf['otype'] as $key=>$val)
                                    <option value='{{$key}}' @if(isset($otype) && $otype ==$key) selected  @endif >{{$val}}</option>
                                    @endforeach        
                    	    	</select>
                            </div>	
                         <span id="searchall">
                            	<a id="searcha"  class="ajaxify btn green" style="display: inline;"> 
                                    <i class=" fa fa-search">搜索</i>
                                </a>
                            </span>
                         </div>
                    </div>
                    
                
                
                <div class="table-scrollable">
              
                <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">

                    <thead>
                        <tr class="" role="row">

                            <th > UID/昵称 </th>
                            
                            <th>  剩余影响额度<br/>(未实现的目标值)</th>
                            
                            <th > 目标值 </th>
                            <th > 概率 </th>
                            <th>  状态</th>
                            
                            <th>  创建时间</th>
                            <th > 最后修改的操作人 </th>
                            <th > 操作时间 </th>
                            <th > 操作 </th>
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v) 
                                <tr role="row" @if($k%2==0) class="even" @else class="odd" @endif >
                                	
                                    <td> 
                                    <a class="btn btn-xs ajaxify" href="/goldrecord/list?uid={{ $v->uid }}" > 
                                        @if ($v->deposit_sum>=500) <!-- 500 金色-->
                                        <code class="label label-warning" > {{ $v->uid }} / {{ $v->username }}</code>
                                    	@elseif ($v->deposit_sum>=100 && $v->deposit_sum<500) <!-- 100-500 红色-->
                                    	<span class="label label-danger" > {{ $v->uid }} / {{ $v->username }}</span>
                                    	@elseif ($v->deposit_sum>=1 && $v->deposit_sum<100) <!-- 小于100绿色-->
                                    	<span class=" label label-success" > {{ $v->uid }} / {{ $v->username }}</span>
                                    	@else <!-- 免费黑色-->
                                    	{{ $v->uid }} / {{ $v->username }}
                                    	@endif 
                                    </a> 
                                    </td>
                                    <td> {{ $v->affect_count }}</td>
                                    @if ($v->o_status==1) <!-- 进行中-->
                                    <td> 
                                    
                                        @if ($v->otype==1)<code class="c-btn-border-1x bold"> {{ $v->goal_num }} </code> 
                                        @elseif ($v->otype==2) <code class="c-btn-border-1x bold"  style="color:#eb8570"> -{{ $v->goal_num }} </code>
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                    </td>
                                    <td>
                                    	@if ($v->otype==1)<code class="c-btn-border-1x bold"> {{ $v->percent }} </code> 
                                        @elseif ($v->otype==2) <code class="c-btn-border-1x bold"  style="color:#eb8570"> -{{ $v->percent }}</code> 
                                        @else {{ $v->percent }}  
                                        @endif 
                                    </td>
                                    <td> <span class="label label-sm font-red "><strong>@if(isset($observecnf['o_status'][$v->o_status])) {{$observecnf['o_status'][$v->o_status]}} @else {{$v->o_status}} @endif</strong></span>  </td>
                                    @elseif ($v->o_status==2) <!-- 自动完成 -->
                                    <td> 
                                    	@if ($v->otype==1) <code style="background-color:#e4eff0;color:#1BA39C"> {{$v->goal_num}}</code> 
                                        @elseif ($v->otype==2) <code style="background-color:#e4eff0;color:#1BA39C"> -{{$v->goal_num}}</code> 
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                    </td>
                                    <td> 
                                    	@if ($v->otype==1)<code style="background-color:#e4eff0;color:#1BA39C">  {{ $v->percent }} </code> 
                                        @elseif ($v->otype==2) <code style="background-color:#e4eff0;color:#1BA39C">  -{{ $v->percent }} </code>
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                   
                                    </td>
                                     <td> <span class="label label-sm font-green-haze"><strong>@if(isset($observecnf['o_status'][$v->o_status])) {{$observecnf['o_status'][$v->o_status]}} @else {{$v->o_status}} @endif</strong></span>  </td>
                                     @elseif ($v->o_status==3) <!-- 后台中止 -->
                                    <td> 
                                    	@if ($v->otype==1) <span class="label label-sm  font-grey-silver">{{ $v->goal_num }}  </span>
                                        @elseif ($v->otype==2) <span class="label label-sm  font-grey-silver"> -{{ $v->goal_num }} </span>
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                    </td>
                                    <td> 
                                    	@if ($v->otype==1)<span class="label label-sm  font-grey-silver"> {{ $v->percent }} </span> 
                                        @elseif ($v->otype==2) <span class="label label-sm  font-grey-silver"> -{{ $v->percent }} </span>
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                   
                                    </td>
                                     <td> <span class="label label-sm  font-grey-silver"><strong>@if(isset($observecnf['o_status'][$v->o_status])) {{$observecnf['o_status'][$v->o_status]}} @else {{$v->o_status}} @endif</strong></span>  </td>

                                    @else
                                    <td> 
                                    	@if ($v->otype==1) {{ $v->goal_num }}
                                        @elseif ($v->otype==2)  -{{ $v->goal_num }} 
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                    </td>
                                    <td> 
                                    	@if ($v->otype==1) {{ $v->percent }} 
                                        @elseif ($v->otype==2)  -{{ $v->percent }} 
                                        @else  {{ $v->goal_num }} 
                                        @endif 
                                   
                                    </td>
                                    <td> <span class="label label-sm  ">@if(isset($observecnf['o_status'][$v->o_status])) {{$observecnf['o_status'][$v->o_status]}} @else {{$v->o_status}} @endif</span>  </td>
                                    @endif
                                    
                                    <td> {{ $v->create_time }} </td>
                                    <td> {{ $v->op_name }}  </td>
                                    <td> {{ $v->op_time }}  </td>
                                    <td>
                                         <a class="ajaxify btn btn-xs blue" href="{{sprintf($actions['observemod'],$page)}}&id={{$v->id}}&uid={{$v->uid}}" > <i class="fa fa-edit"> 修改</i></a> 
                                         @if ($v->o_status==1)
                                         <a class="editstatus btn btn-xs red" data-edithref="{{sprintf($actions['observemod'],$page)}}&act=ajax&id={{$v->id}}&o_status=3" > <i class="fa fa-edit"> 中止</i></a>
                                         @endif 
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
<script type="text/javascript">
$(function(){	
    var href="/uinfo/observe/list?";
    $("#searchall").click(function(){
    	$("#searcha").attr("href",href+"uid="+$("#uid").val()+"&start="+$("#start").val()+"&end="+$("#end").val()+"&otype="+$("#otype").val()+"&o_status="+$("#o_status").val());   
    });
});
</script> 


<script type="text/javascript">

$(function(){	
    $(".editstatus").click(function(){
    	var edithref = $(this).data("edithref");        
        $.ajax( {
        	async: false,
        	cache: false,
            type : "get",
            url : edithref,
            dataType : 'json',
            data:'',
            success : function(data) {
                if(data.status == 0){ 
                	alert(data.msg);
                	Layout.loadAjaxContent("{{sprintf($actions['observelist'],$page)}}");                   
                }else{
                    alert(data.msg);    
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
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker_zh.js"></script>                 