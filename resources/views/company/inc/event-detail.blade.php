@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Event Detail')])
    <!-- Inner Page Title end -->
    @include('flash::message')
    @php
        $company = $event->getCompany();
    @endphp

    <div class="listpgWraper">
        <div class="container">
        @include('flash::message')


        <!-- Event Detail start -->
            <div class="row">
                <div class="col-lg-9">
                    <!-- Event Header start -->
                    <div class="job-header">
                        <div class="jobinfo">
                            <h2>{{$event->title}} - <span class="text-uppercase">{{$company->name}}</span></h2>
                            <div class="ptext">{{__('Date Posted')}}: {{$event->created_at->format('M d, Y')}}</div>
                        </div>
                        <!-- Event Detail start -->
                        <div class="jobmainreq">
                            <div class="jobdetail">
                                <h3><i class="fa fa-align-left" aria-hidden="true"></i> {{__('Event Detail')}}</h3>


                                <ul class="jbdetail">
                                    <li class="row">
                                        <div class="col-md-4 col-xs-5">{{__('Company')}}:</div>
                                        <div class="col-md-8 col-xs-7 text-uppercase">{{$company->name}}</div>
                                    </li>
                                    <li class="row">
                                        <div class="col-md-4 col-xs-5">{{__('Event Starts')}}:</div>
                                        <div class="col-md-8 col-xs-7">
                                            <span>{{\Illuminate\Support\Carbon::parse($event->start_date)->format('M d, Y')}}</span>
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="col-md-4 col-xs-5">{{__('Event Ends')}}:</div>
                                        <div class="col-md-8 col-xs-7">
                                            <span>{{\Illuminate\Support\Carbon::parse($event->end_date)->format('M d, Y')}}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <!-- Event Description start -->
                    <div class="job-header">
                        <div class="contentbox">
                            <h3><i class="fa fa-file-text-o" aria-hidden="true"></i> {{__('Event Description')}}</h3>
                            <p>{!! $event->description !!}</p>
                        </div>
                    </div>
                    <!-- Event Description end -->


                </div>
                <!-- related jobs end -->
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('styles')
    <style type="text/css">
        .view_more {
            display: none !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function ($) {
            $("form").submit(function () {
                $(this).find(":input").filter(function () {
                    return !this.value;
                }).attr("disabled", "disabled");
                return true;
            });
            $("form").find(":input").prop("disabled", false);

            $(".view_more_ul").each(function () {
                if ($(this).height() > 100) {
                    $(this).css('height', 100);
                    $(this).css('overflow', 'hidden');
                    //alert($( this ).next());
                    $(this).next().removeClass('view_more');
                }
            });


        });
    </script>
@endpush
