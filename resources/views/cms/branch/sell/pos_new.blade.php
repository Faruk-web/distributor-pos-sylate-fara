@php( $user = Auth::user())
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sell Point</title>
	<meta name="description" content="Updates and statistics">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{asset('backend/pos/css/style.css?v=1.0') }}" rel="stylesheet" type="text/css">

	<link href="{{asset('backend/pos/api/pace/pace-theme-flat-top.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('backend/pos/api/mcustomscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('backend/pos/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{asset('backend/pos/multiple_select/dist/multiple-select.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
	<link rel="shortcut icon" href="{{asset('backend/pos/media/logos/favicon.ico') }}">
	
	<style>
        .resulttable-pos .table th, .resulttable-pos .table td {
            padding: 6px 0 !important;
        }
        
        i.fa.fa-plus.plus_icon {
            background-color: #F49D2A;
            padding: 3px;
            color: #fff;
            border-radius: 50%;
            cursor: grab;
        }
        
        .fw-bold {
            font-weight: bold !important;
        }
        .productContent {
            text-align: center !important;
            padding-left: 1px !important;
            padding-right: 1px !important;
            min-height: 50px !important;
        }
        h5.fw-bold {
            color: #9439f1;
        }
        .table-datapos {
            padding: 3px !important;
            height: 418px !important;
        }
        
	</style>
</head>

<body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed">
    
    <div class="se-pre-con">
        <div class="pre-loader">
        <img class="img-fluid" src="{{asset('backend/pos/assets/images/loadergif.gif') }}" alt="loading">
        </div>
    </div>
    
