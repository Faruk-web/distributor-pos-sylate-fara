@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<div class="content">
    <div class="block block-rounded">
        <div class="">
            <div class="pb-30">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row p-2">
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->customers)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Customers</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->orders)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Invoice</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->orders)->where('date', date("Y-m-d"))->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Today's Invoice</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        @php( $last_date_invoice = optional($shop_info->orders)->last())
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{date("d M, Y", strtotime(optional($last_date_invoice)->date))}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Last Inv. Date</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->products)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Products</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{number_format($shop_info->sms_limit, 2)}} TK</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">SMS Balance</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->users)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Users</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->banks)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Banks</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-6 col-lg-4 col-md-4">
                                    <a class="block block-rounded block-link-shadow text-center shadow" href="javascript:void(0)">
                                        <div class="block-content block-content-full"> <div class="font-size-h4 text-primary">{{optional($shop_info->shop_branches)->count('id')}}</div> </div>
                                        <div class="block-content py-2 bg-body-light">
                                            <p class="font-w600 font-size-sm text-muted mb-0">Total Branch</p>
                                        </div>
                                    </a>
                                </div>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="shadow">
                              <div class="pl-3 pt-3 border-bottom">
                                  <h4 style="text-align:left"><b>Shop Info</b></h4>
                              </div>
                          
                              <div class="">
                                <div class="text-center shadow p-1 rounded">
                                    <img width="150px" class="img-fluid" src="{{asset(optional($shop_info)->shop_logo)}}" alt="User profile picture" style="padding: 10px;">
                                    <h3 class="profile-username text-center"><b>{{optional($shop_info)->shop_name}}</b></h3>
                                    <p class="text-muted text-center">{{optional($shop_info)->address}}<br>{{optional($shop_info)->phone}}</p>
                                </div>
                                
                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{optional($shop_info)->email}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Website</b> <a class="float-right">{{optional($shop_info)->shop_website}}</a>
                                  </li>
                                  
                                  <li class="list-group-item">
                                    <b>Total Branch</b> <a class="float-right">{{optional($shop_info->shop_branches)->count('id')}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Shop Code</b> <a class="float-right">{{optional($shop_info)->shop_code}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Start Date</b> <a class="float-right">{{date("d M, Y", strtotime(optional($shop_info)->start_date))}}</a>
                                  </li>
                                  <li class="list-group-item bg-primary text-light">
                                    <b>Renew Date</b> <a class="float-right text-light">@if(!empty(optional($shop_info)->renew_date)) {{date('d M, Y', strtotime(optional($shop_info)->renew_date))}} @else <span class="text-danger">Renew Date Not Set.</span> @endif</a>
                                  </li>
                                  <li class="list-group-item">
                                    <button type="button" class="btn btn-rounded btn-outline-secondary btn-block" data-toggle="modal" data-target="#renew_status_modal">Renew Status</button>
                                  </li>
                                  <li class="list-group-item bg-success text-light">
                                    <b>Reseller</b> <a class="float-right text-light">{{optional($shop_info->reseller)->name}}</a>
                                  </li>
                                  
                                </ul>
                            </div>
                                          
                                        
                                      </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="renew_status_modal" tabindex="-1" role="dialog" aria-labelledby="renew_status_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title  text-light" id="renew_status_modalLabel">Recent Renew Status</h5>
        <button type="button" class="close  text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">action Date</th>
              <th scope="col">action By</th>
              <th scope="col">Updated Renew Date</th>
            </tr>
          </thead>
          <tbody>
              @foreach($shop_info->renew_status as $item)
                <tr>
                  <td>{{date("d M, Y", strtotime($item->created_at))}}</td>
                  <td>{{optional($item->user_info)->name}}</td>
                  <td>{{date("d M, Y", strtotime($item->renew_date))}}</td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('super.admin.pending.shop.data') }}",
        columns: [
            {data: 'shop_name', name: 'shop_name'},
            {data: 'shop_code', name: 'shop_code'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'renew_date', name: 'renew_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });

</script>
@endsection
