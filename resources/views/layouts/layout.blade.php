<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Arsip Dokumen Unib | @yield('title') </title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Bootstrap -->
    <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
    
    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('assets/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    @stack('styles')

    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/build/css/custom.min.css') }}" rel="stylesheet">
        <style>
            body{
              font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
              background-color: #fff;
              font-size: 13px;
              margin: 0;
              padding: 0;
              color: #676a6c;
            }

            input[type=text], select, input[type=number],input[type=email],input[type=password],input[type=file] {
                font-size: 13px;
            }
            .form-control{
                font-size:13px !important;
            }

            button{
                font-size: 13px;
            }

            html{
                padding:0;
                margin: 0;
            }

            .toast {
              left: 50%;
              position: fixed;
              transform: translate(-50%, 0px);
              z-index: 9999;
          }

        </style>
    </head>

  <body class="nav-md sidebar_fixed" >
    <div class="container body">
      <div class="main_container" style="background:#013C62;">
        @if (Auth::check())
            <div class="col-md-3 left_col " style="background: #013C62 !important; ">
            @else
            <div class="col-md-3 left_col " style="background: #013C62 !important;">
        @endif
        <div class="left_col scroll-view" style="background: #013C62 !important;">
            <div class="navbar nav_title" style="border-bottom: 1px white solid;; margin:0; padding-bottom:5px 0px !important; background:#013C62;">
                <a href="index.html" class="site_title" style="font-weight:600; font-size:18.5px"> <span>ARSIP DOKUMEN UNIB</span></a>
              </div>
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
                <div class="profile_pic">
                  <img src="{{ asset('assets/images/logo.png') }}"style="width:70%; background:#fff; margin-left:15%;z-index:1000; position:inherit;margin-top:20px;border: 1px solid rgba(52,73,94,0.44);padding: 4px;border-radius:50%;filter:drop-shadow(0px 1px 5px #fff);" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info" style="padding-top:20px;">
                  <span style="color:#fff000; font-weight:bold;">@yield('login_as'),</span>
                  <h2>
                    @yield('user-login')
                  </h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  @yield('sidebar-menu')
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small" style="background:#172D44;">
                <p style="color:white;text-align:center; margin-bottom:0px; padding:5px;">Universitas Bengkulu</p>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav" >
            <div class="nav_menu" style="float:left; background:#fff; border-bottom: 2px solid #e7eaec; margin-bottom:10px; width:100%; padding:1px 0px;">
                <div class="nav toggle" style="padding-bottom:5px !important; float:left; margin:0; padding-top:9px; width:70px;">
                  <a id="menu_toggle" class="btn btn-success" style="background-color:#1c84c6; border-color:#1c84c6; color:#fff; margin:0 15px 5px 15px; border-radius:3px; padding:6px 12px; font-size:14px; font-weight:400; text-align:center;cursor:pointer; display:inline-block;"><i class="fa fa-bars" style="display:inline-block; font-size:inherit; text-rendering:auto;font: normal normal normal 14px/1 FontAwesome;"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp;
                        @yield('user-login2')
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off text-danger pull-right"></i>{{ __('Logout') }}

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="" >
            <div class="page-title">

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                @yield('content')
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer style="overflow:hidden;">
          <div class="pull-right">
            Lembaga Pengembangan Teknologi Informasi dan Kominikasi <a href="https://colorlib.com">Universitas Bengkulu</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    

    <!-- Bootstrap -->
   <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('assets/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Input Tags -->
    <script src="{{ asset('assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('assets/build/js/custom.js') }}"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script>
      
      @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
            toastr.options = {"closeButton": true,"debug": false,"progressBar": true,"positionClass": "toast-bottom-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
            toastr.options = {"closeButton": true,"debug": false,"progressBar": true,"positionClass": "toast-bottom-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
            toastr.options = {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
            toastr.options = {"closeButton": true,"progressBar": true,"positionClass": "toast-bottom-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
                toastr.error("{{ Session::get('message') }}");
                break;
        }
      @endif
    </script>
    @stack('scripts')
  </body>
</html>
