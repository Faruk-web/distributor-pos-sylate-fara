@php( $user = Auth::user())
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>POS</title>
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
   <header class="pos-header bg-white">
	   <div class="container-fluid">
		   <div class="row align-items-center">
			   <div class="col-xl-4 col-lg-4 col-md-6">
				   <div class="greeting-text">
					<a href="{{route('/')}}" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i></a> &nbsp;
					<a href="{{route('shop.walking.customer')}}" class="btn btn-info btn-sm"><i class="fas fa-walking"></i> Walking</a> &nbsp;
					<a type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#customer_search_modal"><i class="fas fa-search"></i> Customer</a> &nbsp;
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_add_new_customer">New Customer</button>
                </div>
			   </div>
			   <div class="col-xl-5 col-lg-6 col-md-7 clock-main">
				<div class="clock">
				  <h5 class="card-label mb-0 font-weight-bold text-primary">{{optional($customer_info)->name}} / {{optional($customer_info)->code}} / {{optional($customer_info)->phone}} / {{optional($customer_info)->address}}</h5>
                    <input type="hidden" name="" id="is_walking" value="@if(optional($customer_info)->code == Auth::user()->shop_id.'WALKING') 1 @else 0 @endif">
				</div>
				
			   </div>
			   <div class="col-xl-3 col-lg-3 col-md-12  order-lg-last order-second">

				<div class="topbar justify-content-end">
				 <div class="dropdown mega-dropdown">
					 <div id="id2" class="topbar-item">
						 <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
						     <i class="fa fa-shopping-bag h2 p-1 rounded" style="border: 2px solid #3F3D56; color: #F50057;"> <span id="total_cart_items" class="text-dark">0</span></i>
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
   <div class="text-center p-20 update_mode" style="display: none;"><h1><b>We Are Updating some fetures!</b></h1></div>
   <div class="contentPOS">
	    <div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 order-xl-first order-last">
					<div class="card card-custom gutter-b bg-white border-0">
						<div class="card-body">
                            <p class="text-primary">{{$branch_info->branch_name}}</p>
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
										<option value="">-- Brand --</option>
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
				<div class="col-xl-8 col-lg-10 col-md-10">
				     <div class="">
                     <form action="javascript:void(0)" id="order_confirm" method="post">
                     <!-- <form action="{{route('branch.new.sell.confirm')}}" method="post">
                          -->
                         @csrf
						<div class="card card-custom gutter-b bg-white border-0 table-contentpos">
                                <div class="form-group row">
                                    <div class="input-group col-md-11">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Barcode" autofocus="autofocus" id="product_barcode_search" name="">
                                    </div>
                                    <div class="text-center col-md-1" id="barcode_spin_div"></div>
                                </div>
								<div class="table-datapos">
									<div class="table-responsive" id="printableTable">
										<table id="orderTables" class="display table-bordered" style="width:100%">
											<thead>
												<tr>
													<th width="20%">Name</th>
													<th>Quantity</th>
													<th>Price</th>
													<th>Discount</th>
													<th>Vat</th>
													<th>Subtotal</th>
													<th width="8%" class="text-center no-sort">Action</th>
												</tr>
											</thead>
                                            <input type="hidden" name="" id="individual_vat_status" @if($user->shop_info->vat_type == 'individual_product_vat') value="yes" @else value="no" @endif>
											<tbody id="demo"></tbody>
										</table>
										
									</div>
								</div>
								<div class="card-body">
								<table class="table">
                                      <tbody>
                                            <tr>
                                                <th class="text-right" colspan="2">Total Gross</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="text" id="sums" name="subtotal" value=""
                                                        class="form-control" readonly></input>
                                                </th>
                                            </tr>
                                            @if($branch_info->discount_type == 'tk')
                                            <tr>
                                                <th class="text-right" colspan="2">Discount TK</th>
                                                <th><input type="number" id="discount_TK" name="discount_Tk" value="0"
                                                        class="form-control" step=any><small class="text-danger fw-bold">Discount Permission is coming soon!</small></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="discount_tk_price" name="discount_tk_price"
                                                        value="0" class="form-control" readonly step=any>
                                                </th>
                                            </tr>
                                            @elseif($branch_info->discount_type == 'percent')
                                            <tr>
                                                <th class="text-right" colspan="2">Discount Parcent (%)</th>
                                                <th><input type="number" id="discount_Percent" name="discount_Percent"
                                                        value="0" class="form-control" step=any><small class="text-danger fw-bold">Discount Permission is coming soon!</small></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="discount_Percent_price"
                                                        name="discount_Percent_price" value="0" class="form-control"
                                                        readonly step=any>
                                                </th>
                                            </tr>
                                            @endif

                                            @if($branch_info->vat_status == 'yes' && optional($user->shop_info)->vat_type == 'total_vat')
                                            <tr>
                                                <th class="text-right" colspan="2">VAT(%)</th>
                                                <th><input type="number" id="vat" name="vat" value="{{$branch_info->vat_rate}}"
                                                        class="form-control" readonly></input></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="vat_price" name="vat_price" value="0"
                                                        class="form-control" step=any readonly step=any></input>
                                                </th>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th class="text-right" colspan="2">Sub Total</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="subTotal" name="subTotal" value="0"
                                                        class="form-control" readonly step=any>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th class="text-right" colspan="2">Previous Due</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="previous_due" name="previous_due"
                                                        value="@if($customer_info->balance != 0){{$customer_info->balance}}@else{{0}}@endif"
                                                        class="form-control bg-danger text-light" readonly step=any>
                                                </th>
                                            </tr>
                                            
                                            @if($branch_info->others_charge == 'yes')
                                            <tr>
                                                <th class="text-right" colspan="2">Others Charge</span></th>
                                                <th><input type="number" id="only_others_crg" name="only_others_crg"
                                                        value="0" class="form-control" step=any></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="only_others_crg_tk"
                                                        name="only_others_crg_tk" value="0" class="form-control"
                                                        readonly step=any>
                                                </th>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th class="text-right" colspan="2">Total Payable</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="total_payable" name="total_payable"
                                                        class="form-control bg-success text-light" value="0" step=any readonly>
                                                </th>
                                            </tr>
                                        </tbody>
									</table>

                                    <hr class="bg-warning">
                                    @if($branch_info->sell_note == 'yes')
                                    <div class="form-group">
                                        <label for="date">Note.</label>
                                        <textarea id="w3review" name="note" class="form-control" rows="2"
                                            cols="50">Note</textarea>
                                    </div>
                                    @endif
                                    <hr class="bg-warning">
                                    <input type="hidden" name="customer_id" id="" class="form-control"
                                        value="{{$customer_info->id}}" required>
                                    <input type="hidden" name="submit_from" id="submit_from" value="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ date('Y-m-d') }}" required />
                                            </div>
                                        </div>
                                        
                                        @if($branch_info->sms_status == 'yes' && $customer_info->code != $user->shop_id."WALKING")
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Send SMS</label><br>
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
                                        @endif
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <!--this is for Full Payment Start-->
                                        <div class="col-md-3">
                                            <button type="button" onclick="payment_for('full_payment')" class="btn btn-primary btn-lg btn-block"
                                                data-toggle="modal" data-target="#fullPayment"> <i class="fas fa-money-bill-wave mr-2"></i> Full Payment</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="fullPayment" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><b>Take Full
                                                                    Payment</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="date">Paid</label>
                                                                <input type="number" name="full_payment"
                                                                    id="full_payment" class="form-control" value="0"
                                                                    step=any readonly />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="Full_payment_submit" name="Full_payment_submit"
                                                                class="btn btn-success" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for Full Payment End-->

                                        
                                        @if($customer_info->code != $user->shop_id."WALKING")
                                        <!--this is for Partial Payment Start-->
                                        <div class="col-md-3">
                                            <button type="button" onclick="payment_for('partial_payment')" class="btn btn-warning btn-lg btn-block"
                                                data-toggle="modal" data-target="#partialPayment">Partial
                                                Payment</button>

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
                                                                <input type="number" name="partial_paid"
                                                                    id="partial_paid" class="form-control" value=""
                                                                    step=any>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date">Current Due</label>
                                                                <input type="number" name="partial_due" id="partial_due"
                                                                    class="form-control" value="" readonly step=any>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                            <input type="submit"  id="partial_payment_submit" name="partial_payment_submit"
                                                                class="btn btn-success" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for Partial Payment End-->

                                        
                                        @if($branch_info->online_sell_status == 'yes')
                                        <!--this is for Cash On Delivery Payment Start-->
                                        <div class="col-md-3">
                                            <button type="button"  onclick="payment_for('cash_on_payment')" class="btn btn-info btn-lg btn-block"
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
                                                                <label for="date">Shipping Charge</label>
                                                                <input type="number" id="delivery_others_crg" name="delivery_others_crg" value="0" class="form-control" step=any>
                                                                <input type="hidden" id="delivery_others_crg_tk" name="delivery_others_crg_tk" value="0" class="form-control" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date">Shipped By</label>
                                                                <select name="delivery_man_id" id="delivery_man_id" class="form-control">
                                                                    <option value="">Select Shipping ...</option>
                                                                    @foreach($delivery_man as $ship)
                                                                        <option value="{{$ship->id}}">{{$ship->name}} [{{$ship->phone}}]</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="date">Paid</label>
                                                                <input type="number" name="cash_on_delivery_paid"
                                                                    id="cash_on_delivery_paid" class="form-control"
                                                                    value="0" step=any>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="date">Current Due</label>
                                                                <input type="number" name="cash_on_delivery_due"
                                                                    id="cash_on_delivery_due" class="form-control"
                                                                    value="" readonly step=any>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
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
                                        @endif
                                    
                                        <!--this is for MFS Payment Start-->
                                        <div class="col-md-3">
                                            <button type="button" onclick="payment_for('cheque_payment')" class="btn btn-dark btn-lg btn-block" data-toggle="modal" data-target="#takeMFS">MFS</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="takeMFS" tabindex="-1" role="dialog"
                                                aria-labelledby="takeMFS" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        <b>Take MFS Payment</b></h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="number" name="" id="mfs_paid_for_show"
                                                                        class="form-control bg-success text-light" value=""
                                                                        step=any readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-2 col-form-label">Paid</label>
                                                                <div class="col-sm-10">
                                                                    <input type="number" name="mfs_paid" id="mfs_paid"
                                                                        class="form-control" value="" step=any>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputName"
                                                                    class="col-sm-2 col-form-label">Current Due</label>
                                                                <div class="col-sm-10">
                                                                    <input type="number" name="mfs_current_due"
                                                                        id="mfs_current_due" class="form-control"
                                                                        value="" step=any readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="inputName"
                                                                            class="col-sm-12 col-form-label">Cheque No.
                                                                            / MFS Acc No.</label>
                                                                        <input type="text" class="form-control" id="checkNoOrMFSAccNo" name="checkNoOrMFSAccNo">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="inputName"
                                                                            class="col-sm-12 col-form-label">MFS Acc
                                                                            Type</label>
                                                                                <select name="MFSAccType" class="form-control MFSAccType">
                                                                                    <option value="">Select One</option>
                                                                                    <option value="Bkash">Bkash</option>
                                                                                    <option value="Rocket">Rocket</option>
                                                                                    <option value="Nagad">Nagad</option>
                                                                                    <option value="mCash">mCash</option>
                                                                                    <option value="T-Cash">T-Cash</option>
                                                                                    <option value="Others">Others</option>
                                                                                </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="inputName"
                                                                            class="col-sm-12 col-form-label">Cheque
                                                                            Bank</label>
                                                                        <input type="text" id="Chequebank" class="form-control"
                                                                            name="Chequebank">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="inputName"
                                                                            class="col-form-label">Cheque / MFS Diposit
                                                                            to</label>
                                                                        <select class="form-control" id="bank"
                                                                            name="Dipositbank">
                                                                            <option value="">Select A bank</option>
                                                                            @foreach($banks as $bank)
                                                                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{$bank->bank_branch}}]</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="inputName" class="col-sm-12 col-form-label">Cheque Date.</label>
                                                                        <input type="date" name="Chequedate" id="Chequedate" class="form-control" required value="{{ date('Y-m-d') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="inputName"
                                                                            class="col-form-label">Cheque Diposit
                                                                            Date.</label>
                                                                        <input type="date" name="DipositDate"
                                                                            id="DipositDate" class="form-control"
                                                                            required
                                                                            value="{{ date('Y-m-d') }}">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" id="mfs_payment_confrim">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--this is for MFS Payment End-->
                                    </div>
								</div>
						</div>
                    </form>	
					 </div>	
				 </div>
			</div>
		</div>
   </div>

   <!-- Customer Search Modal -->
    <div class="modal fade" id="customer_search_modal" tabindex="-1" role="dialog" aria-labelledby="customer_search_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body mb-10">
            <div class="form-group shadow rounded p-3">
                <input type="text" class="form-control" id="customer_search"
                    placeholder="Search by Customer info (name, phone, code)" name="company_name">
            </div>
            <div class="card-body shadow rounded">
                <table class="table table-bootstrap">
                    <tbody id="customer_show_info"></tbody>
                </table>
            </div>
        </div>
        </div>
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
            <form action="{{route('branch.add.new.customer.from.sell')}}" method="post">
                @csrf
                <div class="block-content font-size-sm">
                    <div class="form-group">
                        <label class="control-label" for="filebutton"><span
                                class="text-danger">*</span>Customer Name</label>
                        <input type="text" name="name" class="form-control" id="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="filebutton"><span
                                class="text-danger">*</span>Phone Number (max: 11)</label>
                        <input type="text" maxlength="11" name="phone" class="form-control"
                            id="check_customer_phone_from_sell" required>
                        <div id="add_customer_phone_output"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="filebutton">Email</label>
                        <input type="email" name="email" class="form-control"
                            id="check_customer_email_from_sell">
                        <div id="add_customer_email_output"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="filebutton">Address</label>
                        <input type="text" name="address" class="form-control" id="">
                    </div>

                </div>
                <div class="block-content block-content-full text-right border-top">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger mr-1"
                        data-dismiss="modal">Close</button>
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
    // Begin:: Customer Search for stock in
    $('#customer_search').keyup(function () {
        var customer_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/branch/stock-out/search-customer',
            data: {
                'customer_info': customer_info
            },
            success: function (data) {
                $('#customer_show_info').html(data);
            }
        });
    });
    // End:: Customer Search for stock in


    // Begin:: Add New Customer phone number check
    $('#check_customer_phone_from_sell').keyup(function () {
        var phone = $(this).val();
        if (phone.length == 11) {
            $.ajax({
                type: 'get',
                url: '/branch/search/customer-phone',
                data: {
                    'phone': phone
                },
                success: function (data) {
                    $('#add_customer_phone_output').html(data);
                }
            });
        } else {
            $('#add_customer_phone_output').html('');
        }
    });
    // End:: Add New Customer phone number check

    // Begin:: Add New Customer phone number check
    $('#check_customer_email_from_sell').keyup(function () {
        var email = $(this).val();
        if (email.indexOf('.com') !== -1) {
            $.ajax({
                type: 'get',
                url: '/branch/search/customer-email',
                data: {
                    'email': email
                },
                success: function (data) {
                    $('#add_customer_email_output').html(data);
                }
            });
        } else {
            $('#add_customer_email_output').html('');
        }
    });
    // End:: Add New Customer phone number check


    // Category name to brand find out
    $(document).ready(function () {
        $('#catValue').on('change', function () {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    type: 'get',
                    url: '/branch/sell/category-to-brand-search',
                    data: {
                        'category_id': category_id
                    },
                    success: function (data) {
                        $('#brandValue').html(data);
                        get_products();
                    }
                });
            } else {
                $('#brandValue').html('<option value="">Select Category first</option>');
                get_products();
            }
        });

        $('#brandValue').on('change', function () {
            get_products();
        });

    });
    // Category name to brand find out

    // Begin:: Customer Search for stock in
    $('#product_search').keyup(function () {
        get_products();
    });
    // End:: Customer Search for stock in

    function get_products() {
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();
        var brand_id = $('#brandValue').find(":selected").val();
        $.ajax({
            type: 'get',
            url: '/branch/product-search-into-sell',
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'brand_id': brand_id
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
                swal({
                    title: "Error",
                    text: "Error occured.please try again",
                    icon: "error",
                    button: "Ok",
                });
                var play = document.getElementById('error').play();
            },
            complete: function () {
                //alert('complete');
            },
        });

    }

    var ENDPOINT = "{{ url('/') }}";
    infinteLoadMore(1);

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
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();
        var brand_id = $('#brandValue').find(":selected").val();
        $.ajax({
            type: 'get',
            datatype: "html",
            url: ENDPOINT + "/get_products_from_sell?page=" + page,
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'brand_id': brand_id
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
                swal({
                    title: "Error",
                    text: "Error occured.please try again",
                    icon: "error",
                    button: "Ok",
                });
                var play = document.getElementById('error').play();
            },
            complete: function () {
                //alert('complete');
            },
        });
    }

