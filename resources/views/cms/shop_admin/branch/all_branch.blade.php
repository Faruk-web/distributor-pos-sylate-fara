@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Shop branches</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-danger push" data-toggle="modal" data-target="#modal-block-fadein">Add New Branch</button>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Branch Name</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($branches as $branch)
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$branch->branch_name}}</td>
                            <td>{{$branch->branch_address}}</td>
                            <td width="25%">
                                <a type="button" href="{{url('/admin/edit-branch/'.$branch->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                <!--<button type="button" class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="Permissions">Info</button>-->
                            </td>
                        </tr>
                        @php( $i += 1 )
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('admin.create.branch')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Branch</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm row">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input">Branch Name</label>
                                    <input type="text" class="form-control" id="" required name="branch_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Branch Address</label>
                                    <input type="text" class="form-control" id="" required name="branch_address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Primary Phone Number</label>
                                    <input type="text" class="form-control" required name="branch_phone_1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Optional Phone Number</label>
                                    <input type="text" class="form-control" id="" name="branch_phone_2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Email</label>
                                    <input type="email" class="form-control" id="" name="branch_email">
                                </div>
                            </div>
                            @if(Auth::user()->shop_info->vat_type == 'total_vat')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Vat Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="vat_status_yes" value="yes" required name="vat_status">
                                        <label class="custom-control-label" for="vat_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="vat_status_no" value="no" name="vat_status">
                                        <label class="custom-control-label" for="vat_status_no">No</label>
                                    </div>
                                </div>
                                <div class="form-group d-none" id="vat_rate_parent_div">
                                    <input type="number" class="form-control" id="vat_rate" placeholder="Vat Rate" name="vat_rate" step=any>
                                </div>
                            </div>
                            @else
                                <input type="hidden" name="vat_status" value="no">
                            @endif

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option value="no">No</option>
                                        <option value="percent">Percent</option>
                                        <option value="tk">Tk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Online Sell Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="online_sell_status_yes" value="yes" required name="online_sell_status">
                                        <label class="custom-control-label" for="online_sell_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="online_sell_status_no" value="no" name="online_sell_status">
                                        <label class="custom-control-label" for="online_sell_status_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Sell Note Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="sell_note_yes" value="yes" required name="sell_note">
                                        <label class="custom-control-label" for="sell_note_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="sell_note_no" value="no" name="sell_note">
                                        <label class="custom-control-label" for="sell_note_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Others Charge Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="others_charge_yes" value="yes" required name="others_charge">
                                        <label class="custom-control-label" for="others_charge_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="others_charge_no" value="no" name="others_charge">
                                        <label class="custom-control-label" for="others_charge_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Send SMS Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="sms_status_yes" value="yes" required name="sms_status">
                                        <label class="custom-control-label" for="sms_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="sms_status_no" value="no" name="sms_status">
                                        <label class="custom-control-label" for="sms_status_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Default Printer</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_pos" value="pos" required name="default_printer">
                                        <label class="custom-control-label" for="default_printer_pos">POS</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_general" value="general" name="default_printer">
                                        <label class="custom-control-label" for="default_printer_general">General</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_half_page" value="half_page" name="default_printer">
                                        <label class="custom-control-label" for="default_printer_half_page">Half Page</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="default_printer_no" value="no" name="default_printer">
                                        <label class="custom-control-label" for="default_printer_no">No</label>
                                    </div>
                                </div>
                            </div>
                            
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
        <!-- END Fade In Block Modal -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $('input[type=radio][name=vat_status]').on('change', function() {
                var vat_rate_parent = document.getElementById("vat_rate_parent_div");

                if($(this).val() == 'yes') {
                    vat_rate_parent.classList.remove("d-none");
                    $('#vat_rate').val('');
                    $("#vat_rate").prop('required', true);
                }
                else {
                    vat_rate_parent.classList.add("d-none");
                    $('#vat_rate').val('');
                    $("#vat_rate").prop('required', false);
                }
            });
        </script>
@endsection
