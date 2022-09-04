<?php
Route::get('company-packages', 'Company\CompanyController@resume_search_packages')->name('company.packages');
Route::get('unloced-seekers', 'Company\CompanyController@unlocked_users')->name('company.unloced-users');
Route::get('unlock/{user}', 'Company\CompanyController@unlock')->name('company.unlock');
Route::get('company-home', 'Company\CompanyController@index')->name('company.home');
Route::get('companies', 'Company\CompaniesController@company_listing')->name('company.listing');
Route::get('company-profile', 'Company\CompanyController@companyProfile')->name('company.profile');
Route::put('update-company-profile', 'Company\CompanyController@updateCompanyProfile')->name('update.company.profile');
Route::get('posted-jobs', 'Company\CompanyController@postedJobs')->name('posted.jobs');
Route::get('company/{slug}', 'Company\CompanyController@companyDetail')->name('company.detail');
Route::post('contact-company-message-send', 'Company\CompanyController@sendContactForm')->name('contact.company.message.send');
Route::post('contact-applicant-message-send', 'Company\CompanyController@sendApplicantContactForm')->name('contact.applicant.message.send');
Route::get('list-applied-users/{job_id}', 'Company\CompanyController@listAppliedUsers')->name('list.applied.users');
Route::get('list-hired-users/{job_id}', 'Company\CompanyController@listHiredUsers')->name('list.hired.users');
Route::get('list-favourite-applied-users/{job_id}', 'Company\CompanyController@listFavouriteAppliedUsers')->name('list.favourite.applied.users');
Route::get('add-to-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@addToFavouriteApplicant')->name('add.to.favourite.applicant');
Route::get('remove-from-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@removeFromFavouriteApplicant')->name('remove.from.favourite.applicant');
Route::get('hire-from-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@hireFromFavouriteApplicant')->name('hire.from.favourite.applicant');


Route::get('removed-from-hired-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@removehireFromFavouriteApplicant')->name('remove.hire.from.favourite.applicant');
Route::get('applicant-profile/{application_id}', 'Company\CompanyController@applicantProfile')->name('applicant.profile');
Route::get('reject-applicant-profile/{application_id}', 'Company\CompanyController@rejectApplicantProfile')->name('reject.applicant.profile');
Route::get('user-profile/{id}', 'Company\CompanyController@userProfile')->name('user.profile');
Route::get('company-followers', 'Company\CompanyController@companyFollowers')->name('company.followers');
/* Route::get('company-messages', 'Company\CompanyController@companyMessages')->name('company.messages'); */
Route::post('submit-message-seeker', 'CompanyMessagesController@submitnew_message_seeker')->name('submit-message-seeker');

Route::get('company-messages', 'CompanyMessagesController@all_messages')->name('company.messages');
Route::get('append-messages', 'CompanyMessagesController@append_messages')->name('append-message');
Route::get('append-only-messages', 'CompanyMessagesController@appendonly_messages')->name('append-only-message');
Route::post('company-submit-messages', 'CompanyMessagesController@submit_message')->name('company.submit-message');
Route::get('company-message-detail/{id}', 'Company\CompanyController@companyMessageDetail')->name('company.message.detail');

Route::get('event/{slug}', 'Company\CompanyController@eventDetail')->name('event.detail');
Route::get('post-event', 'Company\CompanyController@createFrontCompanyEvent')->name('post.event');
Route::get('events', 'Company\CompanyController@eventsBySearch')->name('posted.events');
Route::post('store-front-event', 'Company\CompanyController@storeFrontCompanyEvent')->name('store.front.event');
Route::get('edit-front-event/{id}', 'Company\CompanyController@editFrontCompanyEvent')->name('edit.front.event');
Route::put('update-front-event/{id}', 'Company\CompanyController@updateFrontCompanyEvent')->name('update.front.event');
Route::delete('delete-front-event', 'Company\CompanyController@deleteCompanyEvent')->name('delete.front.event');

Route::get('referrals', 'Company\CompanyController@referrals')->name('posted.referrals');
Route::post('store-front-referral', 'Company\CompanyController@storeFrontReferral')->name('store.front.referral');
Route::delete('delete-front-referral', 'Company\CompanyController@deleteReferral')->name('delete.front.referral');
