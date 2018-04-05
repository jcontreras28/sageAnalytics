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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@superAdmin')->name('admin.superAdmin');
Route::get('/admin/newpub', 'AdminController@newPub')->name('admin.newPub');
Route::get('/admin/store', 'AdminController@store')->name('admin.store');
Route::get('/admin/editpub/{id}', 'AdminController@editPub')->name('admin.editPub');
Route::get('/admin/deletepub/{id}', 'AdminController@deletePub')->name('admin.deletePub');
Route::get('/admin/trash', 'AdminController@viewTrash')->name('admin.trash');
Route::get('/admin/trash/{id}/restore', 'AdminController@restorePub')->name('admin.restorePub');
Route::get('/admin/trash/{id}/permanent-delete', 'AdminController@permanentDeletePub')->name('admin.permanentDeletePub');
//Route::get('/pub/{$id}/admin', 'AdminController@pubAdmin')->name('admin.pubAdmin');

Route::get('/pub/{id}', 'PublicationController@index')->name('pub.index');

Route::get('/pub/{id}/admin', 'PublicationController@adminIndex')->name('pub.adminindex');

//Route::get('/pub/{$id}', 'PublicationController@index')->name('pub.index');


// Admin Routes
//Route::get('/admin', 'AdminController@index')->

Route::get('/', function () {
    return redirect('/login');
});