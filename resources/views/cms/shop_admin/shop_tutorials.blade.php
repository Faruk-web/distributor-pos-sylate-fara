@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">All Tutorials</h4>
        </div>
        <div class="block-content">
            <div class="row mb-5">
            @foreach($tutorial as $tutorial)
                <div class="col-md-4 col-12">
                    <div class="card shadow">
                      <div class="card-body">
                       <div class="embed-responsive embed-responsive-16by9">
                          <iframe src="{{optional($tutorial)->link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        </div>
                        </div>
                        <div class="card-footer text-muted"><p>{{optional($tutorial)->title}}</p></div>
                    </div>
                 </div>
            @endforeach
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

@endsection
