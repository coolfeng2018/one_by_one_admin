<div class="row">
    <div class="col-md-12">
        <!-- end加载内容-->
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-rocket font-dark"></i>
                    <span class="caption-subject bold uppercase"> 下载配置文件 </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
            <div class="tab-content">
                <form action="#" class="form-horizontal" method="post">
                {{ csrf_field() }}
                    <div class="btn-group btn-group-circle">
                        <button type="button" class="btn blue">下载</button>
                        <button type="button" class="btn btn-circle-right blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" aria-expanded="false">
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="javascript:;" onclick="downloads('server')"> 服务端配置 </a>
                            </li>
                            <li>
                                <a href="javascript:;" onclick="downloads('customer')"> 客户端配置 </a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script type="text/javascript">
     function downloads(type){
        window.open('/config/download?type='+type);
    }
</script>