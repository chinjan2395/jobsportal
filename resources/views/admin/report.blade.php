@extends('admin.layouts.admin_layout')
@section('content')
    <style type="text/css">
        .table td, .table th {
            font-size: 12px;
            line-height: 2.42857 !important;
        }
        table.dataTable tr.heading>th {
            font-size: 12px;
            line-height: 2.42857 !important;
        }
        .portlet.light .dataTables_wrapper .dt-buttons {
            margin-top: 0px;
            margin-bottom: 20px;
        }
        .dt-buttons a {
            margin-left: 10px;
        }
    </style>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content" style="background-color:#eef1f5;">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a> <i class="fa fa-circle"></i></li>
                    <li><span>Reports</span></li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title"> {{ $siteSetting->site_name }} Admin Panel <small>Reports</small></h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-settings font-dark"></i> <span
                                        class="caption-subject font-dark sbold uppercase">Reports</span></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container" style="width: 100%;overflow-x: scroll;">
                                <form method="post" role="form" id="job-search-form">
                                    <table class="table table-striped table-bordered table-hover" id="jobDatatableAjax">
                                        <thead>
                                        <tr role="row" class="filter">
                                            <td><input type="text" class="form-control" name="title" id="title"
                                                       autocomplete="off" placeholder="Job title"></td>
                                            <td>{!! Form::select('company_id', ['' => 'Select Company']+$companies, null, array('id'=>'company_id', 'class'=>'form-control')) !!}</td>
                                            <td>
                                                <?php $default_country_id = Request::query('country_id', $siteSetting->default_country_id); ?>
                                                {!! Form::select('country_id', ['' => 'Select Country']+$countries, $default_country_id, array('id'=>'country_id', 'class'=>'form-control')) !!}
                                                <span id="default_state_dd">
                                                    {!! Form::select('state_id', ['' => 'Select State'], null, array('id'=>'state_id', 'class'=>'form-control')) !!}
                                                </span>
                                                <span id="default_city_dd">
                                                    {!! Form::select('city_id', ['' => 'Select City'], null, array('id'=>'city_id', 'class'=>'form-control')) !!}
                                                </span></td>
                                            <td>
                                                <?php $default_degree_id = Request::query('degree_id', $siteSetting->default_degree_id); ?>
                                                {!! Form::select('degree_id', ['' => 'Select Degree']+$degreeLevels, $default_degree_id, array('id'=>'degree_id', 'class'=>'form-control')) !!}
                                            </td>
                                            <td>
                                                <?php $default_job_type_id = Request::query('job_type_id', $siteSetting->default_job_type_id); ?>
                                                {!! Form::select('job_type_id', ['' => 'Select Job Types']+$jobTypes, $default_job_type_id, array('id'=>'job_type_id', 'class'=>'form-control')) !!}
                                            </td>
                                            <td>
                                                <?php $default_job_experience_id = Request::query('job_type_id', $siteSetting->default_job_experience_id); ?>
                                                {!! Form::select('job_experience_id', ['' => 'Select Experiences']+$jobExperiences, $default_job_experience_id, array('id'=>'job_experience_id', 'class'=>'form-control')) !!}
                                            </td>
                                            <td>
                                                <?php $default_career_level_id = Request::query('career_level_id', $siteSetting->default_career_level_id); ?>
                                                {!! Form::select('career_level_id', ['' => 'Select Careers']+$jobCareers, $default_career_level_id, array('id'=>'career_level_id', 'class'=>'form-control')) !!}
                                            </td>
                                            <td>
                                                <?php $default_functional_area_id = Request::query('functional_area_id', $siteSetting->default_functional_area_id); ?>
                                                {!! Form::select('functional_area_id', ['' => 'Select Functional Area']+$functionalAreas, $default_functional_area_id, array('id'=>'functional_area_id', 'class'=>'form-control')) !!}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="tel" id="salary_from" class="form-control"/>
                                                <input type="tel" id="salary_to" class="form-control"/>
                                            </td>
                                            <td>
                                                <input type="date" id="from_date" class="form-control"/>
                                                <input type="date" id="to_date" class="form-control"/>
                                            </td>
{{--                                            <td><select name="is_active" id="is_active" class="form-control">--}}
{{--                                                    <option value="-1">Is Active?</option>--}}
{{--                                                    <option value="1" selected="selected">Active</option>--}}
{{--                                                    <option value="0">In Active</option>--}}
{{--                                                </select></td>--}}
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Job title</th>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>Degree</th>
                                            <th>Type</th>
                                            <th>Experience</th>
                                            <th>Career Level</th>
                                            <th>Functional Area</th>
                                            <th>Job Applications</th>
                                            <th>Shortlisted</th>
                                            <th>Hired</th>
                                            <th>Salary Criteria</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <div id="dynamic-modal"></div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('.slimScrol').slimScroll({
                height: '250px',
                railVisible: true,
                alwaysVisible: true
            });
            var oTable = $('#jobDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                ajax: {
                    url: '{!! route('admin.fetch.data.report') !!}',
                    data: function (d) {
                        d.company_id = $('#company_id').val();
                        d.title = $('#title').val();
                        d.description = $('#description').val();
                        d.country_id = $('#country_id').val();
                        d.state_id = $('#state_id').val();
                        d.city_id = $('#city_id').val();
                        d.degree_level_id = $('#degree_id').val();
                        d.is_active = $('#is_active').val();
                        d.is_featured = $('#is_featured').val();
                        d.job_type_id = $('#job_type_id').val();
                        d.job_experience_id = $('#job_experience_id').val();
                        d.career_level_id = $('#career_level_id').val();
                        d.functional_area_id = $('#functional_area_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.salary_from = $('#salary_from').val();
                        d.salary_to = $('#salary_to').val();
                    }
                }, columns: [
                    {data: 'title', name: 'title'},
                    {data: 'company_id', name: 'company_id'},
                    {data: 'city_id', name: 'city_id'},
                    {data: 'degree_level.degree_level', name: 'degree_level_id'},
                    {data: 'job_type.job_type', name: 'job_type_id'},
                    {data: 'job_experience.job_experience', name: 'job_experience_id'},
                    {data: 'career_level.career_level', name: 'career_level_id'},
                    {data: 'functional_area.functional_area', name: 'functional_area'},
                    {data: 'job_applications_count', name: 'job_applications_count'},
                    {data: 'short_list_candidates_count', name: 'short_list_candidates_count'},
                    {data: 'hired_candidates_count', name: 'hired_candidates_count'},
                    {data: 'salary', name: 'salary'},
                    {data: 'date', name: 'created_at'},
                ],
                dom: 'Bfrtip',
                buttons: {
                    buttons: [
                        {
                            extend: 'csv', className: 'btn btn-sm btn-success', init: function (api, node, config) {
                                $(node).removeClass('dt-button')
                            }
                        },
                        {
                            extend: 'excel', className: 'btn btn-sm btn-success', init: function (api, node, config) {
                                $(node).removeClass('dt-button')
                            }
                        }
                    ]
                }
            });
            $('#job-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#company_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#degree_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#job_type_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#job_experience_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#career_level_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#functional_area_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            filterDefaultStates(0);
            $('.btn-job-alert').on('click', function() {
                $('#show_alert').modal('show');
            });
            $('#from_date, #to_date').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#salary_from, #salary_to').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function filterDefaultStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.default.states.dropdown') }}", {
                    country_id: country_id,
                    state_id: state_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                    });
            }
        }

        function filterDefaultCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.default.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }

        function getJobApplications(jobId, type = 'applied-candidate') {
            $.post("{{ route('admin.fetch.job.applications.data') }}", {
                job_id: jobId,
                type: type,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#dynamic-modal').html(response);
                    $('#show_alert').modal('toggle');

                    $('#jobApplicationDatatable').DataTable({
                        processing: false,
                        serverSide: false,
                        stateSave: true,
                        searching: false,
                        dom: 'Bfrtip',
                        buttons: {
                            buttons: [
                                {
                                    extend: 'csv', className: 'btn btn-sm btn-success', init: function (api, node, config) {
                                        $(node).removeClass('dt-button')
                                    }
                                },
                                {
                                    extend: 'excel', className: 'btn btn-sm btn-success', init: function (api, node, config) {
                                        $(node).removeClass('dt-button')
                                    }
                                }
                            ]
                        }
                    });
                });
        }
    </script>
@endpush
