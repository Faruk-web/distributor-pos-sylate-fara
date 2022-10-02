@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">All Delivery man or System</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-primary push" data-toggle="modal" data-target="#modal-block-fadein">Add New</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Delivery man Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Branch</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($delivery_mans as $deliveryMan)
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$deliveryMan->name}}</td>
                            <td>{{$deliveryMan->address}}</td>
                            <td>{{$deliveryMan->phone}}</td>
                            <td>@if($deliveryMan->branch_id == '') All Branch @else {{optional($deliveryMan->branchName)->branch_name}} @endif</td>
                            <td width="25%">
                                <a type="button" href="{{url('/admin/edit-deliveryMan/'.$deliveryMan->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                @if($deliveryMan->active == 1)
                                    <a type="button" href="{{url('/admin/deactive-deliveryMan/'.$deliveryMan->id)}}" class="btn btn-sm btn-success" data-toggle="tooltip" title="DeliveryMan is active now, click to deactive">Active</a>
                                @else
                                    <a type="button" href="{{url('/admin/active-deliveryMan/'.$deliveryMan->id)}}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="DeliveryMan is deactive now, click to active">Deactive</a>
                                @endif
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
                    <form action="{{route('admin.create.deliveryMan')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New delivery Man</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Delivery Man or system Name</label>
                                    <input type="text" class="form-control" id="" required name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Delivery Man or system Email</label>
                                    <input type="text" class="form-control" id="" required name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Delivery Man or system Address</label>
                                    <input type="text" class="form-control" id="" required name="address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Delivery Man or system Phone Number</label>
                                    <input type="text" class="form-control" maxlength="11" minlength="11" required name="phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Password (min: 8)</label>
                                    <input type="password" class="form-control" id="password" required name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" required name="password_confirmation">
                                    <span class="text-danger d-none" id="password_not_matched">Password Not Matched</span>
                                    <span class="text-success d-none" id="password_matched">Password Matched</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-block">For What</label>

                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="all_branch" value="" required name="branch_id">
                                        <label class="custom-control-label" for="all_branch">All Branch</label>
                                    </div>
                                    @foreach($branches as $branch)
                                    <div class="custom-control custom-radio custom-control-inline custom-control-info">
                                        <input type="radio" class="custom-control-input" id="for_{{$branch->id}}_branch" value="{{$branch->id}}" name="branch_id">
                                        <label class="custom-control-label" for="for_{{$branch->id}}_branch">{{$branch->branch_name}}</label>
                                    </div>
                                    @endforeach
                                    
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
            $("#confirm_password").on("change paste keyup cut select", function() {
                var password_matched = document.getElementById("password_matched");
                var password_not_matched = document.getElementById("password_not_matched");

                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();
                if(password == confirm_password && password != '') {
                    password_matched.classList.remove("d-none");
                    password_not_matched.classList.add("d-none");
                }
                else if(password == '' || confirm_password == ''){
                    password_matched.classList.add("d-none");
                    password_not_matched.classList.add("d-none");
                }
                else {
                    password_matched.classList.add("d-none");
                    password_not_matched.classList.remove("d-none");
                }
            });
        </script>
@endsection
