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

// ===============================================================================================================================================

// MASTER DATA

// ===============================================================================================================================================

Route::get('/', 'HomeController@index')->middleware('auth', 'cek_password');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// MODUL BAGIAN
Route::get('/bagian', 'coBagian@index')->name('bagian');
Route::get('/bagian/create', 'coBagian@create')->name('bagian.create');
Route::get('/bagian/data', 'coBagian@listData')->name('bagian.data');
Route::post('/bagian/store', 'cobagian@store')->name('bagian.simpan');
Route::get('/bagian/{id?}/edit', 'cobagian@edit')->name('bagian.edit');
Route::post('/bagian/{id?}/update', 'cobagian@update');

// MODUL TIM
Route::get('/tim', 'coTim@index')->name('tim');
Route::get('/tim/create', 'coTim@create')->name('tim.create');
Route::get('/tim/data', 'coTim@listData')->name('tim.data');
Route::post('/tim/store', 'coTim@store')->name('tim.simpan');
Route::get('/tim/{id?}/edit', 'coTim@edit')->name('tim.edit');
Route::post('/tim/{id?}/update', 'coTim@update');

// MODUL URUSAN BAGIAN
Route::get('/urusan_bagian', 'coUrusan_bagian@index')->name('urusan_bagian');
Route::get('/urusan_bagian/create', 'coUrusan_bagian@create')->name('urusan_bagian.create');
Route::get('/urusan_bagian/data', 'coUrusan_bagian@listData')->name('urusan_bagian.data');
Route::post('/urusan_bagian/store', 'coUrusan_bagian@store')->name('urusan_bagian.simpan');
Route::get('/urusan_bagian/{id?}/edit', 'coUrusan_bagian@edit')->name('urusan_bagian.edit');
Route::post('/urusan_bagian/{id?}/update', 'coUrusan_bagian@update');

// Route modul klasifikasi
Route::get('/klasifikasi', 'coKlasifikasi@index')->name('klasifikasi');
Route::get('/klasifikasi/data', 'coKlasifikasi@listData')->name('klasifikasi.data');
Route::get('/klasifikasi/listTop', 'coKlasifikasi@listTop')->name('klasifikasi.listTop');
Route::get('/klasifikasi/listMiddle', 'coKlasifikasi@listMiddle')->name('klasifikasi.listMiddle');
Route::post('/klasifikasi/store_top', 'coKlasifikasi@store_top')->name('klasifikasi.simpan_top');
Route::post('/klasifikasi/store_mid', 'coKlasifikasi@store_mid')->name('klasifikasi.simpan_mid');
Route::post('/klasifikasi/store_bot', 'coKlasifikasi@store_bot')->name('klasifikasi.simpan_bot');

// MODUL RETENSI AKTIF
Route::get('/retensi_aktif', 'coRetensi_aktif@index')->name('retensi_aktif');
Route::get('/retensi_aktif/create', 'coRetensi_aktif@create')->name('retensi_aktif.create');
Route::get('/retensi_aktif/data', 'coRetensi_aktif@listData')->name('retensi_aktif.data');
Route::post('/retensi_aktif/store', 'coRetensi_aktif@store')->name('retensi_aktif.simpan');
Route::get('/retensi_aktif/{id?}/edit', 'coRetensi_aktif@edit')->name('retensi_aktif.edit');
Route::post('/retensi_aktif/{id?}/update', 'coRetensi_aktif@update');

// MODUL RETENSI INAKTIF
Route::get('/retensi_inaktif', 'coRetensi_inaktif@index')->name('retensi_inaktif');
Route::get('/retensi_inaktif/create', 'coRetensi_inaktif@create')->name('retensi_inaktif.create');
Route::get('/retensi_inaktif/data', 'coRetensi_inaktif@listData')->name('retensi_inaktif.data');
Route::post('/retensi_inaktif/store', 'coRetensi_inaktif@store')->name('retensi_inaktif.simpan');
Route::get('/retensi_inaktif/{id?}/edit', 'coRetensi_inaktif@edit')->name('retensi_inaktif.edit');
Route::post('/retensi_inaktif/{id?}/update', 'coRetensi_inaktif@update');

