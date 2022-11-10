@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <style>
        .listbtn {
            background: #fff;
            display: inline-block;
            border-radius: 40px;
            color: #5e2dfa;
            text-transform: uppercase;
            font-weight: 700;
            padding: 10px 15px;
            text-align: center;
            border: 1px solid #5e2dfa;
        }
        .listbtn:hover {
            background: #5e2dfa;
            color: #fff;
            text-decoration: none;
        }
    </style>
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Report')])

    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row">
                @include('includes.company_dashboard_menu')
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <div class="row searchList">
                            <div class="col-md-8">
                                <h3>{{__('Report')}}</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="listbtn" onclick="exportData('xlsx')">XLSX</button>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body" style="overflow-x: scroll;">
                                <form method="get" role="form" id="job-search-form">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}"
                                                 id="job_title_id_div">
                                                <input type="text" class="form-control" name="title" id="title"
                                                       value="{{request()->has('title')?request()->get('title'):''}}"
                                                       autocomplete="off" placeholder="Job title">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}"
                                                 id="job_experience_id_div">
                                                <input type="tel" name="salary_from" class="form-control" placeholder="12000"
                                                       value="{{ request()->has('salary_from') ? request()->get('salary_from') : '' }}"/>
                                                <input type="tel" name="salary_to" class="form-control"  placeholder="20000"
                                                       value="{{ request()->has('salary_to') ? request()->get('salary_to') : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="date" name="from_date" class="form-control"
                                                       value="{{ request()->has('from_date') ? request()->get('from_date') : '' }}"/>
                                                <input type="date" name="to_date" class="form-control"
                                                       value="{{ request()->has('to_date') ? request()->get('to_date') : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}"
                                                 id="degree_level_id_div">
                                                {!! Form::select('degree_level_id', ['' => 'Select Default Degree Level']+$degreeLevels, request()->has('degree_level_id')?request()->get('degree_level_id'):null, array('class'=>'form-control', 'id'=>'degree_level_id')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}"
                                                 id="job_type_id_div">
                                                {!! Form::select('job_type_id', ['' => 'Select Job Type']+$jobTypes, request()->has('job_type_id')?request()->get('job_type_id'):null, array('class'=>'form-control', 'id'=>'job_type_id')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}"
                                                 id="job_experience_id_div">
                                                {!! Form::select('job_experience_id', ['' => 'Select Job Experience']+$jobExperiences, request()->has('job_experience_id')?request()->get('job_experience_id'):null, array('class'=>'form-control', 'id'=>'job_experience_id')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button class="btn btn-success">Filter</button>
                                                <button type="button" class="btn btn-outline-danger" onclick="resetFilter()">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                        <th>Date</th>
                                        <th class="text-center" colspan="3">Exports</th>
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
                                                        <a href="javascript:void(0)" onclick='getJobApplications({{$job->id}})'>{{$job->job_applications_count}} </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($job->short_list_candidates_count <= 0)
                                                        {{$job->short_list_candidates_count}}
                                                    @else
                                                        <a href="javascript:void(0)" onclick='getJobApplications(`{{$job->id}}`,`short-listed-candidate`)'>{{$job->short_list_candidates_count}} </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($job->hired_candidates_count <= 0)
                                                        {{$job->hired_candidates_count}}
                                                    @else
                                                        <a href="javascript:void(0)" onclick='getJobApplications(`{{$job->id}}`,`hired-candidate`)'>{{$job->hired_candidates_count}} </a>
                                                    @endif
                                                </td>
                                                <td>{{$job->salary_from  . ' - ' . $job->salary_to}}</td>
                                                <td>{{optional($job->created_at)->format('d M, Y')}}</td>
                                                <td><a href="javascript:void(0)"
                                                       onclick="exportData('xlsx', false,'{{$job->id}}','{{$job->title.'-applied-candidates-'}}','applied-candidate')"><i
                                                                class="fa fa-download"></i>
                                                        Applied Candidates</a></td>
                                                <td><a href="javascript:void(0)"
                                                       onclick="exportData('xlsx', false,'{{$job->id}}','{{$job->title.'-shortlisted-candidates-'}}','short-listed-candidate')"><i
                                                                class="fa fa-download"></i>
                                                        Short listed Candidates</a></td>
                                                <td><a href="javascript:void(0)"
                                                       onclick="exportData('xlsx', false,'{{$job->id}}','{{$job->title.'-hired-candidates-'}}','hired-candidate')"><i
                                                                class="fa fa-download"></i>
                                                        Hired Candidates</a></td>
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
        function getJobApplications(jobId, type = 'applied-candidate') {
            $.post("{{ route('company.fetch.job.applications.data') }}", {
                job_id: jobId,
                type: type,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#dynamic-modal').html(response);
                    $('#show_alert').modal('toggle');
                });
        }

        function exportData(mimeType = 'xlsx', parent = true, jobId = null, jobTitle = 'report-', type = 'applied-candidate') {
            $.post(parent ? "{{ route('company.job.export') }}" : "{{ route('company.job.application.export') }}" , {
                _method: 'GET',
                job_id: jobId,
                type: type,
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    var linkSource = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'+ response.data ;
                    var downloadLink = document.createElement("a");

                    downloadLink.href = linkSource;
                    downloadLink.download = jobTitle + new Date().toISOString().split('T')[0] + "." + mimeType;
                    downloadLink.click();
                });
        }

        function resetFilter() {
            window.location.href = "{{route('company.report')}}";
        }
    </script>
@endpush()
