@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@php( $currency = ENV('DEFAULT_CURRENCY'))
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row shadow rounded p-2 border">
                <div class="col-md-12"><h4><b>SMS Dashboard</b></h4></div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{number_format($shop_settings->sms_limit, 2)}} {{$currency}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Balance</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{$shop_settings->sms_limit/$sms_settings->non_masking_price}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Current SMS Quantity</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{number_format($sms_settings->non_masking_price, 2)}} {{$currency}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Per SMS Price</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{number_format($total_purchase, 2)}} {{$currency}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Total Purchase</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{$daily_sent}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Todays Sent (QTY)</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{$monthly_sent}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">This Month Sent (QTY)</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{$yearly_sent}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">This Year Sent (QTY)</p></div>
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-3">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="font-size-h4 text-primary">{{$total_sent}}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light"><p class="font-w600 font-size-sm text-muted mb-0">Total Sent (QTY)</p></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-default">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="block-title">All Recharge Requests</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">New Recharge Request</button>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-full flex-grow-1 d-flex align-items-center">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Request User</th>
                                    <th>Amount ({{$currency}})</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title text-light" id="exampleModalLabel">New Recharge Requests</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.sms.recharge.request.confirm')}}" method="post" id="form_1">
            @csrf
            <div class="form-group">
                <label for="example-text-input">Amount ({{$currency}})</label>
                <input type="number" step=any class="form-control" id="" required name="rechargeable_amount">
            </div>
            <div class="block-content block-content-full text-right border-top">
                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.sms.panel.recharge.request.data') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'user_name', name: 'user_name'},
            {data: 'rechargeable_amount', name: 'rechargeable_amount'},
            {data: 'is_approved', name: 'is_approved'},
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
    
  });

</script>
@endsection
