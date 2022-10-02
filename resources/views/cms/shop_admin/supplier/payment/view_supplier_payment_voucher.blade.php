@extends('cms.master')
@section('body_content')
@php($currency = ENV('DEFAULT_CURRENCY'))
<!-- Page Content -->
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
        <div class="container-fluid">
        <div class="row">
          <div class="col-12" style="padding: 0px 30px;">
            <!-- /.card -->
                <div class="card" style="border: 2px solid black">
                  <div class="card-header text-center">
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <img style="width: 200px;" class="card-img-top" src="{{asset(optional($shop_info)->shop_logo)}}" alt="Card image cap">
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-center "><b>{{optional($shop_info)->shop_name}}</b></h2>
                            <p class="text-center">{{optional($shop_info)->address}}<br>Cell : {{optional($shop_info)->phone}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4><b>Payment Voucher</b></h4>
                               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                  <label class="btn btn-secondary active">
                                    <input type="radio" name="options" id="option1" autocomplete="off" checked> Debit
                                  </label>
                                  <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="option2" autocomplete="off"> Voucher
                                  </label>
                                  <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="option3" autocomplete="off"> 
                                  </label>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <p class="" style="margin-top: 20px; font-size: 20px; font-weight: bold;">Voucher # {{str_replace("_","/", $voucher_info->voucher_number)}}</p>
                        </div>
                        <div class="col-md-4">
                            <button type="button" style="margin-top: 10px;" class="btn btn-outline-dark"><h5><b>Supplier Payment Voucher</b></h5></button>
                        </div>
                        <div class="col-md-4">
                            <p class="" style="margin-top: 20px; font-size: 20px;">Date. <?php echo date("d M, Y", strtotime($voucher_info->created_at)); ?></p>
                        </div>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <div class="row" id="homeBack">
                        <div class="col-md-12">
                            
                            <p class=""  style="font-size: 18px; font-family: Helvetica;"><b>Payment With Thanks From Mr. / Mrs. </b>{{optional($voucher_info->supplier_info)->name}}<br>
                               <span style="font-size: 15px;"><b>Address: </b>{{optional($voucher_info->supplier_info)->address}}<b>, Phone:</b> {{optional($voucher_info->supplier_info)->phone}}
                               <b>Payment By: </b> @if($voucher_info->paymentBy == 'cash') Cash @elseif($voucher_info->paymentBy == 'cheque') {{optional($voucher_info->bank_info)->bank_name}} [{{optional($voucher_info->bank_info)->account_no}}] [Cheque Num: {{$voucher_info->cheque_num}}] @endif
                               </span></p>
                                <div style="padding: 0px 90px;">
                                <table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td><b>Total Amount</b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->due, 2)}}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td><b>Paid </b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->paid, 2)}}</td>
                                        </tr>
                                        <tr>
                                          <td><b>Total Due </b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->due-optional($voucher_info)->paid, 2)}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    </div>
                        </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <p style="padding-top: 15px;">
                                <b>...........................................</b><br>
                                Authorized Signature</p>
                        </div>
                        <div class="col-md-6" >
                           <p style="padding-top: 15px;"><b>...........................................</b><br>
                                Receiver Signature</p>
                        </div>
                    </div>
                  </div>
                </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <br />
        <div class="row">
        <div class="col-12" style="padding: 0px 30px;">
            <!-- /.card -->
                <div class="card" style="border: 2px solid black">
                  <div class="card-header text-center">
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <img style="width: 200px;" class="card-img-top" src="{{asset(optional($shop_info)->shop_logo)}}" alt="Card image cap">
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-center "><b>{{optional($shop_info)->shop_name}}</b></h2>
                            <p class="text-center">{{optional($shop_info)->address}}<br>Cell : {{optional($shop_info)->phone}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4><b>Payment Voucher</b></h4>
                               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                  <label class="btn btn-secondary active">
                                    <input type="radio" name="options" id="option1" autocomplete="off" checked> Debit
                                  </label>
                                  <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="option2" autocomplete="off"> Voucher
                                  </label>
                                  <label class="btn btn-secondary">
                                    <input type="radio" name="options" id="option3" autocomplete="off"> 
                                  </label>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <p class="" style="margin-top: 20px; font-size: 20px; font-weight: bold;">Voucher # {{str_replace("_","/", $voucher_info->voucher_number)}}</p>
                        </div>
                        <div class="col-md-4">
                            <button type="button" style="margin-top: 10px;" class="btn btn-outline-dark"><h5><b>Supplier Payment Voucher</b></h5></button>
                        </div>
                        <div class="col-md-4">
                            <p class="" style="margin-top: 20px; font-size: 20px;">Date. <?php echo date("d M, Y", strtotime($voucher_info->created_at)); ?></p>
                        </div>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <div class="row" id="homeBack">
                        <div class="col-md-12">
                            
                            <p class=""  style="font-size: 18px; font-family: Helvetica;"><b>Payment With Thanks From Mr. / Mrs. </b>{{optional($voucher_info->supplier_info)->name}}<br>
                               <span style="font-size: 15px;"><b>Address: </b>{{optional($voucher_info->supplier_info)->address}}<b>, Phone:</b> {{optional($voucher_info->supplier_info)->phone}}
                               <b>Payment By: </b> @if($voucher_info->paymentBy == 'cash') Cash @elseif($voucher_info->paymentBy == 'cheque') {{optional($voucher_info->bank_info)->bank_name}} [{{optional($voucher_info->bank_info)->account_no}}] [Cheque Num: {{optional($voucher_info)->cheque_num}}] @endif
                               </span></p>
                                <div style="padding: 0px 90px;">
                                <table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td><b>Total Amount</b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->due, 2)}}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td><b>Paid </b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->paid, 2)}}</td>
                                        </tr>
                                        <tr>
                                          <td><b>Total Due </b></td>
                                          <td>{{$currency}} {{number_format(optional($voucher_info)->due-optional($voucher_info)->paid, 2)}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    </div>
                        </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <p style="padding-top: 15px;">
                                <b>...........................................</b><br>
                                Authorized Signature</p>
                        </div>
                        <div class="col-md-6" >
                           <p style="padding-top: 15px;"><b>...........................................</b><br>
                                Receiver Signature</p>
                        </div>
                        <div class="col-md-12 text-left">
                            <p><b>Received by: </b> {{optional($voucher_info->user_info)->name}}</p>
                            <p><b>Note: </b>{{optional($voucher_info)->note}}</p>
                        </div>
                        
                    </div>
                  </div>
                </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <br />
        <div class="row">
                        <div class="col-md-4 text-left">
                            <button style="padding: 10px;" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
                        </div>
                        
                    </div>
        
        <!-- /.row -->
      </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

@endsection