<audio id="error" src="{{asset('backend/audio/error.mp3')}}" preload="auto"></audio>
<audio id="success1" src="{{asset('backend/audio/warning.mp3')}}" preload="auto"></audio>
<audio id="success" src="{{asset('backend/audio/success.mp3')}}" preload="auto"></audio>
<input type="hidden" value="0" id="product_processing" /> 
   <header class="pos-header bg-white">
	   <div class="container-fluid">
		   <div class="row align-items-center">
			   <div class="col-xl-4 col-lg-4 col-md-4 clock-main text-left">
				<div class="clock " style="justify-content: left !important;">
				  <div class="datetime-content">
					<h4 class="card-label mb-0 font-weight-bold text-primary">Sale Point</h4>
				  </div>
				 <div class="datetime-content">
					<div id="Date"></div>
				 </div>
				</div>
			   </div>
			   
			   <div class="col-xl-4 col-lg-4 col-md-4">
				<div class="row">
                    <div class="col-md-4"></div>
				    <div class="col-md-4 d-none">
				        <button disable onclick="select_customer_type('walking')" class="border-success text-center rounded form-control mb-1 rounded-pill"><i class="fas fa-walking"></i> Walking</button>
				    </div>
				    <div class="col-md-4">
				        <button onclick="select_customer_type('search')" class="border-secondary p-1 text-center rounded form-control mb-1 rounded-pill"><i class="fas fa-search"></i> Customer</button>
				    </div>
				    <div class="col-md-4">
				        <button onclick="select_customer_type('add_customer')" data-toggle="modal" data-target="#modal_add_new_customer" class="border-primary p-1 text-center rounded form-control mb-1 rounded-pill"><i class="fa fa-plus"></i> Customer</button>
				    </div>
                    <input type="hidden" name="" id="walking_customer_code" value="">
				</div>
			   </div>
			   
			   <div class="col-xl-1 col-lg-1 col-md-1">
			       <div>
			           <div class="text-center" id="header_loadning" style="display: none;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>
			       </div>
			   </div>
			   
			   <div class="col-xl-3 col-lg-3 col-md-3 order-lg-last order-second">
			       
				<div class="topbar justify-content-end">
				 <div class="dropdown">
				     <div id="id2" class="topbar-item d-none">
						 <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
							 <span class="symbol symbol-35 symbol-light-success" onclick="clearAll()">
								 <span class="symbol-label bg-dark text-light" title="Clear all">Clr</span>
							 </span>
						 </div>
					 </div>
					 
					 <div id="id2" class="topbar-item">
						 <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
							 <span class="symbol symbol-35 symbol-light-success">
								 <a href="{{route('branch.sell.new')}}" class="symbol-label bg-dark" title="Hard Refresh"><i class="fas fa-sync text-light"></i></a>
							 </span>
						 </div>
					 </div>
				     <div id="id2" class="topbar-item">
						 <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
							 <span class="symbol symbol-35 symbol-light-success">
								 <a href="{{route('/')}}" class="symbol-label bg-dark" title="Go Dashboard"><i class="fas fa-angle-double-left text-light"></i></a>
							 </span>
						 </div>
					 </div>
					 
					 <div id="id2" class="topbar-item " data-toggle="dropdown" data-display="static">
						 <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
							 <span class="symbol symbol-35 symbol-light-success">
								 <span class="symbol-label bg-primary"><i class="fas fa-calculator text-light font-size-h5"></i></span>
							 </span>
						 </div>
					 </div>
					 
					 <div class="dropdown-menu dropdown-menu-right calu" style="min-width: 248px;">
						 <div class="calculator">
							 <div class="input" id="input"></div>
							 <div class="buttons">
							   <div class="operators">
								 <div>+</div>
								 <div>-</div>
								 <div>&times;</div>
								 <div>&divide;</div>
							   </div>
								<div class="d-flex justify-content-between">
								 <div class="leftPanel">
									 <div class="numbers">
									   <div>7</div>
									   <div>8</div>
									   <div>9</div>
									 </div>
									 <div class="numbers">
									   <div>4</div>
									   <div>5</div>
									   <div>6</div>
									 </div>
									 <div class="numbers">
									   <div>1</div>
									   <div>2</div>
									   <div>3</div>
									 </div>
									 <div class="numbers">
									   <div>0</div>
									   <div>.</div>
									   <div id="clear">C</div>
									 </div>
								   </div>
								   <div class="equal" id="result">=</div>
								</div>
							 </div>
						   </div>
					 </div>
				 </div>
				</div>
				</div>
		   </div>
	   </div>
   </header>
   <div class="contentPOS">
	    <div class="container-fluid">
	        <button type="button" id="multiple_product_modal_button" class="d-none" data-toggle="modal" data-target="#variation_modal"></button>
            <div class="modal fade" id="variation_modal" tabindex="-1" role="dialog" aria-labelledby="variation_modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="variation_modalLabel">Select Product</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" id="multiple_product_modal_close" aria-label="Close">
                      <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body p-4">
                      <div id="multiple_product_modal_body" class="row"></div>
                  </div>
                </div>
              </div>
            </div>
            
	        
	       {{-- <form action="{{url('/branch/new_sell_confirm_by_ajax_new')}}" id="order_confirm" method="post"> --}}
	       <form action="javascript:void(0)" id="order_confirm" method="post">
            @csrf
            <div id="first_step_row">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-5 p-1">
                                <div class="justify-content-between colorfull-select shadow p-2">
                                    <label class="text-dark d-flex"><span class="text-danger">*</span>Search SR</label>
                                    <input type="text" class="form-control" id="sr_search" placeholder="Search by SR info [ name, phone ]" name="sr_search">
                                    <input type="hidden" name="sr_id" id="sr_id" value="">
                                    <div class="">
                                        <table class="table table-bootstrap">
                                            <tbody id="sr_search_output_info"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-1">
                                <div class="form-group shadow p-2">
                                    <label class="text-dark d-flex"><span class="text-danger">*</span>Method</label>
                                    <select name="order_method" class="form-control" id="order_method">
                                        <option value="0">-- Select Method --</option>
                                        <option value="make_invoice">Make Invoice</option>
                                        <option value="make_invoice_with_product_delivery">Make Invoice With Product Delivery</option>
                                    </select>
                                    <div class="">
                                        <table class="table table-bootstrap">
                                            <tbody id=""></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 p-1">
                                <div class="form-group shadow rounded-pill border mt-4 p-2">
                                    <button type="button" onclick="order_first_step_view_controller()" class=" mt-1 bg-dark text-center text-light rounded form-control mb-1 rounded-pill">Next</button>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row" id="finale_step_row" style="display: none;">
				<div class="col-xl-4 order-xl-first order-last">
					<div class="card card-custom gutter-b bg-white border-0" id="products_section">
						<div class="card-body">
                            <div id="sr_info_show"></div>
							<div class="d-flex justify-content-between colorfull-select">
								<div class="selectmain">
									<select class="w-150px bag-primary" id="catValue">
                                    <option value="">-- Category --</option>
                                    @foreach($categories as $category)
                                    <option value="{{optional($category)->id}}">{{optional($category)->cat_name}}
                                    </option>
                                    @endforeach
									</select>
								</div>
								<div class="selectmain">
									<select class="w-150px bag-secondary"  id="brandValue">
										<option value="">-- Brands --</option>
										@foreach($brands as $brand)
                                        <option value="{{optional($brand)->id}}">{{optional($brand)->brand_name}}
                                        </option>
                                        @endforeach
									</select>
								</div>
							</div>
							<div class="form-group row mb-0">
									<div class="col-md-12">
										<label></label>
										<fieldset class="form-group mb-0 d-flex barcodeselection">
											<input type="text" class="form-control border-dark" placeholder="Product Name" id="product_search">
										</fieldset>
									</div>
								</div>
						</div>	
                            <input type="hidden" name="" id="PAGINATE" value="1">
                            <input type="hidden" name="" id="no_more_products" value="0">
							<div class="product-items" id="result">
								<div class="row" id="myUL"></div>
                                <div class="auto-load text-center">
                                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                        viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                        <path fill="#000"
                                            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="1s" from="0 50 50" to="360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                    </svg>
                                </div>
							</div>
					</div>
				</div>
				
				<div class="col-xl-6 col-lg-6 col-md-6">
				    <div class="card bg-white border table-contentpos mb-3" style="background-color: #fff !important;">
							<div class="card-body row" style="padding: 9px !important;">
							    <div class="col-md-12">
                                    <div class="row" style="display: none;" id="search_customer_shown">
                                        <div class="col-md-6">
                                            <div class="justify-content-between colorfull-select">
                                                <label class="text-dark d-flex">Search a Customer</label>
                                                <input type="text" class="form-control" id="customer_search" placeholder="Search by Customer info [ name, phone ]" name="company_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mr-2">
                                                <label class="control-label"><span class="text-danger">*</span>Area</label>
                                                <select name="search_custoemr_area" class="form-control" id="search_custoemr_area">
                                                    <option value="all">All Area</option>
                                                    @foreach ($all_area as $area)
                                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bootstrap">
                                                <tbody id="customer_show_info"></tbody>
                                            </table>
                                        </div>
                                    </div>
							        
								    <div class="justify-content-between colorfull-select row" id="customer_info_shown">
								        <div class="col-md-12">
								            <label class="border-bottom">Customer Info</label><br>
								            <p id="customer_info_output" class="font-weight-bold"></p>
								            <input type="hidden" class="form-control" id="customer_code" value="" name="customer_code">
								            <input type="hidden" name="customer_id" id="" class="form-control" value="" required>
                                            <input type="hidden" name="submit_from" id="submit_from" value="">
								        </div>
								        <div class="col-md-4 d-none">
								            <label class="border-bottom">Wallet Point Info</label>
								            <div class="d-flex justify-content-between">
								                <h4 id="point_info_output" class="font-weight-bold d-flex"><i class='fas fa-coins mr-2'></i> <span id="customer_point_output"></span></h4>
								                <button class="bg-success text-light rounded-pill ml-2 pl-2 mr-5" id="convert_button" onclick="convert_point_to_tk()" style="display: none;">Convert</button>
								            </div>
								        </div>
								    </div>
							    </div>
							</div>	
						</div>
				    
				     <div class="card bg-white border-0 table-contentpos">
						<div class="card card-custom bg-white border-0 table-contentpos">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3 class="fw-bold p-2 mb-0" id="what_option_output"></h3>
                                        <div class="input-group d-none">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Barcode" autofocus="autofocus" id="product_barcode_search" name="">
                                    </div>
                                    </div>
                                    <div class="col-md-2"><h3 class="fw-bold"><i class="fa fa-shopping-bag p-1" style="color: #F9A826;"> </i> <span id="total_cart_items">0</span></h3></div>
                                </div>
								<div class="table-datapos">
									<div class="table-responsive" id="printableTable">
										<table id="orderTables" class="display table-bordered table" style="width:100%">
											<thead class="bg-dark text-light">
												<tr>
													<th width="60%">Product Info</th>
													<th>Quantity</th>
                                                    <th>Cartoon Qty</th>
													<th>Subtotal</th>
													<th>X</th>
												</tr>
											</thead>
                                            <input type="hidden" name="" id="individual_vat_status" @if($user->shop_info->vat_type == 'individual_product_vat') value="yes" @else value="no" @endif>
											<tbody id="cart_body">
											    
											</tbody>
										</table>
									</div>
								</div>
						</div>
					 </div>	
				 </div>
				 
				 <div class="col-xl-2 col-md-2" style="padding: 0px 5px !important;">
					<div class="card card-custom gutter-b bg-white border-0">
						<div class="card-body">
							<div class="resulttable-pos">
								<table class="table right-table">

									<tbody>
									  <tr class="d-flex align-items-center justify-content-between">
										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">Total Gross</th>
										<td class="border-0 justify-content-end d-flex text-dark font-size-base" id="total_gross_td">0</td>
										<input type="hidden" id="sums" name="subtotal" value="0">
									  </tr>
									  
									  <tr class="d-flex align-items-center justify-content-between">
										<th class="border-0 ">
											<div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
											DISCOUNT(<span id="d_output_td" class="text-success">No</span>) <i class="fa fa-plus plus_icon ml-2" data-toggle="modal" data-target="#discountpop"></i>
											
										</div>
										</th>
										<td class="border-0 justify-content-end d-flex text-dark font-size-base" id="discount_amount_td">0</td>
										
										<!-- Discount Modal -->
                                        <div class="modal fade" id="discountpop" tabindex="-1" role="dialog" aria-labelledby="discountpoplLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header bg-dark">
                                                <h5 class="modal-title text-light" id="discountpoplLabel">Discount Info</h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="row">
                                                      <div class="col-md-6 p-3 mb-5">
                                                          <div class="form-group">
                                                            <lebel>Select Discount Type</lebel>
                                                            <select class="form-control" id="cart_discount" name="cart_discount">
                                                                <option value="0">No</option>
                                                                <option value="flat">Flat</option>
                                                                <option value="percent">Percent</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6 p-3 mb-5">
                                                          <div id="discount-value-div" style="">
                                                            <lebel><span class="text-danger">*</span>Discount Amount</lebel>
                                                            <input type="number" min="0" id="discountAmount" step="any" name="discountAmount" value="0" class="form-control">
                                                            <span id="type_of_discount" class="text-success"></span>
                                                        </div>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
										
										
									  </tr>
									  {{--
									  @if($branch_info->vat_status == 'yes' && optional($user->shop_info)->vat_type == 'total_vat')
                                        <tr class="d-flex align-items-center justify-content-between">
    										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">VAT ({{$branch_info->vat_rate}}%)</th>
    										<input type="hidden" id="vat" name="vat" value="{{$branch_info->vat_rate}}" />
    										<td class="border-0 justify-content-end d-flex text-dark font-size-base" id="vat_amount_tk_td">0</td>
    										<input type="hidden" id="vat_price" name="vat_price" value="0" />
    									</tr>
    								  @else
    								  <input type="hidden" id="vat" name="vat" value="0" />
    								  <input type="hidden" id="vat_price" name="vat_price" value="0" />
                                      @endif
                                      --}}
                                      <input type="hidden" id="vat" name="vat" value="0" />
    								  <input type="hidden" id="vat_price" name="vat_price" value="0" />

									  
									  <tr class="d-flex align-items-center justify-content-between">
										<th class="border-0 ">
											<div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
										    Others<i class="fa fa-plus plus_icon ml-2" data-toggle="modal" data-target="#othersChargeModal"></i>
										</div>
										</th>
										<td class="border-0 justify-content-end d-flex text-dark font-size-base" id="others_charge_td">0</td>
										
										<!-- Others Charge Modal -->
                                        <div class="modal fade" id="othersChargeModal" tabindex="-1" role="dialog" aria-labelledby="othersChargeModallLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header bg-dark">
                                                <h5 class="modal-title text-light" id="othersChargeModallLabel">Others Info</h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="row">
                                                      <div class="col-md-12 pl-4 pr-4">
                                                          <div id="discount-value-div" style="">
                                                            <lebel class="fw-bold"><span class="text-danger" >*</span>Others Charge</lebel>
                                                            <input type="number" min="0" id="only_others_crg" step="any" name="only_others_crg" value="0" class="form-control">
                                                        </div>
                                                      </div>
                                                      
                                                        <div class="col-md-12 mt-4" id="sms_status" style="display:none;">
                                                            <div class="row pl-4 pr-4">
                                                                <label for=" col-md-4" class="fw-bold">Send SMS</label>
                                                                <div class="col-md-8">
                                                                <div class="form-check form-check-inline bg-primary"
                                                                    style="padding: 2px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                                                    <input class="form-check-input" type="radio" checked name="send_sms"
                                                                        id="inlineRadio1" value="1">
                                                                    <label class="form-check-label  text-light" for="inlineRadio1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline bg-dark"
                                                                    style="padding: 2px 10px; border: 1px solid red; border-radius: 10px;">
                                                                    <input class="form-check-input" type="radio" name="send_sms"
                                                                        id="inlineRadio2" value="0">
                                                                    <label class="form-check-label text-light" for="inlineRadio2">No</label>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                      <div class="col-md-12 pl-4 pr-4 mt-3">
                                                          <div class="form-group">
                                                                <label for="" class="fw-bold">Note.</label>
                                                                <textarea id="note" name="note" class="form-control" rows="4" cols="50">Note</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Date</label>
                                                                <input type="hidden" class="form-control" id="todays_date" value="{{ date('Y-m-d') }}" />
                                                                <input type="date" name="date" class="form-control" id="invoice_date" value="{{ date('Y-m-d') }}" required />
                                                            </div>
                                                      </div>
                                                      
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
									  </tr>
									  
									  
									  <tr class="d-flex align-items-center justify-content-between">
										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">Sub Total</th>
										<td class="border-0 justify-content-end d-flex text-dark font-size-base" id="subtotal_amount_id">0</td>
										<input type="hidden" id="subTotal" name="subTotal" value="0">
									  </tr>
									  
									  <tr class="d-flex align-items-center justify-content-between rounded bg-danger text-light pl-2 pr-2 mb-2">
										<th class="border-0 font-size-h5 mb-0 font-size-bold">Pre Due</th>
										<td class="border-0 justify-content-end d-flex font-size-base" id="previous_due_show_td">0</td>
										<input type="hidden" id="previous_due" name="previous_due" value="0">
										
									  </tr>
									  
									  @if(optional($user->shop_info)->is_active_customer_points == 'yes')
									  <tr class="d-flex align-items-center justify-content-between item-price rounded bg-dark text-light pl-2 pr-2">
										<th class="border-0 font-size-h5 mb-0 font-size-bold">Wallet Balance <br><span id="wallet_bl_used"></span></th>
										<td class="border-0 justify-content-end d-flex font-size-base" id="wallet_balance_show_td">0</td>
										<input type="hidden" name="wallet_status" id="wallet_status" value="1">
										<input type="hidden" name="wallet_balance_for_db" id="wallet_balance_for_db" value="0">
									  </tr>
									  @else
									    <span style="display: none;" id="wallet_bl_used"></span>
									    <input type="hidden" name="wallet_status" id="wallet_status" value="0">
									    <input type="hidden" name="wallet_balance_for_db" id="wallet_balance_for_db" value="0">
									  @endif
									  
									  <tr class="d-flex align-items-center justify-content-between item-price">
										<th class="border-0 font-size-h5 mb-0 font-size-bold text-primary">Total Payable</th>
										<td class="border-0 justify-content-end d-flex text-primary"><h2 style="font-weight: bold;" id="total_payable_td">0</h2></td>
										<input type="hidden" id="total_payable" name="total_payable">
									  </tr>
									  
									</tbody>
								  </table>
							 </div>
							 
							 <div class="row mb-1">
                                        <!--this is for Full Payment Start-->
                                        <div class="col-md-12">
                                            <button type="button"  onclick="payment_for('full_payment')" class="bg-primary text-center text-light rounded form-control mb-1 rounded-pill"
                                                data-toggle="modal" data-target="#fullPayment"> <i class="fas fa-money-bill-wave mr-2"></i> CASH</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="fullPayment" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><b>Take Full Payment</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="date">Paid</label>
                                                                <input type="number" name="full_payment" id="full_payment" class="form-control" value="0" step=any readonly />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger close_modal" data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="Full_payment_submit" name="Full_payment_submit" class="btn btn-success" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for Full Payment End-->

                                        
                                        
                                        <!--this is for Partial Payment Start-->
                                        <div class="col-md-12" id="partial_payment_div">
                                            <button type="button"  onclick="payment_for('partial_payment')" class="bg-warning text-center text-light rounded form-control mb-1 rounded-pill"
                                                data-toggle="modal" data-target="#partialPayment">Partial Payment</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="partialPayment" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        <b>Take Partial Payment</b></h5>
                                                                </div>
                                                                <div class="col-md-4 text-right">
                                                                    <input type="number" name="" id="partial_paid_for_show" class="text-light form-control bg-success" value="" step=any readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="date">Paid</label>
                                                                <input type="number" name="partial_paid" id="partial_paid" class="form-control" value="" step=any>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date">Current Due</label>
                                                                <input type="number" name="partial_due" id="partial_due" class="form-control" value="" readonly step=any>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger close_modal" data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="partial_payment_submit" name="partial_payment_submit" class="btn btn-success" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for Partial Payment End-->

                                        {{--
                                        @if($branch_info->online_sell_status == 'yes')
                                        <div class="col-md-12"  id="cash_on_payment_div" style="display: none;">
                                            <button type="button"  onclick="payment_for('cash_on_payment')" class="bg-info text-center text-light rounded form-control mb-1 rounded-pill"
                                                data-toggle="modal" data-target="#cashOnDelivery">Cash On
                                                Delivery</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="cashOnDelivery" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        <b>Take Cash On Delivery Payment</b></h5>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" name="" id="COD_paid_for_show"
                                                                        class="form-control bg-success text-light" value=""
                                                                        step=any readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Shipping Charge</label>
                                                                <input type="number" id="delivery_others_crg" name="delivery_others_crg" value="0" class="form-control" step=any>
                                                                <input type="hidden" id="delivery_others_crg_tk" name="delivery_others_crg_tk" value="0" class="form-control" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Shipped By</label>
                                                                <select name="delivery_man_id" id="delivery_man_id" class="form-control">
                                                                    <option value="">Select Shipping ...</option>
                                                                    @foreach($delivery_man as $ship)
                                                                        <option value="{{$ship->id}}">{{$ship->name}} [{{$ship->phone}}]</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Shipping Details:</label>
                                                                <textarea name="shipping_details" id="shipping_details" class="form-control" rows="4" cols="50"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Paid</label>
                                                                <input type="number" name="cash_on_delivery_paid"
                                                                    id="cash_on_delivery_paid" class="form-control"
                                                                    value="0" step=any>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="date" class="fw-bold">Current Due</label>
                                                                <input type="number" name="cash_on_delivery_due"
                                                                    id="cash_on_delivery_due" class="form-control"
                                                                    value="" readonly step=any>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger close_modal"
                                                                data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="cash_on_delivery_payment_submit" name="partial_payment_submit"
                                                                class="btn btn-success" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for Cash On Delivery Payment End-->
                                        @endif
                                    --}}
                                        <!--this is for MFS Payment Start-->
                                        <div class="col-md-12">
                                            <button type="button"  onclick="payment_for('cheque_payment')" class="bg-dark text-center text-light rounded form-control mb-1 rounded-pill" data-toggle="modal" data-target="#takeMFS">MFS or CARD</button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="takeMFS" tabindex="-1" role="dialog"
                                                aria-labelledby="takeMFS" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5 class="modal-title" id="exampleModalLabel"> <b>Take MFS Payment </b></h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="number" name="" id="mfs_paid_for_show" class="form-control bg-success text-light" value="" step=any readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body row">
                                                            <div class="col-md-6 p-2 pl-4">
                                                                <div class="form-group row">
                                                                    <label for="inputName" class="col-sm-5 col-form-label">Paid</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="number" name="mfs_paid" id="mfs_paid" class="form-control" value="" step=any>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputName" class="col-sm-5 col-form-label">Current Due</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="number" name="mfs_current_due" id="mfs_current_due" class="form-control" value="" step=any readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 p-2">
                                                                <div class="shadow rounded p-2">
                                                                    <div class="form-group">
                                                                        <label for="inputName" class="fw-bold">Card / Cheque or Mobile Banking (মোবাইল ব্যাংকিং)</label>
                                                                        <select name="card_or_mobile_banking" class="form-control" id="card_or_mobile_banking">
                                                                            <option value="">Select One</option>
                                                                            <option value="card">Card / Cheque</option>
                                                                            <option value="mfs">Mobile Banking / মোবাইল ব্যাংকিং</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div id="cart_payment_div" class="p-2"  style="display:none;">
                                                                        <div class="form-group">
                                                                            <label for="" class="fw-bold">Card Name / Cheque Bank Name</label>
                                                                            <input type="text" id="Chequebank" class="form-control" name="Chequebank">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputName" class="fw-bold">Card Number / Cheque Number</label>
                                                                            <input type="text" class="form-control" id="checkNoOrMFSAccNo" name="checkNoOrMFSAccNo">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputName" class="fw-bold">Cheque Date.</label>
                                                                            <input type="date" name="Chequedate" id="Chequedate" class="form-control" required value="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputName" class="fw-bold">Cheque Diposit Date.</label>
                                                                            <input type="date" name="DipositDate" id="DipositDate" class="form-control" required value="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div id="mobile_banking_payment_div" class="p-2" style="display:none;">
                                                                        <div class="form-group">
                                                                            <label for="" class="fw-bold">Sender Number</label>
                                                                            <input type="text" id="mfs_sender_number" class="form-control" name="mfs_sender_number">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputName" class="fw-bold">Mobile Banking Acc Type</label>
                                                                            <select name="mfs_name" id="mfs_name" class="form-control">
                                                                                <option value="">Select One</option>
                                                                                <option value="Bkash">Bkash</option>
                                                                                <option value="Rocket">Rocket</option>
                                                                                <option value="Nagad">Nagad</option>
                                                                                <option value="Upay">Upay</option>
                                                                                <option value="MCash">MCash</option>
                                                                                <option value="Trust Axiata Pay (Tap)">Trust Axiata Pay (Tap)</option>
                                                                                <option value="EasyCash">EasyCash</option>
                                                                                <option value="Mobile Money">Mobile Money</option>
                                                                                <option value="SureCash">SureCash</option>
                                                                                <option value="T-Cash">T-Cash</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group p-2" style="display:none;" id="bank_deposit_to_div">
                                                                        <label for="inputName" class="fw-bold">Cheque / Card / Mobile Banking Diposit to</label>
                                                                        <select class="form-control" id="bank" name="dipositbank">
                                                                            <option value="">Select A bank</option>
                                                                            @foreach($banks as $bank)
                                                                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{$bank->bank_branch}}]</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger close_modal" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" id="mfs_payment_confrim">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for MFS Payment End-->
                                        
                                        {{--
                                        <!--this is for multiple Payment Start-->
                                        <div class="col-md-12">
                                            <button type="button"  onclick="payment_for('multiple')" class="bg-secondary text-center text-light rounded form-control mb-1 rounded-pill"
                                                data-toggle="modal" data-target="#multiple_Payment">Multiple Pay</button>
                                                
                                            <!-- Modal -->
                                            <div class="modal fade" id="multiple_Payment" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><b>Take Multiple Payment</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="shadow rounded p-2">
                                                                        <div class="form-group">
                                                                            <label for="" class="fw-bold">Select Payment Type</label>
                                                                            <select name="select_multiple_payment_type" class="form-control" id="select_multiple_payment_type">
                                                                                <option value="0"> --Select Payment Type-- </option>
                                                                                <option value="cash">Cash</option>
                                                                                <option value="card">Card / Mobile Banking</option>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        <button type="button" onclick="add_multiple_payment_row()" class="border-primary text-light bg-primary p-1 text-center rounded form-control mb-1 rounded-pill">Add Payment Row</button>
                                                                    </div>
                                                                    <div class="shadow rounded p-2 mt-3">
                                                                        <table class="table right-table">
                                        									<tbody>
                                        									  <tr class="d-flex align-items-center justify-content-between item-price">
                                        										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">Total Payable:</th>
                                        										<td class="border-0 justify-content-end d-flex text-dark"><h2 class="fw-bold" id="multiple_payment_total_payable">0</h2></td>
                                        									   </tr>
                                        									   
                                        									   <tr class="d-flex align-items-center justify-content-between item-price">
                                        										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">Received:</th>
                                        										<td class="border-0 justify-content-end d-flex text-dark"><h2 class="fw-bold" id="multiple_payment_total_paid">0</h2></td>
                                        									   </tr>
                                        									   <tr class="d-flex align-items-center justify-content-between item-price">
                                        										<th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">Remaining / Due:</th>
                                        										<td class="border-0 justify-content-end d-flex text-dark"><h2 class="fw-bold" id="multiple_payment_due">0</h2></td>
                                        									   </tr>
                                        									   
                                        									   
                                        									  
                                        									</tbody>
                                        								  </table>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="shadow rounded p-1">
                                                                        <table class="table table-bordered">
                                                                          <thead>
                                                                            <tr>
                                                                              <th>Payment Amount</th>
                                                                              <th width="55%">Payment Type Info</th>
                                                                              <th width="5%" class="text-center">X</th>
                                                                            </tr>
                                                                          </thead>
                                                                          <tbody id="multiple_pay_tbody"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" id="multiple_payment_submit_div">
                                                            <button type="button" class="btn btn-danger close_modal" data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="multiple_payment_submit" name="multiple_payment_submit" class="btn btn-success" value="Submit">
                                                        </div>
                                                        <div class="modal-footer" id="multiple_payment_warning_div" style="display:none;">
                                                            <h3 class="fw-bold text-success text-center">ওয়াকিং কাস্টমার এর জন্য কোন বাকি রাখা যাবে না। </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for multiple Payment End-->
                                        --}}
                                        
                                    </div>
						</div>	
					 </div>
				</div>
				
			</div>
			</form>	
		</div>
   </div>

    <!-- Add New Customer Modal -->
        <div class="modal fade" id="modal_add_new_customer" tabindex="-1" role="dialog" aria-labelledby="modal_add_new_customer" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5><button type="button" class="d-none" onclick="relese_update_mode()">Open</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="javascript:void(0)" method="post">
                @csrf
                <div class="block-content font-size-sm">
                    <div class="form-group">
                        <label class="control-label">Customer Name</label>
                        <input type="text" name="name" class="form-control" id="add_new_customer_name" >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="filebutton"><span class="text-danger">*</span>Phone Number (max: 11)</label>
                        <input type="text" maxlength="11" name="phone" class="form-control"
                            id="check_customer_phone_from_sell" required>
                        <div id="add_customer_phone_output"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><span class="text-danger">*</span>Area</label>
                        <select name="add_customer_area" class="form-control" id="add_customer_area">
                            <option value="">-- Select Area --</option>
                            @foreach ($all_area as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="block-content block-content-full text-right border-top">
                    <button type="submit" class="btn btn-success" onclick="add_new_customer()">Submit</button>
                    <button type="button" class="btn btn-danger mr-1" id="modal_add_new_customer_close_btn" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        </div>
        <!-- Add New Customer Modal -->
</div>	

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>


	<script src="{{asset('backend/pos/js/plugin.bundle.min.js') }}"></script>
	<script src="{{asset('backend/pos/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{asset('backend/pos/multiple_select/dist/multiple-select.min.js') }}"></script>
	<script src="{{asset('backend/pos/js/script.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
	<script>
		  jQuery(function() {
			jQuery('.arabic-select').multipleSelect({
		  filter: true,
		  filterAcceptOnEnter: true
		})
	  });
	  jQuery(function() {
			jQuery('.js-example-basic-single').multipleSelect({
		  filter: true,
		  filterAcceptOnEnter: true
		})
	  });
	  
	</script>

    
<script>


    // Begin:: SR Search for stock
    $('#sr_search').keyup(function () {
        var sr_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/branch/stock-out/search_sr',
            data: {
                'sr_info': sr_info
            },
            beforeSend: function() {
                $('#header_loadning').show();
            },
            success: function (data) {
                $('#sr_search_output_info').html(data);
                $('#header_loadning').hide();
            }
        });
    });
    // End:: SR Search for stock

    function select_sr(id, name, phone, area_name) {
        $('#sr_info_show').html("<div class='mb-3 shadow rounded p-1'>SR Name: "+name+", Phone: "+phone+", Area: "+area_name+"</div>");
        $('#sr_search_output_info').text("Name: "+name+", Phone: "+phone+", Area: "+area_name);
        $('#sr_search').val(name);
        $('#sr_id').val(id);
    }

    function order_first_step_view_controller() {
        var sr_id = $('#sr_id').val();
        var order_method = $('#order_method').val();
        if(sr_id != '' && order_method != 0) {
            $('#first_step_row').hide();
            $('#finale_step_row').show();
            //get_products();
            infinteLoadMore(1);
            $('#what_option_output').text($("#order_method option:selected").text());
        }
        else {
            error("Please Select SR or Method");
        }
    }

    
    // Begin:: Customer Search for stock
    $('#customer_search').keyup(function () {
        var customer_info = $(this).val();
        var search_custoemr_area = $('#search_custoemr_area').val();
        
        $.ajax({
            type: 'get',
            url: '/branch/stock-out/search-customer_new',
            data: {
                'customer_info': customer_info,
                'search_custoemr_area': search_custoemr_area,
            },
            beforeSend: function() {
                $('#header_loadning').show();
            },
            success: function (data) {
                $('#customer_show_info').html(data);
                $('#header_loadning').hide();
            }
        });
    });
    // End:: Customer Search for stock


    // Begin:: Add New Customer phone number check
    $('#check_customer_phone_from_sell').keyup(function () {
        var phone = $(this).val();
        if (phone.length == 11) {
            $.ajax({
                type: 'get',
                url: '/branch/search/customer_phone_new',
                data: {
                    'phone': phone
                },
                beforeSend: function() {
                    $('#header_loadning').show();
                },
                success: function (data) {
                    $('#add_customer_phone_output').html(data);
                    $('#header_loadning').hide();
                }
            });
        } else {
            $('#add_customer_phone_output').html('');
        }
    });
    // End:: Add New Customer phone number check


    $(document).ready(function () {
        $('#catValue').on('change', function () {
            get_products();
        });

        $('#brandValue').on('change', function () {
            get_products();
        });

    });

    // Begin:: Customer Search for stock in
    $('#product_search').keyup(function () {
        get_products();
    });
    // End:: Customer Search for stock in

    function get_products() {
        var order_method = $('#order_method').val();
        var sr_id = $('#sr_id').val();
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();
        
        $.ajax({
            type: 'get',
            url: '/branch/product_search_into_sell_new',
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'order_method': order_method,
                'sr_id': sr_id,
            },
            beforeSend: function () {
                $('#myUL').html('<div class="col-md-12 h4 text-center pt-5">Loading....</div>');
            },
            success: function (data) {
                $('#myUL').html(data);
                $('#PAGINATE').val(1);
                $('#no_more_products').val(0);
            },
            error: function (xhr) {
                error('Network Error!!!');
            },
        });

    }

    var ENDPOINT = "{{ url('/') }}";

    $('div#result').scroll(function () {
        if ($('#no_more_products').val() == 0) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var paginate = $('#PAGINATE').val();
                paginate++;
                infinteLoadMore(paginate);
            }
        }
    });

    function infinteLoadMore(page) {
        var order_method = $('#order_method').val();
        var sr_id = $('#sr_id').val();
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();

        $.ajax({
            type: 'get',
            datatype: "html",
            url: ENDPOINT + "/get_products_from_sell_new?page=" + page,
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'order_method': order_method,
                'sr_id': sr_id,
            },
            beforeSend: function () {
                $('.auto-load').show();
            },
            success: function (data) {
                if (data['status'] == 'yes') {
                    $('.auto-load').hide();
                    $('#PAGINATE').val(page);
                    $("#myUL").append(data['info']);
                } else {
                    $('.auto-load').hide();
                    $("#myUL").append(data['info']);
                    $('#no_more_products').val(1);
                }
            },
            error: function (xhr) {
                error('Network Error!!!');
            },
        });
    }
    
    /*
    
    function set_product(pid, sales_price, variation_id, discount, discount_amount) {
        var product_processing = $('#product_processing').val();
        if(product_processing == 0) {
            $.ajax({
                type: 'get',
                url: '/branch/get_product_for_cart_into_sell_new',
                data: {
                    'pid': pid,
                    'sales_price': sales_price,
                    'variation_id': variation_id,
                    'discount': discount,
                    'discount_amount': discount_amount,
                },
                beforeSend: function () {
                    $('#product_processing').val(1)
                    $('#header_loadning').show();
                },
                success: function (data) {
                    if(data.status == 'yes') {
                       add_to_cart(data.pid, data.p_name, data.variation_id, data.variation_name, data.sales_price, data.discount, data.discount_amount, data.vat_rate, data.total_stock, data.unit_name);
                    }
                    else {
                        error('Network Error! Please Try Again.');
                    }
                    $('#product_processing').val(0)
                    $('#header_loadning').hide();
                },
                error: function (xhr) {
                    error('Network Error!!!');
                    $('#product_processing').val(0)
                    $('#header_loadning').hide();
                },
            });
        }
        else {
            error('Another Product is processing Into cart!');
        }
    }
    
    */
    
