<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-diamond font-dark"></i>
                    <span class="caption-subject bold uppercase"> 商品管理-商品管理</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="btn-group">
                                <a class="ajaxify btn sbold green" href="/goods/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <button id="proShop"  class=" btn sbold yellow" > 发布</button>ps:确认商品调整完毕后，记得发布！
                            <span style="float: right;">
                            平台:&nbsp;&nbsp;
                            <select id="os" class=" form-control input-circle input-inline">
                                @foreach($res['os'] as $k=>$v)
                                    @if($k==$search['os'])
                                        <option value ="{{$k}}" selected>{{$v}}</option>
                                    @else
                                        <option value ="{{$k}}">{{$v}}</option>
                                    @endif
                                @endforeach
                            </select>&nbsp;&nbsp;
                             渠道:&nbsp;&nbsp;
                            <select id="kind" class=" form-control input-circle input-inline">
                                @foreach($res['kind'] as $k=>$v)
                                    @if($k==$search['kind'])
                                        <option value ="{{$k}}" selected>{{$v}}</option>
                                    @else
                                        <option value ="{{$k}}">{{$v}}</option>
                                    @endif
                                @endforeach
                            </select>&nbsp;&nbsp;
                            分类:&nbsp;&nbsp;
                            <select id="type" class=" form-control input-circle input-inline">
                                @foreach($res['type'] as $k=>$v)
                                    @if($k==$search['type'])
                                        <option value ="{{$k}}" selected>{{$v}}</option>
                                    @else
                                        <option value ="{{$k}}">{{$v}}</option>
                                    @endif
                                @endforeach
                            </select>&nbsp;&nbsp;
                            <a class="btn green ajaxify" id="search"  href="">查找</a>
                            </span>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> 名称 </th>
                        <th> 渠道分类 </th>
                        <th> 分类 </th>
                        <th> 促销方案 </th>
                        <th> 获取道具 </th>
                        <th> 获取数量 </th>
                        <th> 消耗道具 </th>
                        <th> 消耗数量 </th>
                        <th> 资源图像 </th>
                        <th> 状态 </th>
                        <th> 平台 </th>
                        <th> 赠送（%） </th>
                        <th> 优先级 </th>
                        <th> 支付渠道 </th>
                        <th> 苹果商品标识 </th>
                        <th> 下架时间 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
                    </tr>
                    </thead>
                    <tbody  id="info">
                        <div>
                            @foreach ($res['results'] as $resources)

                                <tr class="odd gradeX">
                                    <td>{{ $resources->GoodsId }}</td>
                                    <td>{{ $resources->GoodsName }}</td>
                                    <td>{{ $res['kind'][$resources->CategoryId]}}</td>
                                    <td>{{ $res['type'][$resources->GoodsType]}}</td>
                                    <td>{{ $res['sale'][$resources->SaleId]}}</td>
                                    <td>{{ $res['props'][$resources->PropsId] }}</td>
                                    <td>{{ $resources->Number }}</td>
                                    <td>
                                        @if($resources->ExpendType==1)
                                            RMB
                                        @else
                                            钻石
                                        @endif
                                    </td>
                                    <td>{{ $resources->Amount }}</td>
                                    <td><img src="{{config('suit.ImgRemoteUrl').$resources->ImageUrl}}" style="width:60px;height: 60px;"></td>
                                    <td> @if($resources->Status==0)
                                            上架
                                        @else
                                            下架
                                        @endif
                                    </td>
                                    <td>{{ $res['os'][$resources->Platform+1] }}</td>
                                    <td>{{ $resources->HandselPercent }}</td>
                                    <td>{{ $resources->SortNumber }}</td>
                                    <td>{{ $resources->Payment }}</td>
                                    <td>{{ $resources->AppleProductIdentifier }}</td>
                                    <td>{{ $resources->ExpiredAt }}</td>
                                    <td>{{ $resources->CreateTime }}</td>
                                    <td>
                                        <a class="ajaxify btn sbold green" href="/goods/update?id={{ $resources->GoodsId }}&os={{$search['os']}}&kind={{$search['kind']}}&type={{$search['type']}}"> 修改
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="ajaxify btn sbold green" href="/goods/delete?id={{ $resources->GoodsId }}"> 删除
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </div>
                        {!! $res['results']->links() !!}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
$(function() {
    //查找
    var href="/goods/index?";

    $("#search").click(function(){
        $("#search").attr("href",href+"&os="+$("#os").val()+"&kind="+$("#kind").val()+"&type="+$("#type").val());
    });
    var aobj=$(".pagination").find("a");

    aobj.each(function(){
        $(this).attr("href",$(this).attr("href")+"&os="+$("#os").val()+"&kind="+$("#kind").val()+"&type="+$("#type").val());
    });


    //发布
    $('#proShop').click(function(){
        $.ajax( {
            type : "post",
            url : "/goods/store",
            dataType : 'json',
            data : {'_token':'{{csrf_token()}}'},
            success : function(data) {
                if(data.status){
                    alert('发布成功');
                }else{
                    alert('发布失败-'.data.msg);
                }
            }
        });
    });
});
</script>
