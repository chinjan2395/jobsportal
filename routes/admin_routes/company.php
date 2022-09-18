<?php



/* * ******  Company Start ********** */

Route::get('list-companies', array_merge(['uses' => 'Admin\CompanyController@indexCompanies'], $all_users))->name('list.companies');

Route::get('list-payment-history', array_merge(['uses' => 'Admin\CompanyController@indexCompaniesHistory'], $all_users))->name('list.payment.hostory');

Route::get('fetch-payment-history', array_merge(['uses' => 'Admin\CompanyController@fetchCompaniesHistory'], $all_users))->name('fetch.data.companiesHistory');

Route::get('create-company', array_merge(['uses' => 'Admin\CompanyController@createCompany'], $all_users))->name('create.company');

Route::post('store-company', array_merge(['uses' => 'Admin\CompanyController@storeCompany'], $all_users))->name('store.company');

Route::get('edit-company/{id}', array_merge(['uses' => 'Admin\CompanyController@editCompany'], $all_users))->name('edit.company');

Route::put('update-company/{id}', array_merge(['uses' => 'Admin\CompanyController@updateCompany'], $all_users))->name('update.company');

Route::delete('delete-company', array_merge(['uses' => 'Admin\CompanyController@deleteCompany'], $all_users))->name('delete.company');

Route::get('fetch-companies', array_merge(['uses' => 'Admin\CompanyController@fetchCompaniesData'], $all_users))->name('fetch.data.companies');

Route::put('make-active-company', array_merge(['uses' => 'Admin\CompanyController@makeActiveCompany'], $all_users))->name('make.active.company');

Route::put('make-not-active-company', array_merge(['uses' => 'Admin\CompanyController@makeNotActiveCompany'], $all_users))->name('make.not.active.company');

Route::put('make-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeFeaturedCompany'], $all_users))->name('make.featured.company');

Route::put('make-not-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeNotFeaturedCompany'], $all_users))->name('make.not.featured.company');

/* * ****** End Company ********** */

/* * ****** Employee Start ********** */
Route::get('list-employee', array_merge(['uses' => 'Admin\CompanyController@indexEmployee'], $all_users))->name('list.employee');
Route::get('fetch-employee', array_merge(['uses' => 'Admin\CompanyController@fetchEmployeesData'], $all_users))->name('fetch.data.employees');
Route::get('create-employee', array_merge(['uses' => 'Admin\CompanyController@createEmployee'], $all_users))->name('create.employee');
Route::post('store-employee', array_merge(['uses' => 'Admin\CompanyController@storeEmployee'], $all_users))->name('store.employee');
Route::get('edit-employee/{id}', array_merge(['uses' => 'Admin\CompanyController@editEmployee'], $all_users))->name('edit.employee');
Route::put('update-employee/{id}', array_merge(['uses' => 'Admin\CompanyController@updateEmployee'], $all_users))->name('update.employee');
/* * ****** Employee End ********** */