</script>
<!-- End::product load and search and others end -->


<script>


var product_storage = [];

function add_to_cart(pid, p_name, variation_id, variation_name, sales_price, discount, discount_amount, vat_rate, total_stock, unit_name, is_cartoon, cartoon_quantity, cartoon_amount) {
    
    var customer_code = $('#customer_code').val();
    if(customer_code == '') {
        error("Please Select Customer!!!");
        return 0;
    }

    var v_name, cartoon_text, cartoon_status = '';
    if(variation_id != 0) { v_name = '<span class="text-success">('+variation_name+')</span>' }
    var generate_id = pid+'_'+variation_id+'_'+sales_price+'_'+discount+'_'+discount_amount+'_'+vat_rate+'gi';
    generate_id = generate_id.replace(".", "_");
    var flat_discount, discount_percent = 0;
    var order_method = $('#order_method').val();
    
    if($('#check_id_'+generate_id).val()) {

        if(order_method == 'make_invoice') {
            var cr_qty = $('#quantity_'+generate_id).val();
            var up_qty = parseInt(cr_qty) + parseInt(1);
            $('#quantity_'+generate_id).val(up_qty);
            var play = document.getElementById('success1').play();
            changeQuantity(generate_id, is_cartoon, cartoon_quantity, cartoon_amount);
            //multiply();
            //calculateSum();
        }
        else if(order_method == 'make_invoice_with_product_delivery') {
            var cr_qty = $('#quantity_'+generate_id).val();
            if(parseFloat(cr_qty) < parseFloat(total_stock)) {
                var up_qty = parseInt(cr_qty) + parseInt(1);
                $('#quantity_'+generate_id).val(up_qty);
                var play = document.getElementById('success1').play();
                changeQuantity(generate_id, is_cartoon, cartoon_quantity, cartoon_amount);
                // multiply();
                // calculateSum();
            } else { error("Reached Maximum Stock Qunatity!"); }
        }
    }
    else {
        if($('#individual_vat_status').val() === 'no'){ vat_rate = 0; }
        if(discount === 'percent') { discount_percent = discount_amount; } else if(discount === 'flat') { flat_discount = discount_amount; }
        
        if(is_cartoon == 1){ 
            if(order_method == 'make_invoice'){
                cartoon_text= cartoon_quantity+" = 1 Cartoon";
            }
            else if(order_method == 'make_invoice_with_product_delivery'){
                cartoon_text= "Max = "+(total_stock/cartoon_quantity)+" Cartoon<br>"+cartoon_quantity+" = 1 Cartoon";
            }
        }
        else {  
            cartoon_status = 'readonly'; cartoon_text = "<span class='text-danger'>Status is deactive.</span>"; 
        }
         
        
        const cartDom = `<tr id="cart_tr_`+generate_id+`">
                            <td>
                            <input type="hidden" id="check_id_`+generate_id+`" value="`+generate_id+`">
                            <input type="hidden" name="pid[]" value="`+pid+`">
                            <input type="hidden" name="previous_price[]" value="`+sales_price+`">
                            <input type="hidden" name="previous_discount[]" value="`+discount+`">
                            <input type="hidden" name="previous_discount_amount[]" value="`+discount_amount+`">
                            
                            <input type="hidden" name="variation_id[]" value="`+variation_id+`">
                            <h5 class="fw-bold">`+p_name+`<i class="fa fa-plus plus_icon ml-2"  data-toggle="modal" data-target="#cart_modal_`+generate_id+`"></i></h5>
                            <span><b>Price: </b> <span id="pp_show_`+generate_id+`">`+sales_price+`</span> || <b>Discount: </b> <span id="dis_show_`+generate_id+`">`+discount+`(`+discount_amount+`)</span> || <b>Vat: </b> <span id="vat_show_`+generate_id+`">`+vat_rate+`</span></span>
                            
                            <div class="modal fade text-left show" id="cart_modal_`+generate_id+`" tabindex="-1" role="dialog" aria-labelledby="cart_modal_level_`+generate_id+`" aria-modal="true"><div class="modal-dialog modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title fw-bold" id="cart_modal_level_`+generate_id+`">`+p_name+` `+v_name+`</h5></div><div class="modal-body"><div class="row"><div class="form-group col-md-12 col-sm-12"><label>Unit Price</label><input type="number" step=any name="price[]" id="price_`+generate_id+`" onchange="c_price('`+generate_id+`')" onkeyup="c_price('`+generate_id+`')" class="form-control pricesum" value="`+sales_price+`"></div><div class="form-group col-md-6 col-sm-6"><label>Percent Discount</label><input class="form-control discount_percent" onchange="ind_d_percent('`+generate_id+`')" onkeyup="ind_d_percent('`+generate_id+`')" type="number" step=any id="ind_p_d_amount_`+generate_id+`" name="disCP[]" value="`+discount_percent+`"></div><div class="form-group col-md-6 col-sm-6"><label>Flat Discount</label><input class="form-control flat_discount"  onchange="ind_d_flat('`+generate_id+`')" onkeyup="ind_d_flat('`+generate_id+`')" type="number" step=any id="ind_f_d_amount_`+generate_id+`" name="disC_flat[]" value="`+flat_discount+`"></div><div class="form-group col-md-12 col-sm-12"><label>VAT</label><input class="form-control individual_product_vat" name="individual_product_vat[]" type="number" readonly value="`+vat_rate+`"></div><div class="text-right col-md-12 col-sm-12"><button type="button" class="btn-secondary btn white pt-1 pb-1" data-dismiss="modal" aria-label="Close">Close</button></div></div></div></div></div></div>
                            </td>
                            <td>
                                <input type="number" step="any" value="1" class="form-control border-dark w-100px quantity quantity`+generate_id+`" id="quantity_`+generate_id+`"  oninput="changeQuantity('`+generate_id+`', '`+is_cartoon+`', '`+cartoon_quantity+`', '`+cartoon_amount+`')"  name="quantity[]" max="`+total_stock+`"> <span class="text-danger">
                            </td>
                            <td>
                                <div class="mb-2 p-1 border rounded shadow">
                                    <input style="width:90px;" type="number" class="cartoon_amount cartoon_amount`+generate_id+`" value="0" id="cartoon_amount" `+cartoon_status+` oninput="change_cartoon_amount('`+generate_id+`', '`+is_cartoon+`', '`+cartoon_quantity+`', '`+cartoon_amount+`')" name="cartoon_amount[]" step="any" required>
                                    <br><small>`+cartoon_text+`</small>
                                </div>
                            </td>
                            <td>
                                <h5 class="fw-bold item_subtotal" id="subtotal_item_`+generate_id+`">0</h5>
                                <input type="hidden" step="any" value="0" class="total" id="total" name="total[]">
                            </td>
                            <td>
                                <div class="text-center"><i class="fas fa-trash-alt text-danger" onclick="remove_cart_tr('`+generate_id+`')"></i></div>
                            </td>
                        </tr>`;
                        
        $('#cart_body').prepend(cartDom);
        
            changeQuantity(generate_id, is_cartoon, cartoon_quantity, cartoon_amount);
            var play = document.getElementById('success1').play();
    }
    
    $('#multiple_product_modal_close').click();
    
}


