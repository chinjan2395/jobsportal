<?php

namespace App\Http\Controllers\Admin;

use App\CareerLevel;
use App\Company;
use App\Employee;
use App\FunctionalArea;
use App\Helpers\DataArrayHelper;
use App\JobApply;
use App\JobApplyRejected;
use App\User;
use App\Job;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function report()
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $degreeLevels = DataArrayHelper::defaultDegreelevelsArray();
        $jobTypes = DataArrayHelper::defaultJobTypesArray();
        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();
        $jobCareers = DataArrayHelper::defaultCareerLevelsArray();
        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();

        return view('admin.report')
            ->with('companies', $companies)
            ->with('countries', $countries)
            ->with('degreeLevels', $degreeLevels)
            ->with('jobTypes', $jobTypes)
            ->with('jobExperiences', $jobExperiences)
            ->with('jobCareers', $jobCareers)
            ->with('functionalAreas', $functionalAreas)
            ;
    }

    public function fetchData(Request $request)
    {
        $jobs = Job::select([
            'jobs.id', 'jobs.company_id', 'jobs.title', 'jobs.description', 'jobs.country_id', 'jobs.state_id', 'jobs.city_id', 'jobs.is_freelance', 'jobs.career_level_id', 'jobs.salary_from', 'jobs.salary_to', 'jobs.hide_salary', 'jobs.functional_area_id', 'jobs.job_type_id', 'jobs.job_shift_id', 'jobs.num_of_positions', 'jobs.gender_id', 'jobs.expiry_date', 'jobs.degree_level_id', 'jobs.job_experience_id', 'jobs.is_active', 'jobs.is_featured',
        ])
            ->with([
                'jobSkills', 'careerLevel', 'functionalArea', 'jobType', 'jobShift', 'salaryPeriod', 'gender', 'degreeLevel',
                'jobExperience', 'shortListCandidates', 'shortListCandidates',
            ])
            ->withCount(['jobApplications', 'shortListCandidates', 'hiredCandidates'])
        ;
        return Datatables::of($jobs)
            ->filter(function ($query) use ($request) {
                if ($request->has('company_id') && !empty($request->company_id)) {
                    $query->where('jobs.company_id', '=', "{$request->get('company_id')}");
                }
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('jobs.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('country_id') && !empty($request->country_id)) {
                    $query->where('jobs.country_id', '=', "{$request->get('country_id')}");
                }
                if ($request->has('state_id') && !empty($request->state_id)) {
                    $query->where('jobs.state_id', '=', "{$request->get('state_id')}");
                }
                if ($request->has('city_id') && !empty($request->city_id)) {
                    $query->where('jobs.city_id', '=', "{$request->get('city_id')}");
                }
                if ($request->has('is_active') && $request->is_active != -1) {
                    $query->where('jobs.is_active', '=', "{$request->get('is_active')}");
                }
                if ($request->has('degree_level_id') && $request->degree_level_id != null) {
                    $query->where('jobs.degree_level_id', '=', "{$request->get('degree_level_id')}");
                }
                if ($request->has('job_type_id') && $request->job_type_id != null) {
                    $query->where('jobs.job_type_id', '=', "{$request->get('job_type_id')}");
                }
                if ($request->has('job_experience_id') && $request->job_experience_id != null) {
                    $query->where('jobs.job_experience_id', '=', "{$request->get('job_experience_id')}");
                }
                if ($request->has('career_level_id') && $request->career_level_id != null) {
                    $query->where('jobs.career_level_id', '=', "{$request->get('career_level_id')}");
                }
                if ($request->has('functional_area_id') && $request->functional_area_id != null) {
                    $query->where('jobs.functional_area_id', '=', "{$request->get('functional_area_id')}");
                }
            })
            ->addColumn('company_id', function ($jobs) {
                return $jobs->getCompany('name');
            })
            ->addColumn('city_id', function ($jobs) {
                return $jobs->getCity('city') . '(' . $jobs->getState('state') . '-' . $jobs->getCountry('country') . ')';
            })
            ->addColumn('salary', function ($jobs) {
                return $jobs->salary_from  . ' - ' . $jobs->salary_to;
            })
            ->addColumn('career_level', function ($jobs) {
                return $jobs->career_level ? $jobs->career_level : (new CareerLevel(['career_level' => '-']))->toArray();
            })
            ->addColumn('functional_area', function ($jobs) {
                return $jobs->functional_area ? $jobs->functional_area : (new FunctionalArea(['functional_area' => '-']))->toArray();
            })
            ->addColumn('job_applications_count', function ($jobs) {
                if ($jobs->job_applications_count <= 0)
                    return $jobs->job_applications_count;

                return "<a onclick='getJobApplications(".$jobs->id.")'>$jobs->job_applications_count</a>";
            })
            ->rawColumns(['company_id', 'city_id', 'description', 'salary', 'career_level', 'functional_area', 'job_applications_count'])
            ->setRowId(function($jobs) {
                return 'jobDtRow' . $jobs->id;
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function jobApplications(Request $request)
    {
        $applications = Job::findOrFail($request->get('job_id'))->jobApplications;
        return view('admin.modal.job_application')
            ->with('applications', $applications);
    }

}
