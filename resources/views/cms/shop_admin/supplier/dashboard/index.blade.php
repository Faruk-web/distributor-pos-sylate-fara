@extends('cms.master')
@section('body_content')

@if($user->hasPermissionTo('supplier.dashboard') || $user->type == 'owner')
@php
$suppliers = DB::table('suppliers')->where('shop_id', Auth::user()->shop_id)->get(['id', 'balance']);
$total_supplier = $suppliers->count('id');
$supplier_due = $suppliers->sum('balance');
@endphp
<div class="content">
    <div class="row">
        <div class="col-md-12"><h4>Supplier Dashboard</h4></div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h4 font-w700">{{$total_supplier}}</dt>
                        <dd class="text-muted mb-0">Total Suppliers</dd>
                    </dl>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="{{route('suppliers.all')}}">
                        View all Suppliers
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h4 font-w700">{{number_format($supplier_due, 2)}}</dt>
                        <dd class="text-muted mb-0">Supplier Due</dd>
                    </dl>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="{{route('suppliers.all')}}">
                        View all
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="block block-rounded d-flex flex-column">
                
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="javascript:void(0)">Note.<i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
                <div class="block-content block-content-full">
                    <p><b>1) </b></p>
                    <p><b>1) </b></p>
                    <p><b>1) </b></p>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@endif
@endsection
