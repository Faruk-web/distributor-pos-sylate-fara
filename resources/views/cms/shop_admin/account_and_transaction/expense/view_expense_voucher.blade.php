@extends('cms.master')
@section('body_content')
@php($currency = ENV('DEFAULT_CURRENCY'))
<!-- Page Content -->
<style>
    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }

</style>
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
                            <h4><b>Expense Voucher</b></h4>
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
                            <p class="" style="margin-top: 20px; font-size: 20px; font-weight: bold;">Voucher #{{str_replace("_","/", $voucher_info->voucher_num)}}</p>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-dark text-light text-uppercase">{{$voucher_info->cash_or_cheque}}</button>
                        </div>
                        <div class="col-md-4">
                            <p class="" style="margin-top: 20px; font-size: 20px;">Date. <?php echo date("d M, Y", strtotime($voucher_info->created_at)); ?></p>
                        </div>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <div class="row" id="homeBack">
                        <div class="col-md-12">
                            <div style="padding: 0px 30px;">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                        <td width="80%"><p><b>Pay to / for: </b> {{$voucher_info->head_name->head_name}} @if(!empty($voucher_info->voucher))<br><b>Physical Voucher: </b> {{$voucher_info->voucher}} @endif @if(!empty($voucher_info->file))<br><a target="_blank" class="text-danger" href="{{asset('images/'.$voucher_info->file)}}">Attached file</a> @endif</p></td>
                                        <td width="20%" style="text-align:center;">Amount({{$currency}})</td>
                                        </tr>
                                        <tr>
                                        <td style="border-top: hidden;"><b>Note: </b> {{optional($voucher_info)->note}} </td>
                                        <td style="border-top: hidden; text-align: center;">{{$currency." ".number_format($voucher_info->amount, 2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <td><b>Paid By:</b> @if($voucher_info->cash_or_cheque == 'cash') Cash @elseif($voucher_info->cash_or_cheque == 'cheque') Cheque [ {{optional($voucher_info->bank_info)->bank_name."( ".optional($voucher_info->bank_info)->account_no." )"}} ] @endif</td>
                                        <td>Total: {{number_format($voucher_info->amount, 2)}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="card-footer">
                  <div class="row text-center">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th scope="col">Received / Prepared by</th>
                                      <th scope="col">Account Manager</th>
                                      <th scope="col">Chief Executive Officer</th>
                                      <th scope="col">Head Of Operstions / Director</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr class="text-light">
                                      <th> . </th>
                                      <td> . </td>
                                      <td> . </td>
                                      <td> . </td>
                                    </tr>
                                  </tbody>
                                </table>
                        </div>
                    </div>
                  </div>
                </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <br />
        
        <div class="row hidden-print">
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
