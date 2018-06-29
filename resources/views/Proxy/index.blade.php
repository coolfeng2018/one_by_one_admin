<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="  input-inline ">
                                <a class="ajaxify btn sbold green" href="/proxy/add"> 新增
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a class="ajaxify btn sbold green" href="/proxy/updatePwd"> 修改代理密码
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="ajaxify btn sbold green" href="/proxy/configProxy">充值限定
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                            <div class="input-inline" style="float:right;">
                                Date:&nbsp;
                                <input type="text" id="stime" class=" form-control input-circle input-inline" value="{{$res['stime']}}">
                                &nbsp;-&nbsp;
                                <input type="text" id="etime" class=" form-control input-circle input-inline" value="{{$res['etime']}}">&nbsp;
                                GameID:&nbsp;<input type="text" id="uid" class="form-control input-circle input-inline" value="{{$res['uid']}}" >&nbsp;
                                Mobile:&nbsp;<input type="text" id="mobile" class="form-control input-circle input-inline" value="{{$res['mobile']}}" >&nbsp;
                                <button  id="search" class=" btn sbold green"> 查找</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th> 编号 </th>
                        <th> Mobile </th>
                        <th> GameID </th>
                        <th> 钻石数量 </th>
                        <th> 房卡数量 </th>
                        <th> 金币数量 </th>
                        {{--<th> 充值总额 </th>--}}
                        <th> 充值记录 </th>
                        <th>交易记录 </th>
                        <th> 下级代理 </th>
                        <th> 状态 </th>
                        <th> 创建时间 </th>
                        <th> 操作 </th>
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
    var mobile= $('#mobile').val();

    mydata(stime,etime,uid,mobile,1,handler);

    $('#search').click(function(){
        var stime= $('#stime').val();
        var etime= $('#etime').val();
        var uid= $('#uid').val();
        var mobile= $('#mobile').val();
        if((stime == ''&& etime)  || (etime == '' && stime ) ){
            alert('时间区间需要同时选取');
            return false;
        }
        if(uid){
            if(isNaN(uid)){
                alert('ID为数字');
                return false;
            }
        }
        if(mobile){
            if(isNaN(mobile)){
                alert('ID为数字');
                return false;
            }
        }
        mydata(stime,etime,uid,mobile,1,handler);
    });
});

function mydata(stime,etime,uid,mobile,page,callback) {
    $.ajax({
        type: "post",
        url: "/proxy/search",
        dataType: 'json',
        data: {
            '_token': '{{csrf_token()}}',
            stime: stime,
            etime: etime,
            uid: uid,
            mobile: mobile,
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
        $("#mobile").val(data.pram.mobile);

        $("#current").val(data.res.config.page);
        $("#total").val(data.res.config.pages);


        var stime= $("#stime").val();
        var etime= $("#etime").val();
        var uid= $("#uid").val();
        var mobile= $("#mobile").val();

        var page= $("#current").val();
        var total= $("#total").val();

        $("#info").html("");

        var html='';

        var arr= data.res.results;

        if(arr.length>0){

            for (i in arr){
                var type='';
                if(arr[i].Status ==0){
                    type="正常";
                }else if(arr[i].Status ==1){
                    type="禁用";
                }

                html+='<tr><td>'+
                    arr[i].AgentId +'</td><td>'+
                    arr[i].Mobile +'</td><td>'+
                    arr[i].UserId +'</td><td>'+
                    arr[i].diamond +'</td><td>'+
                    arr[i].RoomCardNum +'</td><td>'+
                    arr[i].Score +'</td><td>'+
                    '<a class="ajaxify btn sbold green" href="/proxy/charge?id='+arr[i].UserId+'"> 充值记录 </a>'+'</td><td>'+
                    '<a class="ajaxify btn sbold green" href="/proxy/trade?id='+arr[i].AgentId+'"> 交易记录 </a>'+'</td><td>'+
                    '<a class="ajaxify btn sbold green" href="/proxy/level?id='+arr[i].AgentId+'"> 下级代理 </a>'+'</td><td>'+
                    type+'</td><td>'+
                    arr[i].CreateTime+'</td><td>'+
                    '<a class="ajaxify btn sbold green" href="/proxy/update?id='+arr[i].AgentId+'">修改 <i class="fa fa-pencil"></i> </a>'+
                    '<a class="ajaxify btn sbold green" href="/proxy/delete?id='+arr[i].AgentId+'"> 删除 <i class="fa fa-pencil"></i> </a>'+'</td></tr>';
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
        mydata(stime,etime,uid,mobile,now,handler);
    });
}

</script>
