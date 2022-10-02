@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">All CRM</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-info push" data-toggle="modal" data-target="#modal-block-fadein">Add New CRM</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>CRM Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($crms as $crm)
                        @php( $role_name = DB::table('roles')->where('id', $crm->role_id)->first() )
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$crm->name}}</td>
                            <td>{{$crm->address}}</td>
                            <td>{{$crm->phone}}</td>
                            <td>@if($crm->type == 'branch_user') 
                                @php( $branch_info = DB::table('branch_settings')->where('id', $crm->branch_id)->where('shop_id', Auth::user()->shop_id)->first('branch_name'))
                                <span class="text-bold text-info">Branch User</span><br>
                                <span style="font-size: 13px; color: #F50057;" class="text-bold">Branch Name: {{$branch_info->branch_name}}</span>
                                @elseif($crm->type == 'owner_helper') <span class="text-bold text-warning">Admin Helper</span> @endif</td>
                            <td>{{str_replace(Auth::user()->shop_id."#","", $role_name->name)}}</td>
                            <td width="30%">
                                <a type="button" href="{{url('/admin/edit-crm/'.$crm->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                @if($crm->active == 1)
                                    <a type="button" href="{{url('/admin/deactive-crm/'.$crm->id)}}" class="btn btn-sm btn-success" data-toggle="tooltip" title="CRM is active now, click to deactive">Active</a>
                                @else
                                    <a type="button" href="{{url('/admin/active-crm/'.$crm->id)}}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="CRM is deactive now, click to active">Deactive</a>
                                @endif
                                <!--<button type="button" onclick="reset_password('{{$crm->name}}', '{{$crm->id}}')" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#password_reset_modal">Reset Password</button>-->

                                
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

<!-- Modal -->
<!--<div class="modal fade" id="password_reset_modal" tabindex="-1" role="dialog" aria-labelledby="password_reset_modal" aria-hidden="true">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header bg-dark">-->
<!--        <h5 class="modal-title text-light" id="password_reset_modal">Reset Password</h5>-->
<!--        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">&times;</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <form action="{{route('admin.reset.crm.password')}}" method="post">-->
<!--            @csrf-->
<!--            <div class="form-group text-center">-->
<!--                <span class="text-success text-center h4" id="password_reset_crm_name"></span>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="example-text-input"><span class="text-danger">*</span>Your Password</label>-->
<!--                <input type="password" class="form-control" id="" required name="your_password">-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="example-text-input"><span class="text-danger">*</span>New Password</label>-->
<!--                <input type="password" class="form-control" id="" minlength="8" required name="password">-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="example-text-input"><span class="text-danger">*</span>Confirm Password</label>-->
<!--                <input type="password" class="form-control" id="" minlength="8" required name="password_confirmation">-->
<!--            </div>-->
<!--            <input type="hidden" class="form-control" id="password_reset_crm_id" required name="password_reset_crm_id">-->
<!--            <div class="form-group text-right">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                <button type="submit" class="btn btn-primary">Save</button>-->
<!--            </div>-->
<!--        </from>-->
<!--      </div>-->
      
<!--    </div>-->
<!--  </div>-->
<!--</div>-->



<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('admin.create.crm')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New CRM</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">CRM Name</label>
                                    <input type="text" class="form-control" id="" required name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">CRM Email</label>
                                    <input type="text" class="form-control" id="" required name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">CRM Address</label>
                                    <input type="text" class="form-control" id="" required name="address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">CRM Phone Number</label>
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
                                    <label class="d-block">CRM Type</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="type_owner_helper" value="owner_helper" required name="type">
                                        <label class="custom-control-label" for="type_owner_helper">Admin Helper</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-info">
                                        <input type="radio" class="custom-control-input" id="type_branch_user" value="branch_user" name="type">
                                        <label class="custom-control-label" for="type_branch_user">Branch User</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 pb-3">
                                <div class="form-group shadow p-3 d-none" id="admin_helper_role_div">
                                    <label for="admin_helper_role">Select a Role</label>
                                    <select class="form-control" id="admin_helper_role" name="admin_helper_role">
                                        <option value="">-- Select One --</option>
                                        @foreach($roles as $admin_role)
                                            @if($admin_role->which_roll == 'admin')
                                                <option value="{{$admin_role->id}}">{{str_replace(Auth::user()->shop_id."#","", $admin_role->name)}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row shadow p-3 d-none" id="branch_user_parent_div">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="branch_id">Select a Branch</label>
                                            <select class="form-control" id="branch_id" name="branch_id">
                                                <option value="">-- Select Branch --</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="branch_user_role">Select a Role</label>
                                            <select class="form-control" id="branch_user_role" name="role_id">
                                                <option value="">-- Select role --</option>
                                                @foreach($roles as $branch_role)
                                                    @if($branch_role->which_roll == 'branch')
                                                        <option value="{{$branch_role->id}}">{{str_replace(Auth::user()->shop_id."#","", $branch_role->name)}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
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
            $('input[type=radio][name=type]').on('change', function() {
                var admin_helper_role_div = document.getElementById("admin_helper_role_div");
                var branch_user_parent_div = document.getElementById("branch_user_parent_div");
                

                if($(this).val() == 'owner_helper') {
                    admin_helper_role_div.classList.remove("d-none");
                    branch_user_parent_div.classList.add("d-none");
                    
                    $("#admin_helper_role").prop('required', true);
                    $("#branch_user_role").prop('required', false);
                    $("#branch_id").prop('required', false);
                    
                }
                else if($(this).val() == 'branch_user'){
                    admin_helper_role_div.classList.add("d-none");
                    branch_user_parent_div.classList.remove("d-none");
                    
                    $("#admin_helper_role").prop('required', false);
                    $("#branch_user_role").prop('required', true);
                    $("#branch_id").prop('required', true);
                }
            });

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
            
            
            function reset_password(crm_name, id) {
                $('#password_reset_crm_id').val(id);
                $('#password_reset_crm_name').text(crm_name);
                
            }
            
            


        </script>
@endsection