// MODUL RETENSI DESKRIPSI
Route::get('/retensi_deskripsi', 'coRetensi_deskripsi@index')->name('retensi_deskripsi');
Route::get('/retensi_deskripsi/create', 'coRetensi_deskripsi@create')->name('retensi_deskripsi.create');
Route::get('/retensi_deskripsi/data', 'coRetensi_deskripsi@listData')->name('retensi_deskripsi.data');
Route::post('/retensi_deskripsi/store', 'coRetensi_deskripsi@store')->name('retensi_deskripsi.simpan');
Route::get('/retensi_deskripsi/{id?}/edit', 'coRetensi_deskripsi@edit')->name('retensi_deskripsi.edit');
Route::post('/retensi_deskripsi/{id?}/update', 'coRetensi_deskripsi@update');

// ROUTE KLASIFIKASI
Route::get('/data_klasifikasi', 'HomeController@listKlasifikasi')->name('data_klasifikasi');

// ROUTE KONSEPTOR
Route::get('/data_konseptor', 'HomeController@listKonseptor')->name('data_konseptor');

Route::group(['middleware' => ['web','auth','role_admin','cek_password']], function(){
	// MODUL JABATAN
	Route::get('/jabatan', 'coJabatan@index')->name('jabatan');
	Route::get('/jabatan/create', 'coJabatan@create')->name('jabatan.create');
	Route::get('/jabatan/data', 'coJabatan@listData')->name('jabatan.data');
	Route::post('/jabatan/store', 'coJabatan@store')->name('jabatan.simpan');
	Route::get('/jabatan/{id?}/edit', 'coJabatan@edit')->name('jabatan.edit');
	Route::post('/jabatan/{id?}/update', 'coJabatan@update');

	// MODUL GOLONGAN
	Route::get('/golongan', 'coGolongan@index')->name('golongan');
	Route::get('/golongan/create', 'coGolongan@create')->name('golongan.create');
	Route::get('/golongan/data', 'coGolongan@listData')->name('golongan.data');
	Route::post('/golongan/store', 'coGolongan@store')->name('golongan.simpan');
	Route::get('/golongan/{id?}/edit', 'coGolongan@edit')->name('golongan.edit');
	Route::post('/golongan/{id?}/update', 'coGolongan@update');

	// MODUL MASA KERJA
	Route::get('/masakerja', 'coMasakerja@index')->name('masakerja');
	Route::get('/masakerja/create', 'coMasakerja@create')->name('masakerja.create');
	Route::get('/masakerja/data', 'coMasakerja@listData')->name('masakerja.data');
	Route::post('/masakerja/store', 'coMasakerja@store')->name('masakerja.simpan');
	Route::get('/masakerja/{id?}/edit', 'coMasakerja@edit')->name('masakerja.edit');
	Route::post('/masakerja/{id?}/update', 'coMasakerja@update');

	// MODUL PENDIDIKAN
	Route::get('/pendidikan', 'coPendidikan@index')->name('pendidikan');
	Route::get('/pendidikan/create', 'coPendidikan@create')->name('pendidikan.create');
	Route::get('/pendidikan/data', 'coPendidikan@listData')->name('pendidikan.data');
	Route::post('/pendidikan/store', 'coPendidikan@store')->name('pendidikan.simpan');
	Route::get('/pendidikan/{id?}/edit', 'coPendidikan@edit')->name('pendidikan.edit');
	Route::post('/pendidikan/{id?}/update', 'coPendidikan@update');

	// MODUL HAK AKSES
	Route::get('/hakakses', 'coHakakses@index')->name('hakakses');
	Route::get('/hakakses/create', 'coHakakses@create')->name('hakakses.create');
	Route::get('/hakakses/data', 'coHakakses@listData')->name('hakakses.data');
	Route::post('/hakakses/store', 'coHakakses@store')->name('hakakses.simpan');
	Route::get('/hakakses/{id?}/edit', 'coHakakses@edit')->name('hakakses.edit');
	Route::post('/hakakses/{id?}/update', 'coHakakses@update');

	// MODUL JENIS SURAT
	Route::get('/jenis_surat', 'coJenis_surat@index')->name('jenis_surat');
	Route::get('/jenis_surat/create', 'coJenis_surat@create')->name('jenis_surat.create');
	Route::get('/jenis_surat/data', 'coJenis_surat@listData')->name('jenis_surat.data');
	Route::post('/jenis_surat/store', 'coJenis_surat@store')->name('jenis_surat.simpan');
	Route::get('/jenis_surat/{id?}/edit', 'coJenis_surat@edit')->name('jenis_surat.edit');
	Route::post('/jenis_surat/{id?}/update', 'coJenis_surat@update');

	// MODUL SIFAT SURAT
	Route::get('/sifat_surat', 'coSifatsurat@index')->name('sifat_surat');
	Route::get('/sifat_surat/create', 'coSifatsurat@create')->name('sifat_surat.create');
	Route::get('/sifat_surat/data', 'coSifatsurat@listData')->name('sifat_surat.data');
	Route::post('/sifat_surat/store', 'coSifatsurat@store')->name('sifat_surat.simpan');
	Route::get('/sifat_surat/{id?}/edit', 'coSifatsurat@edit')->name('sifat_surat.edit');
	Route::post('/sifat_surat/{id?}/update', 'coSifatsurat@update');

	// MODUL KARYAWAN
	Route::get('/karyawan', 'coKaryawan@index')->name('karyawan');
	Route::get('/karyawan/create', 'coKaryawan@create')->name('karyawan.create');
	Route::get('/karyawan/data', 'coKaryawan@listData')->name('karyawan.data');
	Route::post('/karyawan/store', 'coKaryawan@store')->name('karyawan.simpan');
	Route::get('/karyawan/{id?}/edit', 'coKaryawan@edit')->name('karyawan.edit');
	Route::post('/karyawan/{id?}/update', 'coKaryawan@update');
	Route::get('/karyawan/{id?}/editFoto', 'coKaryawan@editFoto');
	Route::post('/karyawan/editFoto/{id?}', 'coKaryawan@updateFoto');
	Route::delete('/karyawan/{id?}', 'coKaryawan@destroy');

	// MODUL PENGGUNA
	Route::get('/pengguna', 'coPengguna@index')->name('pengguna');
	Route::get('/pengguna/create', 'coPengguna@create')->name('pengguna.create');
	Route::get('/pengguna/data', 'coPengguna@listData')->name('pengguna.data');
	Route::post('/pengguna/store', 'coPengguna@store')->name('pengguna.simpan');
	Route::get('/pengguna/{id?}/edit', 'coPengguna@edit')->name('pengguna.edit');
	Route::get('/pengguna/{id?}/resetpassword', 'coPengguna@resetpassword')->name('pengguna.resetpassword');
	Route::post('/pengguna/{id?}/update', 'coPengguna@update');
	Route::post('/pengguna/{id?}/updatepassword', 'coPengguna@updatepassword');

	// MODUL JENIS DISPOSISI DIREKSI
	Route::get('/jenis_disposisi', 'coJenisdisposisi_direksi@index')->name('jenis_disposisi');
	Route::get('/jenis_disposisi/create', 'coJenisdisposisi_direksi@create')->name('jenis_disposisi.create');
	Route::get('/jenis_disposisi/data', 'coJenisdisposisi_direksi@listData')->name('jenis_disposisi.data');
	Route::post('/jenis_disposisi/store', 'coJenisdisposisi_direksi@store')->name('jenis_disposisi.simpan');
	Route::get('/jenis_disposisi/{id?}/edit', 'coJenisdisposisi_direksi@edit')->name('jenis_disposisi.edit');
	Route::post('/jenis_disposisi/{id?}/update', 'coJenisdisposisi_direksi@update');

	// MODUL JENIS DISPOSISI BAGIAN
	Route::get('/jenis_disposisi_bagian', 'coJenisdisposisi_bagian@index')->name('jenis_disposisi_bagian');
	Route::get('/jenis_disposisi_bagian/create', 'coJenisdisposisi_bagian@create')->name('jenis_disposisi_bagian.create');
	Route::get('/jenis_disposisi_bagian/data', 'coJenisdisposisi_bagian@listData')->name('jenis_disposisi_bagian.data');
	Route::post('/jenis_disposisi_bagian/store', 'coJenisdisposisi_bagian@store')->name('jenis_disposisi_bagian.simpan');
	Route::get('/jenis_disposisi_bagian/{id?}/edit', 'coJenisdisposisi_bagian@edit')->name('jenis_disposisi_bagian.edit');
	Route::post('/jenis_disposisi_bagian/{id?}/update', 'coJenisdisposisi_bagian@update');
});

