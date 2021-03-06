<?php

use Illuminate\Support\Facades\Route;
use App\Models\MsMngr;

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




Route::group(['middleware' => ['auth', 'cekroleuser:admin']], function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/mngr-store', 'HomeController@mngr_store')->name('mngr-store');
    Route::put('/mngr-update/{id}', 'HomeController@mngr_update')->name('mngr-update');


    Route::get('/user-registration', 'UserController@user_registration_index')->name('user-registration');
    Route::get('/user-approved', 'UserController@user_approved_index')->name('user-approved');
    Route::get('/user-rejected', 'UserController@user_rejected_index')->name('user-rejected');

    Route::post('/user-store', 'UserController@user_store')->name('user-store');

    Route::get('/user-editregistration/{id}', 'UserController@user_edit')->name('user-editregistration');
    Route::get('/user-editapproved/{id}', 'UserController@user_edit')->name('user-editapproved');
    Route::get('/user-editrejected/{id}', 'UserController@user_edit')->name('user-editrejected');
    // Route::put('/user-update/{id}', 'UserController@user_update')->name('user-update');
    // Route::put('/user-update-password/{id}', 'UserController@user_update_password')->name('user-update-password');
    Route::get('/user-approve-print', 'UserController@user_approve_print')->name('user-approve-print');


    Route::get('user/active/{id}', "UserController@user_active")->name("user.active");
    Route::get('user/not-active/{id}', "UserController@user_not_active")->name("user.not-active");

    Route::post('/select-delete-user', 'UserController@select_delete_user')->name('select-delete-user');


    Route::get('/perform-noc-history', 'NocReportController@perform_noc_history')->name('perform-noc-history');
    Route::get('/perform-noc-history-get', 'NocReportController@perform_noc_history_get')->name('perform-noc-history-get');
    Route::get('/pdf-perform-noc-history', 'NocReportController@download_perform_noc_history')->name('pdf-perform-noc-history');
    Route::get('/excelex-perform-noc-history', 'NocReportController@excelex_perform_noc_history')->name('excelex-perform-noc-history');


    Route::get('/perform-sales-history', 'SalesReportController@perform_sales_history')->name('perform-sales-history');
    Route::get('/perform-sales-history-get', 'SalesReportController@perform_sales_history_get')->name('perform-sales-history-get');
    Route::get('/pdf-perform-sales-history', 'SalesReportController@download_perform_sales_history')->name('pdf-perform-sales-history');
    Route::get('/excelex-perform-sales-history', 'SalesReportController@excelex_perform_sales_history')->name('excelex-perform-sales-history');

    
});

Route::group(['middleware' => ['auth', 'cekroleuser:admin,noc,sales']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/edit-profil-password/{id}', 'UserController@user_edit')->name('edit-profil-password');
    Route::put('/user-update/{id}', 'UserController@user_update')->name('user-update');
    Route::put('/user-update-password/{id}', 'UserController@user_update_password')->name('user-update-password');

    Route::resource('client-element', 'ClientController');
    Route::get('/client-create-wuuid/{uuid}', 'ClientController@client_create_wuuid')->name('client-create-wuuid');
    Route::get('/client-element-delete/{id}', 'ClientController@destroy')->name('client-element-delete');
});

Route::group(['middleware' => ['auth', 'cekroleuser:admin,noc']], function () {

    Route::get('/noc-daily-report', 'NocReportController@noc_daily_report')->name('noc-daily-report');
    Route::post('/noc-daily-reportstore', 'NocReportController@noc_daily_report_store')->name('noc-daily-reportstore');
    Route::get('/noc-daily-report-edit/{id}', 'NocReportController@noc_daily_report_editshow')->name('noc-daily-report-edit');
    Route::get('/noc-daily-report-show/{id}', 'NocReportController@noc_daily_report_editshow')->name('noc-daily-report-show');
    Route::put('/noc-daily-report-update/{id}', 'NocReportController@noc_daily_report_update')->name('noc-daily-report-update');
    Route::post('/select-delete-daily-report-noc', 'NocReportController@select_delete_daily_report_noc')->name('select-delete-daily-report-noc');

    Route::get('/pdf-daily-report-noc', 'NocReportController@pdf_daily_report_noc')->name('pdf-daily-report-noc');

    Route::resource('link-element', 'LinkController');
    Route::get('/link-element-delete/{id}', 'LinkController@destroy')->name('link-element-delete');

    Route::resource('capacity-element', 'CapacityController');
    Route::get('/capacity-element-delete/{id}', 'CapacityController@destroy')->name('capacity-element-delete');

    Route::resource('site-element', 'SiteController');
    Route::get('/site-element-delete/{id}', 'SiteController@destroy')->name('site-element-delete');
    
    Route::resource('vendor-element', 'VendorController');
    Route::get('/vendor-element-delete/{id}', 'VendorController@destroy')->name('vendor-element-delete');

});

Route::group(['middleware' => ['auth', 'cekroleuser:admin,sales']], function () {

    Route::get('/sales-lobbyist-process', 'SalesReportController@sales_lobbyist_process')->name('sales-lobbyist-process');
    Route::post('/sales-lobbyist-store', 'SalesReportController@sales_lobbyist_store')->name('sales-lobbyist-store');
    Route::put('/sales-lobbyist-update/{id}', 'SalesReportController@sales_lobbyist_update')->name('sales-lobbyist-update');
    Route::post('/select-delete-lobbyist', 'SalesReportController@select_delete_lobbyist')->name('select-delete-lobbyist');

    Route::get('/sales-daily-report', 'SalesReportController@sales_daily_report')->name('sales-daily-report');
    Route::get('/sales-daily-report-create-nemail', 'SalesReportController@sales_daily_report_create_nemail')->name('sales-daily-report-create-nemail');
    Route::get('/sales-daily-report-create/{emailclient}', 'SalesReportController@sales_daily_report_wemail')->name('sales-daily-report-create');
    Route::post('/sales-daily-report-store', 'SalesReportController@sales_daily_report_store')->name('sales-daily-report-store');
    
    Route::get('/salesdaily-getprice-capacit', "SalesReportController@getprice_capacitybandwith");

    Route::get('/sales-daily-report-edit/{id}', 'SalesReportController@sales_daily_report_editshow')->name('sales-daily-report-edit');
    Route::get('/sales-daily-report-show/{id}', 'SalesReportController@sales_daily_report_showonly')->name('sales-daily-report-show');
    Route::put('/sales-daily-report-update/{id}', 'SalesReportController@sales_daily_report_update')->name('sales-daily-report-update');
    Route::post('/select-delete-daily-report-sales', 'SalesReportController@select_delete_daily_report_sales')->name('select-delete-daily-report-sales');

    Route::get('/pdf-daily-report-sales', 'SalesReportController@pdf_daily_report_sales')->name('pdf-daily-report-sales');
    Route::get('/pdf-daily-report-sales-detail/{id}', 'SalesReportController@pdf_daily_report_sales_detail')->name('pdf-daily-report-sales-detail');

});




