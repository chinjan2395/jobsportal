<?php

namespace App\Http\Controllers;


use App\FeedbackAndEnquiry;
use App\Mail\EnquiryJob;
use App\Mail\FeedbackJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use View;
use DB;
use Auth;
use Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Seo;
use App\Job;
use App\Company;
use App\ContactMessage;
use App\ReportAbuseMessage;
use App\ReportAbuseCompanyMessage;
use App\SendToFriendMessage;
use App\Mail\ContactUs;
use App\Mail\EmailToFriend;
use App\Mail\ReportAbuse;
use App\Mail\ReportAbuseCompany;
use App\Http\Requests\Front\ContactFormRequest;
use App\Http\Requests\Front\EmailToFriendFormRequest;
use App\Http\Requests\Front\ReportAbuseFormRequest;
use App\Http\Requests\Front\ReportAbuseCompanyFormRequest;

class ContactController extends Controller
{

    public function index()
    {
        $seo = SEO::where('seo.page_title', 'like', 'contact')->first();
        return view('contact.contact_page')->with('seo', $seo);
    }

    public function postContact(ContactFormRequest $request)
    {
        $data['full_name'] = $request->input('full_name');
        $data['email'] = $request->input('email');
        $data['phone'] = $request->input('phone');
        $data['subject'] = $request->input('subject');
        $data['message_txt'] = $request->input('message_txt');
        $msg_save = ContactMessage::create($data);
        $when = Carbon::now()->addMinutes(5);
        Mail::send(new ContactUs($data));
        return Redirect::route('contact.us.thanks');
    }

    public function thanks()
    {
        $seo = SEO::where('seo.page_title', 'like', 'contact')->first();
        return view('contact.contact_page_thanks')->with('seo', $seo);
    }

    /*     * ******************************************************** */

    public function emailToFriend($slug)
    {
        $job = Job::where('slug', $slug)->first();
        $seo = SEO::where('seo.page_title', 'like', 'email_to_friend')->first();
        return view('contact.email_to_friend_page')->with('job', $job)->with('slug', $slug)->with('seo', $seo);
    }

    public function emailToFriendPost(EmailToFriendFormRequest $request, $slug)
    {
        $data['your_name'] = $request->input('your_name');
        $data['your_email'] = $request->input('your_email');
        $data['friend_name'] = $request->input('friend_name');
        $data['friend_email'] = $request->input('friend_email');
        $data['job_url'] = $request->input('job_url');
        $msg_save = SendToFriendMessage::create($data);
        $when = Carbon::now()->addMinutes(5);
        Mail::send(new EmailToFriend($data));
        return Redirect::route('email.to.friend.thanks');
    }

    public function emailToFriendThanks()
    {
        $seo = SEO::where('seo.page_title', 'like', 'email_to_friend')->first();
        return view('contact.email_to_friend_page_thanks')->with('seo', $seo);
    }

    /*     * ******************************************************** */

    public function reportAbuse($slug)
    {
        $job = Job::where('slug', $slug)->first();
        $seo = SEO::where('seo.page_title', 'like', 'report_abuse')->first();
        return view('contact.report_abuse_page')->with('job', $job)->with('slug', $slug)->with('seo', $seo);
    }

    public function reportAbusePost(ReportAbuseFormRequest $request, $slug)
    {
        $data['your_name'] = $request->input('your_name');
        $data['your_email'] = $request->input('your_email');
        $data['job_url'] = $request->input('job_url');
        $msg_save = ReportAbuseMessage::create($data);
        $when = Carbon::now()->addMinutes(5);
        Mail::send(new ReportAbuse($data));
        return Redirect::route('report.abuse.thanks');
    }

    public function reportAbuseThanks()
    {
        $seo = SEO::where('seo.page_title', 'like', 'report_abuse')->first();
        return view('contact.report_abuse_page_thanks')->with('seo', $seo);
    }

    /*     * ******************************************************** */

    public function reportAbuseCompany($slug)
    {
        $company = Company::where('slug', $slug)->first();
        $seo = SEO::where('seo.page_title', 'like', 'report_abuse')->first();
        return view('contact.report_abuse_company_page')->with('company', $company)->with('slug', $slug)->with('seo', $seo);
    }

    public function reportAbuseCompanyPost(ReportAbuseCompanyFormRequest $request, $slug)
    {
        $data['your_name'] = $request->input('your_name');
        $data['your_email'] = $request->input('your_email');
        $data['company_url'] = $request->input('company_url');
        $msg_save = ReportAbuseCompanyMessage::create($data);
        $when = Carbon::now()->addMinutes(5);
        Mail::send(new ReportAbuseCompany($data));
        return Redirect::route('report.abuse.company.thanks');
    }

    public function reportAbuseCompanyThanks()
    {
        $seo = SEO::where('seo.page_title', 'like', 'report_abuse')->first();
        return view('contact.report_abuse_company_page_thanks')->with('seo', $seo);
    }

    /*     * ******************************************************** */

    public function feedbackOnJob($slug)
    {
        $job = Job::where('slug', $slug)->first();
        return view('contact.feedback_on_job')->with('job', $job)->with('slug', $slug);
    }

    public function feedbackOnJobPost(Request $request)
    {
        $data['your_name'] = $request->input('your_name');
        $data['your_email'] = $request->input('your_email');
        $data['company_url'] = $request->input('company_url');
        FeedbackAndEnquiry::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'actionable_type' => Job::class,
            'actionable_id' => $request->input('job_id'),
            'action' => 'feedback',
            'content' => $request->input('content'),
        ]);
        Mail::send(new FeedbackJob($data));
        return Redirect::route('feedback.job.thanks');
    }

    public function feedbackOnJobThanks()
    {
        return view('contact.feedback_on_job_page_thanks');
    }

    /*     * ******************************************************** */

    public function enquiryOnJob($slug)
    {
        $job = Job::where('slug', $slug)->first();
        return view('contact.enquiry_on_job')->with('job', $job)->with('slug', $slug);
    }

    public function enquiryOnJobPost(Request $request)
    {
        $data['your_name'] = $request->input('your_name');
        $data['your_email'] = $request->input('your_email');
        $data['company_url'] = $request->input('company_url');
        FeedbackAndEnquiry::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'actionable_type' => Job::class,
            'actionable_id' => $request->input('job_id'),
            'action' => 'enquiry',
            'content' => $request->input('content'),
        ]);
        Mail::send(new EnquiryJob($data));
        return Redirect::route('enquiry.job.thanks');
    }

    public function enquiryOnJobThanks()
    {
        return view('contact.enquiry_on_job_page_thanks');
    }

}