// ===============================================================================================================================================

// MASTER TRANSAKSI

// ===============================================================================================================================================
Route::group(['middleware' => ['web','auth','role_sekretariat','cek_password']], function(){
	// ROUTE MODUL SURAT MASUK INTERNAL
	Route::get('/surat_masuk_internal', 'coSurat_masuk_internal@index')->name('surat_masuk_internal');
	Route::get('/surat_masuk_internal/data', 'coSurat_masuk_internal@listData')->name('surat_masuk_internal.data');
	Route::get('/surat_masuk_internal/{id?}/create', 'coSurat_masuk_internal@create')->name('surat_masuk_internal.create');
	Route::get('/surat_masuk_internal/{id?}/detail', 'coSurat_masuk_internal@detail')->name('surat_masuk_internal.detail');
	Route::post('/surat_masuk_internal/{id?}/update', 'coSurat_masuk_internal@update');

	// ROUTE MODUL SURAT MASUK EKSTERNAL
	Route::get('/surat_masuk_eksternal', 'coSurat_masuk_eksternal@index')->name('surat_masuk_eksternal');
	Route::get('/surat_masuk_eksternal/data', 'coSurat_masuk_eksternal@listData')->name('surat_masuk_eksternal.data');
	Route::get('/surat_masuk_eksternal/create', 'coSurat_masuk_eksternal@create')->name('surat_masuk_eksternal.create');
	Route::get('/surat_masuk_eksternal/{id?}/edit', 'coSurat_masuk_eksternal@edit')->name('surat_masuk_eksternal.edit');
	Route::get('/surat_masuk_eksternal/{id?}/detail', 'coSurat_masuk_eksternal@detail')->name('surat_masuk_eksternal.detail');
	Route::get('/surat_masuk_eksternal/{id?}/upload', 'coSurat_masuk_eksternal@upload')->name('surat_masuk_eksternal.upload');
	Route::post('/surat_masuk_eksternal/store', 'coSurat_masuk_eksternal@store');
	Route::post('/surat_masuk_eksternal/{id?}/update', 'coSurat_masuk_eksternal@update');
	Route::post('/surat_masuk_eksternal/{id?}/update_upload', 'coSurat_masuk_eksternal@update_upload');
});

