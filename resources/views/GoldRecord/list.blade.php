<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">

                    <i class="fa fa-search font-dark"></i>
                    <span class="caption-subject bold uppercase">{{ $pagename }}</span>
                    <button class="ajaxify btn btn-circle green-madison" href="/withdraw/index?page={{$search['page']}}&Status={{$search['Status']}}"> 返回
                        <i class="fa fa-reply"></i>
                    </button>
                </div>               
            </div>
            
            <div class="portlet-body">
                <div  class=" no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                            	<select class="bs-select form-control  input-medium " id="reason" name="reason">
                             			<option value="">变化原因选择</option>
                             			@foreach($reasonlist as $key=>$val) 
     		                            <option value="{{$key}}"  @if(isset($search['reason']) && $search['reason']==$key) selected="selected" @endif >{{$val['cn']}}</option>
     		                        	@endforeach
        	                            
        	                     </select>
                                
                            </div>
                            <div class="btn-group">
                            	<select class="bs-select form-control  input-medium " id="table" name="table">
                             		<option value="">房间选择</option>
                             			@foreach($tablelist as $key=>$val) 
     		                            <option value="{{$key}}"  @if(isset($search['table']) && $search['table']==$key) selected="selected" @endif >{{$val}}</option>
     		                        	@endforeach
        	                     </select>
                                
                            </div>
                            <div class="btn-group">
                            	<input type="text" name="uid" id="uid" class="form-control" value="{{$search['uid']}}" placeholder="UID">
                            </div> 

                            
                           
                             <span id="demo">日期区间:&nbsp;
                                <input type="text" id="start" name="start" class=" form-control  input-inline" @if(isset($search['start'])) value="{{ $search['start'] }}" @else value="{{date('Y-m-d 00:00:00',strtotime('-1 week'))}}"  @endif >
                                &nbsp;-&nbsp;
                                <input type="text" id="end" name="end"  class=" form-control  input-inline" @if(isset($search['end'])) value="{{ $search['end'] }}" @else value="{{date('Y-m-d H:i:s',time())}}"  @endif >&nbsp;
                                </span>
                            

                           
                            <span id="searchall">
                            	<a id="searcha"  class="ajaxify btn green" style="display: inline;"> 
                                    <i class=" fa fa-search"></i>
                                </a>
                            </span>
                                
                                              
                         </div>
                    </div>               
                <div class="table-scrollable">             
                <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">
                    <thead>
                        <tr class="" role="row">
							<th > ID </th>
                            <th > UID </th>
                            <th > 变化前数量 </th>
                            <th > 变化数量 </th>
                            <th > 变化原因 </th>
                            <th > 房间类型 </th>
                            <th > 渠道号 </th>
							<th > 操作时间 </th>
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="even" @else class="odd" @endif >
                                	<td> {{ $v->incr_id }} </td> 
                                    <td> <a href="/uinfo/index?act=search&uid={{ $v->uid }}" class="ajaxify" style="display: inline;"> {{ $v->uid }}</a> </td>
                                    <td> {{ $v->cur_num }} </td>
                                    <td> @if($v->op == 1)<span class="label label-sm label-danger"> + {{ $v->chg_num }} </span> @else <span class="label label-sm  label-success"> - {{ $v->chg_num }} </span> @endif </td>
                                    <td> {{ $v->rsn }} </td>
                                    <td> {{ $v->table }}  </td>
                                    <td> {{ $v->channel }}  </td>
                                    <td> {{ $v->optime }}  </td>
                                </tr>
                            @endforeach
                    	
                    </tbody>
                </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
 
<script type="text/javascript">
$(function(){	
    var href="/goldrecord/list?";
    $("#searchall").click(function(){
    	$("#searcha").attr("href",href+"uid="+$("#uid").val()+"&start="+$("#start").val()+"&end="+$("#end").val()+"&reason="+$("#reason").val()+"&table="+$("#table").val());
    
    });
    var aobj=$("#sample_1_info").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&uid="+$("#uid").val()+"&start="+$("#start").val()+"&end="+$("#end").val()+"&reason="+$("#reason").val()+"&table="+$("#table").val());
    });
});
</script> 
 
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker_zh.js"></script>          