</script>
<!-- End::product load and search and others end -->


<script>


var product_storage = [];

function deleteFromArray(productName){
    const index = product_storage.indexOf(productName);
    if (index > -1) {
      product_storage.splice(index, 1);
    }
}

function myFunction(id, name, descriptionP, price,quantity, unit_name, discount, discount_amount, vat_rate) {
    var x = document.getElementsByClassName("quantity");
    var flat_discount = 0;
    var discount_percent = 0;
    if(quantity > 0) {
        if(product_storage.indexOf(name) !== -1){
            var cr_qty = $('.pid_'+id).val();
            if(cr_qty < quantity) {
                var up_qty = parseInt(cr_qty) + parseInt(1);
                $('.pid_'+id).val(up_qty);
                var play = document.getElementById('success1').play();
                multiply();
                calculateSum();
            }
            else {
                Toastify({
                    text: "Quantity is over than stock!",
                    backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                    className: "error",
                }).showToast();
                var play = document.getElementById('error').play();
            }
        }
        else{
            if($('#individual_vat_status').val() === 'no'){ vat_rate = 0; }
            if(discount === 'percent') { discount_percent = discount_amount; } else if(discount === 'flat') { flat_discount = discount_amount; }
            $('#demo').prepend('<tr><td class="t_tittle" id="t_tittle"><input type="hidden" name="pid[]" value="'+id+'"><input type="hidden" id="product_storage" name="product_storage" class="product_name" value="'+name+'">'+name+' <br /> <span class="text-success">'+descriptionP+'</span></td><td><input type="number" step=any value="1" class="form-control border-dark w-100px quantity pid_'+id+'" id="quantity" name="quantity[]"  max="'+quantity+'"> <span class="text-danger">Max: '+quantity+' '+unit_name+'</span></td><td><input type="number" step=any value="'+price+'" class="form-control border-dark w-100px pricesum" id="price" name="price[]"></td><td><span>Percent: </span><input type="number" step=any value="'+discount_percent+'" class="form-control-sm border-dark w-100px discount_percent" onchange="change_indv_p_discount_percent('+id+')" onkeyup="change_indv_p_discount_percent('+id+')"  id="disCP_'+id+'" name="disCP[]"><br /><span>Flat Rate: </span><input type="number" step=any value="'+flat_discount+'" class="form-control-sm flat_discount border-dark w-100px" onkeyup="change_indv_p_flat_discount('+id+')" onchange="change_indv_p_flat_discount('+id+')" id="disC_flat_'+id+'" name="disC_flat[]"></td><td><input type="number" readonly step=any value="'+vat_rate+'" class="form-control-sm border-dark w-70px individual_product_vat" id="individual_product_vat" name="individual_product_vat[]"></td><td><input type="number" step=any value="" class="form-control-sm border-dark w-70px total" readonly id="total" name="total[]"></td><td><div class="card-toolbar text-center"><span><i class="fas fa-trash-alt text-danger remove btnSelect"></i></span></div></td></tr>');
            product_storage.push(name);
            calculateSum();
            multiply();
            var play = document.getElementById('success1').play();
        }
    }
    else {
        Toastify({
            text: "Empty Stock",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        var play = document.getElementById('error').play();
    }
}

//product barcode to product
    $('#product_barcode_search').keypress(function(e) {
        var barcode = $('#product_barcode_search').val();
        if(e.which == 13 && barcode != '') {
            jQuery(this).blur();
            $.ajax({
                type: 'get',
                url: '/branch/product-search-from-barcode',
                data: { 'barcode': barcode, },
                beforeSend: function () {
                    $('#barcode_spin_div').html('<div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div>');
                },
                success: function (data) {
                    if(data['exist'] == 'yes') {
                        if(data['stock'] > 0) {
                            console.log(data['unit_name']);
                            myFunction(data['pid'], data['p_name'], '', data['selling_price'], data['stock'], data['unit_name'], data['discount'], data['discount_amount'], data['vat_rate']);
                        }
                        else {
                            Toastify({
                                text: data['p_name'] + "Stock is empty.",
                                backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                                className: "error",
                            }).showToast();
                            var play = document.getElementById('error').play(); 
                        }
                    }
                    else {
                        Toastify({
                            text: "Product is not exist",
                            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                            className: "error",
                        }).showToast();
                        var play = document.getElementById('error').play(); 
                    }

                    $('#barcode_spin_div').html('');
                    $('#product_barcode_search').val('');
                    $('#product_barcode_search').focus();
                },
                error: function (xhr) {
                    swal({
                        title: "Error",
                        text: "Error occured.please try again",
                        icon: "error",
                        button: "Ok",
                    });
                    var play = document.getElementById('error').play();
                    $('#barcode_spin_div').html('');
                    $('#product_barcode_search').val('');
                    $('#product_barcode_search').focus();
                },
                complete: function () {
                    //alert('complete');
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
				
$(".pricesum").on("click change paste keyup cut select", function() {
	calculateSum();
	});
});

$( document ).ready(function() {
    $(document).on("click change paste keyup cut select", "#price", function() {
        multiply();
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#quantity", function() {
        calculateSum();
		multiply();
    }); 
    
     
    $(document).on("click change paste keyup cut select", "#discount_Percent", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#discount_TK", function() {
        calculateSum();
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
     
    
    
});

function change_indv_p_discount_percent(product_id) {
    $('#disC_flat_'+product_id).val(0);
    multiply();
    calculateSum();
}

function change_indv_p_flat_discount(product_id) {
    $('#disCP_'+product_id).val(0);
    multiply();
    calculateSum();
}




function calculateSum() {
        var sum = 0;
        
		//iterate through each textboxes and add the values
		$(".total").each(function() {
			//add only if the value is number
			if(!isNaN(this.value) && this.value.length!=0) {
				sum += parseFloat(this.value);
			}
		});
		//.toFixed() method will roundoff the final sum to 2 decimal places
		
        // document.getElementsByClassName('sum')[0].innerText = sum
        document.getElementById("sums").value = sum;
		$("#sums").val(sum.toFixed(2));
	
        // discount taka or percent start
          var discountTk = $("#discount_TK").val();
          var discountParcent = $('#discount_Percent').val();
          if(typeof(discountTk) != 'undefined' && discountTk != null) {
              sum = parseFloat(sum) - parseFloat(discountTk);
              $("#discount_tk_price").val(discountTk);
          }
          else if(typeof(discountParcent) != 'undefined' && discountParcent != null) {
            var discountParcentTk = (discountParcent * sum)/100;
            sum = parseFloat(sum) - parseFloat(discountParcentTk);
            $("#discount_Percent_price").val(discountParcentTk.toFixed(2));
         }
        // discount taka or percent End

        // vat parcent and vat parcent rate start
        var vatParcent = $("#vat").val();
        if(typeof(vatParcent) != 'undefined' && vatParcent != null){ 
            var vatParcentPrice = sum*vatParcent/100;
            sum = parseFloat(sum) + parseFloat(vatParcentPrice);
            $("#vat_price").val(vatParcentPrice.toFixed(2));
        }
        // vat parcent and vat parcent rate End

        $("#subTotal").val(sum.toFixed(2));
        var previousDue = $('#previous_due').val();
        var sum = parseFloat(sum) + parseFloat(previousDue);

        //Others Charge 
        var others_charge = $("#only_others_crg").val();
        //alert(others_charge);
        if(typeof(others_charge) != 'undefined' && others_charge != null){ 
            if(others_charge == ''){
                others_charge = 0;
            }
            sum = parseFloat(sum) + parseFloat(others_charge);
            $("#only_others_crg_tk").val(parseFloat(others_charge));
        }
        //Others Charge

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
        
        $("#total_payable").val(sum.toFixed(2));
        
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
            vat_price = sum*individual_product_vat/100;
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
            sum = sum+vat_price;
            document.getElementsByClassName('total')[i].value=sum.toFixed(2);
            
    }
    calculateSum();
}   

</script>

<!--This is for product delete-->
<script>

$(document).ready(function(){

$("#orderTables").on('click', '.btnSelect', function() {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
           // get the current row
            var currentRow = $(this).closest("tr");
            $(this).parents("tr").remove();
            var product_name = currentRow.find(".product_name").val(); // get current row 2nd table cell TD value
            deleteFromArray(product_name);
            calculateSum();
            multiply();
            //var play = document.getElementById('success').play();
        }
    });
});


});


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
        $("#delivery_others_crg").val(0);
        
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
        $("#delivery_others_crg").val(0);
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
        
    }
    else if(track == 'cheque_payment') {
        $('#submit_from').val('cheque_payment');
        $("#partial_paid").prop('required',false);
        $("#cash_on_delivery_paid").prop('required',false);
        $("#mfs_paid").prop('required',true);
        $("#checkNoOrMFSAccNo").prop('required',true);
        $("#bank").prop('required',true);
        $("#delivery_man_id").prop('required',false);
        $("#Chequebank").prop('required',true);
        $("#delivery_others_crg").val(0);
        
        var is_walking = $('#is_walking').val();
        if(is_walking == 1) {
            var totaL_pay = $('#total_payable').val();
            $('#mfs_paid').val(totaL_pay);
            $('#mfs_paid').prop('readonly', true);
            $('#mfs_current_due').val(0);
            
        }
    }
    calculateSum();
}

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

        //$('#send_form').html('Sending..');
        
        $.ajax({
            url: "{{ url('/branch/new-sell-confirm-by-ajax')}}",
            method: 'post',
            data: $('#order_confirm').serialize(),
            beforeSend: function() {
                $('.se-pre-con').show();
            },
            success: function(response){
                //console.log(response);
                if(response['status'] == 'yes') {
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
                    location.replace("{{ route('shop.walking.customer') }}");
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
        Toastify({
            text: "Error Occoured!",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        var play = document.getElementById('error').play(); 
    }
}



function relese_update_mode() {
    $('.update_mode').hide();
    $('.contentPOS').show();
    
}



</script>

	
</body>
</html>