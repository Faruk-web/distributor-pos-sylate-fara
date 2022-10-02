
@php($referral_id = Session::get('referral_id'))
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
<link href="images/favicon.png" rel="icon">
<title>Ehishab Registration</title>
<meta name="description" content="Login and Register Form Html Template">
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
========================= -->
<link rel='stylesheet' href="{{ asset('backend/register-assets/css.css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i') }}" type='text/css'>

<!-- Stylesheet
========================= -->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/register-assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/register-assets/vendor/font-awesome/css/all.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/register-assets/css/stylesheet.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
<!-- Colors Css -->
<link id="color-switcher" type="text/css" rel="stylesheet" href="css/color-red.css">
<style>
    .oxyy-login-register .form-dark .form-control {
        background: #ffffff;
    }
</style>
</head>
<body>

<!-- Preloader -->
<!--<div class="preloader preloader-dark">-->
<!--  <div class="lds-ellipsis">-->
<!--    <div></div>-->
<!--    <div></div>-->
<!--    <div></div>-->
<!--    <div></div>-->
<!--  </div>-->
<!--</div>-->
<!-- Preloader End -->

<div id="main-wrapper" class="oxyy-login-register">
  <div class="hero-wrap min-vh-100">
    <div class="hero-mask opacity-4 bg-secondary"></div>
    <div class="hero-bg hero-bg-scroll" style="background-image:url({{asset('backend/register-assets/images/login-bg-5.jpg')}});"></div>
    <div class="hero-content d-flex min-vh-100">
      <div class="container my-auto">
        <div class="row">
          <div class="col-md-9 col-lg-7 col-xl-5 mx-auto">
            <div class="hero-wrap rounded shadow-lg p-4 py-sm-5 px-sm-5 my-4">
              <div class="hero-mask bg-light"></div>
              <div class="hero-content">
                <!--<div class="logo mb-4 text-center"><a class="d-flex justify-content-center text-center" href="javascript:void(0)" style="width: 150px;" title="Oxyy"><img src="{{asset('backend/Login/images/ehishab.png') }}" class="rounded mx-auto d-block" alt="Ehishab"></a> </div>-->
                <h6 class="text-center text-dark"><b>Welcome to <b class="text-danger">E-hishab</b> Registration!</b></h6><br>
                <form id="registerForm" class="form-dark" method="POST" action="{{ route('register') }}">
                    @csrf
                  <div class="mb-3 icon-group">
                    <input type="text" class="form-control text-dark" name="name" id="fullName" required="" value="{{old('name')}}" placeholder="Full Name">
                    <span class="icon-inside"><i class="fas fa-user"></i></span>
                    @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                    @endif
				  </div>
				  <div class="mb-3 icon-group">
                    <input type="text" class="form-control text-dark" name="company_name" id="" required="" value="{{old('company_name')}}" placeholder="Company Name">
                    <span class="icon-inside"><i class="fas fa-building"></i></span>
                    @if($errors->has('company_name'))
                        <div class="error text-danger">{{ $errors->first('company_name') }}</div>
                    @endif
				  </div>
				  
                  <div class="mb-3 icon-group">
                    <input type="email" class="form-control text-dark" name="email" id="" required="" value="{{old('email')}}" placeholder="Email">
                    <span class="icon-inside"><i class="fas fa-envelope"></i></span>
                    @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                    @endif
				  </div>
				  
				  <div class="mb-3 icon-group">
                    <input type="text" maxlength="11" minlength="11" class="form-control text-dark" name="phone" required="" value="{{old('phone')}}" placeholder="Phone (Ex: 01627382866)">
                    <span class="icon-inside"><i class="fas fa-phone"></i></span>
                    @if($errors->has('phone'))
                        <div class="error text-danger">{{ $errors->first('phone') }}</div>
                    @endif
				  </div>
				  
                  <div class="mb-3 icon-group">
                    <input type="password" class="form-control text-dark" name="password" id="loginPassword" required="" placeholder="Password (min 8 digit)">
                    <span class="icon-inside"><i class="fas fa-lock"></i></span>
                    @if($errors->has('password'))
                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                    @endif
				  </div>
				  <div class="mb-3 icon-group">
                    <input type="password" class="form-control text-dark" name="password_confirmation" id="loginPassword" required="" placeholder="Confirm Password">
                    <span class="icon-inside"><i class="fas fa-lock"></i></span>
                    @if($errors->has('password_confirmation'))
                        <div class="error text-danger">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                    @if(!empty($referral_id))
                        <input type="hidden" name="reseller_id" value="{{$referral_id}}">
                    @else
                        <input type="hidden" name="reseller_id" value="none">
                    @endif
				  </div>
				  @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>
    
                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif
				  
                  <div class="d-grid my-4">
					<button class="btn btn-danger btn-block" type="submit">Register</button>
				  </div>
                </form>
                <div class="d-flex align-items-center mt-1 mb-1">
                  <hr class="flex-grow-1 border-dark">
                  <span class="mx-2 text-muted text-2">Or</span>
                  <hr class="flex-grow-1 border-dark">
                </div>
                <p class="text-2 text-muted text-center mb-0">Already a Registered? <a class="link-danger text-3" href="{{ route('login') }}">Login now</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script --> 
<script src="{{ asset('backend/register-assets/vendor/jquery/jquery.min.js') }}"></script> 
<script src="{{ asset('backend/register-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
<!-- Style Switcher --> 
<script src="{{ asset('backend/register-assets/js/switcher.min.js') }}"></script> 
<script src="{{ asset('backend/register-assets/js/theme.js') }}"></script>

<script src="{{ asset('js/toastify-js.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
    
    function verify_otp() {
        var verify_phone = $('#verify_phone').val();
        if(verify_phone.length == 11) {
            if($.isNumeric(verify_phone)) {
                // $.ajax({
                //     type : 'get',
                //     url: '/supplier/stock-in/search-supplier',
                //     data:{'supplier_info':supplier_info},
                //     success:function(data){
                //     $('#supplier_show_info').html(data);
                //     }
                // });
            }
            else {
                swal({
                    title: "Error",
                    text: "Wrong Phone Number!",
                    icon: "error",
                    button: "Ok",
                }); 
                document.getElementById('error').play();
            }
        }
        else {
            swal({
                title: "Error",
                text: "Phone Number must be 11 digit",
                icon: "error",
                button: "Ok",
            }); 
            document.getElementById('error').play();
        }
    }

    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
    
</script>


</body>
</html>













