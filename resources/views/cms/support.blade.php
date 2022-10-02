
@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
    #tawk_61f8fdb29bd1f31184da5924 div {
        min-width: 100% !important;
    }
</style>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="lender_body" style="">
                <div class="col-md-4 p-1  col-12">
                    <div class="lender_info rounded shadow p-3">
                        <div class="block block-rounded">
                            <div class="bg-light">
                                <img src="{{asset('images/support.png')}}" width="100%" />
                                <button type="button" class="btn btn-outline-success btn-rounded btn-lg btn-block btn-sm mt-3 mb-3">Support Time: 10:00 AM - 08:00 PM</button>
                                
                            </div>
                            <div class="short_info"  style="display: none;">
                                <button type="button" class="btn btn-outline-success btn-rounded btn-lg btn-block btn-sm mb-3"><i class="fas fa-phone-square-alt"></i> <a href="tel:01708443633">01708443633</a></button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <!-- loan Receive div Start -->
                    <div class="row" id="loan_paid_div">
                        <div class="col-md-12 p-3 shadow rounded" height="100%" style="height: 100vh;">
                            <div class="long_info">
                               <h6>Contact Us For Any Kind Of Information: <a href="tel:01708443633">01708443633</a></h6>
                                <div>
                                    <button type="button" onclick="startLiveChat()" class="btn btn-primary btn-rounded btn-lg btn-block mt-5">Start Live Chat</button>
                                </div>
                            </div>
                            <div class="text-center">
                                <div style="display: none;" class="chat_box w-100 text-center rounded shadow" width="100" height="80%" id='tawk_61f8fdb29bd1f31184da5924'></div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date(); Tawk_API.embedded='tawk_61f8fdb29bd1f31184da5924';
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/61f8fdb29bd1f31184da5924/1fqqkebc4';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);})();
</script>
<!--End of Tawk.to Script-->

<script>
    function startLiveChat() {
        $('.long_info').hide();
        $('.chat_box').show();
        $('.short_info').show();
    }
</script>

@endsection
