@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Banks</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-danger push" data-toggle="modal" data-target="#modal-block-fadein">Add New Bank</button>
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
                            <th>Bank Name</th>
                            <th>Account Num.</th>
                            <th>Account Type</th>
                            <th>Branch</th>
                            <th>Balance</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($banks as $bank)
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$bank->bank_name}}</em></td>
                            <td>{{$bank->account_no}}</em></td>
                            <td>{{$bank->account_type}}</em></td>
                            <td>{{$bank->bank_branch}}</em></td>
                            <td>{{number_format($bank->balance, 2)}}</em></td>
                            <td class="text-center" width="15%">
                                <a type="button" href="{{route('admin.account.transaction.edit.bank', ['id'=>$bank->id])}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                <a type="button" target="_blank" href="{{route('report.bank.ledger.table', ['id'=>$bank->id])}}" class="btn btn-sm btn-primary" >Ledger</a>
                                    
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('admin.create.new.bank')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Bank</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input">Bank Name</label>
                                <input type="text" class="form-control" id="" required name="bank_name" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Account Number</label>
                                <input type="text" class="form-control" id="" required name="account_no" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Account Type</label>
                                <input type="text" class="form-control" id="" required name="account_type" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Branch Name</label>
                                <input type="text" class="form-control" id="" required name="bank_branch" >
                            </div>
                            <!-- <div class="form-group">
                                <label for="example-text-input">Opening Balance</label>
                                <input type="number" class="form-control" id="" required name="opening_bl" step=any>
                            </div> -->
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
@endsection
