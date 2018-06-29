
<div class="tab-content">
    <div class="tab-pane active" id="tab_0">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>推广礼包修改
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">推广礼包</label>
                            <div class="col-md-9">
                                <div class="mt-repeater">
                                    <div data-repeater-list="group-b" id="list">
                                        @foreach ($res['gift'] as $k =>$v)
                                            <div data-repeater-item class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">STYLE</label>
                                                    <select class="form-control kind" name="kind">
                                                        @foreach ($res['kind'] as $key =>$val)
                                                            @if($v['type'] ==$key)
                                                                <option value ="{{ $key }}" selected>{{$val}}</option>
                                                            @else
                                                                <option value ="{{ $key }}">{{$val}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">NUM</label>
                                                    <input type="text" name="num" placeholder="eg:100" class="form-control num" value=" {{ $v['number']}}"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="control-label">DEL</label><br/>
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                        <i class="fa fa-plus"></i> 增加奖励项</a>
                                    <br>
                                    <br> </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="save" type="button" class="btn btn-circle green">保存</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        FormRepeater.init();

        $("#save").click(function(){
            var json=new Array;
            $("#list .row").each(function(i,item){
                //获取道具名称，数量
                mykey=$(item).find(".kind").find('option:selected').val();
                myname=$(item).find(".kind").find('option:selected').text();
                myval=$(item).find(".num").val();
                //判定是否未空
                if(typeof(mykey)=="undefined"){
                    alert("奖励类型不能为空");
                    return false;
                }
                if(myval==''){
                    alert("奖励数量不能为空,如需要请置零");
                    return false;
                }
                mystr={type:parseInt(mykey),number:parseInt(myval),name:myname};
                json.push(mystr);
            });
            var award=JSON.stringify(json);
            //ajax提交
            $.ajax( {
                type : "post",
                url : "/extensionGift/save",
                dataType : 'json',
                data : {_token:'{{csrf_token()}}',award:award},
                success : function(data) {
                    if(data.status){
                        Layout.loadAjaxContent(data.url);
                    }else{
                        alert('添加失败');
                    }
                }
            });
        });




    })
</script>

