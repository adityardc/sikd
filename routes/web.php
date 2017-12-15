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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->middleware('buat_tabel');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Route modul bagian
Route::get('/bagian', 'coBagian@index')->middleware('auth', 'cek_role')->name('bagian');
Route::get('/bagian/data', 'coBagian@listData')->middleware('auth', 'cek_role')->name('bagian.data');
Route::post('/bagian/store', 'cobagian@store')->name('bagian.simpan');
Route::get('/bagian/{id?}/edit', 'cobagian@edit');
Route::put('/bagian/{id?}', 'cobagian@update');
Route::delete('/bagian/{id?}', 'coBagian@destroy');

// Route modul jabatan
Route::get('/jabatan', 'coJabatan@index')->middleware('auth', 'cek_role')->name('jabatan');
Route::get('/jabatan/data', 'coJabatan@listData')->middleware('auth', 'cek_role')->name('jabatan.data');
Route::post('/jabatan/store', 'coJabatan@store')->name('jabatan.simpan');
Route::get('/jabatan/{id?}/edit', 'coJabatan@edit');
Route::put('/jabatan/{id?}', 'coJabatan@update');
Route::delete('/jabatan/{id?}', 'coJabatan@destroy');

// Route modul golongan
Route::get('/golongan', 'coGolongan@index')->middleware('auth', 'cek_role')->name('golongan');
Route::get('/golongan/data', 'coGolongan@listData')->middleware('auth', 'cek_role')->name('golongan.data');
Route::post('/golongan/store', 'coGolongan@store')->name('golongan.simpan');
Route::get('/golongan/{id?}/edit', 'coGolongan@edit');
Route::put('/golongan/{id?}', 'coGolongan@update');
Route::delete('/golongan/{id?}', 'coGolongan@destroy');

// Route modul masa kerja
Route::get('/masakerja', 'coMasakerja@index')->middleware('auth', 'cek_role')->name('masakerja');
Route::get('/masakerja/data', 'coMasakerja@listData')->middleware('auth', 'cek_role')->name('masakerja.data');
Route::post('/masakerja/store', 'coMasakerja@store')->name('masakerja.simpan');
Route::get('/masakerja/{id?}/edit', 'coMasakerja@edit');
Route::put('/masakerja/{id?}', 'coMasakerja@update');
Route::delete('/masakerja/{id?}', 'coMasakerja@destroy');

// Route modul masa pendidikan
Route::get('/pendidikan', 'coPendidikan@index')->middleware('auth', 'cek_role')->name('pendidikan');
Route::get('/pendidikan/data', 'coPendidikan@listData')->middleware('auth', 'cek_role')->name('pendidikan.data');
Route::post('/pendidikan/store', 'coPendidikan@store')->name('pendidikan.simpan');
Route::get('/pendidikan/{id?}/edit', 'coPendidikan@edit');
Route::put('/pendidikan/{id?}', 'coPendidikan@update');
Route::delete('/pendidikan/{id?}', 'coPendidikan@destroy');

// Route modul masa hak akses
Route::get('/hakakses', 'coHakakses@index')->middleware('auth', 'cek_role')->name('hakakses');
Route::get('/hakakses/data', 'coHakakses@listData')->middleware('auth', 'cek_role')->name('hakakses.data');
Route::post('/hakakses/store', 'coHakakses@store')->name('hakakses.simpan');
Route::get('/hakakses/{id?}/edit', 'coHakakses@edit');
Route::put('/hakakses/{id?}', 'coHakakses@update');
Route::delete('/hakakses/{id?}', 'coHakakses@destroy');

// Route modul jenis surat
Route::get('/jenis_surat', 'coJenis_surat@index')->middleware('auth', 'cek_role')->name('jenis_surat');
Route::get('/jenis_surat/data', 'coJenis_surat@listData')->middleware('auth', 'cek_role')->name('jenis_surat.data');
Route::post('/jenis_surat/store', 'coJenis_surat@store')->name('jenis_surat.simpan');
Route::get('/jenis_surat/{id?}/edit', 'coJenis_surat@edit');
Route::put('/jenis_surat/{id?}', 'coJenis_surat@update');
Route::delete('/jenis_surat/{id?}', 'coJenis_surat@destroy');

// Route modul sifat surat
Route::get('/sifat_surat', 'coSifatsurat@index')->middleware('auth', 'cek_role')->name('sifat_surat');
Route::get('/sifat_surat/data', 'coSifatsurat@listData')->middleware('auth', 'cek_role')->name('sifat_surat.data');
Route::post('/sifat_surat/store', 'coSifatsurat@store')->name('sifat_surat.simpan');
Route::get('/sifat_surat/{id?}/edit', 'coSifatsurat@edit');
Route::put('/sifat_surat/{id?}', 'coSifatsurat@update');
Route::delete('/sifat_surat/{id?}', 'coSifatsurat@destroy');

// Route modul masa karyawan
Route::get('/karyawan', 'coKaryawan@index')->middleware('auth', 'cek_role')->name('karyawan');
Route::get('/karyawan/data', 'coKaryawan@listData')->middleware('auth', 'cek_role')->name('karyawan.data');
Route::post('/karyawan/store', 'coKaryawan@store')->name('karyawan.simpan');
Route::get('/karyawan/{id?}/edit', 'coKaryawan@edit');
Route::post('/karyawan/{id?}', 'coKaryawan@update');
Route::get('/karyawan/{id?}/editFoto', 'coKaryawan@editFoto');
Route::post('/karyawan/editFoto/{id?}', 'coKaryawan@updateFoto');
Route::delete('/karyawan/{id?}', 'coKaryawan@destroy');