function changeQuantity(generated_id, is_cartoon, cartoon_quantity, cartoon_amount) {
    quantity_info_change(generated_id, is_cartoon, cartoon_quantity, cartoon_amount, 'single_qty');
}

function change_cartoon_amount(generated_id, is_cartoon, cartoon_quantity, cartoon_amount) {
    quantity_info_change(generated_id, is_cartoon, cartoon_quantity, cartoon_amount, 'cartoon_qty');
}

function quantity_info_change(generated_id, is_cartoon, cartoon_quantity, cartoon_amount, info) {
    var order_method = $('#order_method').val();

    if(info == 'single_qty') {
        if(is_cartoon == 1) {
            var qty = $('.quantity'+generated_id).val();
            var total_cartoon = qty / cartoon_quantity;
            $('.cartoon_amount'+generated_id).val(total_cartoon.toFixed(2));
        }
    }
    else if(info == 'cartoon_qty') {
        if(is_cartoon == 1) {
            var cartoon_qty = $('.cartoon_amount'+generated_id).val();
            var total_qty = cartoon_quantity * cartoon_qty;
            $('.quantity'+generated_id).val(total_qty.toFixed(2));
        }
    }

    multiply();
    calculateSum();
}


//product barcode to product
    $('#product_barcode_search').keypress(function(e) {
        var barcode = $('#product_barcode_search').val();
        if(e.which == 13 && barcode != '') {
            jQuery(this).blur();
            $.ajax({
                type: 'get',
                url: '/branch/product_search_from_barcode_new',
                data: { 'barcode': barcode, },
                beforeSend: function() {
                    $('#header_loadning').show();
                },
                success: function (data) {
                    if(data.exist == 'yes') {
                        if(data.s_or_multiple == 's') {
                            if(data.stock > 0) {
                                add_to_cart(data.pid, data.p_name, data.variation_id, data.variation_name, data.sales_price, data.discount, data.discount_amount, data.vat_rate, data.stock, data.unit_name);
                            } else { error(data.p_name + "Stock is empty!"); }
                        }
                        else if(data.s_or_multiple == 'm') {
                            $('#multiple_product_modal_body').html(data.product_info)
                            $('#multiple_product_modal_button').click();
                        }
                    }
                    else {
                        error("Product is not exist!");
                    }

                    $('#header_loadning').hide();
                    $('#product_barcode_search').val('');
                    $('#product_barcode_search').focus();
                },
                error: function (xhr) {
                    error("Network Error!!!");
                    $('#header_loadning').hide();
                    $('#product_barcode_search').val('');
                    $('#product_barcode_search').focus();
                },
            });
        }
    });
    //product barcode to product

