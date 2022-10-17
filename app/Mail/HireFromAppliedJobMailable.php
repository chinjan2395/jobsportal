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
        $this->setConfig($job);
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

        return $this->from(config('mail.from.address'), config('mail.from.name'))
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

    private function setConfig($job)
    {
        $company = $job->company;
        $config = array(
            'driver' => $company->mail_driver,
            'host' => $company->mail_host,
            'port' => $company->mail_port,
            'from' => array('address' => $company->mail_from_address, 'name' => $company->mail_from_name),
            'encryption' => $company->mail_encryption,
            'username' => $company->mail_username,
            'password' => $company->mail_password,
            'sendmail' => $company->mail_sendmail,
            'pretend' => $company->mail_pretend,
        );
        \Illuminate\Support\Facades\Config::set('mail', $config);
    }

}
