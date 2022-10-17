<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyRegisteredMailable extends Mailable
{

    use SerializesModels;

    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
        $this->setConfig($company);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject('Employer/Company "' . $this->company->name . '" has been registered on "' . config('app.name'))
                        ->view('emails.company_registered_message')
                        ->with(
                                [
                                    'name' => $this->company->name,
                                    'email' => $this->company->email,
                                    'link' => route('company.detail', $this->company->slug),
                                    'link_admin' => route('edit.company', ['id' => $this->company->id])
                                ]
        );
    }

    private function setConfig($company)
    {
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