</script>

<script>
$(".addproduct").click(function(){
    multiply();
	calculateSum();
});

$( document ).ready(function() {
    $(document).on("click change paste keyup cut select", ".pricesum", function() {
        console.log($(this).val());
        multiply();
        calculateSum();
    }); 
    
    // $(document).on("click change paste keyup cut select", ".quantity", function() {
    //     multiply();
    //     calculateSum();
    // }); 
    
    $(document).on("click change paste keyup cut select", "#discountAmount", function() {
        discount_output_td();
    }); 
    
    $(document).on("click change paste keyup cut select", "#delivery_others_crg", function() {
        calculateSum();
    });
    
    $(document).on("click change paste keyup cut select", "#only_others_crg", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#partial_paid", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#cash_on_delivery_paid", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#mfs_paid", function() {
        calculateSum();
    });
    
    $(document).on("click change paste keyup cut select", ".multiple_pay_input", function() {
        calculate_multiple_payment();
    });
    
    $(document).on("click change paste keyup cut select", "#change_amount", function() {
        calculateSum();
    });
    
    
     
    
    
});

$("#cart_discount").change(function() {
    discount_output_td();
});

function discount_output_td() {
    var discountType = $('#cart_discount').val();
    var d_amount = $('#discountAmount').val();
    if(discountType == 'flat') {
        $('#d_output_td').text(d_amount+' TK');
        $('#type_of_discount').text('You are selected Flat discount');

    }
    else if(discountType == 'percent') {
        $('#d_output_td').text(d_amount+'%');
        $('#type_of_discount').text('You are selected Percent(%) discount');
    }
    else {
        $('#d_output_td').text('No');
        $('#type_of_discount').text('');
        $('#discountAmount').val(0);
    }
    calculateSum();
}


