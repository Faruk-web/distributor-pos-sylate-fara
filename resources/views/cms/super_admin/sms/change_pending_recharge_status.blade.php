@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
        <h3>Change SMS Recharge Request Status</h3>
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('super.admin.update.sms.recharge.request.status')}}" method="post">
                    @csrf
                    <div class="block-content font-size-sm row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>
                                        <b>Shop Name: </b> {{$info->shop_info->shop_name}}<br>
                                        <b>Code: </b> {{$info->shop_info->shop_code}}<br>
                                        <b>Address: </b> {{optional($info->shop_info)->address}}<br>
                                        <b>Email: </b> {{optional($info->shop_info)->email}}<br>
                                        <b>Phone: </b> {{optional($info->shop_info)->phone}}<br>
                                        <span class="text-danger"><b>Recharge Amount: </b> {{number_format($info->rechargeable_amount, 2)}}</span><br>
                                        <input type="hidden" value="{{$info->id}}" name="rechargeable_amount_id" />
                                        
                                    </p>
                                    
                                </div>
                            </div>
                            <div class="col-md-6 p-2 shadow rounded">
                                <div class="form-group ">
                                    <label class="d-block">Status</label>
                                    <select class="form-control" id="exampleFormControlSelect1">
                                      <option @if(optional($info)->is_approved == 'pending') selected class="bg-success" @endif value="pending">Pending</option>
                                      <option @if(optional($info)->is_approved == 'approved') selected class="bg-success" @endif value="approved">Approved</option>
                                      <option @if(optional($info)->is_approved == 'cancel') selected class="bg-success" @endif value="cancel">Cancel</option>
                                    </select>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->
@endsection
