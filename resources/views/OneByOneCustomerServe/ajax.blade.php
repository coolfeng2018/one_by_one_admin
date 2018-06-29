<style type="text/css">
#content span{
    white-space:pre-wrap;word-wrap:break-word;
}
#content b{
    padding-right: 20px;
}
</style>
<div class="modal-header">  
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>  
    <h4 class="modal-title">聊天窗口</h4>  
</div>  
<div class="modal-body">  
    <div class="row">  
        <div class="col-md-12">
            <div id="content">
            @foreach ($res as $resources)
                    @if($resources->FromUid==888888)
                        <b>ID:客服答复</b>
                    @else
                        <b>ID:{{ $resources->FromUid }}</b>
                    @endif
                <b>留言时间:{{ $resources->time }}</b>
                <br>
                <br>
                @if($resources->FromUid==888888)
                    <span  class="label label-sm label-success">{{ $resources->message }}</span>
                @else
                    <span  class="label label-sm label-primary">{{ $resources->message }}</span>
                @endif
                <br>
                <br>
            @endforeach
            </div>
            <p>  
                <form action="/customerserve/ajax?uid={{ $uid }}&type=receive" method="get" id="FormID">
                    <input type="text" name="receive" id="receive" class="col-md-12 form-control">  
                </form>
                <button onclick="Load()">回复</button>
            </p>  
        </div>  
    </div>  
</div>  
<div class="modal-footer">  
    <button type="button" class="btn default" data-dismiss="modal" id="flushbtn">关闭</button>  
<!--     <button type="button" class="btn blue">Save changes</button>   -->
</div>  
<script type="text/javascript">
    function Load(){
    var message = $('#receive').val();
    var tag = '<b>ID:客服答复</b><b>留言时间:';
    var data=$('#FormID').serialize();
    var submitData=decodeURIComponent(data,true);
    $.ajax({
        url:'/customerserve/ajax?uid={{ $uid }}&type=receive',
        data:submitData,
        cache:false,//false是不缓存，true为缓存
        async:true,//true为异步，false为同步
        beforeSend:function(){
            $('#receive').val('');
        },
        success:function(result){
            if(result.code==200){
                tag += result.result.time;
                tag += '</b><br><br><span  class="label label-sm label-success">';
                tag += message;
                tag += '</span><br><br>';
                $("#content").append(tag);
            }
        },
        complete:function(){
            //请求结束时
        },
        error:function(){
            //请求失败时
        }
    })
}
</script>
<script type="text/javascript">
$(function(){	
    $("#flushbtn").click(function(){
    	$('#ajax').modal('hide');
    })
})
</script>
<script>
$(function() {
	
	$('#ajax').on('hidden.bs.modal',
	    function() {
	    	var url = '/customerserve/index?page='+{{$page}};
			Layout.loadAjaxContent(url);
	    })
});
</script>
