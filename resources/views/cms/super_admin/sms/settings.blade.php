@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
        <h3>SMS Setting</h3>
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('super.admin.update.sms.settings')}}" method="post">
                    @csrf
                    <div class="block-content font-size-sm row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Masking SMS Price (tk)</label>
                                    <input type="number" class="form-control" id="others_charge_yes" value="{{optional($info)->masking_price}}" name="masking_price" step=any required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Non Masking SMS Price (tk)</label>
                                    <input type="number" class="form-control" id="others_charge_yes" step=any value="{{optional($info)->non_masking_price}}" name="non_masking_price" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
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
