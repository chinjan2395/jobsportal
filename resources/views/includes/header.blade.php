<div class="header">
    <div class="top-header">
        <div class="container">
             <div class="row">
            <div class="col-md-12">
                <div class="tp-head">
                    <ul class="social-ul">
                        <li>
                            <a href="#">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="dropdown userbtn"><a href="{{url('/')}}"><img src="{{asset('/')}}images/translate-icon.png" alt="" class="userimg" /></a>
                            <ul class="dropdown-menu">
                                @foreach($siteLanguages as $siteLang)
                                <li><a href="javascript:;" onclick="event.preventDefault(); document.getElementById('locale-form-{{$siteLang->iso_code}}').submit();" class="nav-link">{{$siteLang->native}}</a>
                                    <form id="locale-form-{{$siteLang->iso_code}}" action="{{ route('set.locale') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="locale" value="{{$siteLang->iso_code}}"/>
                                        <input type="hidden" name="return_url" value="{{url()->full()}}"/>
                                        <input type="hidden" name="is_rtl" value="{{$siteLang->is_rtl}}"/>
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>


        <div class="main-header">
            <div class="container">
            <div class="row align-items-center">
            <div class="col-lg-2 col-md-12 col-12">

                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/01.jpeg" alt="img"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/02.jpeg" alt="img"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/03.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/04.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/05.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/06.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/07.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/08.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/09.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/10.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/11.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/12.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/13.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/14.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/15.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/16.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/17.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="logo">
                                <img src="{{ asset('/') }}images/18.jpeg"
                                     alt="{{ $siteSetting->site_name }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navbar-header navbar-light">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-main" aria-controls="nav-main" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-10 col-md-12 col-12"> 

                <!-- Nav start -->
                <nav class="navbar navbar-expand-lg navbar-light">
					
                    <div class="navbar-collapse collapse" id="nav-main">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item {{ Request::url() == route('index') ? 'active' : '' }}"><a href="{{url('/')}}" class="nav-link">{{__('Home')}}</a> </li>
							@if(Auth::guard('company')->check())
							<li class="nav-item"><a href="{{url('/job-seekers')}}" class="nav-link">{{__('Seekers')}}</a> </li>
							@else
{{--							<li class="nav-item"><a href="{{url('/jobs')}}" class="nav-link">{{__('Jobs')}}</a> </li>--}}
							@endif

{{--							<li class="nav-item {{ Request::url()}}"><a href="{{url('/companies')}}" class="nav-link">{{__('Companies')}}</a> </li>--}}
                            @foreach($show_in_top_menu as $top_menu) @php $cmsContent = App\CmsContent::getContentBySlug($top_menu->page_slug); @endphp
                            <li class="nav-item {{ Request::url() == route('cms', $top_menu->page_slug) ? 'active' : '' }}"><a href="{{ route('cms', $top_menu->page_slug) }}" class="nav-link">{{ $cmsContent->page_title }}</a> </li>
                            @endforeach
{{--							<li class="nav-item {{ Request::url() == route('blogs') ? 'active' : '' }}"><a href="{{ route('blogs') }}" class="nav-link">{{__('Blog')}}</a> </li>--}}
{{--                            <li class="nav-item {{ Request::url() == route('contact.us') ? 'active' : '' }}"><a href="{{ route('contact.us') }}" class="nav-link">{{__('Contact us')}}</a> </li>--}}
                            @if(Auth::check())
                            <li class="nav-item dropdown userbtn"><a href="">{{Auth::user()->printUserImage()}}</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="{{route('home')}}" class="nav-link"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a> </li>
                                    <li class="nav-item"><a href="{{ route('my.profile') }}" class="nav-link"><i class="fa fa-user" aria-hidden="true"></i> {{__('My Profile')}}</a> </li>
                                    <li class="nav-item"><a href="{{ route('view.public.profile', Auth::user()->id) }}" class="nav-link"><i class="fa fa-eye" aria-hidden="true"></i> {{__('View Public Profile')}}</a> </li>
                                    <li><a href="{{ route('my.job.applications') }}" class="nav-link"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('My Job Applications')}}</a> </li>
                                    <li class="nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();" class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a> </li>
                                    <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                            @endif @if(Auth::guard('company')->check())
                            <li class="nav-item postjob"><a href="{{route('post.job')}}" class="nav-link register">{{__('Post a job')}}</a> </li>
                            <li class="nav-item dropdown userbtn"><a href="">{{Auth::guard('company')->user()->printCompanyImage()}}</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="{{route('company.home')}}" class="nav-link"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a> </li>
                                    <li class="nav-item"><a href="{{ route('company.profile') }}" class="nav-link"><i class="fa fa-user" aria-hidden="true"></i> {{__('Company Profile')}}</a></li>
                                    <li class="nav-item"><a href="{{ route('post.job') }}" class="nav-link"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('Post Job')}}</a></li>
                                    <li class="nav-item"><a href="{{route('company.messages')}}" class="nav-link"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{__('Company Messages')}}</a></li>
                                    <li class="nav-item"><a href="{{ route('company.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header1').submit();" class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a> </li>
                                    <form id="logout-form-header1" action="{{ route('company.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                            @endif @if(!Auth::user() && !Auth::guard('company')->user())
                            <li class="nav-item liregister"><a href="{{route('register')}}" class="nav-link register">{{__('Register')}}</a> </li>
                            <li class="nav-item lilogin"><a href="{{route('login')}}" class="nav-link">{{__('Sign in')}}</a> </li>
                            @endif

                        </ul>

                        <!-- Nav collapes end --> 

                    </div>
                    <div class="clearfix"></div>
                </nav>

                <!-- Nav end --> 

            </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Header container end -->
