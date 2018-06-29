<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-equalizer font-black-sunglo"></i>
                    <span class="caption-subject bold uppercase"> 推广管理</span>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                检测是否是分销用户:
                                <input type="text" id="searchID" class="form-control input-sm input-small input-inline" placeholder="eg:10000001" aria-controls="sample_1">
                                <button  id="search" class=" btn sbold green"> 检测</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 每日分享金币 </th>
                        <th> 一级会员抽成比例(%) </th>
                        <th> 二级会员抽成比例(%) </th>
                        <th> 三级会员抽成比例(%) </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <tr class="odd gradeX">
                            <td>{{ $data->everyday??0 }}</td>
                            <td>{{ $data->s1??0 }}</td>
                            <td>{{ $data->s2??0 }}</td>
                            <td>{{ $data->s3??0 }}</td>
                            <td>
                                <a class="ajaxify btn sbold green" href="/generalize/find"> 修改
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#search').click(function() {
        var id = $('#searchID').val();

        var reg=/^\d+$/;

        if(!reg.test(String(id))){
            alert('请输入正确ID');
            return false;
        }

        $.ajax( {
            type : "post",
            url : "/generalize/checkUser",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}',id:id},
            success : function(data) {
                if(data.status){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                }
            }
        });
    });
})
</script>