Route::group(['middleware' => ['web','auth','role_pengguna','cek_password']], function(){
	// ROUTE MODUL SURAT KELUAR INTERNAL
	Route::get('/surat_keluar_internal', 'coSurat_keluar_internal@index')->name('surat_keluar_internal');
	Route::get('/surat_keluar_internal/data', 'coSurat_keluar_internal@listData')->name('surat_keluar_internal.data');
	Route::get('/surat_keluar_internal/create', 'coSurat_keluar_internal@create')->name('surat_keluar_internal.create');
	Route::get('/surat_keluar_internal/{id?}/edit', 'coSurat_keluar_internal@edit')->name('surat_keluar_internal.edit');
	Route::get('/surat_keluar_internal/{id?}/detail', 'coSurat_keluar_internal@detail')->name('surat_keluar_internal.detail');
	Route::get('/surat_keluar_internal/{id?}/upload', 'coSurat_keluar_internal@upload')->name('surat_keluar_internal.upload');
	Route::post('/surat_keluar_internal/store', 'coSurat_keluar_internal@store');
	Route::post('/surat_keluar_internal/{id?}/update', 'coSurat_keluar_internal@update');
	Route::post('/surat_keluar_internal/{id?}/update_upload', 'coSurat_keluar_internal@update_upload');

	// ROUTE MODUL SURAT KELUAR EKSTERNAL
	Route::get('/surat_keluar_eksternal', 'coSurat_keluar_eksternal@index')->name('surat_keluar_eksternal');
	Route::get('/surat_keluar_eksternal/data', 'coSurat_keluar_eksternal@listData')->name('surat_keluar_eksternal.data');
	Route::get('/surat_keluar_eksternal/create', 'coSurat_keluar_eksternal@create')->name('surat_keluar_eksternal.create');
	Route::get('/surat_keluar_eksternal/{id?}/edit', 'coSurat_keluar_eksternal@edit')->name('surat_keluar_eksternal.edit');
	Route::get('/surat_keluar_eksternal/{id?}/detail', 'coSurat_keluar_eksternal@detail')->name('surat_keluar_eksternal.detail');
	Route::get('/surat_keluar_eksternal/{id?}/upload', 'coSurat_keluar_eksternal@upload')->name('surat_keluar_eksternal.upload');
	Route::post('/surat_keluar_eksternal/store', 'coSurat_keluar_eksternal@store');
	Route::post('/surat_keluar_eksternal/{id?}/update', 'coSurat_keluar_eksternal@update');
	Route::post('/surat_keluar_eksternal/{id?}/update_upload', 'coSurat_keluar_eksternal@update_upload');

	// ROUTE MODUL SURAT KELUAR KARYAWAN
	Route::get('/surat_keluar_karyawan', 'coSurat_keluar_karyawan@index')->name('surat_keluar_karyawan');
	Route::get('/surat_keluar_karyawan/data', 'coSurat_keluar_karyawan@listData')->name('surat_keluar_karyawan.data');
	Route::get('/surat_keluar_karyawan/create', 'coSurat_keluar_karyawan@create')->name('surat_keluar_karyawan.create');
	Route::get('/surat_keluar_karyawan/{id?}/edit', 'coSurat_keluar_karyawan@edit')->name('surat_keluar_karyawan.edit');
	Route::get('/surat_keluar_karyawan/{id?}/detail', 'coSurat_keluar_karyawan@detail')->name('surat_keluar_karyawan.detail');
	Route::get('/surat_keluar_karyawan/{id?}/upload', 'coSurat_keluar_karyawan@upload')->name('surat_keluar_karyawan.upload');
	Route::post('/surat_keluar_karyawan/store', 'coSurat_keluar_karyawan@store');
	Route::post('/surat_keluar_karyawan/{id?}/update', 'coSurat_keluar_karyawan@update');
	Route::post('/surat_keluar_karyawan/{id?}/update_upload', 'coSurat_keluar_karyawan@update_upload');

	// ROUTE MODUL SURAT KELUAR DIREKSI INTERNAL
	Route::get('/surat_keluar_direksi_internal', 'coSurat_keluar_direksi_internal@index')->name('surat_keluar_direksi_internal');
	Route::get('/surat_keluar_direksi_internal/data', 'coSurat_keluar_direksi_internal@listData')->name('surat_keluar_direksi_internal.data');
	Route::get('/surat_keluar_direksi_internal/create', 'coSurat_keluar_direksi_internal@create')->name('surat_keluar_direksi_internal.create');
	Route::get('/surat_keluar_direksi_internal/{id?}/edit', 'coSurat_keluar_direksi_internal@edit')->name('surat_keluar_direksi_internal.edit');
	Route::get('/surat_keluar_direksi_internal/{id?}/detail', 'coSurat_keluar_direksi_internal@detail')->name('surat_keluar_direksi_internal.detail');
	Route::get('/surat_keluar_direksi_internal/{id?}/upload', 'coSurat_keluar_direksi_internal@upload')->name('surat_keluar_direksi_internal.upload');
	Route::post('/surat_keluar_direksi_internal/store', 'coSurat_keluar_direksi_internal@store');
	Route::post('/surat_keluar_direksi_internal/{id?}/update', 'coSurat_keluar_direksi_internal@update');
	Route::post('/surat_keluar_direksi_internal/{id?}/update_upload', 'coSurat_keluar_direksi_internal@update_upload');

	// ROUTE MODUL SURAT KELUAR DIREKSI EKSTERNAL
	Route::get('/surat_keluar_direksi_eksternal', 'coSurat_keluar_direksi_eksternal@index')->name('surat_keluar_direksi_eksternal');
	Route::get('/surat_keluar_direksi_eksternal/data', 'coSurat_keluar_direksi_eksternal@listData')->name('surat_keluar_direksi_eksternal.data');
	Route::get('/surat_keluar_direksi_eksternal/create', 'coSurat_keluar_direksi_eksternal@create')->name('surat_keluar_direksi_eksternal.create');
	Route::get('/surat_keluar_direksi_eksternal/{id?}/edit', 'coSurat_keluar_direksi_eksternal@edit')->name('surat_keluar_direksi_eksternal.edit');
	Route::get('/surat_keluar_direksi_eksternal/{id?}/detail', 'coSurat_keluar_direksi_eksternal@detail')->name('surat_keluar_direksi_eksternal.detail');
	Route::get('/surat_keluar_direksi_eksternal/{id?}/upload', 'coSurat_keluar_direksi_eksternal@upload')->name('surat_keluar_direksi_eksternal.upload');
	Route::post('/surat_keluar_direksi_eksternal/store', 'coSurat_keluar_direksi_eksternal@store');
	Route::post('/surat_keluar_direksi_eksternal/{id?}/update', 'coSurat_keluar_direksi_eksternal@update');
	Route::post('/surat_keluar_direksi_eksternal/{id?}/update_upload', 'coSurat_keluar_direksi_eksternal@update_upload');
});

