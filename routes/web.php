<?php

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
    return view('welcome');
});

Auth::routes(); //The method routes(); is implemented in core of the framework in the file /vendor/laravel/framework/src/Illuminate/Routing/Router.php public function auth()

Route::get('/home', 'HomeController@index')->name('home');

//facebook login
Route::get('/redirect', 'SocialController@redirect');
Route::get('auth/{provider}/callback', 'SocialController@callback');

//Google login
Route::get('/redirect/google', 'SocialAuthGoogleController@redirect')->name('google');
Route::get('/callback', 'SocialAuthGoogleController@callback');

//verify user after registration
Auth::routes(['verify' => true]); //untuk menjalankan kode ini tambahkan implements MustVerifyEmail di User.php

//applicant register page
Route::get('/applicant', 'ApplicantController@register')->name('applicant');

Route::group(['middleware' => ['auth']], function () {
    //Manage Role
    Route::resource('roles', 'RoleController');

    //Manage Categories
    Route::get('/categories/adminPDF', 'CategoryController@downloadPDF')->name('categories.pdf');
    Route::get('/categories/downloadExcel', 'CategoryController@downloadExcel')->name('categories.excel');
    Route::get('/categories/downloadWord', 'CategoryController@downloadWord')->name('categories.word');
    Route::get('/category/{id}/edit',  ['as' => 'category.edit', 'uses' => 'CategoryController@edit']); //for breadcrumbs
    Route::resource('categories', 'CategoryController');
    Route::delete('/category/{id}/destroy', 'CategoryController@destroy')->name('categories.destroy');
    Route::delete('/category/{id}/delete-permanent', 'CategoryController@deletePermanent')->name('categories.delete-permanent');
    Route::get('categoriesadminDeleteAll', 'CategoryController@deleteMultiple');
    Route::get('searchcategories', 'CategoryController@ajaxSearch');

    //Manage Products
    Route::get('/products/adminPDF', 'ProductController@downloadPDF')->name('products.pdf');
    Route::get('/products/downloadExcel', 'ProductController@downloadExcel')->name('products.excel');
    Route::get('/products/downloadWord', 'ProductController@downloadWord')->name('products.word');
    Route::get('/product/{id}/edit',  ['as' => 'product.edit', 'uses' => 'ProductController@edit']); //for breadcrumbs
    Route::resource('products', 'ProductController');
    Route::delete('/product/{id}/delete-permanent', 'ProductController@deletePermanent')->name('products.delete-permanent');
    Route::delete('/product/{id}/delete-image', 'ProductController@deleteImage')->name('products.delete-image');
    Route::get('product-deleteMultiple', 'ProductController@deleteMultiple');

    //Manage Users
    Route::get('/users/adminPDF', 'UserController@downloadPDF')->name('users.pdf');
    Route::get('/users/downloadExcel', 'UserController@downloadExcel')->name('users.excel');
    Route::get('/users/downloadWord', 'UserController@downloadWord')->name('users.word');
    Route::get('/users/activeAdminPDF', 'UserController@downloadActiveAdminPDF')->name('users.pdfactiveadmin');
    Route::get('/users/downloadActiveExcel', 'UserController@downloadActiveExcel')->name('users.activeexcel');
    Route::get('/users/activeAdminWord', 'UserController@downloadActiveAdminWord')->name('users.wordactiveadmin');
    Route::get('/users/inactiveAdminPDF', 'UserController@downloadInactiveAdminPDF')->name('users.pdfinactiveadmin');
    Route::get('/users/downloadInactiveExcel', 'UserController@downloadInactiveExcel')->name('users.inactiveexcel');
    Route::get('/users/inactiveAdminWord', 'UserController@downloadInactiveAdminWord')->name('users.wordinactiveadmin');
    Route::get('users/trash', 'UserController@trash')->name('users.trash');
    Route::get('/user/{id}/restore', 'UserController@restore')->name('users.restore');
    Route::get('usersadminRestoreAll', 'UserController@restoreMultiple');
    Route::delete('/user/{id}/delete-permanent', 'UserController@deletePermanent')->name('users.delete-permanent');
    Route::get('usersadminDeleteAll', 'UserController@deleteMultiple');
    Route::name('users.active')->get('/users/active', 'UserController@active');
    Route::name('users.inactive')->get('/users/inactive', 'UserController@inactive');
    Route::get('/user/{id}/activate', 'UserController@activate')->name('users.activate');
    Route::get('/user/{id}/deactivate', 'UserController@deactivate')->name('user.deactivate');
    Route::get('usersadminDeactivateAll', 'UserController@deactivateMultiple');
    Route::get('usersadminActivateAll', 'UserController@activateMultiple');
    Route::get('searchrole', 'UserController@ajaxSearch');
    Route::get('/user/{id}/edit',  ['as' => 'user.edit', 'uses' => 'UserController@edit']); //for breadcrumbs
    Route::resource('users', 'UserController');
    Route::get('usersadminTrashAll', 'UserController@destroyMultiple'); //for multiple trash

    //Profile
    Route::get('/profile/{username}', 'ProfileUserController@show')->name('show.applicant');
    Route::get('saveForm', 'ProfileUserController@update');
    Route::get('/usersadmin/{id}/avatar', 'ProfileUserController@deleteAvatar')->name('delete.avatar');
    Route::get('password/change', 'ProfileUserController@changePassword');
    Route::post('password/change', 'ProfileUserController@postChangePassword');
    Route::resource("profile", 'ProfileUserController'); //tidak boleh diletakkan di urutan pertama agar route ke view bekerja. Kode ini akan mengenerate otomatis route edit, index, store, create, edit, destroy, update, show

    //applicant index page
    Route::get('applicantsTrashAll', 'ApplicantController@destroyMultiple'); //for multiple trash
    Route::get('applicants/trash', 'ApplicantController@trash')->name('applicants.trash');
    Route::get('/applicants/{id}/restore', 'ApplicantController@restore')->name('applicants.restore');
    Route::get('applicantsRestoreAll', 'ApplicantController@restoreMultiple');
    Route::delete('/applicants/{id}/delete-permanent', 'ApplicantController@deletePermanent')->name('applicants.delete-permanent');
    Route::get('applicantsDeleteAll', 'ApplicantController@deleteMultiple');
    Route::name('applicants.pending')->get('/applicants/pending', 'ApplicantController@pending');
    Route::name('applicants.showapproved')->get('/applicants/show-approved', 'ApplicantController@showApproved');
    Route::name('applicants.showrejected')->get('/applicants/show-rejected', 'ApplicantController@showRejected');
    Route::get('/applicant/{id}/approve', 'ApplicantController@approve')->name('applicants.approve');
    Route::get('applicantsApproveAll', 'ApplicantController@approveMultiple');
    Route::get('applicantsRejectAll', 'ApplicantController@rejectMultiple');
    Route::get('/applicant/{id}/reject', 'ApplicantController@reject')->name('applicants.reject');
    Route::get('/applicant/{id}/hold', 'ApplicantController@hold')->name('applicants.hold');
    Route::get('applicantsHoldAll', 'ApplicantController@holdMultiple');
    Route::resource('applicants', 'ApplicantController');
});
