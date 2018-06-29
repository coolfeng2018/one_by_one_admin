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
                             	<a class="ajaxify btn btn-xs" href="{{sprintf($actions['add'],$page,'add')}}">
                                <button id="sample_editable_1_new" class="btn sbold green"> 
                                    <i class="fa fa-plus"></i>添加新配置
                                </button>
                                </a>
                            </div>
                            
							<div class="btn-group">
                            	<input type="text" name="uid" id="uid" class="form-control" @if(isset($uid)) value="{{$uid}}" @endif placeholder="UID">
                            </div>
                         
                         <!-- <div class="col-md-2 btn-group">
                         <div class="input-group date form_meridian_datetime form_datetime bs-datetime" data-date="2012-12-21T15:25:00Z">
                            <input type="text" size="16" class="form-control" name="start" @if(isset($start)) value="{{$start}}" @endif>
                            <span class="input-group-addon">
                                <button class="btn default date-reset" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                            <span class="input-group-addon">
                                <button class="btn default date-set" type="button"  name="end" @if(isset($end)) value="{{$end}}" @endif>
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                         </div>
                         
                         </div>
                         <div class="col-md-2 btn-group">
                         <div class="input-group date form_meridian_datetime form_datetime bs-datetime" data-date="2012-12-21T15:25:00Z">
                            <input type="text" size="16" class="form-control">
                            <span class="input-group-addon">
                                <button class="btn default date-reset" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                            <span class="input-group-addon">
                                <button class="btn default date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                         </div>
                         </div>
                          -->
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
                            <th > 封号状态 </th>
                            <th > 原因 </th>
                            <th > 结束时间 </th>
                            <th > 最后修改的操作人 </th>
                            <th > 操作时间 </th>
                            <th > 操作 </th>
                        </tr>
                  
                    </thead>
                    <tbody>
                    <tbody>
    						@foreach($data as $k=>$v)
                                <tr role="row" @if($k%2==0) class="even" @else class="odd" @endif >
                                	<td> {{ $v->id }} </td>
                                    <td> {{ $v->uid }} </td>
                                    <td> {{ isset($lockstatus[$v->lock_status]) ? $lockstatus[$v->lock_status] : $v->lock_status }} </td>
                                    <td> {{ $v->reason }} </td>
                                    <td> {{ isset($v->endtime) && $v->endtime!=0 ? date('Y-m-d H:i:s',$v->endtime) : $v->endtime}} </td>
                                    <td> {{ $v->op_name }}  </td>
                                    <td> {{ date('Y-m-d H:i:s',$v->op_time) }}  </td>
                                    <td>
                                         <a class="editstatus btn btn-xs blue" data-edithref="{{sprintf($actions['lock'],$page,'mod')}}&id={{$v->id}}&type={{$v->lock_status}}&uid={{$v->uid}}" > <i class="fa fa-edit"> @if($v->lock_status==1) 解封 @else 封号 @endif</i></a> 
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
    var href="/uinfo/locklist?";
    $("#searchall").click(function(){
    	$("#searcha").attr("href",href+"uid="+$("#uid").val());//+"&start="+$("#start").val()+"&end="+$("#end").val()
    
    });
});
</script> 
<script type="text/javascript">
    $(".form_datetime").datetimepicker({
    	language: "zh-CN",
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep: 10
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
                if(data.status = 0){ 
                	alert(data.msg);
                	Layout.loadAjaxContent("{{sprintf($actions['locklist'],$page)}}");                   
                }else{
                    alert(data.msg);
                    Layout.loadAjaxContent("{{sprintf($actions['locklist'],$page)}}");     
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