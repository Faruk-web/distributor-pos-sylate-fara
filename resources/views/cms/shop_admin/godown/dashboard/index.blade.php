@extends('cms.master')
@section('body_content')
@if($user->hasPermissionTo('godown.dashboard') || $user->type == 'owner')
@php

$godown_current_stock = DB::table('product_stocks')->where('shop_id', Auth::user()->shop_id)->where('branch_id', 'G')->where('stock', '>', 0)->count('id');


@endphp
<div class="content">
    <div class="row">
        <div class="col-md-12"><h4>Godowns Dashboard</h4></div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700">{{$godown_current_stock}}</dt>
                        <dd class="text-muted mb-0">Godown Products</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-shopping-cart font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="{{route('godown.current.stock.info')}}">
                        View Godowns Product
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-9">
            <div class="block">
                <div class="block-content">
                    <h4><b>Note.</b></h4>
                    <p><b>1) </b> </p>
                    <p><b>2) </b> </p>
                    <p><b>3) </b> </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
