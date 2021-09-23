<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();



Route::group(['middleware' => ['auth', 'cekroleuser:admin,noc,sales']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user-registration', 'UserController@user_registration_index')->name('user-registration');
    Route::get('/user-approved', 'UserController@user_approved_index')->name('user-approved');
    Route::get('/user-rejected', 'UserController@user_rejected_index')->name('user-rejected');

    Route::post('/user-store', 'UserController@user_store')->name('user-store');

    Route::get('/user-editregistration/{id}', 'UserController@user_edit')->name('user-editregistration');
    Route::get('/user-editapproved/{id}', 'UserController@user_edit')->name('user-editapproved');
    Route::get('/user-editrejected/{id}', 'UserController@user_edit')->name('user-editrejected');
    Route::put('/user-update/{id}', 'UserController@user_update')->name('user-update');

    Route::put('/user-update-password/{id}', 'UserController@user_update_password')->name('user-update-password');

    Route::get('user/active/{id}', "UserController@user_active")->name("user.active");
    Route::get('user/not-active/{id}', "UserController@user_not_active")->name("user.not-active");

    Route::post('/select-delete-user', 'UserController@select_delete_user')->name('select-delete-user');

    Route::resource('link-element', 'LinkController');
    Route::get('/link-element-delete/{id}', 'LinkController@destroy')->name('link-element-delete');

    Route::resource('capacity-element', 'CapacityController');
    Route::get('/capacity-element-delete/{id}', 'CapacityController@destroy')->name('capacity-element-delete');

    Route::resource('site-element', 'SiteController');
    Route::get('/site-element-delete/{id}', 'SiteController@destroy')->name('site-element-delete');
    
    Route::resource('vendor-element', 'VendorController');
    Route::get('/vendor-element-delete/{id}', 'VendorController@destroy')->name('vendor-element-delete');
    

    Route::get('/noc-dialy-report', 'NocReportController@noc_dialy_report')->name('noc-dialy-report');
    Route::get('/noc-dialy-report-edit/{id}', 'NocReportController@noc_dialy_report_editshow')->name('noc-dialy-report-edit');
    Route::get('/noc-dialy-report-show/{id}', 'NocReportController@noc_dialy_report_editshow')->name('noc-dialy-report-show');
    Route::put('/noc-dialy-report-update/{id}', 'NocReportController@noc_dialy_report_update')->name('noc-dialy-report-update');
    Route::post('/select-delete-dialy-report-noc', 'NocReportController@select_delete_dialy_report_noc')->name('select-delete-dialy-report-noc');

    Route::post('/noc-dialy-reportstore', 'NocReportController@noc_dialy_report_store')->name('noc-dialy-reportstore');
    



});




