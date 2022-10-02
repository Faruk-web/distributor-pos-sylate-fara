<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{optional($shop_info)->shop_name}}</title>
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
                <div class="login100-pic ">
                    <img src="{{asset(optional($shop_info)->shop_logo) }}" alt="IMG">
                    <p class="txt2">Welcome To <b>{{optional($shop_info)->shop_name}}</b></p>
                </div>
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <center id="footerImg">
                                <img style="width: 150px;" src="{{asset(optional($shop_info)->shop_logo) }}"
                                    alt="IMG">
                            </center>
                            
                            <div class="text-center p-t-13">
                                <p class="txt2">Login Now.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                        <br>
                            <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                                <input class="input100" type="email" name="email" value="{{old('email')}}" required placeholder="Email">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="wrap-input100 validate-input" data-validate="Password is required">
                                <input class="input100" type="password" name="password" class="form-control" required
                                autocomplete="current-password" placeholder="Password">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="icheck-primary p-t-10">
                                <input type="checkbox" id="remember_me" name="remember">
                                <label class="txt2" for="remember_me">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right p-t-12">
                                @if (Route::has('password.request'))
                                <span class="txt1">Forgot</span>
                                <a class="txt2" href="{{ route('password.request') }}">Password?</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if (session('status'))
                    <div class="font-medium text-sm text-danger">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn btn btn-success" >Login</button>
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