function c_price(generate_id) {
    var price = $('#price_'+generate_id).val();
    $('#pp_show_'+generate_id).text(price);
    multiply();
    calculateSum();
}

function ind_d_percent(generate_id) {
    $('#ind_f_d_amount_'+generate_id).val(0);
    var dp_amount = $('#ind_p_d_amount_'+generate_id).val();
    $('#dis_show_'+generate_id).text(dp_amount+"%");
    multiply();
    calculateSum();
}

function ind_d_flat(generate_id) {
    $('#ind_p_d_amount_'+generate_id).val(0);
    var df_amount = $('#ind_f_d_amount_'+generate_id).val();
    $('#dis_show_'+generate_id).text(df_amount+" TK");
    multiply();
    calculateSum();
}



function calculateSum() {
        var sum = 0;
		$(".total").each(function() {
			if(!isNaN(this.value) && this.value.length!=0) {
				sum += parseFloat(this.value);
			}
		});
		
        // document.getElementsByClassName('sum')[0].innerText = sum
        document.getElementById("sums").value = sum;
		$("#sums").val(sum.toFixed(2));
		$("#total_gross_td").text(sum.toFixed(2));
		
	
	   //Discount Start
       var discountType = $('#cart_discount').val();
       var discountAmount = $('#discountAmount').val();
       if(discountAmount == '') { discountAmount = 0; }
       
       if(discountType == 'flat') {
          sum = parseFloat(sum) - parseFloat(discountAmount);
          $('#discount_amount_td').text(discountAmount);
       }
       else if(discountType == 'percent') {
           var discountParcentTk = (discountAmount * sum)/100;
           sum = parseFloat(sum) - parseFloat(discountParcentTk);
           $('#discount_amount_td').text(discountParcentTk.toFixed(2));
       }
       else {
            $('#discount_amount_td').text(0);
       }
       //Discount End
	
        // vat parcent and vat parcent rate start
        var vatParcent = $("#vat").val();
        if(typeof(vatParcent) != 'undefined' && vatParcent != null){ 
            var vatParcentPrice = sum*vatParcent/100;
            sum = parseFloat(sum) + parseFloat(vatParcentPrice);
            $("#vat_price").val(vatParcentPrice.toFixed(2));
            $("#vat_amount_tk_td").text(vatParcentPrice.toFixed(2));
        }
        // vat parcent and vat parcent rate End

        //Others Charge 
        var others_charge = $("#only_others_crg").val();
        if(typeof(others_charge) != 'undefined' && others_charge != null){ 
            if(others_charge == ''){ others_charge = 0; }
            sum = parseFloat(sum) + parseFloat(others_charge);
            $("#others_charge_td").text(parseFloat(others_charge));
        }
        //Others Charge

        $("#subTotal").val(sum.toFixed(2));
        $("#subtotal_amount_id").text(sum.toFixed(2));
        
        var previousDue = $('#previous_due').val();
        
        var sum = parseFloat(sum) + parseFloat(previousDue);

        // Delivery Charge Start
          var delivery_online_charge = $("#delivery_others_crg").val();
          if(typeof(delivery_online_charge) != 'undefined' && delivery_online_charge != null){ 
            if(delivery_online_charge == ''){
                delivery_online_charge = 0;
            }
            sum = parseFloat(sum) + parseFloat(delivery_online_charge);
            $("#delivery_others_crg_tk").val(parseFloat(delivery_online_charge));
        }
        // Delivery Charge End
        
        var wallet_bl = $("#wallet_balance_for_db").val();
        
        if(sum >= wallet_bl && wallet_bl > 0) {
            sum = parseFloat(sum) - parseFloat(wallet_bl);
            $('#wallet_bl_used').html('<span>Used: '+wallet_bl+'</span>');
        }
        else if(wallet_bl >= sum && wallet_bl > 0) {
            var rest = parseFloat(wallet_bl) - parseFloat(sum);
            $('#wallet_bl_used').html('<span>Used: '+sum+'<br>Remaining Wallet Bl: '+rest+'</span>');
            sum = parseFloat(sum) - parseFloat(sum);
        }
        
        $("#total_payable").val(sum.toFixed(2));
        $("#total_payable_td").text(sum.toFixed(2));
        $("#multiple_payment_total_payable").text(sum.toFixed(2));
        
        
        
        //this is for full payment paid
        $("#full_payment").val(sum.toFixed(2));
        
        var total_payable =sum;
        //this is for partial payment
        var partial_paid_tag = document.getElementById('partial_paid');
        if(typeof(partial_paid_tag) != 'undefined'){
            $("#partial_paid_for_show").val(total_payable.toFixed(2));
            var partial_paid = $("#partial_paid").val();
            var current_due_for_partial_paid = parseFloat(total_payable) - parseFloat(partial_paid);
            $("#partial_due").val(current_due_for_partial_paid.toFixed(2));
        }
        
        //this is for Cash on delivery payment
        var cash_on_delivery_tag = document.getElementById('cash_on_delivery_paid');
        if(typeof(cash_on_delivery_tag) != 'undefined'){
            $("#COD_paid_for_show").val(total_payable.toFixed(2));
            var cash_on_de_paid = $("#cash_on_delivery_paid").val();
            var current_due_for_cashOn_paid = parseFloat(total_payable) - parseFloat(cash_on_de_paid);
            $("#cash_on_delivery_due").val(current_due_for_cashOn_paid.toFixed(2));
        }
        
        //this is for MFS payment
        var mfs_paid_tag = document.getElementById('mfs_current_due');
        if(typeof(mfs_paid_tag) != 'undefined'){
            $("#mfs_paid_for_show").val(total_payable.toFixed(2));
            var mfs_paid = $("#mfs_paid").val();
            var current_due_for_mfs_paid = parseFloat(total_payable) - parseFloat(mfs_paid);
            $("#mfs_current_due").val(current_due_for_mfs_paid.toFixed(2));
        }
        
        var change_amount = $('#change_amount').val();
        
        if(change_amount != '') {
            var change_return = parseFloat(change_amount) - parseFloat(sum);
            $('.change_return_div').text(change_return.toFixed(2));
        }
        else {
            $('.change_return_div').text('');
        }
        
        var rowCount = $('#orderTables >tbody >tr').length;
        
        $('#total_cart_items').html(rowCount);
        
        
}



