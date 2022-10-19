<header id="page-header">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            
            <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout"
                data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>

            @if($user->type == 'owner' || $user->type == 'owner_helper')
            <button type="button" class="btn btn-sm btn-dual mr-2" data-toggle="modal" data-target="#one-modal-apps">
                <i class="fa fa-fw fa-cubes"></i>Wings
            </button>
            @if($user->hasPermissionTo('admin.header.balance.statements') || $user->type == 'owner')
            <button type="button" onclick="balance_statement()" class="btn btn-sm btn-dual mr-2" data-toggle="modal" data-target="#balance-statement-modal">
                <i class="fas fa-dollar-sign"></i> Balance
            </button>
            @endif
            @endif

            @if($user->type == 'branch_user')
            <a href="javascript:void(0)" type="button" class="btn btn-sm btn-dual ml-2 mr-2 bg-primary text-light">
                {{optional($user->branchName)->branch_name}}
            </a>
            @endif

            @if($user->hasPermissionTo('others.sell') || $user->type == 'owner' || $user->type == 'branch_user')
            <a href="{{route('branch.sell', ['customer_code'=>0])}}" type="button" class="btn btn-sm btn-dual ml-2 bg-success mr-2 text-light d-none"><i class="fa fa-shopping-cart"></i> Sell</a>
            <a href="{{route('shop.walking.customer')}}" type="button" class="btn btn-sm btn-dual ml-2 bg-success mr-2 text-light d-none"><i class="fas fa-walking"></i> Walking</a>
            <a href="{{route('branch.sell.new')}}" type="button" class="btn btn-sm btn-dual ml-2 bg-primary mr-2 text-light">Sell Point</a>
            @endif
            
            
            <h6 class="text-danger fw-bold d-none">আমরা ভার্সন  4.1 আপডেট করতেসি, এখন সফটওয়্যার ব্যবহার করা থেকে বিরত থাকুন।</h6>

        </div>
        <div class="d-flex align-items-center">
            {{--
            @if($today >= $renew_date_str && !empty($renew_date) && $user->type != 'super_admin') <div class="remaining shadow rounded bg-light">!!! Your Software has been expired <b id="re_days">{{date("d M, Y", strtotime($renew_date))}}</b>. Please renew from <a target="_blank" href="shopkeeper-payment.php">here</a> !!!</b></div> @endif
            @if($user->type != 'super_admin')
            
            <a href="{{route('user.support')}}" type="button" class="btn btn-sm btn-dual ml-2 bg-primary mr-2 text-light">Support</a>
            @endif
            --}}
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn btn-sm btn-dual d-flex align-items-center"
                    id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-sm-inline-block ml-2">{{ $user->name }}</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ml-1 mt-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-primary-dark rounded-top">
                        <p class="mt-2 mb-0 text-white font-w500">{{ $user->name }}</p>
                        <p class="mb-0 text-white-50 font-size-sm">@if($user->type == 'owner') Admin @else {{str_replace($user->shop_id."#","", $user->getRoleNames())}}  @endif</p>
                    </div>
                    <div class="p-2">
                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('profile.show') }}">
                            <span class="font-size-sm font-w500">Profile</span>
                            <span class="badge badge-pill badge-primary ml-2"></span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{route('my.moments')}}">
                            <span class="font-size-sm font-w500">My Moments</span>
                            <span class="badge badge-pill badge-primary ml-2"></span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="font-size-sm font-w500">Log Out</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-white">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin"></i>
            </div>
        </div>
    </div>
</header>
