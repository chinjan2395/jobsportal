@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Referrals')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')

                <div class="col-md-9 col-sm-8">
                    <div class="">
                        <h3>{{__('Referrals')}}</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="userccount" style="padding: 20px;">
                                    <div class="formpanel">
                                        <h5>{{__('Generate Referral')}}</h5>
                                        {!! Form::open(array('method' => 'post', 'route' => array('store.front.referral'), 'class' => 'form')) !!}
                                        {!! Form::hidden('company_id', Auth::guard('company')->user()->id) !!}
                                        @php
                                        $existingReferrals = Auth::guard('company')->user()->referrals();
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="formrow">
                                                    <input type="text" name="code" class="form-control" value="{{optional($existingReferrals->latest()->first())->code}}"
                                                           placeholder="{{__('Enter your code')}}" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                @if($existingReferrals->count()>0)
                                                    <div class="formrow">
                                                        <button type="button" class="btn" disabled>{{__('Generate Referral')}}
                                                            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                                                    </div>
                                                    @else
                                                    <div class="formrow">
                                                        <button type="submit" class="btn">{{__('Generate Referral')}}
                                                            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--<div class="userbtns">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#un-used" aria-expanded="true">{{__('Un Used')}}</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#used" aria-expanded="false">{{__('Used')}}</a></li>
                            </ul>
                        </div>--}}
                        <div class="tab-content">
                            <div id="used" class="formpanel tab-pane active">
                                <ul class="searchList">
                                    <!-- referral start -->
                                    @if(isset($referrals['used']) && count($referrals['used']))
                                        @foreach($referrals['used'] as $referral)
                                            @php $company = $referral->getCompany(); @endphp
                                            @if(null !== $company)
                                                <li id="job_li_{{$referral->id}}">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="jobinfo">
                                                                <h5>
                                                                    <i class="fa fa-user-o"></i> {!! $referral->display_code !!}
                                                                    <div class="companyName">
                                                                        <i class="fa fa-industry"></i> <a
                                                                                href="{{route('company.detail', $company->slug)}}"
                                                                                title="{{$company->name}}">{{$company->name}}
                                                                            -
                                                                            <small>{{$referral->created_at->format('M d, Y H:i:s')}}</small></a>
                                                                    </div>
                                                                </h5>
                                                                @if($referral->usedBy)
                                                                    <div>Used By - <a
                                                                                href="{{route('user.profile', optional($referral->usedBy)->id)}}"
                                                                                title="{{optional($referral->usedBy)->getName()}}">
                                                                            {{optional($referral->usedBy)->getName()}}
                                                                            - {{optional($referral->usedBy)->email}}
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <p>{{\Illuminate\Support\Str::limit(strip_tags($referral->description), 150, '...')}}</p>
                                                </li>
                                                <!-- referral end -->
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                                <!-- Pagination Start -->
                                <div class="pagiWrap">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="showreslt">
                                                {{__('Showing Pages')}} : {{ $referrals['used']->firstItem() }}
                                                - {{ $referrals['used']->lastItem() }} {{__('Total')}} {{ $referrals['used']->total() }}
                                            </div>
                                        </div>
                                        <div class="col-md-7 text-right">
                                            @if(isset($referrals['used']) && count($referrals['used']))
                                                {{ $referrals['used']->appends(request()->query())->links() }}
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
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">
        function deleteJob(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.front.referral') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok') {
                            $('#job_li_' + id).remove();
                            location.reload();
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endpush