$(".addproduct").click(function(){
   
    calculateSum();
    $(".pricesum").each(function() {
    $(".quantity").on("change paste keyup cut select", function() {
            multiply();
    		});
    });
    $(".quantity").each(function() {
    $(".pricesum").on("change paste keyup cut select", function() {
            
    				multiply();
    		
    		});
    });
    //dis
    
});		

function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".pricesum");
    var discount_pernect = document.querySelectorAll(".discount_percent");
    var flat_discount = document.querySelectorAll(".flat_discount");
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {

            individual_quantity = Number(document.getElementsByClassName('quantity')[i].value);
            individual_price = Number(document.getElementsByClassName('pricesum')[i].value);
            individual_discount_percent = Number(document.getElementsByClassName('discount_percent')[i].value);
            individual_flat_discount = Number(document.getElementsByClassName('flat_discount')[i].value);
            individual_product_vat = Number(document.getElementsByClassName('individual_product_vat')[i].value);
            
            sum = individual_quantity*individual_price;
            if(individual_flat_discount != 0 && individual_flat_discount != '') {
                var t_discount = individual_flat_discount * individual_quantity;
                sum = sum - t_discount; 
            }
            else if(individual_discount_percent != 0 && individual_discount_percent != '') {
                var sum_for_item = individual_quantity*individual_price;
                discountParcent_amount_tk = (individual_discount_percent * sum_for_item)/100;
                //var t_discount = discountParcent_amount_tk * individual_quantity;
                sum = sum - discountParcent_amount_tk;
            }
            vat_price = sum*individual_product_vat/100;
            sum = sum+vat_price;
            document.getElementsByClassName('total')[i].value=sum.toFixed(2);
            document.getElementsByClassName('item_subtotal')[i].innerText=sum.toFixed(2);
            
    }
    calculateSum();
}   

</script>

<!--This is for product delete-->
<script>

function remove_cart_tr(generated_id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
           $('#cart_tr_'+generated_id).remove();
            calculateSum();
            multiply();
        }
    });
}


function payment_for(track) {
    if(track == 'full_payment') {
        $('#submit_from').val('full_payment');
        $("#partial_paid").prop('required',false);
        $("#cash_on_delivery_paid").prop('required',false);
        $("#mfs_paid").prop('required',false);
        $("#checkNoOrMFSAccNo").prop('required',false);
        $("#bank").prop('required',false);
        $("#delivery_man_id").prop('required',false);
        $("#Chequebank").prop('required',false);
        $("#card_or_mobile_banking").prop('required',false);
        $("#delivery_others_crg").val(0);

        $('#multiple_pay_tbody').html('');
        $('#select_multiple_payment_type').val(0);
        calculate_multiple_payment();
        
        $('#change_amount').val('');
        
        
    }
    else if(track == 'partial_payment') {
        $('#submit_from').val('partial_payment');
        $("#partial_paid").prop('required',true);
        $("#cash_on_delivery_paid").prop('required',false);
        $("#mfs_paid").prop('required',false);
        $("#checkNoOrMFSAccNo").prop('required',false);
        $("#bank").prop('required',false);
        $("#delivery_man_id").prop('required',false);
        $("#Chequebank").prop('required',false);
        $("#card_or_mobile_banking").prop('required',false);
        $("#delivery_others_crg").val(0);
        
        $('#multiple_pay_tbody').html('');
        $('#select_multiple_payment_type').val(0);
        calculate_multiple_payment();
        
    }
    else if(track == 'cash_on_payment') {
        $('#submit_from').val('cash_on_payment');
        $("#partial_paid").prop('required',false);
        $("#cash_on_delivery_paid").prop('required',true);
        $("#mfs_paid").prop('required',false);
        $("#checkNoOrMFSAccNo").prop('required',false);

        $("#bank").prop('required',false);
        $("#delivery_man_id").prop('required',true);
        $("#Chequebank").prop('required',false);
        $("#card_or_mobile_banking").prop('required',false);
        
        $('#multiple_pay_tbody').html('');
        $('#select_multiple_payment_type').val(0);
        calculate_multiple_payment();
        
    }
    else if(track == 'cheque_payment') {
        $('#submit_from').val('cheque_payment');
        $("#partial_paid").prop('required',false);
        $("#cash_on_delivery_paid").prop('required',false);
        $("#mfs_paid").prop('required',true);
        //$("#checkNoOrMFSAccNo").prop('required',true);
        $("#bank").prop('required',true);
        $("#delivery_man_id").prop('required',false);
        //$("#Chequebank").prop('required',true);
        $("#delivery_others_crg").val(0);
        $("#card_or_mobile_banking").prop('required',true);
        
        var customer_code = $('#customer_code').val();
        
        
        $('#multiple_pay_tbody').html('');
        $('#select_multiple_payment_type').val(0);
        calculate_multiple_payment();
        
    }
    else if(track == 'multiple') {
        $('#submit_from').val('multiple');
        calculate_multiple_payment();
        //$('#multiple_pay_tbody').html('');
    }
    calculateSum();
}

    $('#card_or_mobile_banking').on('change', function() {
        var value = this.value;
        if(value == 'card') {
            $('#cart_payment_div').show();
            $('#mobile_banking_payment_div').hide();
            $('#bank_deposit_to_div').show();
        }
        else if(value == 'mfs') {
            $('#cart_payment_div').hide();
            $('#mobile_banking_payment_div').show();
            $('#bank_deposit_to_div').show();
        }
        else {
           $('#cart_payment_div').hide();
            $('#mobile_banking_payment_div').hide();
            $('#bank_deposit_to_div').hide();
        }
    });


    $('select.MFSAccType').on('change', function() {
        var value = this.value;
        if(value != '') {
            $('#Chequebank').prop('required', false);
        }
        else {
            $('#Chequebank').prop('required', true);
        }
    });


$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});




</script>


