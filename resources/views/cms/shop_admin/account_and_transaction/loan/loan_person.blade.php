@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Loan Persons</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-primary push" data-toggle="modal" data-target="#modal-block-fadein">Add New Person</button>
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th width="15%">Balance</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loan_persons as $person)
                        <tr>
                            <td>{{$person->name}}</em></td>
                            <td>{{$person->phone}}</em></td>
                            <td>{{optional($person)->email}}</em></td>
                            <td>{{optional($person)->address}}</em></td>
                            @if($person->balance > 0) <td class="bg-danger text-light">{{$person->balance}}<br><span style="font-size: 12px;">=> ঋণদাতা পাবে।</span></td> @elseif($person->balance < 0) <td class="text-light bg-success">{{$person->balance}}<br><span style="font-size: 12px;">=> ঋণদাতা থেকে পাবো।</span></td> @else <td>{{$person->balance}}</td> @endif
                            <td class="text-center" width="15%">
                                <a type="button" href="{{route('admin.edit.loan.person', ['id'=>$person->id])}}" class="btn btn-rounded btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                <a type="button" target="_blank" href="{{route('report.lender.ledger.table', ['id'=>$person->id])}}" class="btn btn-rounded btn-sm btn-primary">Ledger</a>
                            </td>
                        </tr>
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
                    <form action="{{route('admin.create.new.loan.person')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Loan Person</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input">Name</label>
                                <input type="text" class="form-control" id="" required name="name" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Phone</label>
                                <input type="text" class="form-control" id="" required name="phone" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Email</label>
                                <input type="text" class="form-control" id="" name="email" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Address</label>
                                <input type="text" class="form-control" id="" name="address" >
                            </div>
                            <!-- <div class="form-group">
                                <label for="example-text-input">Opening Balance</label>
                                <input type="number" class="form-control" value="0" required name="opening_balance" step=any>
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
