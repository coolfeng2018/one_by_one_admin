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
                             	<a class="ajaxify btn btn-xs" href="">
<!--                                 <button id="sample_editable_1_new" class="btn sbold green">
                                   <i class="fa fa-plus"></i> 
                                </button> -->
                                </a>
                            </div>
                           
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
							
                            <th > 机器人类型    </th>
                            <th > 金币数量     </th>
                            
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v)
                                <tr role="row"  >
                                	<td> @if(isset($rtypelist[$k]))  {{ $rtypelist[$k] }}  @else {{ $k }} @endif</td>
                                    <td> {{ $v }} </td>
                                   
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



