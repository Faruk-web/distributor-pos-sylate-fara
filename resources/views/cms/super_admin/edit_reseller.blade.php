
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
        <div class="row p-2">
            <div class="col-md-6">
                <h4 class="">Update Resellers</h4>
            </div>
            
        </div>
        
        <div class="block-content">
            <form id="registerForm" class="form-dark" method="POST" action="{{route('super.admin.update.reseller', ['id'=>optional($user_info)->id])}}">
                @csrf      
                <div class="mb-3 icon-group">
                    <input type="text" class="form-control text-dark" name="name" id="fullName" required="" value="{{optional($user_info)->name}}" placeholder="Full Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3 icon-group">
                    <input type="email" class="form-control text-dark" name="email" id="" required="" value="{{optional($user_info)->email}}" placeholder="Email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    		  
    		    <div class="mb-3 icon-group">
                    <input type="text" maxlength="11" minlength="11" class="form-control text-dark" name="phone" required="" value="{{optional($user_info)->phone}}" placeholder="Phone (Ex: 01627382866)">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 icon-group">
                    <textarea type="text" class="form-control text-dark" name="address" id="" required="" row="30" col="5" placeholder="Address">{!!optional($user_info)->address!!}</textarea>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3 icon-group">
                    <label for="exampleFormControlSelect1">Active</label>
                    <select class="form-control" name="active" id="">
                      <option @if(optional($user_info)->active == 1) selected @endif value="1">Active</option>
                      <option @if(optional($user_info)->active == 0) selected @endif value="0">Deactive</option>
                    </select>
                </div>
                
                
                <div class="mb-3 icon-group">
                    <lebel class="text-danger">*If you want to update password use this.</lebel>
                    <input type="text" class="form-control text-dark" minlength="8" name="password" id="loginPassword" placeholder="Password (min 8 digit)">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    		    
    		  				  
              <div class="d-grid my-4">
    			    <button class="btn btn-success btn-block" type="submit">Update</button>
    		  </div>
            </form>
        </div>
    </div>
    <!-- END Full Table -->
</div>

@endsection




