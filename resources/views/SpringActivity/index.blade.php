<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject bold uppercase"> 春节活动中奖名单</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 排名 </th>
                        <th> ID </th>
                        <th> 头像 </th>
                        <th> 昵称 </th>
                        <th> 分数 </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        @foreach ($list as $resources)
                            <tr class="odd gradeX">
                                <td>{{ $resources->rank }}</td>
                                <td>{{ $resources->uid }}</td>
                                <td><img width="80" height="80" src="{{ $resources->icon }}" /></td>
                                <td>{{ $resources->name }}</td>
                                <td>{{ $resources->score }}</td>
                                <td>
                                    <button class=" btn sbold green contact-view" data-identity="{{$resources->uid}}" data-toggle="modal" data-target="#myModal">查看联系方式</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">联系方式</h4>
                            </div>
                            <div class="modal-body">
                                <span>真实姓名：</span><span class="contact-realname"></span><br/>
                                <span>联系电话：</span><span class="contact-telephone"></span><br/>
                                <span>地址：</span><span class="contact-address"></span><br/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $(".contact-view").click(function(){
            $('.contact-realname').html('');
            $('.contact-telephone').html('');
            $('.contact-address').html('');
            var uid=$(this).data('identity');
            $.get('/act/spring/contact?uid='+uid,function(result){
                if(result.status==200){
                    $('.contact-realname').html(result.data.RealName);
                    $('.contact-telephone').html(result.data.Telephone);
                    $('.contact-address').html(result.data.Address);
                }
            });
        });
    });
</script>
