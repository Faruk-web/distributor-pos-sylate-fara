@if($user->type == 'super_admin')
<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header bg-white-5">
        <a class="font-w600 text-dual" href="{{route('/')}}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">
            FARA IT Fusion<span class="font-w400"></span>
            </span>
        </a>
        
        <div>
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>
    
    <div class="js-sidebar-scroll">
        <div class="content-side">
        <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('/')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1 bg-info">Dashboard</span></span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-energy"></i>
                        <span class="nav-main-link-name">Shop Info</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.pending.shop')}}"><span class="nav-main-link-name">Pending Shop</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.active.shop')}}"><span class="nav-main-link-name">Active Shop</span></a></li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-sms"></i>
                        <span class="nav-main-link-name">SMS</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.sms.settings')}}"><span class="nav-main-link-name">SMS Settings</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.sms.pending.recharge.requests')}}"><span class="nav-main-link-name">Pending Recharge Request</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.sms.approved.recharge.requests')}}"><span class="nav-main-link-name">Approved Recharge Request</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('super_admin.sms.history')}}"><span class="nav-main-link-name">SMS History</span></a></li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('super_admin.all.reseller')}}">
                        <i class="nav-main-link-icon fas fa-store"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1">Resellers</span></span>
                    </a>
                </li>
                
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('super_admin.tutorials')}}">
                        <i class="nav-main-link-icon fas fa-tv"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1">Tutorials</span></span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
@elseif($user->type == 'reseller')
<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header bg-white-5">
        <a class="font-w600 text-dual" href="{{route('/')}}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">
            FARA IT Fusion<span class="font-w400"></span>
            </span>
        </a>
        
        <div>
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>
  
  
    <div class="js-sidebar-scroll">
        <div class="content-side">
        <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('/')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span>Dashboard</span></span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-energy"></i>
                        <span class="nav-main-link-name">Shop Info</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('reseller.pending.shop')}}"><span class="nav-main-link-name">Pending Shop</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('reseller.active.shop')}}"><span class="nav-main-link-name">Active Shop</span></a></li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('super_admin.tutorials')}}">
                        <i class="nav-main-link-icon fas fa-tv"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1">Tutorials</span></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@else
