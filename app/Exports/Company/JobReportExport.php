<?php


namespace App\Exports\Company;

use App\Job;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return Job::select([
            'jobs.id', 'jobs.company_id', 'jobs.title', 'jobs.description', 'jobs.country_id', 'jobs.state_id', 'jobs.city_id', 'jobs.is_freelance', 'jobs.career_level_id', 'jobs.salary_from', 'jobs.salary_to', 'jobs.hide_salary', 'jobs.functional_area_id', 'jobs.job_type_id', 'jobs.job_shift_id', 'jobs.num_of_positions', 'jobs.gender_id', 'jobs.expiry_date', 'jobs.degree_level_id', 'jobs.job_experience_id', 'jobs.is_active', 'jobs.is_featured',
        ])
            ->with([
                'jobSkills', 'careerLevel', 'functionalArea', 'jobType', 'jobShift', 'salaryPeriod', 'gender', 'degreeLevel',
                'jobExperience', 'shortListCandidates', 'shortListCandidates',
            ])
            ->withCount(['jobApplications', 'shortListCandidates', 'hiredCandidates'])
            ->where('jobs.company_id', '=', Auth::guard('company')->user()->id);
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Job Title',
            'City',
            'Degree',
            'Type',
            'Experience',
            'Job Applications',
            'Shortlisted',
            'Hired',
            'Salary Criteria',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($job): array
    {
        return [
            $job->title,
            optional($job->city)->city,
            optional($job->degreeLevel)->degree_level,
            optional($job->jobType)->job_type,
            optional($job->jobExperience)->job_experience,
            $job->job_applications_count <= 0 ? '-' : $job->job_applications_count,
            $job->short_list_candidates_count <= 0 ? '-' : $job->short_list_candidates_count,
            $job->hired_candidates_count <= 0 ? '-' : $job->hired_candidates_count,
            $job->salary_from . ' - ' . $job->salary_to,
        ];
    }
}
