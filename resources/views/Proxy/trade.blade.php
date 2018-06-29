<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 代理管理-交易记录 </span>
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
                                <input type="hidden" id="aid" class="form-control input-circle input-inline" value="{{$res['aid']}}" >&nbsp;&nbsp;
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
                        <th> 类型 </th>
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
        var aid= $('#aid').val();
        var uid= $('#uid').val();
        var mobile= $('#mobile').val();

        mydata(stime,etime,aid,uid,mobile,1,handler);
        $('#search').click(function(){
            var stime= $('#stime').val();
            var etime= $('#etime').val();
            var aid= $('#aid').val();
            var uid= $('#uid').val();
            var mobile= $('#mobile').val();

            if((stime == ''&& etime)  || (etime == '' && stime ) ){
                alert('时间区间需要同时选取');
                return false;
            }

            mydata(stime,etime,aid,uid,mobile,1,handler);
        });
    });

    function mydata(stime,etime,aid,uid,mobile,page,callback) {
        $.ajax({
            type: "post",
            url: "/proxy/searchTrade",
            dataType: 'json',
            data: {
                '_token': '{{csrf_token()}}',
                stime: stime,
                etime: etime,
                aid:aid,
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
            $("#aid").val(data.pram.aid);
            $("#uid").val(data.pram.uid);
            $("#mobile").val(data.pram.mobile);

            $("#current").val(data.res.config.page);
            $("#total").val(data.res.config.pages);


            var stime= $("#stime").val();
            var etime= $("#etime").val();
            var aid= $("#aid").val();
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
                    if(arr[i].Type ==0){
                        type="金币";
                    }else if(arr[i].Type ==1){
                        type="房卡";
                    }

                    html+='<tr><td>'+
                        arr[i].Id +'</td><td>'+
                        arr[i].Mobile +'</td><td>'+
                        arr[i].UserId +'</td><td>'+
                        type +'</td><td>'+
                        arr[i].Number +'</td><td>'+
                        arr[i].CreateTime+'</td></tr>';
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
            mydata(stime,etime,aid,uid,mobile,now,handler);
        });
    }

</script>
