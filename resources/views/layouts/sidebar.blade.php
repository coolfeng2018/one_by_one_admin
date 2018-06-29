<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>后台管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="后台管理" name="description" />
    <meta content="" name="author" />
    <link href="/hsgm/global/css/family.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

    <link href="/hsgm/global/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css" />

    <link href="/hsgm/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/hsgm/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/hsgm/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="/hsgm/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    @stack('links')
    <link rel="shortcut icon" href="favicon.ico" /> </head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">

                    <img src="/hsgm/layouts/layout/img/logo.png" alt="logo" class="logo-default" />
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="/hsgm/pages/img/avatar1.jpg" />
                            <span class="username username-hide-on-mobile"> {{session('admin')['username']}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/admin/out">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                @section('navbar')@show
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                @section('content')@show
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner"> 2016 &copy; Metronic Theme By
            <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
            <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
</div>
<script src="/hsgm/global/plugins/respond.min.js"></script>
<script src="/hsgm/global/plugins/excanvas.min.js"></script>
<script src="/hsgm/global/plugins/ie8.fix.min.js"></script>

<script src="/hsgm/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>

<script src="/hsgm/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/hsgm/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>

<script src="/hsgm/global/plugins/jquery-nestable/jquery.nestable.js" type="text/javascript"></script>


<script src="/hsgm/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/hsgm/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
<!-- <script src="/hsgm/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script> -->
<script src="/hsgm/pages/scripts/bootstrap-paginator.js" type="text/javascript"></script>


<script src="/hsgm/pages/scripts/form-samples.min.js" type="text/javascript"></script>

<script src="/hsgm/layouts/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/hsgm/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="/hsgm/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="/hsgm/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker.css">
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="/hsgm/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
</body>

</html>