<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
use App\JobApply;
use App\JobApplyRejected;
use App\User;
use App\Job;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now();
        $totalActiveUsers = User::where('is_active', 1)->count();
        $totalVerifiedUsers = User::where('verified', 1)->count();
        $totalTodaysUsers = User::where('created_at', 'like', $today->toDateString() . '%')->count();
        $recentUsers = User::orderBy('id', 'DESC')->take(25)->get();
        $totalActiveJobs = Job::where('is_active', 1)->count();
        $totalFeaturedJobs = Job::where('is_featured', 1)->count();
        $totalTodaysJobs = Job::where('created_at', 'like', $today->toDateString() . '%')->count();
        $recentJobs = Job::orderBy('id', 'DESC')->take(25)->get();

        $companyRegistered = Company::whereMonth('created_at', '=', now()->format('m'))->count();
        $employeeRegistered = Employee::whereMonth('created_at', '=', now()->format('m'))->count();
        $jobApplied = JobApply::whereMonth('created_at', '=', now()->format('m'))->count();
        $jobRejected = JobApplyRejected::whereMonth('created_at', '=', now()->format('m'))->count();
        $recentCompanies = Company::orderBy('id', 'DESC')->take(25)->get();

        return view('admin.home')
                        ->with('totalActiveUsers', $totalActiveUsers)
                        ->with('totalVerifiedUsers', $totalVerifiedUsers)
                        ->with('totalTodaysUsers', $totalTodaysUsers)
                        ->with('recentUsers', $recentUsers)
                        ->with('totalActiveJobs', $totalActiveJobs)
                        ->with('totalFeaturedJobs', $totalFeaturedJobs)
                        ->with('totalTodaysJobs', $totalTodaysJobs)
                        ->with('recentJobs', $recentJobs)
                        ->with('companyRegistered', $companyRegistered)
                        ->with('employeeRegistered', $employeeRegistered)
                        ->with('jobApplied', $jobApplied)
                        ->with('jobRejected', $jobRejected)
                        ->with('recentCompanies', $recentCompanies)
            ;
    }

}
