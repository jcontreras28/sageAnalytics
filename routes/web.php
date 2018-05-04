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



Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});



//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changePassword', 'HomeController@showChangePasswordForm')->name('auth.changePassword');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');


//Route::get('/pub/{id}', 'PublicationController@index')->name('pub.index');


Route::group(['middleware' => 'App\Http\Middleware\AccessMiddleware'], function() {

    Route::get('/pub/{id}', 'PublicationController@wrapper')->name('pub.wrapper');
    Route::get('/pub/{id}/admin', 'PublicationController@adminIndex')->name('pub.adminindex');

    Route::get('/admin', 'AdminController@superAdmin')->name('admin.superAdmin');    

    // publication routes
    Route::get('/admin/newpub', 'AdminController@newPub')->name('admin.newPub');
    Route::post('/admin/store', 'AdminController@store')->name('admin.store');
    Route::get('/admin/editpub/{id}', 'AdminController@editPub')->name('admin.editPub');
    Route::patch('/admin/updatePub/{id}', 'AdminController@updatePub')->name('admin.updatePub');
    Route::get('/admin/deletepub/{id}', 'AdminController@deletePub')->name('admin.deletePub');
    Route::get('/admin/trash', 'AdminController@viewTrash')->name('admin.trash');
    Route::get('/admin/trash/{id}/restore', 'AdminController@restorePub')->name('admin.restorePub');
    Route::get('/admin/trash/{id}/permanent-delete', 'AdminController@permanentDeletePub')->name('admin.permanentDeletePub');
    Route::get('/admin/pub/{id}', 'AdminController@pubAdmin')->name('admin.pubAdmin');

    // action routes
    Route::patch('/admin/updateAction/{id}', 'AdminController@updateAction')->name('admin.updateAction');
    Route::post('/admin/storeAction', 'AdminController@storeAction')->name('admin.storeAction');
    Route::get('/admin/deleteAction/{id}', 'AdminController@deleteAction')->name('admin.deleteAction');

    // user routes
    Route::get('/admin/newuser', 'UserController@newUser')->name('admin.newUser');
    Route::post('/admin/storeUser', 'UserController@storeUser')->name('admin.storeUser');
    Route::get('/admin/editUser/{id}', 'UserController@editUser')->name('admin.editUser');
    Route::patch('/admin/updateUser/{id}', 'UserController@updateUser')->name('admin.updateUser');
    Route::get('/admin/deleteuser/{id}', 'UserController@deleteUser')->name('admin.deleteUser');
    Route::get('/admin/usertrash', 'UserController@userViewTrash')->name('admin.userTrash');
    Route::get('/admin/usertrash/{id}/restore', 'UserController@restoreUser')->name('admin.restoreUser');
    Route::get('/admin/usertrash/{id}/permanent-delete', 'UserController@permanentDeleteUser')->name('admin.permanentDeleteUser');
    Route::get('/admin/users/', 'UserController@showUsers')->name('admin.users');

});

// ajax call routes
Route::get('/pub/{id}/refresh/', 'PublicationController@refreshData')->name('pub.refreshData');
Route::get('/pub/{id}/sectionRefresh/', 'PublicationController@sectionRefresh')->name('pub.sectionRefresh');


