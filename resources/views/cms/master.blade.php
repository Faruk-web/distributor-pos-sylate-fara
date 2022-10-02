@php
    $user = Auth::user();
    $shop_info = DB::table('shop_settings')->where('shop_code', $user->shop_id)->first();
    $renew_date = optional($user->shop_info)->renew_date;
    $renew_date_str = strtotime($renew_date);
    $today = strtotime(date("Y-m-d"));
    $date_diff = $renew_date_str - $today;
    
@endphp

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{optional($shop_info)->shop_name}}</title>
        <meta name="description" content="Ridoy Paul">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Open Graph Meta -->
        <meta property="og:title" content="Best POS Solution">
        <meta property="og:site_name" content="FARA IT Fusion">
        <meta property="og:description" content="Best POS Solution">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        
        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{asset(optional($shop_info)->shop_logo)}}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('backend/assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('backend/assets/media/favicons/apple-touch-icon-180x180.png') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{asset('backend/assets/css/oneui.min.css') }}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" id="css-theme" href="{{asset('backend/assets/css/themes/amethyst.min.css') }}">
        <!-- END Stylesheets -->

        <link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
        
        <style>
            @media only screen and (min-width: 1000px) {
                #page-container.main-content-narrow>#main-container .content, #page-container.main-content-narrow>#page-footer .content, #page-container.main-content-narrow>#page-header .content, #page-container.main-content-narrow>#page-header .content-header {
                    width: 100%;
                }
            }
            div.dataTables_processing { z-index: 1; }
            .remaining {
                font-size: 18px;
                border: 1px dashed #e02b5e;
                padding: 1px 10px;
                border-radius: 4px;
                position: relative;
            }
            #re_days{
                color: #DB004D;
            }
            .dataTables_processing {
                border-radius: 50px;
                padding: 10px 10px !important;
                border: 2px solid #00BFA6;
                padding-bottom: 40px !important;
            }
        </style>


    </head>
    <body>
        <!-- Page Container -->
        
      <audio id="error" src="{{asset('backend/audio/error.mp3')}}" preload="auto"></audio>
      <audio id="success" src="{{asset('backend/audio/success.mp3')}}" preload="auto"></audio>
      <audio id="success1" src="{{asset('backend/audio/warning.mp3')}}" preload="auto"></audio>
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
            <!-- Side Overlay-->
            
            @include('cms.body.left_sidebar')
            <!-- END Sidebar -->

            <!-- Header -->
            @include('cms.body.header')
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">

                <!--Body end-->
                    @yield('body_content')
                <!--Body end-->

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-3">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">
                            Design & Developed <i class="fa fa-heart text-danger"></i> by <a class="font-w600" href="http://faraitfusion.com/" target="_blank">FARA IT Fusion</a>
                        </div>
                        <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                            <a class="font-w600" href="http://ehishab.com/" target="_blank">Ehishab POS Solution</a> &copy; <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
            
            @if($user->hasPermissionTo('admin.header.balance.statements') || $user->type == 'owner')
            <div class="modal fade" id="balance-statement-modal" tabindex="-1" role="dialog" aria-labelledby="balance-statement-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Balance Statements </h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content block-content-full"><div class="row gutters-tiny" id="balance_output_show_div"></div></div>
                            <div class="block-content block-content-full text-center">
                                @if($today <= $renew_date_str && !empty($renew_date))
                                <div class="remaining shadow rounded bg-light">Remaining <b id="re_days">{{$date_diff / 86400}}</b> Days.</b> <a target="_blank" href="shopkeeper-payment.php">Get more</a></div>
                                @elseif($today >= $renew_date_str && !empty($renew_date))
                                <div class="remaining shadow rounded bg-light">!!! Your Software has been expired <b id="re_days">{{date("d M, Y", strtotime($renew_date))}}</b>. Please renew from <a target="_blank" href="shopkeeper-payment.php">here</a> !!!</b></div>
                                @endif
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($user->type == 'owner' || $user->type == 'owner_helper')
            <div class="modal fade" id="one-modal-apps" tabindex="-1" role="dialog" aria-labelledby="one-modal-apps" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Others Wings</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny">
                                    <div class="col-6">
                                        <!-- CRM -->
                                        <a class="block block-rounded block-link-shadow bg-body" href="{{route('admin.supplier.wing')}}">
                                            <div class="block-content text-center">
                                                <i class="fa fa-people-carry fa-2x text-primary"></i>
                                                <p class="font-w600 font-size-sm mt-2 mb-3">
                                                    Company Wing
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END CRM -->
                                    </div>
                                    {{--
                                    <div class="col-6">
                                        <!-- Products -->
                                        <a class="block block-rounded block-link-shadow bg-body" href="{{route('admin.godown.wing')}}">
                                            <div class="block-content text-center">
                                                <i class="fa fa-store-alt fa-2x text-primary"></i>
                                                <p class="font-w600 font-size-sm mt-2 mb-3">
                                                    Godowns Wing
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Products -->
                                    </div>
                                    --}}
                                    <div class="col-6">
                                        <!-- Sales -->
                                        <a class="block block-rounded block-link-shadow bg-body mb-0" href="{{route('admin.account.transaction.wing')}}">
                                            <div class="block-content text-center">
                                                <i class="fa fa-money-check-alt fa-2x text-primary"></i>
                                                <p class="font-w600 font-size-sm mt-2 mb-3">
                                                    Acc & Transaction Wing
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Sales -->
                                    </div>
                                    <div class="col-6">
                                        <!-- Payments -->
                                        <a class="block block-rounded block-link-shadow bg-body mb-0" href="{{route('/')}}">
                                            <div class="block-content text-center">
                                                <i class="fa fa-home fa-2x text-primary"></i>
                                                <p class="font-w600 font-size-sm mt-2 mb-3">
                                                    Main Dashboard
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Payments -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            
        </div>
        <!-- END Page Container -->
        @include('sweetalert::alert')
        @include('cms.body.footer')