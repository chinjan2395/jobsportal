<?php


namespace App\Exports\Company;

use App\JobApply;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobApplicationReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function query()
    {
        return JobApply::select(['*'])
            ->with([
                'user',
                'user.careerLevel', 'user.functionalArea', 'user.industry', 'user.jobExperience'
            ])
            ->where('job_id', '=', $this->job);
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Company',
            'Job Title',
            'Name',
            'Email',
            'Current Salary',
            'Expected Salary',
            'Salary Currency',
            'Career Level',
            'Functional Area',
            'Industry',
            'Job Experience',
            'Applied Date',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($application): array
    {
        $user = $application->user;
        return isset($user)
            ? [
                optional(optional(optional($application)->job)->company)->name,
                optional(optional($application)->job)->title,
                optional($user)->name,
                optional($user)->email,
                $application->current_salary,
                $application->expected_salary,
                $application->salary_currency,
                optional(optional($user)->careerLevel)->career_level,
                optional(optional($user)->functionalArea)->functional_area,
                optional(optional($user)->industry)->industry,
                optional(optional($user)->jobExperience)->job_experience,
                $application->created_at
            ]
            : ['User not available', '-', '-', '-', '-', '-', '-', '-', '-', '-'];
    }
}
