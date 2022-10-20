@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	
</style>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Feedback</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Feedback <small>Feedback</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Feedback</span> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="search-form">
                                <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th>Job Title</th>
                                            <th>Company</th>
                                            <th>User</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection
@push('scripts') 
<script>
    $(function () {
        var oTable = $('#datatable_ajax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            ajax: {
                url: '{!! route('fetch.data.feedback', 'feedback') !!}',
            }, columns: [
                {data: 'job', name: 'job'},
                {data: 'company', name: 'company'},
                {data: 'user', name: 'user'},
                {data: 'content', name: 'content'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    function delete_faq(id) {
        if (confirm('Are you sure! you want to delete?')) {
            $.post("{{ route('delete.feedback') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#datatable_ajax').DataTable();
                            table.row('faq_dt_row_' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
</script> 
@endpush
