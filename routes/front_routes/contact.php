<?php

Route::get('email-to-friend/{job_slug}', 'ContactController@emailToFriend')->name('email.to.friend');
Route::post('email-to-friend/{job_slug}', 'ContactController@emailToFriendPost')->name('email.to.friend');
Route::get('email-to-friend-thanks', 'ContactController@emailToFriendThanks')->name('email.to.friend.thanks');
Route::get('report-abuse/{job_slug}', 'ContactController@reportAbuse')->name('report.abuse');
Route::post('report-abuse/{job_slug}', 'ContactController@reportAbusePost')->name('report.abuse');
Route::get('report-abuse-thanks', 'ContactController@reportAbuseThanks')->name('report.abuse.thanks');
Route::get('report-abuse-company/{company_slug}', 'ContactController@reportAbuseCompany')->name('report.abuse.company');
Route::post('report-abuse-company/{company_slug}', 'ContactController@reportAbuseCompanyPost')->name('report.abuse.company');
Route::get('report-abuse-company-thanks', 'ContactController@reportAbuseCompanyThanks')->name('report.abuse.company.thanks');

Route::get('feedback-job/{job_slug}', 'ContactController@feedbackOnJob')->name('feedback.job');
Route::post('feedback-job/{job_slug}', 'ContactController@feedbackOnJobPost')->name('feedback.job');
Route::get('feedback-job-thanks', 'ContactController@feedbackOnJobThanks')->name('feedback.job.thanks');

Route::get('enquiry-job/{job_slug}', 'ContactController@enquiryOnJob')->name('enquiry.job');
Route::post('enquiry-job/{job_slug}', 'ContactController@enquiryOnJobPost')->name('enquiry.job');
Route::get('enquiry-job-thanks', 'ContactController@enquiryOnJobThanks')->name('enquiry.job.thanks');
