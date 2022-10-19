@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Report')])

    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <h3>{{__('Report')}}</h3>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table" id="jobDatatableAjax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th>Job Title</th>
                                        <th>City</th>
                                        <th>Degree</th>
                                        <th>Type</th>
                                        <th>Experience</th>
                                        <th>Job Applications</th>
                                        <th>Shortlisted</th>
                                        <th>Hired</th>
                                        <th>Salary Criteria</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($jobs) && count($jobs))
                                        @foreach($jobs as $job)
                                            <tr>
                                                <td>{{$job->title}}</td>
                                                <td>{{optional($job->city)->city}}</td>
                                                <td>{{optional($job->degreeLevel)->degree_level}}</td>
                                                <td>{{optional($job->jobType)->job_type}}</td>
                                                <td>{{optional($job->jobExperience)->job_experience}}</td>
                                                <td>
                                                    @if ($job->job_applications_count <= 0)
                                                        {{$job->job_applications_count}}
                                                    @else
                                                        <a href="javascript:void(0)" onclick='getJobApplications({{$job->id}})'>{{$job->job_applications_count}}</a>
                                                    @endif
                                                </td>
                                                <td>{{$job->short_list_candidates_count}}</td>
                                                <td>{{$job->hired_candidates_count}}</td>
                                                <td>{{$job->salary_from  . ' - ' . $job->salary_to}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <!-- Pagination Start -->
                        <div class="pagiWrap">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="showreslt">
                                        {{__('Showing Pages')}} : {{ $jobs->firstItem() }}
                                        - {{ $jobs->lastItem() }} {{__('Total')}} {{ $jobs->total() }}
                                    </div>
                                </div>
                                <div class="col-md-7 text-right">
                                    @if(isset($jobs) && count($jobs))
                                        {{ $jobs->appends(request()->query())->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Pagination end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dynamic-modal"></div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script>
        function getJobApplications(jobId) {
            $.post("{{ route('company.fetch.job.applications.data') }}", {
                job_id: jobId,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#dynamic-modal').html(response);
                    $('#show_alert').modal('toggle');
                });
        }
    </script>
@endpush()
