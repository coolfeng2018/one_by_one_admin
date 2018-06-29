<style type="text/css">
.pay div{
    padding:5px 5px 5px 25px;
}
.pay span{
    color:red;
}
.test{clear:both;}
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 用户消息列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div id="sample_1_filter" class="dataTables_filter">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 对话编号 </th>
                        <th> 游戏ID </th>
                        <th> 留言内容 </th>
                        <th> 留言时间 </th>
                        <th> 对话最后更新时间 </th>
                        <th> 状态 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res['results'] as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->CustomerId }}</td>
                                    <td>{{ $resources->uid }}</td>
                                    <td>
                                        @if(strlen($resources->message)>12)
                                            {{ substr($resources->message, 0,12) }}...
                                        @else
                                            {{ $resources->message }}
                                        @endif
                                    </td>
                                    <td>{{ $resources->m_time }}</td>
                                    <td>{{ $resources->updatetime }}</td>
                                    <td>
                                        @if($resources->re_status==2)
                                        	<b style="color:green">@if(isset($reply_tips[$resources->re_status])) {{ $reply_tips[$resources->re_status] }} @else $resources->re_status @endif</b>
                                        @elseif($resources->re_status==1)
                                        	<b style="color:blue">@if(isset($reply_tips[$resources->re_status])) {{ $reply_tips[$resources->re_status] }} @else $resources->re_status @endif</b>
                                                
                                        @else
                                            <b style="color:red">@if(isset($reply_tips[$resources->re_status])) {{ $reply_tips[$resources->re_status] }} @else $resources->re_status @endif</b>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-xs green" href="/customerserve/ajax?page={{$page}}&uid={{ $resources->uid }}" data-target="#ajax" data-toggle="modal">   回复 </button>  
                                        <button class="btn btn-xs blue delcfg" data-delurl="/customerserve/ajax?type=isread&mid={{ $resources->m_mid }}" data-backurl="/customerserve/index?page={{$page}}" data-toggle="confirmation" data-original-title="Are you sure ?" title="">置为已读</button>
                                        <div class="modal fade" id="ajax" role="basic" aria-hidden="true">                                      
                                        <div class="modal-dialog" width="800px">  
                                        <div class="modal-content">  
                                        </div>  
                                        </div>  
                                        </div>  
                                    </td>

                                    

                                
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                </table>
                <div id="record">共<span>{{$res['total']}}</span>条记录</div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<!-- model begin -->

<!-- model end -->

<style>
    .max{width:100%;height:auto;}
    .min{width:100px;height:auto;}
</style>
<script>
    $('.img').click(function(){
        $(this).toggleClass('min');
        $(this).toggleClass('max');
    });
</script>

<script type="text/javascript">
$(function(){	
    $(".delcfg").click(function(){
        var del_url = $(this).data('delurl');
        var backurl = $(this).data('backurl');
    	swal({
    	  title: "确定要置为已读吗?",
    	  type: "warning",
    	  showCancelButton: true,
    	  confirmButtonText: "确定！",
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
  	            	if(data.status==0){ 
	                	swal("已设置为已读!", data.msg, "success");
	                	Layout.loadAjaxContent(backurl);
	                }else{
	                	swal("失败!");
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
 