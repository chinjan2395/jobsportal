@php
    $companyPublicProfile = Auth::guard('company')->user();
    $companyPublicProfile = $companyPublicProfile->is_employee ? App\Company::findOrFail($companyPublicProfile->belongs_to) : $companyPublicProfile;
@endphp

<div class="col-md-3 col-sm-4">
	<div class="usernavwrap">
    <ul class="usernavdash">
        <li class="{{ Request::url() == route('company.home') ? 'active' : '' }}"><a href="{{route('company.home')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a></li>
        <li class="{{ Request::url() == route('company.report') ? 'active' : '' }}"><a href="{{route('company.report')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Report')}}</a></li>
        <li class="{{ Request::url() == route('company.profile') ? 'active' : '' }}"><a href="{{ route('company.profile') }}"><i class="fa fa-pencil" aria-hidden="true"></i> {{__('Edit Profile')}}</a></li>
        <li><a href="{{ route('company.detail', $companyPublicProfile->slug) }}"><i class="fa fa-address-card-o" aria-hidden="true"></i> {{__('Company Public Profile')}}</a></li>
        <li class="{{ Request::url() == route('post.job') ? 'active' : '' }}"><a href="{{ route('post.job') }}"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('Post Job')}}</a></li>
        <li class="{{ Request::url() == route('posted.jobs') ? 'active' : '' }}"><a href="{{ route('posted.jobs') }}"><i class="fa fa-black-tie" aria-hidden="true"></i> {{__('Company Jobs')}}</a></li>

{{--        <li class="{{ Request::url() == route('company.packages') ? 'active' : '' }}"><a href="{{ route('company.packages') }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('CV Search Packages')}}</a></li>--}}

        <li class="{{ Request::url() == route('company.unloced-users') ? 'active' : '' }}"><a href="{{ route('company.unloced-users') }}"><i class="fa fa-unlock" aria-hidden="true"></i> {{__('Unlocked Users')}}</a></li>

        <li class="{{ Request::url() == route('post.event') ? 'active' : '' }}"><a href="{{ route('post.event') }}"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{__('Post Event')}}</a></li>
        <li class="{{ Request::url() == route('posted.events') ? 'active' : '' }}"><a href="{{ route('posted.events') }}"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{__('Company Events')}}</a></li>
        <li class="{{ Request::url() == route('posted.my.referrals') ? 'active' : '' }}"><a href="{{ route('posted.my.referrals') }}"><i class="fa fa-random" aria-hidden="true"></i> {{__('My Referrals')}}</a></li>
        @if(Auth::guard('company')->user()->is_employee == false)
            <li class="{{ Request::url() == route('posted.employee.referrals') ? 'active' : '' }}"><a href="{{ route('posted.employee.referrals') }}"><i class="fa fa-random" aria-hidden="true"></i> {{__('Employee Referrals')}}</a></li>
        @endif
        <li class="{{ Request::url() == route('company.messages') ? 'active' : '' }}"><a href="{{route('company.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{__('Company Messages')}}</a></li>
        <li class="{{ Request::url() == route('company.followers') ? 'active' : '' }}"><a href="{{route('company.followers')}}"><i class="fa fa-users" aria-hidden="true"></i> {{__('Company Followers')}}</a></li>
        <li><a href="{{ route('company.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a>
            <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        </li>
    </ul>
	</div>
</div>
