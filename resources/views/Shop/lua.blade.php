<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 确认lua数据发送api </span>
                    <button id="proConfig"  class="btn btn-circle blue-madison" >发送api</button>
                    <button class="ajaxify btn btn-circle green-madison" href="/error/index"> 返回上一页
                        <i class="fa fa-reply"></i>
                    </button>
                    <!-- <button href="javascript:window.opener=null;window.open('','_self');window.close();">关闭</button> -->
                </div>
            </div>
            <div class="portlet-body">
                <pre>
                    {{ $lua }}
                </pre>
                <!-- <div id="lua" name="lua" style="display: none">{{ $lua }}</div> -->
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>



<script>
$(function(){
    var href="/error/index?";
    $("#search").click(function(){
        $("#search").attr("href",href+"id="+$("#id").val()+"&name="+$("#name").val());

    });
    var aobj=$(".pagination").find("a");
    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&id="+$("#id").val()+"&name="+$("#name").val());
    });
    //转Lua
    $('#proConfig').click(function(){
        if(confirm("请确认是否发送数据？"))
        {
            $.ajax( {
                type : "post",
                url : "/error/lua?lua=1",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}'},
                success : function(data) {
                    if(data.status==1){
                        alert('发送成功');
                    }else{
                        alert('发送失败');
                    }
                }
            });
        }
    });
});
</script>

