@extends('admin.layouts.admin_layout')
@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.employee') }}">Employees</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Edit Employee</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- END PAGE HEADER--> 
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Employee Form</span> </div>
                    </div>
                    <div class="portlet-body form">
                        <ul class="nav nav-tabs">
                            <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Details </a> </li>
                        </ul>
                        {!! Form::model($company, array('method' => 'put', 'route' => array('update.employee', $company->id), 'class' => 'form', 'files'=>true)) !!}
                        {!! Form::hidden('id', $company->id) !!}
                        {!! Form::hidden('is_employee', true) !!}
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="Details"> @include('admin.employee.forms.form') </div>
                        </div>
                        {!! Form::close() !!} </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    @endsection