@if(session('success'))
<script>
    swal({
        title: "Success",
        text: "{{ session('success') }}",
        icon: "success",
        button: "Ok",
    });
    var play = document.getElementById('error').play();
</script>
@endif

@if(session('error'))
<script>
    swal({
        title: "Error",
        text: "{{ session('error') }}",
        icon: "error",
        button: "Ok",
    });
    var play = document.getElementById('error').play();
</script>
@endif


<script>
//-----------------
$(document).ready(function(){
    
    $('#Full_payment_submit').click(function(e){
        order_confirm(e);
     });
     $('#partial_payment_submit').click(function(e){
        order_confirm(e);
     });
     $('#cash_on_delivery_payment_submit').click(function(e){
        order_confirm(e);
     });
     $('#mfs_payment_confrim').click(function(e){
        order_confirm(e);
     });
     
     $('#multiple_payment_submit').click(function(e){
        order_confirm(e);
     });
});
//-----------------

function order_confirm(e) {
    if (document.getElementById("order_confirm").checkValidity()) { 
        
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('/branch/new_sell_confirm_by_ajax_new')}}",
            method: 'post',
            data: $('#order_confirm').serialize(),
            beforeSend: function() {
                $('.se-pre-con').show();
            },
            success: function(response){
                console.log(response);
                if(response['status'] == 'yes') {
                    clearAll();
                    if(response['default_print'] == 'pos') {
                        let newWindow = open("/pos-print/"+response['invoice_num'], 'Print Invoice', 'width=600,height=550')
                        newWindow.focus();
                        newWindow.onload = function() {
                            newWindow.document.body.insertAdjacentHTML('afterbegin');
                        };
                    }
                    else if(response['default_print'] == 'general') {
                        let newWindow = open("/print_invoice/"+response['invoice_num'], 'Print Invoice', 'width=600,height=550')
                        newWindow.focus();
                        newWindow.onload = function() {
                            newWindow.document.body.insertAdjacentHTML('afterbegin');
                        };
                    }
                    else if(response['default_print'] == 'half_page') {
                        let newWindow = open("/print-invoice-half-page/"+response['invoice_num'], 'Print Invoice', 'width=600,height=550')
                        newWindow.focus();
                        newWindow.onload = function() {
                            newWindow.document.body.insertAdjacentHTML('afterbegin');
                        };
                    }
                    
                    var play = document.getElementById('success').play();
                    $('.se-pre-con').hide();
                    
                    //location.replace("{{ route('shop.walking.customer') }}");
                }
                else {
                    swal({
                        title: "Error!",
                        text: response['reason'],
                        icon: "error",
                        button: "Ok",
                    });
                    $('.se-pre-con').hide();
                    var play = document.getElementById('error').play();
                }
            }
        });
        
    }
    else {
        error("Error Occoured!");
    }
}



function relese_update_mode() {
    $('.update_mode').hide();
    $('.contentPOS').show();
    
}

var walking_customer_code = $('#walking_customer_code').val();

function add_new_customer() {
    var name = $('#add_new_customer_name').val();
    var phone = $('#check_customer_phone_from_sell').val();
    var area = $('#add_customer_area').val();
    
    $.ajax({
        type: 'get',
        url: '/branch/add-new-customer_into_pos_new',
        data: {
            'name': name,
            'phone': phone,
            'area': area
        },
        beforeSend: function() {
            $('#header_loadning').show();
        },
        success: function (data) {
            $('#header_loadning').hide();
            if(data.status == 'yes') {
                success('New Customer Added.');
                search_customer_info(data.code);
            }
            else {
                error(data.msg);
            }
        }
    });
}

function clear_add_customer_form_data() {
    $('#add_new_customer_name').val('');
    $('#check_customer_phone_from_sell').val('');
    $('#add_customer_phone_output').html('');
}

var wallet_status = $('#wallet_status').val();

function select_customer_type(type) {
    $('#customer_info_shown').hide();
    $('#search_customer_shown').show();
    $('#customer_search').focus();
    $('#customer_search').val('');
}

function search_customer_info(code) {
    $.ajax({
        type: 'get',
        url: '/branch/sell/search_customer_info',
        data: {
            'code': code
        },
        beforeSend: function() {
            $('#header_loadning').show();
        },
        success: function (data) {
            $('#header_loadning').hide();
            set_customer_info(data.name, data.phone, data.address, data.code, data.balance, data.area);
            $('#modal_add_new_customer_close_btn').click();
        }
    });
}

function convert_point_to_tk() {
    var code = $('#customer_code').val();
    $.ajax({
        type: 'get',
        url: '/branch/convert_point_to_tk_into_sell',
        data: {
            'code': code
        },
        beforeSend: function() {
            $('#header_loadning').show();
        },
        success: function (data) {
            if(data.status == 'yes') {
                search_customer_info(data.code);
            }
            else {
                error(data.msg);
            }
            $('#header_loadning').hide();
        }
    });
}



function set_customer_info(name, phone, address, code, balance, area) {
    if(code != null) {
        $('#customer_info_shown').show();
        $('#search_customer_shown').hide();
        $('#customer_search').val('');
        $('#customer_show_info').html('');
        $('#customer_info_output').text(name+" || "+code+" || "+phone+" || "+address+" || Area: "+area);
        $('#customer_code').val(code);
        
        // $('#customer_point_output').text(wallet_point);
        // if(wallet_point > 0) { $('#convert_button').show(); }else { $('#convert_button').hide(); }
        
        // if(wallet_status == 1) {
        //     $('#wallet_balance_show_td').text(wallet_balance);
        //     $('#wallet_balance_for_db').val(wallet_balance);
        // }
        // else { $('#wallet_balance_for_db').val(0); }
        
        $('#previous_due_show_td').text(balance);
        $('#previous_due').val(balance);
        success(phone+" Customer Info Set Successfully.");
        calculateSum();
    }
    else {
        error("Network Error, Please Try Again!!!");
    }
    
}

function add_multiple_payment_row() {
    var type = $('#select_multiple_payment_type').val();
    if(type == 'cash') {
        if($('#multiple_cash_payment').val()) {
            error('Cash Payment Type is already exist!');
        }
        else {
            multiple_payment_row_add('cash');
        }
    }
    else if(type == 'card') {
        multiple_payment_row_add('card');
    }
    else {
        error('Please Select Payment Type!');
    }
}

function multiple_payment_row_add(type) {
   $.ajax({
        type: 'get',
        url: '/branch/multiple_payment_row_add',
        data: {
            'type': type
        },
        beforeSend: function() {
            $('#header_loadning').show();
        },
        success: function (data) {
            $('#multiple_pay_tbody').append(data);
            $('#header_loadning').hide();
        }
    }); 
}

function remove_multiple_pay_tr(tr_id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
           $('#multiple_pay_tr_'+tr_id).remove();
           calculate_multiple_payment();
        }
    });
}

function calculate_multiple_payment() {
    var total = 0;
	$(".multiple_pay_input").each(function() {
		if(!isNaN(this.value) && this.value.length!=0) {
			total += parseFloat(this.value);
		}
	});
	
	$('#multiple_payment_total_paid').text(total.toFixed(2));
	
	var total_payable = $('#total_payable').val();
	var due = parseFloat(total_payable) - parseFloat(total);
	$('#multiple_payment_due').text(due.toFixed(2));
	
}

function clearAll() {
    clear_add_customer_form_data();
    select_customer_type('walking');
    $('#cart_body').html('');
    
    $("#partial_paid").prop('required',false);
    $("#cash_on_delivery_paid").prop('required',false);
    $("#mfs_paid").prop('required',false);
    $("#checkNoOrMFSAccNo").prop('required',false);
    $("#bank").prop('required',false);
    $("#delivery_man_id").prop('required',false);
    $("#Chequebank").prop('required',false);
    $("#card_or_mobile_banking").prop('required',false);
    $("#delivery_others_crg").val(0);
    
    //global discount
    $("#cart_discount").val(0);
    $("#discountAmount").val(0);
    $("#d_output_td").html('No');
    
    $("#only_others_crg").val(0);
    $("#note").val('');
    $("#shipping_details").val('');
    
    $('#multiple_pay_tbody').html('');
    $('#select_multiple_payment_type').val(0);
    calculate_multiple_payment();
    
    $('.close_modal').click();
    
    var todays_date = $('#todays_date').val();
    $('#invoice_date').val(todays_date);
    
    $('#myUL').html('');
    $('#product_search').val('');
    $("#partial_paid").val(0);
    calculateSum();
    infinteLoadMore(1);
    
    
}




function success(msg) {
    Toastify({
        text: msg,
        backgroundColor: "linear-gradient(to right, #00BFA6, #6CF5E3)",
        className: "error",
    }).showToast();
    var play = document.getElementById('success1').play(); 
}

function error(msg) {
    Toastify({
        text: msg,
        backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
        className: "error",
    }).showToast();
    var play = document.getElementById('error').play(); 
}







</script>

	
</body>
</html>