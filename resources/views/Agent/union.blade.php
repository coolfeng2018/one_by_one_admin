<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-wrench font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理商联运分配 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="  input-inline ">
                            <a class="ajaxify btn sbold green" href="/agent/index"> 返回代理
                                <i class="fa fa-reply"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="id" class="form-control input-circle" value="{{$res['id']}}">
                            </div>
                        </div>
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr class="uppercase">
                                    <th class="col-md-11 text-center"> 我的代理-联运 </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @foreach($res['union'] as $k=>$v)
                                                <div class="md-checkbox col-md-4">
                                                    <input type="checkbox" id="permission_{{$v['UnionId']}}" class="md-check" value="{{$v['UnionId']}}" @if(in_array($v['UnionId'],$res['myunion'])) checked @endif name="permission">
                                                    <label for="permission_{{$v['UnionId']}}">
                                                        <span  @if(in_array($v['UnionId'],$res['myunion'])) class="inc" @endif ></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{$v['UnionName']}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-5 col-md-7">
                                <input type="button" id="save" class="btn green" value="保存">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#save").click(function(){
            var json=new Array;
            var myval="";
            $('input:checkbox[name=permission]:checked').each(function() {
                myval = parseInt($(this).val());
                json.push(myval);
            });
            var mypro=JSON.stringify(json);
            var id=$('#id').val();
            $.ajax( {
                type : "post",
                url : "/agent/unionSave",
                dataType : 'json',
                data : {'_token':'{{csrf_token()}}',mypro:mypro,id:id},
                success : function(data) {
                    console.log(data.url);
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('权限添加失败');
                    }
                }
            });

        })
    })
</script>
