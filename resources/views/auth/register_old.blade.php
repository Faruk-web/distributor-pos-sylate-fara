<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">

<x-guest-layout>
<audio id="error" src="{{asset('backend/audio/error.mp3')}}" preload="auto"></audio>
      <audio id="success" src="{{asset('backend/audio/success.mp3')}}" preload="auto"></audio>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img style="width: 150px;" src="{{asset('backend/Login/images/fara-IT-Logo.png') }}" alt="FARA IT Fusion">
        </x-slot>
        <x-jet-validation-errors class="mb-4" />
        <h3 class="text-center"><b>Welcome to E-hishab Registration!</b></h3>
        @if(empty(Session::get('registration_phone')))
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" placeholder="" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>
            <div class="mt-4">
                <x-jet-label for="company_name" value="{{ __('Company Name') }}" />
                <x-jet-input id="company_name" placeholder="" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus autocomplete="company_name" />
            </div>
            
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" placeholder="" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="phone" value="{{ __('phone') }}" />
                <x-jet-input id="phone" placeholder="Ex: 01627382866" minlength="11" maxlength="11" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password (min 8 digit)') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
        @else
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12">
                <div class="mt-4">
                        <x-jet-label for="verify_phone" value="{{ __('Please verify Your Phone') }}" />
                        <input id="verify_phone" placeholder="Ex: 01627382866" minlength="11" maxlength="11" class="form-control rounded" type="text" name="verify_phone" :value="old('verify_phone')" required />
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="verify_otp()" class="btn btn-success">Send OTP</button>
                    </div>
                    
                </div>
            </div>
        </form>
        @endif
    </x-jet-authentication-card>
</x-guest-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="" crossorigin="anonymous"></script>
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