Route::group(['middleware' => ['web','auth','role_sekdir','cek_password']], function(){
	// ROUTE MODUL AGENDA DIREKSI SURAT KELUAR
	Route::get('/agenda_direksi_surat_keluar', 'coAgenda_direksi_surat_keluar@index')->name('agenda_direksi_surat_keluar');
	Route::get('/agenda_direksi_surat_keluar/data', 'coAgenda_direksi_surat_keluar@listData')->name('agenda_direksi_surat_keluar.data');
	Route::get('/agenda_direksi_surat_keluar/{id?}/edit', 'coAgenda_direksi_surat_keluar@edit')->name('agenda_direksi_surat_keluar.edit');
	Route::post('/agenda_direksi_surat_keluar/{id?}/update', 'coAgenda_direksi_surat_keluar@update');

	// ROUTE MODUL SURAT MASUK DIREKSI SENTRAL
	Route::get('/surat_masuk_direksi_sentral', 'coSurat_masuk_direksi_sentral@index')->name('surat_masuk_direksi_sentral');
	Route::get('/surat_masuk_direksi_sentral/data', 'coSurat_masuk_direksi_sentral@listData')->name('surat_masuk_direksi_sentral.data');
	Route::get('/surat_masuk_direksi_sentral/{id?}/create_int', 'coSurat_masuk_direksi_sentral@create_int')->name('surat_masuk_direksi_sentral.create_int');
	Route::get('/surat_masuk_direksi_sentral/{id?}/create_eks', 'coSurat_masuk_direksi_sentral@create_eks')->name('surat_masuk_direksi_sentral.create_eks');
	Route::post('/surat_masuk_direksi_sentral/{id?}/update_int', 'coSurat_masuk_direksi_sentral@update_int');
	Route::post('/surat_masuk_direksi_sentral/{id?}/update_eks', 'coSurat_masuk_direksi_sentral@update_eks');

	// ROUTE MODUL SURAT MASUK DIREKSI LANGSUNG
	Route::get('/surat_masuk_direksi_langsung', 'coSurat_masuk_direksi_langsung@index')->name('surat_masuk_direksi_langsung');
	Route::get('/surat_masuk_direksi_langsung/data', 'coSurat_masuk_direksi_langsung@listData')->name('surat_masuk_direksi_langsung.data');
	Route::get('/surat_masuk_direksi_langsung/{id?}/create', 'coSurat_masuk_direksi_langsung@create')->name('surat_masuk_direksi_langsung.create');
	Route::post('/surat_masuk_direksi_langsung/{id?}/update', 'coSurat_masuk_direksi_langsung@update');

	// ROUTE MODUL DISPOSISI DIREKSI SURAT MASUK
	Route::get('/disposisi_direksi_surat_masuk', 'coDisposisi_direksi_surat_masuk@index')->name('disposisi_direksi_surat_masuk');
	Route::get('/disposisi_direksi_surat_masuk/data', 'coDisposisi_direksi_surat_masuk@listData')->name('disposisi_direksi_surat_masuk.data');
	Route::get('/disposisi_direksi_surat_masuk/{id?}/edit', 'coDisposisi_direksi_surat_masuk@edit')->name('disposisi_direksi_surat_masuk.ubah');
	Route::post('/disposisi_direksi_surat_masuk/{id?}/update', 'coDisposisi_direksi_surat_masuk@update');

	// ROUTE MODUL SURAT MASUK DIREKSI SENTRAL
	Route::get('/surat_masuk_direksi_sentral', 'coSurat_masuk_direksi_sentral@index')->name('surat_masuk_direksi_sentral');
	Route::get('/surat_masuk_direksi_sentral/data', 'coSurat_masuk_direksi_sentral@listData')->name('surat_masuk_direksi_sentral.data');
	Route::get('/surat_masuk_direksi_sentral/{id?}/create_int', 'coSurat_masuk_direksi_sentral@create_int')->name('surat_masuk_direksi_sentral.create_int');
	Route::get('/surat_masuk_direksi_sentral/{id?}/create_eks', 'coSurat_masuk_direksi_sentral@create_eks')->name('surat_masuk_direksi_sentral.create_eks');
	Route::post('/surat_masuk_direksi_sentral/{id?}/update_int', 'coSurat_masuk_direksi_sentral@update_int');
	Route::post('/surat_masuk_direksi_sentral/{id?}/update_eks', 'coSurat_masuk_direksi_sentral@update_eks');

	// ROUTE MODUL SURAT MASUK DIREKSI LANGSUNG
	Route::get('/surat_masuk_direksi_langsung', 'coSurat_masuk_direksi_langsung@index')->name('surat_masuk_direksi_langsung');
	Route::get('/surat_masuk_direksi_langsung/data', 'coSurat_masuk_direksi_langsung@listData')->name('surat_masuk_direksi_langsung.data');
	Route::get('/surat_masuk_direksi_langsung/{id?}/create', 'coSurat_masuk_direksi_langsung@create')->name('surat_masuk_direksi_langsung.create');
	Route::post('/surat_masuk_direksi_langsung/{id?}/update', 'coSurat_masuk_direksi_langsung@update');
});

