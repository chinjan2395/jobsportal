<?php


namespace App\Exports\Company;

use App\FavouriteApplicant;
use App\JobApply;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShortListedAndHiredReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $job;
    public $exportModel;

    public function __construct($job, $type)
    {
        $this->job = $job;
        switch ($type) {
            case 'short-listed-candidate':
                $this->exportModel = FavouriteApplicant::where('job_id', '=', $this->job);
                break;
            case 'hired-candidate':
                $this->exportModel = FavouriteApplicant::where('status', 'hired')->where('job_id', '=', $this->job);
                break;
        }
    }

    public function query()
    {
        return $this->exportModel->select(['*'])
            ->with([
                'user',
                'user.careerLevel', 'user.functionalArea', 'user.industry', 'user.jobExperience'
            ]);
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
        $name = '';
        $title = '';
        $current_salary = 0;
        $expected_salary = 0;
        $salary_currency = 0;

        $user = $application->user;
        if (isset($user)) {
            $jobApply = JobApply::where('user_id', $user->id)->where('job_id', $application->job_id)->get();

            if ($jobApply->count() > 0) {
                $jobApply = $jobApply->first();
                $name = optional(optional(optional($jobApply)->job)->company)->name;
                $title = optional(optional($jobApply)->job)->title;
                $current_salary = $jobApply->current_salary;
                $expected_salary = $jobApply->expected_salary;
                $salary_currency = $jobApply->salary_currency;
            }
        }

        return isset($user)
            ? [
                $name,
                $title,
                optional($user)->name,
                optional($user)->email,
                $current_salary,
                $expected_salary,
                $salary_currency,
                optional(optional($user)->careerLevel)->career_level,
                optional(optional($user)->functionalArea)->functional_area,
                optional(optional($user)->industry)->industry,
                optional(optional($user)->jobExperience)->job_experience,
                $application->created_at
            ]
            : ['User not available', '-', '-', '-', '-', '-', '-', '-', '-', '-'];
    }
}
