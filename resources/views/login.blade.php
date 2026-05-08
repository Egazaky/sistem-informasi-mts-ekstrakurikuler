<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISTEM INFORMASI</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.png">
    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/libs/flot/css/float-chart.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::asset('dist/css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/extra-libs/multicheck/multicheck.css')}}">
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
</head>
<body>

<body style="background-color: #343a40">
    <div class="main-wrapper" style="margin-top: 100px">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center pt-3 pb-3">
                            <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 32px;">
                                <img src="{{ URL::asset('img/logo3.png') }}" alt="Logo Tut Wuri Handayani" style="height:80px; margin-bottom: 10px;">
                                <img src="{{ URL::asset('img/logo.png') }}" alt="Logo MTS Al Islam" style="height:80px; margin-bottom: 20px;">
                                <img src="{{ URL::asset('img/logo4.png') }}" alt="Logo UNISNU Jepara" style="height:80px; margin-bottom: 10px;">
                                <img src="{{ URL::asset('img/logo2.png') }}" alt="Logo DIKTISAINTEK Berdampak" style="height:80px; margin-bottom: 10px;">
                            </div>
                            <hr style="border-top:2px solid #aaa; width:50%; margin:auto; margin-bottom:30px;">
                            <div class="text-center pb-3">
                                <h3 class="text-white">SISTEM DIGITAL INTEREST REKOMENDASI<br>EKSTRAKULIKULER TERFAVORIT<br>MTS Al Islam
                                </h3>
                            </div>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal mt-3" id="loginform" action="{{ route('proses-login') }}" method="POST">
                        @csrf
                        @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{session('status')}}
                        </div>
                        @endif
                        <div class="row pb-4">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3" id="show_hide_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                    <span class="input-group-text">
                                <a href="">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </a>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="pt-3">
                                        <button class="btn btn-info" id="to-recover" type="submit"></i> Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- ============================================================== -->
    <script src="{{ URL::asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ URL::asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{ URL::asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{ URL::asset('dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{ URL::asset('dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{ URL::asset('dist/js/custom.min.js')}}"></script>
    <!--This page JavaScript -->
    <!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="{{ URL::asset('assets/libs/flot/excanvas.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot/jquery.flot.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot/jquery.flot.time.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot/jquery.flot.stack.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot/jquery.flot.crosshair.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{ URL::asset('dist/js/pages/chart/chart-page-init.js')}}"></script>
    <script src="{{ URL::asset('assets/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script>
    <script src="{{ URL::asset('assets/extra-libs/multicheck/jquery.multicheck.js')}}"></script>
    <script src="{{ URL::asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script>
</body>
</html>
