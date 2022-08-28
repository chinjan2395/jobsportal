@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Feedback')])
<!-- Inner Page Title end -->
<!-- Page Title End -->
<div class="listpgWraper">
    <div class="container">
        @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount"> {!! Form::open(array('method' => 'post', 'route' => ['feedback.job', $slug])) !!}
                    <div class="formpanel"> 
                        <!-- Ad Information -->
                        <h5>{{__('Feedback')}}</h5>
                        <div class="row">
                            <div class="col-md-12 hidden">
                                <div class="formrow{{ $errors->has('listing_url') ? ' has-error' : '' }}">
                                    {!! Form::text('company_url', route('company.detail', $slug), array('class'=>'form-control', 'id'=>'company_url', 'placeholder'=>__('URL'), 'required'=>'required', 'readonly'=>'readonly')) !!}
                                    {!! Form::text('job_id', $job->id, array('class'=>'form-control', 'placeholder'=>__('Job'), 'readonly'=>'readonly')) !!}
                                    @if ($errors->has('company_url')) <span class="help-block"> <strong>{{ $errors->first('company_url') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow">
                                    {!! Form::text('', $job->title, array('class'=>'form-control', 'placeholder'=>__('Job'), 'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('your_name') ? ' has-error' : '' }}">
                                    <?php
                                    $your_name = (Auth::check()) ? Auth::user()->name : '';
                                    ?>
                                    {!! Form::text('your_name', $your_name, array('class'=>'form-control', 'id'=>'your_name', 'placeholder'=>__('Your Name'), 'required'=>'required')) !!}                
                                    @if ($errors->has('your_name')) <span class="help-block"> <strong>{{ $errors->first('your_name') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('your_email') ? ' has-error' : '' }}">
                                    <?php
                                    $your_email = (Auth::check()) ? Auth::user()->email : '';
                                    ?>
                                    {!! Form::text('your_email', $your_email, array('class'=>'form-control', 'id'=>'your_email', 'placeholder'=>__('Your Email'), 'required'=>'required')) !!}                
                                    @if ($errors->has('your_email')) <span class="help-block"> <strong>{{ $errors->first('your_email') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('content') ? ' has-error' : '' }}">
                                    {!! Form::textarea('content', '', array('class'=>'form-control', 'id'=>'content', 'placeholder'=>__('Feedback'), 'required'=>'required')) !!}
                                    @if ($errors->has('content')) <span class="help-block"> <strong>{{ $errors->first('content') }}</strong> </span> @endif </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" id="post_ad_btn" class="btn" value="{{__('Submit')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
