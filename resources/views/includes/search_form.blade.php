@if(Auth::guard('company')->check())
<h3 class="seekertxt">{{__('One million success stories')}}. <span>{{__('Search Jobseekers Today')}}.</span></h3>
<form action="{{route('job.seeker.list')}}" method="get">
    <div class="searchbar">
        <div class="srchbox seekersrch">
            <div class="input-group">
                <input type="text" name="search" id="empsearch" value="{{Request::get('search', '')}}"
                       class="form-control" placeholder="{{__('Enter Skills or Job Seeker Details')}}"
                       autocomplete="off"/>
                <span class="input-group-btn">
			<input type="submit" class="btn" value="{{__('Search Job Seeker')}}">
		  </span>
            </div>
        </div>


    </div>
</form>
@else
<div class="header-title text-center">
    <h1 class="prime-color">Hi There,</h1>
    <h3>
        Welcome to "Massar International" Hiring Portalii
    </h3>
</div>
<!--<h3>{{__('One million success stories')}}. <span>{{__('Start yours today')}}.</span></h3>-->
<form action="{{route('job.list')}}" method="get">
    <div class="searchbar">
        <div class="srchbox srcsubfld additional_fields">

            <div class="row">
                <div class="col-lg-9 col-md-8 od-1">
                    <!--				<label for=""> {{__('Keywords / Job Title')}}</label>-->
                    <input type="text" name="search" id="jbsearch" value="{{Request::get('search', '')}}"
                           class="form-control" placeholder="{{__('Enter Skills or job title')}}" autocomplete="off"/>
                </div>
                <div class="col-lg-3 col-md-4 od-2">
                    <!--				<label for="">&nbsp;</label>-->
                    <input type="submit" class="btn mt-0 mb-sm-0 mb-3" value="{{__('Search Job')}}">
                </div>
                <div class="od-3 col-lg-{{((bool)$siteSetting->country_specific_site)? 6:3}} col-md-4">
                    <!--			<label for="">{{__('Select Category')}}</label>-->
                    {!! Form::select('functional_area_id[]', ['' => __('Select Category')]+$functionalAreas,
                    Request::get('functional_area_id', null), array('class'=>'form-control',
                    'id'=>'functional_area_id')) !!}
                </div>

                @if((bool)$siteSetting->country_specific_site)
                {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id),
                array('id'=>'country_id')) !!}
                @else
                <div class="col-lg-3 col-md-4 od-4">
                    <!--			<label for="">{{__('Select Country')}}</label>-->
                    {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries,
                    Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control',
                    'id'=>'country_id')) !!}
                </div>
                @endif

                <div class="col-lg-3 col-md-4 od-5">
                    <!--			<label for="">{{__('Select State')}}</label>-->
                    <span id="state_dd">
                {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}
            </span>
                </div>
                <div class="col-lg-3 col-md-4 od-6">
                    <!--			<label for="">{{__('Select City')}}</label>-->
                    <span id="city_dd">
                {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}
            </span>
                </div>
            </div>

        </div>


    </div>
</form>
@endif
<div class="home-card-slider-section">
    <div class="desk-slider owl-carousel owl-theme">
        @foreach($companyWithJobs as $companyWithJob)
            <div class="item">
                <div class="desk-card">
                    <div class="desk-img">
                        {{$companyWithJob->printCompanyImage()}}
                    </div>
                    @foreach($companyWithJob->jobs as $job)
                        <div class="desk-under-box">
                            <h5>{{$job->title}}</h5>
                            <p>
                                {{\Illuminate\Support\Str::substr($job->description,0,150) }}
                            </p>
                            <a href="{{route('job.detail', [$job->slug])}}"
                               title="{{$job->title}}" class="btn btn-primary">Easy apply</a>
                        </div>
                    @endforeach
                    <div class="desk-btn-div">
                        <a href="#">
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i> See More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
