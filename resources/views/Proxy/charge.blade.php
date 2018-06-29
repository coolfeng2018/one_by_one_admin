<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理-充值记录 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="  input-inline ">
                            <a class="ajaxify btn sbold green" href="/proxy/index"> 代理管理
                                <i class="fa fa-reply"></i>
                            </a>
                        </div>
                        <div class="row">
                            <div class="input-inline" style="float:right;">
                                Date:&nbsp;
                                <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{$res['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{$res['etime']}}">&nbsp;
                                <input type="hidden" id="uid" class="form-control input-circle input-inline" value="{{$res['uid']}}" >&nbsp;&nbsp;
                                <button  id="search" class=" btn sbold green"> 查找</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 编号 </th>
                        <th> 订单号 </th>
                        <th> 付款方式 </th>
                        <th> 平台 </th>
                        <th> 优惠方案 </th>
                        <th> 商品名称 </th>
                        <th> 金额 </th>
                        <th> 数量 </th>
                        <th> 创建时间 </th>
                    </tr>


                    </thead>
                    <tbody id="info">
                        <div >
                            <input type="hidden" id="current" value="">
                            <input type="hidden" id="total" value="">
                            <ul id="page">
                            </ul>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
$(function(){
    $('#stime').datetimepicker();
    $('#etime').datetimepicker();

    var stime= $('#stime').val();
    var etime= $('#etime').val();
    var uid= $('#uid').val();

    mydata(stime,etime,uid,1,handler);
    $('#search').click(function(){
        var stime= $('#stime').val();
        var etime= $('#etime').val();
        var uid= $('#uid').val();

        if((stime == ''&& etime)  || (etime == '' && stime ) ){
            alert('时间区间需要同时选取');
            return false;
        }

        mydata(stime,etime,uid,1,handler);
    });
});

function mydata(stime,etime,uid,page,callback) {
    $.ajax({
        type: "post",
        url: "/proxy/searchCharge",
        dataType: 'json',
        data: {
            '_token': '{{csrf_token()}}',
            stime: stime,
            etime: etime,
            uid: uid,
            page: page
        },
        success:function (data) {
            callback(data);
        }
    })
}

function handler(data) {

    if(data.status){

        $("#stime").val(data.pram.stime);
        $("#etime").val(data.pram.etime);
        $("#uid").val(data.pram.uid);

        $("#current").val(data.res.config.page);
        $("#total").val(data.res.config.pages);


        var stime= $("#stime").val();
        var etime= $("#etime").val();
        var uid= $("#uid").val();

        var page= $("#current").val();
        var total= $("#total").val();

        $("#info").html("");

        var html='';

        var arr= data.res.results;

        if(arr.length>0){

            for (i in arr){
                var typeData='';
                if(arr[i].platform==1){
                    typeData='安卓';
                }else{
                    typeData='苹果';
                }
                var saleData=data.sale;

                html+='<tr><td>'+
                    arr[i].order_id +'</td><td>'+
                    arr[i].order_code +'</td><td>'+
                    arr[i].pay_way +'</td><td>'+
                    typeData +'</td><td>'+
                    saleData[arr[i].sale_id] +'</td><td>'+
                    arr[i].goods_name +'</td><td>'+
                    arr[i].amount +'</td><td>'+
                    arr[i].number +'</td><td>'+
                    arr[i].create_time +'</td></tr>';
            }
        }else{
            html='<tr><td colspan=15>暂无记录!!</td></tr>';

        }

        $("#info").html(html);

        var pageinfo='';

        if(page < total){
            if(page ==1){
                pageinfo="<button class='disabled'><span>«</span></button>" +
                    "<button class='active'><span>"+page+"</span></button>"+
                    "<button class='infoRes '><a href='#'  rel='next' value='" + (Number(page)+1)+"'>»</a></button>共"+total+"页";
            }else{
                pageinfo= "<button class='infoRes '><a href='#' rel='pre' value='" + (Number(page)-1)+"'>«</a></button>"+
                    "<button class='active'><span>"+page+"</span></button>"+
                    "<button class='infoRes '><a href='#'  rel='next' value='" + (Number(page)+1)+"'>»</a></button>共"+total+"页";
            }
        }else if(page == total){
            if(total>1){
                pageinfo= "<button class='infoRes '><a href='#' value='" + (Number(page)-1)+"'>«</a></button>"+
                    "<button class='active'><span>"+page+"</span></button>"+
                    "<button class='disabled'><span>»</span></button>共"+total+"页";
            }else{
                pageinfo= "<button class='disabled '><span>«</span></button>"+
                    "<button class='active'><span>"+page+"</span></button>"+
                    "<button class='disabled'><span>»</span></button>共"+total+"页";
            }

        }
        $("#page").html(pageinfo);

    }
    $('.infoRes').click(function(){
        now=$(this).find('a').attr('value');
        mydata(stime,etime,uid,now,handler);
    });
}

</script>
