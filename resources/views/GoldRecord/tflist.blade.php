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
                <div  class=" no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                            	<input type="text" name="uid" id="uid" class="form-control" value="{{$uid}}" placeholder="UID">
                            </div> 
                                                       
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
							@foreach($game_data as $k=>$v)
                            <th> {{$v}} </th>
                            @endforeach
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
                         <tr role="row">
        						@foreach($data as $k=>$v)
                                    	<td> {{ $v}} </td> 
                                @endforeach
                         </tr>
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