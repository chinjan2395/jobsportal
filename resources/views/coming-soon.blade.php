@extends('layouts.app')
@section('content')
    <div class="md:flex min-h-screen">
        <div class="w-full md:w-1 bg-white flex items-center justify-center">
            <div class="max-w-sm m-8 text-center" style="margin: 0 auto">
                <div class="text-black text-5xl md:text-15xl font-black">Coming Soon</div>

                <div class="w-16 h-1 bg-purple-light my-3 md:my-6" style="margin: 0 auto;"></div>

                <p class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal">
                    We are developing. Please check back soon.</p>
            </div>
        </div>
    </div>
@endsection
<link href="{{ asset('/') }}admin_assets/pages/css/coming-soon.css" rel="stylesheet" type="text/css"/>
