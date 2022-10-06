<?php

namespace App\Mail;

use App\Job;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HireFromAppliedJobMailable extends Mailable
{

    use SerializesModels;

    public $job;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Job $job
     * @param User $user
     */
    public function __construct($job, $user)
    {
        $this->job = $job;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = $this->job->getCompany();
        $user = $this->user;

//        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
        //        return $this->from($company->email, $company->name)
        return $this->from('csr_notification@massar.com', 'CSR Notification')
            ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
            ->to($user->email, $user->name)
            ->subject($user->name . ' you have been hired for job: ' . $this->job->title)
            ->view('emails.hire_from_applied_job_message')
            ->with(
                [
                    'job_title' => $this->job->title,
                    'company_name' => $company->name,
                    'user_name' => $user->name,
                    'company_link' => route('company.detail', $company->slug),
                    'job_link' => route('job.detail', [$this->job->slug])
                ]
            );
    }

}