// Route modul pengguna
Route::get('/pengguna', 'coPengguna@index')->middleware('auth', 'cek_role')->name('pengguna');
Route::get('/pengguna/data', 'coPengguna@listData')->middleware('auth', 'cek_role')->name('pengguna.data');
Route::post('/pengguna/store', 'coPengguna@store')->name('pengguna.simpan');
Route::get('/pengguna/{id?}/edit', 'coPengguna@edit');
Route::put('/pengguna/{id?}', 'coPengguna@update');
Route::put('/pengguna/editPassword/{id?}', 'coPengguna@updatePassword');
Route::delete('/pengguna/{id?}', 'coPengguna@destroy');

// Route modul parent klasifikasi
Route::get('/parentKlasifikasi', 'coParentklasifikasi@index')->middleware('auth', 'cek_role')->name('parentKlasifikasi');
Route::get('/parentKlasifikasi/data', 'coParentklasifikasi@listData')->middleware('auth', 'cek_role')->name('parentKlasifikasi.data');
Route::post('/parentKlasifikasi/store', 'coParentklasifikasi@store')->name('parentKlasifikasi.simpan');
Route::get('/parentKlasifikasi/{id?}/edit', 'coParentklasifikasi@edit');
Route::put('/parentKlasifikasi/{id?}', 'coParentklasifikasi@update');
Route::delete('/parentKlasifikasi/{id?}', 'coParentklasifikasi@destroy');

// Route modul child klasifikasi
Route::get('/childKlasifikasi', 'coChild@index')->middleware('auth', 'cek_role')->name('childKlasifikasi');
Route::get('/childKlasifikasi/data', 'coChild@listData')->middleware('auth', 'cek_role')->name('childKlasifikasi.data');

// Route modul surat keluar
Route::get('/surat_keluar', 'coSuratkeluar@index')->middleware('auth', 'cek_role')->name('surat_keluar');
Route::get('/surat_keluar/data', 'coSuratkeluar@listSurat')->middleware('auth', 'cek_role')->name('surat_keluar.data');
Route::get('/surat_keluar/data/klasifikasi', 'coSuratkeluar@listKlasifikasi')->middleware('auth', 'cek_role')->name('surat_keluar.klasifikasi');
Route::get('/surat_keluar/data/bagian', 'coSuratkeluar@listBagian')->middleware('auth', 'cek_role')->name('surat_keluar.bagian');
Route::get('/surat_keluar/data/konseptor', 'coSuratkeluar@listKonseptor')->middleware('auth', 'cek_role')->name('surat_keluar.konseptor');
Route::get('/surat_keluar/{id?}/detail', 'coSuratkeluar@detailSurat');
Route::post('/surat_keluar/store', 'coSuratkeluar@store')->name('surat_keluar.simpan');
Route::get('/surat_keluar/{id?}/edit', 'coSuratkeluar@edit');
Route::put('/surat_keluar/{id?}', 'coSuratkeluar@update');
Route::get('/surat_keluar/{id?}/unggah', 'coSuratkeluar@unggah_surat');
Route::post('/surat_keluar/unggah_surat/{id?}', 'coSuratkeluar@updateSurat');
Route::delete('/surat_keluar/{id?}', 'coSuratkeluar@destroy');

// Route modul surat masuk
Route::get('/surat_masuk', 'coSuratmasuk@index')->middleware('auth', 'cek_role')->name('surat_masuk');
Route::get('/surat_masuk/data', 'coSuratmasuk@listSurat')->middleware('auth', 'cek_role')->name('surat_masuk.data');
Route::get('/surat_masuk/data/klasifikasi', 'coSuratmasuk@listKlasifikasi')->middleware('auth', 'cek_role')->name('surat_masuk.klasifikasi');
Route::get('/surat_masuk/data/tujuan', 'coSuratmasuk@listTujuan')->middleware('auth', 'cek_role')->name('surat_masuk.tujuan');
Route::get('/surat_masuk/data/pengirim', 'coSuratmasuk@listPengirim')->middleware('auth', 'cek_role')->name('surat_masuk.pengirim');
Route::post('/surat_masuk/store', 'coSuratmasuk@store')->name('surat_masuk.simpan');
Route::get('/surat_masuk/{id?}/detail', 'coSuratmasuk@detailSurat');
Route::get('/surat_masuk/{id?}/unggah', 'coSuratmasuk@unggah_surat');
Route::get('/surat_masuk/{id?}/edit', 'coSuratmasuk@edit');
Route::put('/surat_masuk/{id?}', 'coSuratmasuk@update');

// Route modul agenda direksi langsung
Route::get('/agenda_langsung', 'coAgenda_langsung@index')->middleware('auth', 'cek_role')->name('agenda_langsung');
Route::get('/agenda_langsung/data', 'coAgenda_langsung@listAgenda')->middleware('auth', 'cek_role')->name('agenda_langsung.data');

Route::get('/home', 'HomeController@index')->middleware('buat_tabel')->name('home');
