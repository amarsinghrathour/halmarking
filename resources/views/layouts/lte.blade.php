<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }} | {{SetttingValue('buisness_name') ?? config('app.app_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Sweet Alert -->
<script src="{{ asset('sweet-alert/dist/sweetalert.js') }}"></script>
<link rel="stylesheet" href="{{ asset('sweet-alert/dist/sweetalert.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('dist/css/custome.css') }}">
    @yield('style_css')
    <style>
        #clock {
            font-size: 25px;
            width: 150px;
            margin: 200px;
            text-align: center;
            border: 2px solid black;
            border-radius: 20px;
        }
    </style>
</head>
<?php /*
 * Use Only Left Menue
<body class="hold-transition sidebar-mini layout-fixed">
*/ ?>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                
                <!-- start menu -->
                <?php
                $myTopMenu = App\Models\Menu::getTopMenu('0');
                if(null !== $myTopMenu){
                    foreach ($myTopMenu as $topMenuList){
                        if($topMenuList->url === "#"){
                            $topMenuUrl = "#";
                        }else{
                            $topMenuUrl = url($topMenuList->url);
                        }
                        if($topMenuUrl === "#"){
                            ?>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                        <i class="nav-icon fas {{ $topMenuList->icon }}"></i>
                        {{$topMenuList->name}}
                    </a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <?php
                        $topSubMenu = App\Models\Menu::getTopMenu($topMenuList->id);
                        foreach ($topSubMenu as $topSubMenuList){
                            ?>
                        <li>
                            <a href="{{$topSubMenuList->url}}" class="dropdown-item">
                                <i class="nav-icon fas {{ $topSubMenuList->icon }}"></i>
                                {{$topSubMenuList->name}}
                            </a>
                        </li>
                            <?php
                        }
                         ?>
                    </ul>
                </li>
                            <?php
                        }else{
                            ?>
                <li class="nav-item">
                    <a href="{{ $topMenuUrl }}" class="nav-link">
                        <i class="nav-icon fas {{ $topMenuList->icon }}"></i>
                        {{ $topMenuList->name }}
                    </a>
                </li>
                            <?php
                        }
                    }
                }
                ?>
                <!-- end menu -->
            </ul>
            <div id="clock">8:10:45</div>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                
                <!-- Notifications Dropdown Menu -->
                 
                <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="nav-icon fas fa-power-off text-danger"></i>
          <span class="badge badge-warning">Power</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <div class="dropdown-divider"></div>
          <a href="{{url('/lock-screen')}}" class="dropdown-item">
                          <i class="nav-icon fas fa-lock"></i>Lock Screen
                        </a>
          
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
                        <i class="fas fa-power-off text-danger"></i> Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
        </div>
      </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-navy">
          <!-- Brand Logo -->
          <a href="#" class="brand-link navbar-secondary">
            <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="App Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{SetttingValue('buisness_name') ?? config('app.app_name')}}</span>
          </a>

          <!-- Sidebar -->
          <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
              </div>
            </div>

            

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    $myMenu = App\Models\Menu::getLeftMenu('0');
                    if(null !== $myMenu){
                        foreach ($myMenu as $menuList){
                            if($menuList->url === "#"){
                                $menuUrl = "#";
                            }else{
                                $menuUrl = url($menuList->url);
                            }
                            $menu2 = App\Models\Menu::getLeftMenu($menuList->id);
                            $active=""; $menuOpen="";
                            foreach ($menu2 as $menuL2){
                                if(App\Models\Menu::checkForCurrentUrl($menuL2->url)){
                                    $active="active";
                                    $menuOpen = "menu-open";
                                    break;
                                }
                            }
                            if($menuUrl === "#"){
                                ?>
                                <li class="nav-item {{$menuOpen}}">
                                    <a href="{{ $menuUrl }}" class="nav-link {{ $active }}">
                                        <i class="nav-icon fas {{ $menuList->icon }}"></i> 
                                        <p>
                                            {{ $menuList->name }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php
                                        if(count($menu2) > 0){
                                            foreach ($menu2 as $menuL2){
                                                if($menuL2->url == "#"){
                                                    $menuUrl = "#";
                                                }else{
                                                    $menuUrl = url($menuL2->url);
                                                }
                                                $menu3 = App\Models\Menu::getLeftMenu($menuL2->id);
                                                $active=""; $menuOpen="";
                                                foreach ($menu3 as $menuL3){
                                                    if(App\Models\Menu::checkForCurrentUrl($menuL3->url)){
                                                        $active="active";
                                                        $menuOpen = "menu-open";
                                                        break;
                                                    }
                                                }
                                                if($menuUrl === "#"){
                                                    ?>
                                                <li class="nav-item {{$menuOpen}}">
                                                    <a href="{{ $menuUrl }}" class="nav-link {{ $active }}">
                                                        <i class="fas {{ $menuL2->icon }}"></i>
                                                        <p>
                                                            {{ $menuL2->name }}
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                          <?php
                                                          if(count($menu3) > 0){
                                                              foreach ($menu3 as $menuL3){
                                                                  if($menuL3->url == "#"){
                                                                      $menuUrl = "#";
                                                                  }else{
                                                                      $menuUrl = url($menuL3->url);
                                                                  }
                                                                  $active="";
                                                                  if('1' == $menuL3->id){
                                                                      $active="active";
                                                                  }?>
                                                                  <li class="nav-item">
                                                                      <a href="{{ $menuUrl }}" class="nav-link {{ $active }}">
                                                                          <i class="fas {{ $menuL3->icon }}"></i>
                                                                          <p>{{ $menuL3->name }}</p>
                                                                      </a>
                                                                  </li><?php
                                                              }
                                                          }?>
                                                    </ul>
                                                </li>
                                                <?php
                                                }else{
                                                    $active="";
                                                    if(App\Models\Menu::checkForCurrentUrl($menuL2->url)){
                                                        $active="active";
                                                    }?>
                                                    <li class="nav-item">
                                                        <a href="{{ $menuUrl }}" class="nav-link {{ $active }}">
                                                            <i class="fas {{ $menuL2->icon }}"></i>
                                                            <p>{{ $menuL2->name }}</p>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }?>
                                    </ul>
                                </li>
                            <?php
                            }else{
                                $active="";
                                if(App\Models\Menu::checkForCurrentUrl($menuList->url)){
                                    $active="active";
                                }
                                ?>
                                <li class="nav-item">
                                    <a href="{{ $menuUrl }}" class="nav-link {{ $active }}">
                                        <i class="nav-icon fas {{ $menuList->icon }}"></i>
                                        <p>{{ $menuList->name }}</p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-power-off text-danger"></i>
                      <p>
                        Power
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{url('/lock-screen')}}" class="nav-link">
                          <i class="nav-icon fas fa-lock"></i>
                          <p>Lock Screen</p>
                        </a>
                      </li>
                      <li class="nav-item">
                         <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('shut-down').submit();" role="button">
                          <i class="nav-icon fas fa-power-off"></i>
                          <p>Log Out</p>
                         </a>
                         <form id="shut-down" action="{{ route('logout') }}" method="POST" style="display: none;">
                           @csrf
                         </form>
                      </li>
                    </ul>
                  </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                {{ $title }} 
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2020-{{date('Y')}} <a href="{{config('app.company_url')}}">{{config('app.company')}}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0-rc
            </div>
        </footer>
    </div>
    
    
      <!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- page script -->
<script src="{{ asset('dist/js/lte.page.list.js') }}"></script>
<script src="{{ asset('dist/js/lte.developers.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    function changeStatus(id, status, table)
{
    var sts="",txt="",txtsts="",swalsts="";
    
    if(status === "ACTIVE")
    {
        sts = "Activate ?";
        swalsts = "Activated";
        txt = "This data will be shown for further use!";
        txtsts = "Data has been activated for further use!";
    }
    else if(status === "DELETED")
    {
        sts = "Delete ?";
        swalsts = "Deleted";
        txt = "This data will not be able to recover!";
        txtsts = "Data has been deleted!";
    }
    else
    {
        sts = "Deactivate ?";
        swalsts = "Deactivated";
        txt = "This data will be deactivated!";
        txtsts = "Data has been deactivated, and it can not be use further!";
    }
    swal({
    title: sts,
    text: txt,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-primary",
    confirmButtonText: "Yes!",
    cancelButtonText: "No, cancel plx!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) 
  {
    if (isConfirm) 
    {
        $.ajax({
            type: "post",
            url: "{{route('change.status')}}",
            dataType: "json",
            data: { id:id, status:status, table:table },
            cache: false,
            success: function(data) {
                console.log(data);
                if(data.status === "success")
                {
                    swal({
                        title: swalsts, 
                        text: txtsts, 
                        type: "success"
                    },function() {
                        setTimeout(function(){
                        location.reload();
                      }, 1);
                    });
                }
                else if(data.status === "expired")
                {
                    swal("OOps!!!", "Session Expired!", "error");
                    location.reload();
                }
                else
                {
                    swal("OOps!!!", data.message, "error");
                }
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                if(textStatus == "timeout")
                {
                     swal("Timeout !", "We couldn't connect to the server ! ", "error");
                }
                else
                {
                     swal("Oops", "We couldn't connect to the server ! "+errorThrown, "error");
                }
              }
        });
    }
    else 
    {
        swal("Cancelled", "Your  Data is Not Altered :)", "info");
    }
  });
}
    </script>
    <!-- ./wrapper -->
    @yield('script_js')
<script>
        setInterval(showTime, 1000);
        function showTime() {
            let time = new Date();
            let hour = time.getHours();
            let min = time.getMinutes();
            let sec = time.getSeconds();
            am_pm = "AM";
  
            if (hour > 12) {
                hour -= 12;
                am_pm = "PM";
            }
            if (hour == 0) {
                hr = 12;
                am_pm = "AM";
            }
  
            hour = hour < 10 ? "0" + hour : hour;
            min = min < 10 ? "0" + min : min;
            sec = sec < 10 ? "0" + sec : sec;
  
            let currentTime = hour + ":" 
                + min + ":" + sec + am_pm;
  
            document.getElementById("clock")
                .innerHTML = currentTime;
        }
  
        showTime();
    </script>
</body>
</html>
