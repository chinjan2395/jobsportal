<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobPostedMailable extends Mailable
{

    use SerializesModels;

    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job)
    {
        $this->job = $job;
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
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject('Employer/Company "' . $company->name . '" has posted new job on "' . config('app.name'))
                        ->view('emails.job_posted_message')
                        ->with(
                                [
                                    'name' => $company->name,
                                    'link' => route('job.detail', [$this->job->slug]),
                                    'link_admin' => route('edit.job', ['id' => $this->job->id])
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
