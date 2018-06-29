<style type="text/css">
.pay div{
    padding:5px 5px 5px 25px;
    min-height: 20px;
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
                    <span class="caption-subject bold uppercase"> 邮件列表 </span>
                    <div class="  input-inline ">
                                <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_mailCreate">写邮件&nbsp;<i class="fa fa-plus"></i></button>

                                <button onClick="send_email_cfm()" class=" btn sbold blue " data-toggle="modal">发邮件&nbsp;<i class="fa fa-paper-plane"></i></button>
                                    <!-- 信息删除确认 -->  
                                    <div class="modal fade" id="sendfmModel">  
                                      <div class="modal-dialog">  
                                        <div class="modal-content message_align">  
                                          <div class="modal-header">  
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                                            <h4 class="modal-title">提示信息</h4>  
                                          </div>  
                                          <div class="modal-body">  
                                            <p>您确认要发送所有邮件吗？</p>  
                                          </div>  
                                          <div class="modal-footer">  
                                             <input type="hidden" id="url"/>  
                                             <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
                                             <a  onclick="sendEmailSubmit()" class="btn btn-success" data-dismiss="modal">确定</a>  
                                          </div>  
                                        </div><!-- /.modal-content -->  
                                      </div><!-- /.modal-dialog -->  
                                    </div><!-- /.modal -->
                                    <!-- 信息删除确认 -->   
                            </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div>
                                <div id="sample_1_filter" class="dataTables_filter">
                                    日志序号:&nbsp;&nbsp;<input type="text" id="id" class="form-control input-circle input-inline" value="{{$search['id']}}" >&nbsp;&nbsp;
                                    收件人:&nbsp;&nbsp;<input type="text" id="range" class="form-control input-circle input-inline" value="{{$search['range']}}" >&nbsp;&nbsp;
                                    标题:&nbsp;&nbsp;<input type="text" id="title" class="form-control input-circle input-inline" value="{{$search['title']}}" >&nbsp;&nbsp;
                                    状态:&nbsp;&nbsp;<select id="status" class=" form-control input-circle input-inline">
                                <option value="0"></option>
                                <option value="1" @if($search['status']==1) selected @endif>已读</option>
                                <option value="2" @if($search['status']==2) selected @endif>未读</option>
                                <option value="3" @if($search['status']==3) selected @endif>已领取</option>
                                <option value="4" @if($search['status']==4) selected @endif>未领取</option>
                                <option value="5" @if($search['status']==5) selected @endif>待发送</option>
                            </select>&nbsp;&nbsp;
                                 <!--    状态:&nbsp;&nbsp;
                                    <select>
                                        <option>待发送</option>
                                        <option>已读</option>
                                        <option>未读</option>
                                        <option>已领取</option>
                                        <option>未领取</option>
                                    </select>&nbsp;&nbsp; -->
                                    <a class="btn green ajaxify" id="search"  href="">查找</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 日志序号 </th>
                        <th> 时间 </th>
                        <th> 操作人 </th>
                        <th> 收件人 </th>
                        <th> 邮件标题 </th>
                        <th> 邮件道具 </th>
                        <th> 邮件状态 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody id="info">
                        <div>
                            @foreach ($res as $resources)
                                <tr class="odd gradeX">
                                    <td>{{ $resources->id }}</td>                            
                                    <td>{{ $resources->create_at }}</td>                            
                                    <td>{{ $resources->op_user }}</td>                            
                                    <td>{{ $resources->range }}</td>                            
                                    <td>{{ $resources->title }}</td>                            
                                    <td>金币:{{ $resources->coins }}</td>                            
                                    <td>
                                        @if($resources->status==0)
                                            <span class="label label-sm label-danger">待发送</span>
                                        @else
                                            @if(!$resources->coins)
                                                @if($resources->read_state==true)
                                                    <span class="label label-sm label-info">已读</span>
                                                @else
                                                    <span class="label label-sm label-danger">未读</span>
                                                @endif
                                            @else
                                                    @if($resources->receive_state==true)
                                                        <span class="label label-sm label-success">已领取</span>
                                                    @else
                                                        <span class="label label-sm label-danger">未领取</span>
                                                    @endif
                                            @endif
                                        @endif
                                    </td>                            
                                    <td>
                                        <button class=" btn sbold green " data-toggle="modal" data-target="#myModal_{{ $resources->id }}">查看详情</button>
                                        <div class="modal fade" id="myModal_{{ $resources->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel"><b>邮件详情</b></h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in">
                                                            <div class="pay">
                                                                        <div class="float-div">邮件标题：</div>
                                                                        <div><input class="form-control input-circle input-inline" value="{{ $resources->title }}" disabled></div>
                                                                        <div class="clear"></div>

                                                                        <div class="float-div">收件人：</div>
                                                                        <div><textarea disabled class="form-control input-circle input-inline" >{{ $resources->id }}</textarea></div>
                                                                        <div class="clear"></div>

                                                                        <div class="float-div">发件人昵称：</div>
                                                                        <div><input disabled class="form-control input-circle input-inline" value="{{ $resources->op_user }}"></div>
                                                                        <div class="clear"></div>

                                                                        <div class="float-div">邮件内容：</div>
                                                                        <div><textarea disabled class="form-control input-circle input-inline" style="width: 350px;height:100px">{{ $resources->content }}</textarea></div>
                                                                        <div class="clear"></div>

                                                                        <div class="float-div">金币：</div>
                                                                        <div><input disabled class="form-control input-circle input-inline"  value="{{ $resources->coins }}"></div>
                                                                        <div class="clear"></div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($resources->receive_state==0)
                                            <button class=" btn sbold red " data-toggle="modal" data-target="#myModal_edit_{{ $resources->id }}">编辑</button>
                                            <div class="modal fade" id="myModal_edit_{{ $resources->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel"><b>邮件详情</b></h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse in">
                                                                <div class="pay">
                                                                            <div class="float-div">邮件标题：</div>
                                                                            <div><input id="edit_title_{{ $resources->id }}" class="form-control input-circle input-inline" value="{{ $resources->title }}"></div>
                                                                            <div class="clear"></div>

                                                                            <div class="float-div">收件人：</div>
                                                                            <div><textarea id="edit_range_{{ $resources->id }}" class="form-control input-circle input-inline" disabled>{{ $resources->id }}</textarea></div>
                                                                            <div class="clear"></div>

                                                                            <div class="float-div">发件人昵称：</div>
                                                                            <div><input disabled id="edit_op_user_{{ $resources->id }}" class="form-control input-circle input-inline" value="{{ $resources->op_user }}"></div>
                                                                            <div class="clear"></div>

                                                                            <div class="float-div">邮件内容：</div>
                                                                            <div><textarea id="edit_content_{{ $resources->id }}" class="form-control input-circle input-inline" style="width: 350px;height:100px">{{ $resources->content }}</textarea></div>
                                                                            <div class="clear"></div>

                                                                            <div class="float-div">金币：</div>
                                                                            <div><input id="edit_coins_{{ $resources->id }}" class="form-control input-circle input-inline" value="{{ $resources->coins }}"></div>
                                                                            <div class="clear"></div>

                                                                            <input style="display: none;" id="edit_seq_{{ $resources->id }}" class="form-control input-circle input-inline" value="{{ $resources->id }}">
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                            <button onclick="edit_email_cfm_first({{ $resources->id }})" type="button" class="btn btn-default btn sbold red" data-dismiss="modal">修改</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 信息修改确认 -->  
                                            <div class="modal fade" id="editfmModel_{{ $resources->id }}">  
                                              <div class="modal-dialog">  
                                                <div class="modal-content message_align">  
                                                  <div class="modal-header">  
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                                                    <h4 class="modal-title">提示信息</h4>  
                                                  </div>  
                                                  <div class="modal-body">  
                                                    <p>您确认要修改邮件吗？</p>  
                                                  </div>  
                                                  <div class="modal-footer">  
                                                     <input type="hidden" id="url"/>  
                                                     <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
                                                     <button onclick="edit_email_cfm({{ $resources->id }})" type="button" id="edit_{{ $resources->id }}" class="btn btn-success" data-dismiss="modal">确定</button>  
                                                  </div>  
                                                </div><!-- /.modal-content -->  
                                              </div><!-- /.modal-dialog -->  
                                            </div><!-- /.modal -->
                                            <!-- 信息修改确认 --> 
                                        @endif
                                    </td>                              
                                </tr>
                            @endforeach
                        </div>
                        {!! $res->links() !!}
                    </tbody>
                </table>
                <div id="record">共<span>{{$res->total()}}</span>条记录</div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<!--create email-->
    <div class="modal fade" id="myModal_mailCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><b>邮件详情</b></h4>
                </div>
                <div id="collapseOne" class="panel-collapse in">
                    <form id="myform">
                        <div class="pay">
                                    <div class="float-div">邮件标题：</div>
                                    <div><input class="form-control input-circle input-inline" value="" id="send-title"></div>
                                    <div class="clear"></div>

                                    <div class="float-div">收件人：</div>
                                    <div><textarea class="form-control input-circle input-inline" id="send-range"></textarea></div>
                                    <div class="clear"></div>

                                    <div class="float-div">发件人昵称：</div>
                                    <div><input id="send_op_user" class="form-control input-circle input-inline"></div>
                                    <div class="clear"></div>

                                    <div class="float-div">邮件内容：</div>
                                    <div><textarea id="send-content" class="form-control input-circle input-inline" style="width: 350px;height:100px"></textarea></div>
                                    <div class="clear"></div>

                                    <div class="float-div">金币：</div>
                                    <div><input class="form-control input-circle input-inline" value="" id="send-coins" placeholder="eg:0"></div>
                                    <div class="clear"></div>

                                    <!-- <div class="">道具：</div> -->
                                  <!--   <div class="mt-repeater">
                                        <div data-repeater-list="group-b" id="list">
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">道具</label>
                                                    <select class="form-control input-circle input-inline" name="prop_list_id">
                                                        <option value=""></option>
                                                        <option value="1001">金币</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">道具数量</label>
                                                    <input type="text" name="prop_list_count" placeholder="eg:100" class="form-control input-circle input-inline" style="width: 100px"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">删除</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
           
                                        </div>
                                        <hr>
                                        <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                            <i class="fa fa-plus"></i> 增加道具</a>
                                        <br>
                                        <br>
                                    </div> -->
                  
                                    <!-- <div class="clear"></div> -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="send">发送</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

      

<!--create email-->
<style>
    .max{width:100%;height:auto;}
    .min{width:100px;height:auto;}
    .float-div{
        float:left;
        width: 120px;
    }
    .clear{ clear:both}
</style>
<script>
    $('.img').click(function(){
        $(this).toggleClass('min');
        $(this).toggleClass('max');
    });
</script>


<script>
    $(function(){
        $('#stime').datetimepicker();
        $('#etime').datetimepicker();
        
        $('#id').val('{{$search["id"]}}');
        $('#range').val('{{$search["range"]}}');
        $('#status').val('{{$search["status"]}}');

        var href="/customer/index?";

        $("#search").click(function(){
            $("#search").attr("href",href+"&id="+$("#id").val()+"&range="+$("#range").val()+"&title="+$("#title").val()+"&status="+$("#status").val());
        });

        var aobj=$(".pagination").find("a");

        aobj.each(function(){
            $(this).attr("href",$(this).attr("href")+"&id="+$("#id").val()+"&range="+$("#range").val()+"&title="+$("#title").val()+"&status="+$("#status").val());
        });
    });

</script>

<script type="text/javascript">
        $(function(){
            FormRepeater.init();
            $("#send").click(function(){
                //ajax提交
                var send_title= $("#send-title").val();
                var send_content= $("#send-content").val();
                var send_op_user= $("#send_op_user").val();
                var send_range= $('#send-range').val();
                var send_coins= $("#send-coins").val();
                // alert(send_content);
                //验证
                if(send_title==''){
                    alert('邮件标题不能为空,请检查');
                    return false;
                }
                if(send_content==''){
                    alert('邮件内容不能为空,请检查');
                    return false;
                }
                if(send_op_user==''){
                    alert('发件人昵称不能为空,请检查');
                    return false;
                }
                // console.log(send_range);
                if(send_range==''){
                    alert('收件人不能为空,请检查');
                    return false;
                }
                // alert(send_coins);
                if(isNaN(send_coins)){
                    alert('金币必须是数字,请检查');
                    return false;
                }
                if(send_coins==''){
                    send_coins = 0;
                }
                // var json=new Array;

                // var award=JSON.stringify(json);
              // console.log(send_range);
              // console.log(send_content);
                $.ajax( {
                    type : "post",
                    url : "/customer/index",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',send_title:send_title,send_content:send_content,send_range:send_range,send_coins:send_coins,send_op_user:send_op_user},
                    success : function(data) {
                        if(data.code==200){
                            alert('添加成功');
                            $(':input','#myform')  
                             .not(':button, :submit, :reset, :hidden')  
                             .val('')  
                             .removeAttr('checked')  
                             .removeAttr('selected');
                             $("#myModal_mailCreate").modal("hide");
                             // $('#myModal_mailCreate').modal('hide');
                             // Layout.loadAjaxContent('/customer/index');
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });


            //编辑
            $("#edit").click(function(){
                //ajax提交
                var edit_title= $("#edit_title").val();
                var edit_content= $("#edit_content").val();
                var edit_op_user= $("#edit_op_user").val();
                var edit_range= $('#edit_range').val();
                var edit_coins= $("#edit_coins").val();
                var edit_seq= $("#edit_seq").val();

                //验证
                if(edit_title==''){
                    alert('邮件标题不能为空,请检查');
                    return false;
                }
                if(edit_content==''){
                    alert('邮件内容不能为空,请检查');
                    return false;
                }
                if(edit_op_user==''){
                    alert('发件人昵称不能为空,请检查');
                    return false;
                }
                // console.log(edit_range);
                if(edit_range==''){
                    alert('收件人不能为空,请检查');
                    return false;
                }
                // alert(edit_coins);
                if(isNaN(edit_coins)){
                    alert('金币必须是数字,请检查');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/customer/editEmail",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',edit_title:edit_title,edit_content:edit_content,edit_range:edit_range,edit_coins:edit_coins,edit_op_user:edit_op_user,edit_seq:edit_seq},
                    success : function(data) {
                        if(data.code==200){
                            alert(data.msg);
                            // Layout.loadAjaxContent('/customer/index');
                        }else{
                            alert(data.msg);
                            // Layout.loadAjaxContent('/customer/index');
                        }
                    }
                });
            });

        })

        //修改
        function edit_email_cfm(ids) {   
             //ajax提交
                var edit_title= $("#edit_title_"+ids).val();
                var edit_content= $("#edit_content_"+ids).val();
                var edit_op_user= $("#edit_op_user_"+ids).val();
                var edit_range= $('#edit_range_'+ids).val();
                var edit_coins= $("#edit_coins_"+ids).val();
                var edit_seq= $("#edit_seq_"+ids).val();

                //验证
                if(edit_title==''){
                    alert('邮件标题不能为空,请检查');
                    return false;
                }
                if(edit_content==''){
                    alert('邮件内容不能为空,请检查');
                    return false;
                }
                if(edit_op_user==''){
                    alert('发件人昵称不能为空,请检查');
                    return false;
                }
                // console.log(edit_range);
                if(edit_range==''){
                    alert('收件人不能为空,请检查');
                    return false;
                }
                // alert(edit_coins);
                if(isNaN(edit_coins)){
                    alert('金币必须是数字,请检查');
                    return false;
                }
                $.ajax( {
                    type : "post",
                    url : "/customer/editEmail",
                    dataType : 'json',
                    data : {'_token':'{{csrf_token()}}',edit_title:edit_title,edit_content:edit_content,edit_range:edit_range,edit_coins:edit_coins,edit_op_user:edit_op_user,edit_seq:edit_seq},
                    success : function(data) {
                        if(data.code==200){
                            alert(data.msg);
                            // Layout.loadAjaxContent('/customer/index');
                        }else{
                            alert(data.msg);
                            // Layout.loadAjaxContent('/customer/index');
                        }
                    }
                });
        } 

        //编辑弹窗
        function edit_email_cfm_first(ids) {   
            $('#editfmModel_'+ids).modal();  
        }  

        //一键发送
        function send_email_cfm() {   
            $('#sendfmModel').modal();  
        }  
        function sendEmailSubmit(){ 
           $.ajax( {
                type : "post",
                url : "/customer/sendAllEmail",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}'},
                success : function(data) {
                    if(data.code==200){
                        alert(data.msg);
                        // Layout.loadAjaxContent('/customer/index');
                    }else{
                        alert(data.msg);
                    }
                }
            });
        }  
    </script>