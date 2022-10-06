{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'company_id') !!}" id="company_id_div">
        {!! Form::label('company_id', 'Company', ['class' => 'bold']) !!}
        <div><label>{{$job->getCompany('name')}}</label></div>
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}">
        {!! Form::label('title', 'Job title', ['class' => 'bold']) !!}
        <div><label>{!! $job->title !!}</label></div>
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description', 'Job description', ['class' => 'bold']) !!}
        <div><label>{!! $job->description !!}</label></div>
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('applications', 'Job applications', ['class' => 'bold']) !!}
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="job-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="jobDatatableAjax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th>Candidate</th>
                                        <th>Current Salary</th>
                                        <th>Expected Salary</th>
                                        <th>CV</th>
                                        <th>Applied Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($applications as $application)
                                        <tr role="row" class="heading">
                                            <td>{{optional($application->user)->first_name}} {{optional($application->user)->last_name}}</td>
                                            <td>{{$application->current_salary}} <small>({{$application->salary_currency}})</small></td>
                                            <td>{{$application->expected_salary}} <small>({{$application->salary_currency}})</small></td>
                                            <td>
                                                @if($application->profileCv)
                                                    <a href="{{asset('cvs/'.optional($application->profileCv)->cv_file)}}" class="btn btn-sm"><i
                                                                class="fa fa-download" aria-hidden="true"></i> {{__('Download CV')}}</a>
                                                @endif
                                            </td>
                                            <td>{{$application->created_at->format('M d,Y')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts')
@include('admin.shared.tinyMCEFront') 
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2-multiple').select2({
            placeholder: "Select Required Skills",
            allowClear: true
        });
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-m-d'
        });
        $('#country_id').on('change', function (e) {
            e.preventDefault();
            filterDefaultStates(0);
        });
        $(document).on('change', '#state_id', function (e) {
            e.preventDefault();
            filterDefaultCities(0);
        });
        filterDefaultStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);
    });
    function filterDefaultStates(state_id)
    {
        var country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterDefaultCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
                    });
        }
    }
    function filterDefaultCities(city_id)
    {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.default.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
        }
    }
</script>
@endpush
