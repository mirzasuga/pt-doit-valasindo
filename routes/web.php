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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home',[
    'uses' => 'HomeController@getHome',
    'as' => 'home'
]);

/**
 * DASHBOARD
 */

Route::get('/dashboard/',[
    'uses' => 'DashboardController@index'
])->name('dashboard');

/**
 * Valas URL
 */

Route::group(['prefix' => 'dashboard/valas'], function() {
    Route::get('/' , [
        'uses' => 'ValasController@index',
        'as'   => 'valas_index'
    ]);
    Route::post('/store',[
        'uses' => 'ValasController@store',
        'as'    => 'valas_store',
        'middleware'    => 'role:store-valas'
    ]);
    Route::get('/all',[
        'uses' => 'ValasController@all',
        'as'    => 'valas_all',
        'middleware'    => 'role:view-valas'
    ]);
    Route::post('/cari',[
        'uses'=> 'ValasController@cari',
        'as'  => 'valas_cari'
    ]);
});

/**
 * MITRA
 */
Route::group(['prefix' => 'dashboard/mitra'],function() {
    Route::get('/',[
        'uses'  => 'MitraController@index',
        'as'    => 'mitra_index'
    ]);
    Route::get('/all',[
        'uses'  => 'MitraController@all',
        'as'    => 'mitra_all'
    ]);
    Route::post('/store',[
        'uses'  => 'MitraController@store',
        'as'    => 'mitra_store'
    ]);
    Route::get('/search/{q}',[
        'uses'  => 'MitraController@search',
        'as'    => 'mitra_search'
    ]);
});

Route::get('/valas/entry',[
    'uses' => 'ValasController@index'
])->name('getentry.valas');
Route::post('/valas/entry',[
    'uses' => 'ValasController@postEntry'
])->name('postentry.valas');

Route::get('/test', function() {
    return 'okeeee';
})->middleware('role:view-kurs');

Route::get('test2', [
    'uses'=> 'ValasController@test'
])
->middleware('role:view-dashboard')
->name('test');

Auth::routes();
route::get('/access-denied-401',function() {
    return 'ddd';
})->name('401');
Route::get('/home', 'HomeController@index')->name('home');

