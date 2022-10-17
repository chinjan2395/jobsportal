<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAppliedCompanyMailable extends Mailable
{

    use SerializesModels;

    public $job;
    public $jobApply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job, $jobApply)
    {
        $this->job = $job;
        $this->jobApply = $jobApply;
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
        $user = $this->jobApply->getUser();
        //        return $this->from($company->email, $company->name)
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                        ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->to($company->email, $company->name)
                        ->subject('Job seeker named "' . $user->name . '" has applied on job "' . $this->job->title)
                        ->view('emails.job_applied_company_message')
                        ->with(
                                [
                                    'job_title' => $this->job->title,
                                    'company_name' => $company->name,
                                    'user_name' => $user->name,
                                    'user_link' => route('user.profile', $user->id),
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
