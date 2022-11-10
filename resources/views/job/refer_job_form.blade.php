@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Apply on Job')]) 
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container"> @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    <div class="formpanel"> {!! Form::open(array('id'=>'refer-form','method' => 'post', 'route' => ['post.refer.job', $job_slug])) !!}
                        <!-- Job Information -->
                        <h5>{{$job->title}}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('name') ? ' has-error' : '' }}"> {!! Form::text('name', null, array('required'=>'required','class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Full Name'))) !!}
                                    @if ($errors->has('name')) <span class="help-block"> <strong>{{ $errors->first('name') }}</strong> </span> @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}"> {!! Form::email('email', null, array('required'=>'required','class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'))) !!}
                                    @if ($errors->has('email')) <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span> @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="div_cv_file">
                                    <input class="form-control" id="cv_file" name="cv_file" type="file" required>
                                    <span class="help-block cv_file-error"></span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('current_salary') ? ' has-error' : '' }}"> {!! Form::number('current_salary', null, array('required'=>'required','class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current salary').' ('.$job->getSalaryPeriod('salary_period').')' )) !!}
                                    @if ($errors->has('current_salary')) <span class="help-block"> <strong>{{ $errors->first('current_salary') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('expected_salary') ? ' has-error' : '' }}"> {!! Form::number('expected_salary', null, array('required'=>'required','class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected salary').' ('.$job->getSalaryPeriod('salary_period').')')) !!}
                                    @if ($errors->has('expected_salary')) <span class="help-block"> <strong>{{ $errors->first('expected_salary') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('salary_currency') ? ' has-error' : '' }}">
                                    {!! Form::select('salary_currency', ['' =>__('Select Salary Currency')]+$currencies, Request::get('salary_currency'), array('required'=>'required','class'=>'form-control', 'id'=>'salary_currency')) !!}
                                    @if ($errors->has('salary_currency')) <span class="help-block"> <strong>{{ $errors->first('salary_currency') }}</strong> </span> @endif
                                </div>
                            </div>
                        </div>

                        {{--@if(Auth::guard('company')->user())
                            <input id="refer_for_other_employee" type="radio" value="1"
                                   name="has_referral_code" style="margin-bottom: 10px"/> {{__('Refer for other Employee?')}}
                            <div id="referral_code_for_other" style="margin-top: 10px; margin-bottom: 10px">

                                <div class="formrow{{ $errors->has('employee_name') ? ' has-error' : '' }}"> {!! Form::text('employee_name', null, array('class'=>'form-control', 'id'=>'employee_name', 'placeholder'=>__('Employee Full Name'))) !!}
                                    @if ($errors->has('employee_name')) <span class="help-block"> <strong>{{ $errors->first('employee_name') }}</strong> </span> @endif
                                </div>

                                <div class="formrow{{ $errors->has('employee_email') ? ' has-error' : '' }}"> {!! Form::text('employee_email', null, array('class'=>'form-control', 'id'=>'employee_email', 'placeholder'=>__('Employee Email'))) !!}
                                    @if ($errors->has('employee_email')) <span class="help-block"> <strong>{{ $errors->first('employee_email') }}</strong> </span> @endif
                                </div>
                            </div>
                        @endif--}}

                        <div class="formrow{{ $errors->has('referral_code') ? ' has-error' : '' }}">
                            <?php
                            $is_checked = '';
                            if (old('referral_code', 0)) {
                                $is_checked = 'checked="checked"';
                            }
                            ?>
                            <input id="referral_code" type="radio" value="1"
                                   name="has_referral_code" {{$is_checked}} /> {{__('Have Referral Code?')}}
                            <div id="referral_code_input" style="margin-top: 10px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @if(Auth::guard('company')->user())
                                                <input type="text" name="referral_code" class="form-control"
                                                       placeholder="{{__('Referral Code')}}"
                                                       value="{{optional(Auth::guard('company')->user()->referrals()->latest()->first())->code}}">
                                            @else
                                                <input type="text" name="referral_code" class="form-control"
                                                       placeholder="{{__('Referral Code')}}" value="">
                                            @endif
                                            @if ($errors->has('referral_code')) <span
                                                    class="help-block"> <strong>{{ $errors->first('referral_code') }}</strong> </span> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="formrow{{ $errors->has('employee_name') ? ' has-error' : '' }}"> {!! Form::text('employee_name', null, array('class'=>'form-control', 'id'=>'employee_name', 'placeholder'=>__('Referral Name'))) !!}
                                                @if ($errors->has('employee_name')) <span
                                                        class="help-block"> <strong>{{ $errors->first('employee_name') }}</strong> </span> @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="formrow{{ $errors->has('employee_email') ? ' has-error' : '' }}"> {!! Form::text('employee_email', null, array('class'=>'form-control', 'id'=>'employee_email', 'placeholder'=>__('Referral Email'))) !!}
                                                @if ($errors->has('employee_email')) <span
                                                        class="help-block"> <strong>{{ $errors->first('employee_email') }}</strong> </span> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::guard('company')->user())
                            {{--{!! Form::hidden('referral_code', optional(Auth::guard('company')->user()->referrals()->latest()->first())->code) !!}
                            <br>--}}
                            <input type="submit" class="btn" value="{{__('Refer Candidate')}}">
                        @else
                            <br>
                            <input type="submit" class="btn" value="{{__('Apply')}}">
                        @endif
                        {!! Form::close() !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="add_cv_modal" role="dialog"></div>
@include('includes.footer')
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#salary_currency').typeahead({
            source: function (query, process) {
                return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {
                    console.log(data);
                    data = $.parseJSON(data);
                    return process(data);
                });
            }
        });

        @if(!$errors->has('referral_code'))
        $('#referral_code_input').hide();
        @endif
        $('#referral_code').change(function() {
            $('#referral_code_input').hide();
            if(this.checked) {
                $('#referral_code_input').show();
                $('#referral_code_for_other').hide();
            }
        });
        $('#referral_code_for_other').hide();
        $('#refer_for_other_employee').change(function() {
            $('#referral_code_for_other').hide();
            if(this.checked) {
                $('#referral_code_input').hide();
                $('#referral_code_for_other').show();
            }
        });
    });
</script> 
@endpush

