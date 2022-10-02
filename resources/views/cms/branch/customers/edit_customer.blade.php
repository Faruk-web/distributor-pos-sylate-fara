@extends('cms.master')
@section('body_content')
<div class="content">
    <div class="block block-rounded">
        <div class="block block-rounded block-themed block-transparent mb-0">
            <form action="{{url('/branch/update-customer/'.$customer->id)}}" method="post" id="form_1">
                @csrf
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-light">Update Customer</h3>
                </div>
                <div class="block-content font-size-sm row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Customer Name</label>
                            <input type="text" class="form-control" value="{{ $customer->name }}" required name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input"><span class="text-danger">*</span>Customer Phone Number</label>
                            <input type="text" class="form-control" value="{{ $customer->phone }}" maxlength="11" minlength="11" required name="phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Customer Email</label>
                            <input type="text" class="form-control" value="{{ $customer->email }}" name="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Customer Address</label>
                            <input type="text" class="form-control" value="{{ $customer->address }}" name="address">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Opening Balance</label>
                            <input type="number" class="form-control" readonly value="{{$customer->opening_bl}}" step=any name="opening_bl" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Customer Type</label>
                            <select class="form-control" name="customer_type" id="">
                                <option value="">-- Select Type --</option>
                                @foreach($customer_types as $type)
                                <option @if($type->id == $customer->customers_type_id) selected class="bg-success" @endif value="{{$type->id}}">{{$type->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input">Is Comissioned Customer?</label>
                            <select class="form-control comissioned_customer" id="">
                                <option @if(optional($customer)->is_comissioned == '' || optional($customer)->is_comissioned == 0) selected class="bg-success" @endif value="no">No</option>
                                <option @if(optional($customer)->is_comissioned != '' || optional($customer)->is_comissioned != 0) selected class="bg-success" @endif  value="yes">Yes</option>
                            </select>
                        </div>
                        <div id="comissioned_value_div" class="form-group rounded shadow p-2" @if(optional($customer)->is_comissioned == '' || optional($customer)->is_comissioned == 0)  style="display: none;" @endif>
                            <label for="example-text-input">Comission Value</label>
                            <input type="number" class="form-control" value="{{optional($customer)->is_comissioned}}" step=any name="comission_value">
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-right border-top">
                    <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $('select.comissioned_customer').on('change', function() {
        var value = this.value;
        if(value == 'no') {
            $("#comissioned_value_div").hide();
        }
        else if(value == 'yes') {
            $("#comissioned_value_div").show();
        }
    });
</script>

@endsection