// ===============================================================================================================================================

// LAPORAN

// ===============================================================================================================================================

// ROUTE MODUL LAPORAN SURAT MASUK
Route::get('/laporan_surat_masuk', 'coLaporan_surat_masuk@index')->middleware('web','auth','cek_password')->name('laporan_surat_masuk');
Route::get('/laporan_surat_masuk/data', 'coLaporan_surat_masuk@listData')->name('laporan_surat_masuk.data');
Route::get('/laporan_surat_masuk/{id?}/detail', 'coLaporan_surat_masuk@detail')->name('laporan_surat_masuk.detail');
Route::get('/laporan_surat_masuk/{id?}/detail_eksternal', 'coLaporan_surat_masuk@detail_eksternal')->name('laporan_surat_masuk.detail_eksternal');

Route::get('/home', 'HomeController@index')->middleware('auth','cek_password')->name('home');
Route::get('/home/{id?}/edit_profile', 'HomeController@edit')->middleware('auth','cek_password')->name('edit_profile');
Route::post('/home/{id?}/update_profile', 'HomeController@update')->middleware('auth','cek_password')->name('update_profile');
Route::get('/forbidden', 'HomeController@forbidden')->middleware('auth','cek_password')->name('forbidden');
Route::get('/ganti_password', 'HomeController@ganti_password');
Route::post('/ganti_password/{id?}/update_password', 'HomeController@update_password');