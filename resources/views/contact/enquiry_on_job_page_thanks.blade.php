@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Enquiry')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">
                        <h5>{{__('Thanks')}}!</h5>
                        <p>
                            {{__('We have received your enquiry.')}},<br/>
                            {{__('We will contact you soon regarding same.')}},<br/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