<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header bg-white-5">
        <a class="font-w600 text-dual" href="{{route('/')}}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">
            {{optional($shop_info)->shop_name}}<span class="font-w400"></span>
            </span>
        </a>
        
        <div>
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>
   
    <div class="js-sidebar-scroll">
        
        <div class="content-side">
        @if($user->type == 'owner' || $user->type == 'owner_helper')
            @if($wing == 'main')
            <!-- Main wing left side bar Start -->
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('/')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1 bg-primary">Main Wing Dashboard</span></span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-settings"></i>
                        <span class="nav-main-link-name">Shop Setting & Others</span>
                    </a>
                    <ul class="nav-main-submenu">
                        @if($user->hasPermissionTo('admin.setting') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.shop_setting')}}">
                                <span class="nav-main-link-name">Settings</span>
                            </a>
                        </li>
                        @endif
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.tutorials')}}">
                                <span class="nav-main-link-name">Tutorial</span>
                            </a>
                        </li>
                        <!--<li class="nav-main-item">-->
                        <!--    <a class="nav-main-link" href="{{route('test.paul')}}">-->
                        <!--        <span class="nav-main-link-name">test</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        
                        @if($user->hasPermissionTo('admin.helper.role.permission') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.helper_role_permission')}}">
                                <span class="nav-main-link-name">Admin Helper Roll & Permissions</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa-solid fas fa-users-cog"></i>
                        <span class="nav-main-link-name">Area & SR</span>
                    </a>
                    <ul class="nav-main-submenu">
                        @if($user->hasPermissionTo('admin.area') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.all.area')}}">
                                <span class="nav-main-link-name">Area</span>
                            </a>
                        </li>
                        @endif
                        @if($user->hasPermissionTo('admin.sr') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.all.sr')}}">
                                <span class="nav-main-link-name">SR</span>
                            </a>
                        </li>
                        @endif
                        
                    </ul>
                </li>
                
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-code-branch"></i>
                        <span class="nav-main-link-name">Shop Branch</span>
                    </a>
                    <ul class="nav-main-submenu">
                        @if($user->hasPermissionTo('branch') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.all.branch')}}">
                                <span class="nav-main-link-name">Branch</span>
                            </a>
                        </li>
                        @endif
                        @if($user->hasPermissionTo('branch.role.permission') || $user->type == 'owner')
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.branch.role')}}">
                                <span class="nav-main-link-name">Branch role & permission</span>
                            </a>
                        </li>
                        @endif
                        
                    </ul>
                </li>

                @if($user->hasPermissionTo('admin.crm') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.crm')}}">
                        <i class="nav-main-link-icon fas fa-users-cog"></i>
                        <span class="nav-main-link-name">CRM</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.deliveryman') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.all.deliveryman')}}">
                        <i class="nav-main-link-icon fa fa-shipping-fast"></i>
                        <span class="nav-main-link-name">Delivery man</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.products') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-coins"></i>
                        <span class="nav-main-link-name">Products</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.add')}}">
                                <span class="nav-main-link-name">Add New Product</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.all')}}">
                                <span class="nav-main-link-name">All Products</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.brands')}}">
                                <span class="nav-main-link-name">Product Brands</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.categories')}}">
                                <span class="nav-main-link-name">Product Categories</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.unit_types')}}">
                                <span class="nav-main-link-name">Product Unit Types</span>
                            </a>
                        </li>
                        {{--
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.variations')}}">
                                <span class="nav-main-link-name">Variations <small class="text-success">(New)</small></span>
                            </a>
                        </li>
                        --}}
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.csv.upload')}}">
                                <span class="nav-main-link-name">Upload Product By CSV</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.barcode')}}">
                                <span class="nav-main-link-name">Barcode</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('admin.product.barcode.printers')}}">
                                <span class="nav-main-link-name">Barcode Level Printers</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.branch.product.stock') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.branch.product.stock')}}">
                        <i class="nav-main-link-icon fab fa-shopify"></i>
                        <span class="nav-main-link-name">Product Stocks</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.set.opening.and.own.stock') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fab fa-goodreads"></i>
                        <span class="nav-main-link-name">Opening & Own Stock</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.set.opening.and.own.stock')}}"><span class="nav-main-link-name">Own Stock</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.set.opening.stock')}}"><span class="nav-main-link-name">Opening Stock</span></a></li>
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.product.ledger.table') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" target="_blank" href="{{route('admin.product.ledger.table')}}">
                        <i class="nav-main-link-icon fas fa-tablets"></i>
                        <span class="nav-main-link-name">Product Ledger Table</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.damage.product') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-energy"></i>
                        <span class="nav-main-link-name">Damage Products</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.damage.products')}}"><span class="nav-main-link-name">Add New Product</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.damage.stock.info')}}"><span class="nav-main-link-name">All Damage Product</span></a></li>
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.sms.panel') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-sms"></i>
                        <span class="nav-main-link-name">SMS Panel</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.sms.settings')}}"><span class="nav-main-link-name">SMS Settings</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.sms.panel')}}"><span class="nav-main-link-name">Dashboard & Requests</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.sms.histories')}}"><span class="nav-main-link-name">SMS Histories</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.sms.send')}}"><span class="nav-main-link-name">Send SMS</span></a></li>
                        
                    </ul>
                </li>
                @endif
                
                
                <li class="nav-main-heading">Others</li>
                    @if($user->hasPermissionTo('others.customers') || $user->type == 'owner')
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon far fa-address-book"></i>
                            <span class="nav-main-link-name">Customers</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.all.customer.types')}}"><span class="nav-main-link-name">Customer Types</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customer.create')}}"><span class="nav-main-link-name">Add New Customer</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customers')}}"><span class="nav-main-link-name">All Customers</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('others.receive.customers.due') || $user->hasPermissionTo('account.transaction') || $user->type == 'owner')
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fa fa-funnel-dollar"></i>
                            <span class="nav-main-link-name">Received Customer Due</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customer.due.received', ['customer_code'=>0])}}"><span class="nav-main-link-name">Received</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customer.due.received.vouchers')}}"><span class="nav-main-link-name">Vouchers</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('others.sell') || $user->type == 'owner')
                    <li class="nav-main-item bg-light">
                        <a class="nav-main-link" href="{{route('branch.sell.new')}}">
                            <i class="nav-main-link-icon fa fa-cart-plus text-dark"></i>
                            <span class="nav-main-link-name text-dark">Sell</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('branch.sold.invoices')}}">
                            <i class="nav-main-link-icon si si-paper-plane"></i>
                            <span class="nav-main-link-name">Sold Invoices</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('branch.sold.invoices.full.info')}}">
                            <i class="nav-main-link-icon si si-paper-plane"></i>
                            <span class="nav-main-link-name">Sold Invoices V2 <small class="text-success">(New)</small></span>
                        </a>
                    </li>
                    
                    @endif
                    @if($user->hasPermissionTo('others.returns.refund') || $user->type == 'owner')
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fas fa-undo-alt"></i>
                            <span class="nav-main-link-name">Return & Refunds</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.returnable.invoice')}}"><span class="nav-main-link-name">Returnable Product</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.customer.returned.invoices')}}"><span class="nav-main-link-name">Returned Invoice</span></a></li>
                        </ul>
                    </li>
                    @endif
            </ul>
            <!-- Main wing left side bar End -->

            @elseif($wing == 'supplier')
            <!-- supplier left side bar Start -->
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.supplier.wing')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1 bg-primary">Supplier Dashboard</span></span>
                    </a>
                </li>
                @if($user->hasPermissionTo('supplier.view.and.edit') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('suppliers.all')}}">
                        <i class="nav-main-link-icon fa fa-people-arrows"></i>
                        <span class="nav-main-link-name">Suppliers</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('supplier.stock.in') || $user->type == 'owner')
                <li class="nav-main-item bg-danger">
                    <a class="nav-main-link active" href="{{route('suppliers.stock.in.new', ['code'=>0])}}">
                        <i class="nav-main-link-icon fas fa-shipping-fast"></i>
                        <span class="nav-main-link-name">Stock in / Purchase</span>
                    </a>
                </li>
                
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('supplier.stock.in.invoices')}}">
                        <i class="nav-main-link-icon fas fa-file-invoice"></i>
                        <span class="nav-main-link-name">Purchase Invoices</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('supplier.all.stock.in.invoices')}}">
                        <i class="nav-main-link-icon fas fa-file-invoice"></i>
                        <span class="nav-main-link-name">P Invoices Report<small class="text-success">(New)</small></span>
                    </a>
                </li>
                
                @endif
                @if($user->hasPermissionTo('supplier.return.product') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-code-branch"></i>
                        <span class="nav-main-link-name">Purchase Return</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('supplier.stock.in.invoices.for.return')}}">
                                <span class="nav-main-link-name">Invoice Return Product</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('supplier.direct.return.products.new')}}">
                                <span class="nav-main-link-name">Direct Return Product (<small class="text-success">New</small>)</span>
                            </a>
                        </li>
                        
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('supplier.all.returned.invoices')}}">
                                <span class="nav-main-link-name">Returned Invoices</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('supplier.table.ledger') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('supplier.table.ledger')}}">
                        <i class="nav-main-link-icon fas fa-table"></i>
                        <span class="nav-main-link-name">Supplier Table Ledger</span>
                    </a>
                </li>
                @endif
                
                @if($user->hasPermissionTo('supplier.report') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('supplier.all.reports')}}">
                        <i class="nav-main-link-icon fas fa-flag-checkered"></i>
                        <span class="nav-main-link-name">Supplier Reports</span>
                    </a>
                </li>
                @endif
            </ul>
            <!-- supplier left side bar End -->

            @elseif($wing == 'godown')
            <!-- godown left side bar Start -->
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.godown.wing')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1 bg-primary">Godown Dashboard</span></span>
                    </a>
                </li>
                @if($user->hasPermissionTo('godown.stock.info') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('godown.current.stock.info')}}">
                        <i class="nav-main-link-icon fa fa-podcast"></i>
                        <span class="nav-main-link-name">Current Stock Info</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('godown.stock.out') || $user->type == 'owner')
                <li class="nav-main-item bg-light">
                    <a class="nav-main-link active text-dark" href="{{route('godown.stock.out.new')}}">
                        <i class="nav-main-link-icon fas fa-shipping-fast text-dark"></i>
                        <span class="nav-main-link-name text-dark">Stock Out</span>
                    </a>
                </li>
                
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('godown.stock.out.invoices')}}">
                        <i class="nav-main-link-icon fas fa-dolly"></i>
                        <span class="nav-main-link-name">Stock Out Invoices</span>
                    </a>
                </li>
                @endif
                @if($user->hasPermissionTo('godown.stock.in.out.report') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('godown.stock.out.report')}}">
                        <i class="nav-main-link-icon fas fa-file-invoice"></i>
                        <span class="nav-main-link-name">Stock In Out Report</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('godown.stock.in.out.ledger')}}">
                        <i class="nav-main-link-icon fas fa-chart-line"></i>
                        <span class="nav-main-link-name">G Stock In Out Ledger</span>
                    </a>
                </li>

                @endif
            </ul>
            <!-- godown left side bar End -->

            @elseif($wing == 'acc_and_tran')
            <!-- Account and Transaction left side bar Start -->
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{route('admin.account.transaction.wing')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name"><span class="rounded p-1 bg-primary">Acc & Transaction D</span></span>
                    </a>
                </li>
                @if($user->hasPermissionTo('account.bank.and.cash') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-university"></i>
                        <span class="nav-main-link-name">Bank & Cash</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.transaction.bank')}}"><span class="nav-main-link-name">Banks</span></a></li>
                        <!--<li class="nav-main-item"><a class="nav-main-link" href=""><span class="nav-main-link-name">Cheque Register</span></a></li>-->
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.cash.flow')}}"><span class="nav-main-link-name">Cash Flow</span></a></li>
                        
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('account.transaction') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-money-bill-alt nav-icon"></i>
                        <span class="nav-main-link-name">Transaction</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customer.due.received', ['customer_code'=>0])}}"><span class="nav-main-link-name">Customer Due Received</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.supplier.payment', ['supplier_code'=>0])}}"><span class="nav-main-link-name">Payment Supplier</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.contra')}}"><span class="nav-main-link-name">Contra / Balance Transfer</span></a></li>
                        
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('account.expense') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-coins nav-icon"></i>
                        <span class="nav-main-link-name">Expenses</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.expense.group')}}"><span class="nav-main-link-name">List Of Groups</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.ledger.heads')}}"><span class="nav-main-link-name">Ledger Head</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.make.expense.entry')}}"><span class="nav-main-link-name">Expense Entry</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.expense.vouchers')}}"><span class="nav-main-link-name">Expense Vouchers</span></a></li>
                        
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('account.indirect.income') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-dollar-sign nav-icon"></i>
                        <span class="nav-main-link-name">Direct / Indirect Incomes</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.add.indirect.incomes')}}"><span class="nav-main-link-name">Add Direct / Indirect Income</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.indirect.incomes.history')}}"><span class="nav-main-link-name">Di. / In. Incomes Vouchers</span></a></li>
                    </ul>
                </li>
                @endif
                @if($user->hasPermissionTo('admin.transaction.vouchers') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-archive nav-icon"></i>
                        <span class="nav-main-link-name">Vouchers</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.customer.due.received.vouchers')}}"><span class="nav-main-link-name">Customer Due Received Vouchers</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.supplier.payment.vouchers')}}"><span class="nav-main-link-name">Supplier Payment Vouchers</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.contra.list')}}"><span class="nav-main-link-name">Contra List</span></a></li>
                        
                    </ul>
                </li>
                @endif
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-comment-dollar"></i>
                        <span class="nav-main-link-name">Loan & Capital</span>
                    </a>
                    @if($user->hasPermissionTo('account.loan') || $user->type == 'owner')
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.loan.person')}}"><span class="nav-main-link-name">Loan Persons</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.loan.receive')}}"><span class="nav-main-link-name">Loan Receive</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.loan.paid')}}"><span class="nav-main-link-name">Loan Paid</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.loan.history')}}"><span class="nav-main-link-name">Loan History</span></a></li>
                    </ul>
                    @endif
                    @if($user->hasPermissionTo('account.capital') || $user->type == 'owner')
                    <ul class="nav-main-submenu bg-light">
                        <li class="nav-main-item"><a class="nav-main-link text-dark" href="{{route('admin.account.capital.person')}}"><span class="nav-main-link-name">Owners</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link text-dark" href="{{route('admin.account.capital.receive')}}"><span class="nav-main-link-name">Add Capital</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link text-dark" href="{{route('admin.account.capital.withdraw')}}"><span class="nav-main-link-name">Withdraw</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link text-dark" href="{{route('admin.account.capital.history')}}"><span class="nav-main-link-name">Capital History</span></a></li>
                    </ul>
                    @endif
                </li>
                
                @if($user->hasPermissionTo('account.report') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-paste nav-icon"></i>
                        <span class="nav-main-link-name">Reports</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.all.user.moments')}}"><span class="nav-main-link-name">All User Moments</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.report.all.customers')}}"><span class="nav-main-link-name">Customers</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.report.all.suppliers')}}"><span class="nav-main-link-name">Suppliers</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('sales.report.only')}}"><span class="nav-main-link-name">Sales Report</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('sales.report.by.product')}}"><span class="nav-main-link-name">Sales Report By Product</span></a></li>
                        
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('best.selling.products')}}"><span class="nav-main-link-name">Best Selling Products<small class="text-success"> (New)</small></span></a></li>
                        
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.cash.flow')}}"><span class="nav-main-link-name">Transaction History</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.cash.flow.diagram')}}"><span class="nav-main-link-name">Cash Flow Diagram<small class="text-success"> (New)</small></span></a></li>
                        
                    </ul>
                </li>
                @endif

                @if($user->hasPermissionTo('account.statement') || $user->type == 'owner')
                <li class="nav-main-item">
                    <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-chart-line nav-icon"></i>
                        <span class="nav-main-link-name">Account Statement</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.report.day.book')}}"><span class="nav-main-link-name">Day Book</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.statement.ledger')}}"><span class="nav-main-link-name">Ledger Report</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.expenses.ledger')}}"><span class="nav-main-link-name">Expense Ledger</span></a></li>
                        
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.report.trial.balance')}}"><span class="nav-main-link-name">Trial Balance</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="{{route('admin.account.income.and.expenditure')}}"><span class="nav-main-link-name">Income & Expenditure</span></a></li>
                        <li class="nav-main-item"><a class="nav-main-link" href="#"><span class="nav-main-link-name">Balance Sheet</span></a></li>
                        
                    </ul>
                </li>
                @endif

                
                
                
                
                
            </ul>
            <!-- Account and Transaction left side bar End -->
            @endif

            @elseif($user->type == 'branch_user')
            <ul class="nav-main">
                <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('/')}}">
                            <i class="nav-main-link-icon si si-speedometer"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>
                    @if($user->hasPermissionTo('branch.setting'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('branch.branch_setting')}}">
                            <i class="nav-main-link-icon si si-settings"></i>
                            <span class="nav-main-link-name">Settings</span>
                        </a>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.customers'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon far fa-address-book"></i>
                            <span class="nav-main-link-name">Customers</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.add.customer')}}"><span class="nav-main-link-name">Add New Customer</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.all.customer')}}"><span class="nav-main-link-name">All Customer</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.received.customer.due'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fa fa-funnel-dollar"></i>
                            <span class="nav-main-link-name">Customer Due & Others</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.take.customer.due', ['customer_code'=>0])}}"><span class="nav-main-link-name">Take Customer Due</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.due.received.vouchers')}}"><span class="nav-main-link-name">Due Received Voucher</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.product.stock'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('branch.product.stock')}}">
                            <i class="nav-main-link-icon fa fa-coins"></i>
                            <span class="nav-main-link-name">Product Stocks</span>
                        </a>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.sell'))
                    <li class="nav-main-item bg-primary">
                        <a class="nav-main-link active" href="{{route('branch.sell', ['customer_code'=>0])}}">
                            <i class="nav-main-link-icon fa fa-cart-plus"></i>
                            <span class="nav-main-link-name">Sell</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{route('branch.sold.invoices')}}">
                            <i class="nav-main-link-icon si si-paper-plane"></i>
                            <span class="nav-main-link-name">Sold Invoices</span>
                        </a>
                    </li>
                    @endif
                    
                    @if($user->hasPermissionTo('branch.damage.product'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon si si-energy"></i>
                            <span class="nav-main-link-name">Damage Products</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.damage.product')}}"><span class="nav-main-link-name">Add New Damage Product</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.all.damaged.product')}}"><span class="nav-main-link-name">Damaged Products</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.return.product'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fas fa-undo-alt"></i>
                            <span class="nav-main-link-name">Return & Refunds</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.returnable.invoice')}}"><span class="nav-main-link-name">Returnable Product</span></a></li>
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.customer.returned.invoices')}}"><span class="nav-main-link-name">Returned Invoice</span></a></li>
                        </ul>
                    </li>
                    @endif
                    @if($user->hasPermissionTo('branch.reports'))
                    <li class="nav-main-item">
                        <a class="nav-main-link active nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fab fa-page4"></i>
                            <span class="nav-main-link-name">Reports</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item"><a class="nav-main-link" href="{{route('branch.due.customers')}}"><span class="nav-main-link-name">Due Customers</span></a></li>
                        </ul>
                    </li>
                    @endif
                    
                    
                    
                </ul>
            @endif
        </div>
    </div>
</nav>
@endif
