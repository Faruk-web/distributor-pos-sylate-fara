<!DOCTYPE html>
<html lang="en">

<head>
    <title>FARA IT Fusion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('backend/Login/images/icons/favicon.ico') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{asset('backend/Login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/Login/css/main.css') }}">
    <!--===============================================================================================-->

    <style>
        @media only screen and (max-width: 768px) {
            #topImg {
                display: none;
            }
        }

        @media only screen and (min-width: 768px) {
            #welcomeTo {
                display: none;
            }

            #footerImg {
                display: none;
            }

            .login100-pic.js-tilt {
                margin-top: -130px;
            }

            form.login100-form.validate-form {
                margin-top: -141px;
            }
        }

    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{asset('backend/Login/images/ehishab.png') }}" alt="IMG">
                </div>
                <form class="login100-form validate-form">

                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <h3 id="welcomeTo" style="font-size: 20px;">Welcome to <b>POS</b></h3>
                                <div id="topImg">
                                    <img style="width: 150px;" src="{{asset('backend/Login/images/fara-IT-Logo.png') }}"
                                        alt="FARA IT Fusion">
                                </div>
                            </center>
                        </div>
                    </div>
                    <x-jet-validation-errors class="mb-4" />
                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-danger">
                        {{ session('status') }}
                    </div>
                    @endif
                    <p class="text-center text-danger" style="font-weight: bold;"></p>
                    <div class="container-login100-form-btn">
                        <button type="button" class="login100-form-btn btn btn-success" data-toggle="modal"
                            data-target="#exampleModal">Login</button>
                    </div>
                    <div class="container-login100-form-btn">
                        <a href="{{ route('register') }}" class="login100-form-btn btn btn-success">Register</a>
                    </div>
                    <div class="container-login100-form-btn">
                        <a href="crm-registration.php" class="login100-form-btn btn btn-success">Help</a>
                    </div>
                    <div class="container-login100-form-btn">
                        <a href="crm-registration.php" class="login100-form-btn btn btn-success">FAQ</a>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <center id="footerImg">
                                <img style="width: 150px;" src="{{asset('backend/Login/images/fara-IT-Logo.png') }}"
                                    alt="IMG">
                            </center>
                        </div>
                    </div>
                    <div class="text-center p-t-13">
                        <a class="txt2" href="#">
                            Technical Support by <b>FARA IT Fusion</b><br>
                            Hotline: <a href="tel:+8801309923205"><i class="fa fa-phone" aria-hidden="true"></i>+880 130
                                992 3205</a>
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Login Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm" style="color: red;">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" :value="old('email')" required autofocus
                                class="form-control" placeholder="gmail">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" required
                                autocomplete="current-password" placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember_me" name="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" name="admin_login" type="submit"
                                    class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="col-md-12">
                                @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                                @endif
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!--===============================================================================================-->
    <script src="{{asset('backend/Login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('backend/Login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{asset('backend/Login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('backend/Login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('backend/Login/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })

    </script>
    <!--===============================================================================================-->
    <script src="{{asset('backend/Login/js/main.js') }}"></script>
    @include('sweetalert::alert')
</body>

</html>
