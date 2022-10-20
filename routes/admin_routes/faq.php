<?php

/* * ******  FAQ Field Start ********** */
Route::get('list-faqs', array_merge(['uses' => 'Admin\FaqController@indexFaqs'], $all_users))->name('list.faqs');
Route::get('create-faq', array_merge(['uses' => 'Admin\FaqController@createFaq'], $all_users))->name('create.faq');
Route::post('store-faq', array_merge(['uses' => 'Admin\FaqController@storeFaq'], $all_users))->name('store.faq');
Route::get('edit-faq/{id}/{industry_id?}', array_merge(['uses' => 'Admin\FaqController@editFaq'], $all_users))->name('edit.faq');
Route::put('update-faq/{id}', array_merge(['uses' => 'Admin\FaqController@updateFaq'], $all_users))->name('update.faq');
Route::delete('delete-faq', array_merge(['uses' => 'Admin\FaqController@deleteFaq'], $all_users))->name('delete.faq');
Route::get('fetch-faqs', array_merge(['uses' => 'Admin\FaqController@fetchFaqsData'], $all_users))->name('fetch.data.faqs');
Route::get('sort-faq', array_merge(['uses' => 'Admin\FaqController@sortFaqs'], $all_users))->name('sort.faqs');
Route::get('faq-sort-data', array_merge(['uses' => 'Admin\FaqController@faqSortData'], $all_users))->name('faq.sort.data');
Route::put('faq-sort-update', array_merge(['uses' => 'Admin\FaqController@faqSortUpdate'], $all_users))->name('faq.sort.update');
/* * ****** End FAQ Field ********** */

/* * ******  Enquiries & Feedback Start ********** */
Route::get('list-feedback/{type}', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@index'], $all_users))->name('list.feedback');
Route::delete('delete-feedback', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@delete'], $all_users))->name('delete.feedback');
Route::get('fetch-feedback/{type}', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@fetchData'], $all_users))->name('fetch.data.feedback');

Route::get('list-enquiry/{type}', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@index'], $all_users))->name('list.enquiry');
Route::delete('delete-enquiry', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@delete'], $all_users))->name('delete.enquiry');
Route::get('fetch-enquiry/{type}', array_merge(['uses' => 'Admin\FeedbackAndEnquiryController@fetchData'], $all_users))->name('fetch.data.enquiry');
/* * ****** End Enquiries & Feedback ********** */
?>
