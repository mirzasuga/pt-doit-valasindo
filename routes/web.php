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

Route::get('/url/valas', function() {
    $data = [
        'urls' => [
            'put_valas_all'         => route("put_valas_all"),
            'put_valas_rate'        => route("put_valas_rate",['prefix' => null]),
            'put_mitra_all'         => route("mitra_all"),
            'penukaran_store'       => route("penukaran_store"),
            'kuitansi_cetak'        => route("kuitansi_cetak",['tukar_id' => null]),
            'get_kurs_mitra'        => route("get_kurs_mitra",['mitra_id' => null]),
            'ppsv_store'            => route("ppsv_store"),
            'ppsv_all'              => route("ppsv_all",['status' => null]),
            'ppsv_approve'          => route("ppsv_approve"),
        ],
    ];
    return response()->json($data);
})->name("configURLs");


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
Route::get('/test3', function() {
    $tukars = \App\Penukaran::find(1)->detilTukar()->get();
    foreach($tukars as $t) {
        dd($t->valas()->first());
    }
});

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
        'as'    => 'mitra_index',
        'middleware' => 'role:index-mitra'
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

/**
 * ==========
 * PENUKARAN
 * ==========
 */
Route::group(['prefix' => 'dashboard/penukaran'], function() {
    Route::get('/', [
        'uses'  => 'PenukaranController@index',
        'as'    => 'penukaran_index'
    ]);
    Route::post('/store', [
        'uses'  => 'PenukaranController@store',
        'as'    => 'penukaran_store'
    ]);
});

/**
 * ===============
 *      VALAS
 * ===============
 */
Route::get('/valas/all',[
    'uses'  => 'ValasController@putAll',
    'as'    => 'put_valas_all'
 ]);
 Route::get('/valas/rate/{prefix}',[
    'uses'  => 'ValasController@putValasRate',
    'as'    => 'put_valas_rate'
 ]);

Route::get('/valas/entry',[
    'uses' => 'ValasController@index'
])->name('getentry.valas');
Route::post('/valas/entry',[
    'uses' => 'ValasController@postEntry'
])->name('postentry.valas');


/**
 * KUITANSI
 */

Route::group(['prefix' => 'dashboard/kuitansi'], function() {
    Route::get('/cetak-kuitansi/{tukar_id}',[
        'uses'  => 'KuitansiController@cetak',
        'as'    => 'kuitansi_cetak'
    ]);
});

/**
 * ==============
 *      PPSV
 * ==============
 */
Route::group(['prefix' => 'dashboard/permintaan-pembelian-stok-valas/'], function() {
    Route::get('/', [
        'uses'          => 'PpsvController@index',
        'as'            => 'ppsv_index',
        'middleware'    => 'role:ppsv-index'
    ]);
    Route::post('/store', [
        'uses'          => 'PpsvController@store',
        'as'            => 'ppsv_store',
        'middleware'    => 'role:ppsv-store'
    ]);
    Route::get('/approvals',[
        'uses'          => 'PpsvController@approvals',
        'as'            => 'ppsv_approvals',
        'middleware'    => 'role:ppsv-approval'
    ]);
    Route::get('/all/status-{status}', [
        'uses'          => 'PpsvController@all',
        'as'            => 'ppsv_all',
        'middleware'    => 'role:ppsv-all'
    ]);
    Route::get('/detil-{ppsv_id}', [
        'uses'          => 'PpsvController@detil',
        'as'            => 'ppsv_detil',
        'middleware'    => 'role:ppsv-detil'
    ]);
    Route::post('/approve',[
        'uses'          => 'PpsvController@approve',
        'as'            => 'ppsv_approve',
        'middleware'    => 'role:ppsv-approve'
    ]);
    Route::post('/reject/{ppsv_id}', [
        'uses'          => 'PpsvController@reject',
        'as'            => 'ppsv_reject',
        'middleware'    => 'role:ppsv-reject',
    ]);
}); /**EOF PPSV */

/**
 * ==============
 *      KURS
 * ==============
 */
Route::group(['prefix' => 'kurs'], function() {
    Route::get('/mitra-{mitra_id}', [
        'uses'      => 'KursController@getKursMitra',
        'as'        => 'get_kurs_mitra',
        'middleware'=> 'role:get-kurs-mitra',
    ]);
});

Route::get('/test', function() {
    return 'okeeee';
})->middleware('role:view-kurs');

Route::get('test2', [
    'uses'=> 'KuitansiController@buildKuitansi'
])
->middleware('role:view-dashboard')
->name('test');

Auth::routes();
route::get('/access-denied-401',function() {
    return 'ddd';
})->name('401');
Route::get('/home', 'HomeController@index')->name('home');

