@extends('cms.master')
@section('body_content')
<style>
    ul {
        list-style: none;
    }
</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">List Of Groups</h4>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th>Parent</th>
                            <th>Group Name</th>
                            <th>Group Under</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses_group as $group)
                        <tr>
                            <td class="text-capitalize">{{$group->parent}}</em></td>
                            <td>
                               <b class="text-capitalize">{{$group->group_name}}</b>
                                <ul>
                                    @foreach($group->ledger_heads as $head)
                                    <li><i class="fa fa-angle-right text-danger"></i> {{$head->head_name}}</li>
                                    @endforeach
                                </ul>
                        </td>
                            <td>{{$group->group_under}}</em></td>
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

@endsection
