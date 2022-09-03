@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Company Events')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')

                <div class="col-md-9 col-sm-8">
                    <div class="">
                        <h3>{{__('Company Events')}}</h3>
                        <ul class="searchList">
                            <!-- event start -->
                            @if(isset($events) && count($events))
                                @foreach($events as $event)
                                    @php $company = $event->getCompany(); @endphp
                                    @if(null !== $company)
                                        <li id="job_li_{{$event->id}}">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <div class="jobimg">{{$company->printCompanyImage()}}</div>
                                                    <div class="jobinfo">
                                                        <h3><a href="{{route('event.detail', [$event->slug])}}"
                                                               title="{{$event->title}}">{{$event->title}}</a></h3>
                                                        <div class="companyName"><a
                                                                    href="{{route('company.detail', $company->slug)}}"
                                                                    title="{{$company->name}}">{{$company->name}}</a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="listbtn"><a
                                                                href="{{route('edit.front.event', [$event->id])}}">{{__('Edit')}}</a>
                                                    </div>
                                                    <div class="listbtn"><a href="javascript:;"
                                                                            onclick="deleteJob({{$event->id}});">{{__('Delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{\Illuminate\Support\Str::limit(strip_tags($event->description), 150, '...')}}</p>
                                        </li>
                                        <!-- event end -->
                                    @endif
                                @endforeach
                            @endif
                        </ul>


                        <!-- Pagination Start -->

                        <div class="pagiWrap">

                            <div class="row">

                                <div class="col-md-5">

                                    <div class="showreslt">

                                        {{__('Showing Pages')}} : {{ $events->firstItem() }}
                                        - {{ $events->lastItem() }} {{__('Total')}} {{ $events->total() }}

                                    </div>

                                </div>

                                <div class="col-md-7 text-right">

                                    @if(isset($events) && count($events))

                                        {{ $events->appends(request()->query())->links() }}

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
    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">
        function deleteJob(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.front.event') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
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
