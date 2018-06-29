<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">

                    <i class="fa fa-search font-dark"></i>
                    <span class="caption-subject bold uppercase">{{ $pagename }} &nbsp;&nbsp;&nbsp;&nbsp;大厅人数：{{$data['hall_count']}}&nbsp;&nbsp;&nbsp;&nbsp;房间人数：{{$data['game_count']}}</span>
                </div>               
            </div>
            
            <div class="portlet-body">
                <div  class=" no-footer">
             
                <div class="table-scrollable">             
                <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">
                    <thead>
                        <tr class="" role="row">
							@foreach($game_data as $k=>$v)
                            <th> {{$v}} </th>
                            @endforeach
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
                        
        						@foreach($data['online_list'] as $v)
        						        <tr role="row">
                                    	<td><a href="/goldrecord/list?uid={{$v['uid']}}" class="ajaxify" style="display: inline;"> {{$v['uid']}} <a/></td> 
                                    	<td>
                          
                                        @if($v['pay_count'] > 0)
                                            	<p class="invoice-desc grand-total "><b style="color: red;"> {{$v['name']}} </p></b>
                                        @else
                                                {{$v['name']}}
                                        @endif
                                    	
                                    	</td> 
                                    	<td> {{$v['table_type']}} </td> 
                                    	<td> {{$v['coins']}} </td> 
                                    	<td> {{$v['amout_offline']}} </td> 
                                    	<td> {{$v['amout_online']}} </td> 
                                    	<td> {{$v['amout_total']}} </td> 
                                    	<td> {{$v['pay_count']}} </td> 
                                    	<td> {{$v['withdraw_total']}} </td> 
                                    	<td> {{$v['user_wl']}} </td>
                                    	<td> {{$v['cost_sum']}} </td>
                                    	<td> {{$v['channel']}} </td>
                                    	<td> {{$v['created_time']}} </td>
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
<script type="text/javascript">
$(function(){	
    var href="/goldrecord/tflist?";
    $("#searchall").click(function(){
    	$("#searcha").attr("href",href+"uid="+$("#uid").val()+"&start="+$("#start").val()+"&end="+$("#end").val());
    
    });
});
</script>           