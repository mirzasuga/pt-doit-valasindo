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
            'valas_edit'            => route("valas_edit"),
            'put_mitra_all'         => route("mitra_all"),
            'penukaran_store'       => route("penukaran_store"),
            'kuitansi_cetak'        => route("kuitansi_cetak",['tukar_id' => null]),
            'put_kurs_mitra'        => route("put_kurs_mitra",['mitra_id' => null]),
            'ppsv_store'            => route("ppsv_store"),
            'ppsv_all'              => route("ppsv_all",['status' => null]),
            'ppsv_approve'          => route("ppsv_approve"),
            'ppsv_approved'         => route("ppsv_approved",['ppsv_id' => null,'detil' => null]),
            'ppsv_reject'           => route("ppsv_reject"),
            'ppsv_filter'           => route("ppsv_filter",['status' => null,'tanggal' => null]),
            'ppsv_viewed'           => route("ppsv_viewed",['ppsv_id' => null]),

            'btupsv_store'          => route("btupsv_store"),
            'btupsv_cetak'          => route("btupsv_cetak",['btupsv_id' => null]),
            
            'bbsv_upload_kuitansi'  => route("bbsv_upload_kuitansi"),
            'bbsv_store'            => route("bbsv_store"),
            'bbsv_cetak'            => route("bbsv_cetak",['bbsvId' => null]),

            'put_user_all'     => route("put_user_all",['jenis' => null]),

            'cek_role'              => route('cek_role'),
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
        'uses'          => 'ValasController@index',
        'as'            => 'valas_index',
        'middleware'    => 'role:valas-index'
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
    Route::post('edit',[
        'uses'          => 'ValasController@edit',
        'as'            => 'valas_edit',
        'middleware'    => 'role:valas-edit'
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
    Route::get('/status', [
        'uses'          => 'PpsvController@statusPermintaan',
        'as'            => 'ppsv_status_view',
        'middleware'    => 'role:ppsv-status-view',
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
    Route::get('/filter/{status}/{tanggal}', [
        'uses'          => 'PpsvController@filter',
        'as'            => 'ppsv_filter',
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
    Route::get('/approved/{ppsv_id}/{detil}',[
        'uses'          => 'PpsvController@approved',
        'as'            => 'ppsv_approved',
        'middleware'    => 'role:ppsv-approved'
    ]);
    Route::get('/viewed/{ppsv_id}', [
        'uses'          => 'PpsvController@viewed',
        'as'            => 'ppsv_viewed',
        'middleware'    => 'role:ppsv-view'
    ]);
    Route::post('/reject', [
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
        'as'        => 'put_kurs_mitra',
        'middleware'=> 'role:put-kurs-mitra',
    ]);
});


/**
 * =========
 * BTUPSV
 * =========
 */
Route::group(['prefix' => '/dashboard/btupsv'], function() {
    Route::get('/', [
        'uses'      => 'BtupsvController@index',
        'as'        => 'btupsv_index'
    ]);
    Route::post('/store', [
        'uses'          => 'BtupsvController@store',
        'as'            => 'btupsv_store',
        'middleware'    => 'role:btupsv-store',
    ]);
    Route::get('/cetak/{btupsv_id}', [
        'uses'          => 'BtupsvController@cetak',
        'as'            => 'btupsv_cetak'
    ]);
});

/**
 * BBSV
 */
Route::group(['prefix' => 'dashboard/bbsv'], function() {
    Route::get('/',[
        'uses'      => 'BbsvController@index'
    ]);

    Route::get('/entry',[
        'uses'      => 'bbsv\BbsvController@entry',
        'as'        => 'bbsv_entry',
        //'middleware'=> 'role:bbsv-entry'
    ]);

    Route::post('/upload-kuitansi', [
        'uses'      => 'bbsv\BbsvUploadController@upload',
        'as'        => 'bbsv_upload_kuitansi'
    ]);
    Route::post('/store', [
        'uses'      => 'bbsv\BbsvController@store',
        'as'        => 'bbsv_store'
    ]);
    Route::get('cetak/{bbsvId}',[
        'uses'      => 'bbsv\BbsvController@cetak',
        'as'        => 'bbsv_cetak'
    ]);
});



/**
 * =========
 *  USER
 * =========
 */
Route::group(['prefix' => 'users'], function() {
    Route::get('/find-all/{jenis}',[
        'uses'     => 'UserController@findAll',
        'as'       => 'put_user_all'
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

Route::get('/beautify/{role_id}',function($role_id) {
    //$role = \App\Role::find($role_id);
    $user = Auth::user()->roles()->get();
    return response()->json($user);
});

Route::get('user/cek-role', [
    'uses'  => 'UserController@cekRole',
    'as'    => 'cek_role'
]);