<!-- ==================================================================================
*   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
*   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
*   
*   :: plz..don't remove this text if u are "the real open-sourcer" ::
==================================================================================== -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>PTPN IX</title>

    <meta name="description" content="Sistem Informasi Kesekretariatan" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Basic Styles-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/weather-icons.min.css') }}" rel="stylesheet" />

    <!--Fonts-->
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css"> -->

    <!--Beyond styles-->
    <link href="{{ asset('assets/css/beyond.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/skins/green.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/demo.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/typicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/sweetalert2/sweetalert2.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/x-icon">

    @yield('css')
</head>
<body>
    <div class="loading-container">
        <div class="loader"></div>
    </div>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <img src="{{ asset('assets/img/logo-sidebar.png') }}" alt="logo" />
                        </small>
                    </a>
                </div>

                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container container-fluid">
        <div class="page-container">
            <div class="page-sidebar sidebar-fixed" id="sidebar">
                <ul class="nav sidebar-menu">
                    <li class="{{ set_active(['home','lap_sm_eks','lap_sm_int','lap_sk_dir_int']) }}">
                        <a href="{{ route('home') }}">
                            <i class="menu-icon fa fa-university"></i>
                            <span class="menu-text">Beranda</span>
                        </a>
                    </li>
                    <!-- MASTER DATA -->
                    <li class="{{ set_active_open(['bagian','bagian.create','bagian.edit','jabatan','jabatan.create','jabatan.edit','golongan','golongan.create','golongan.edit','masakerja','masakerja.create','masakerja.edit','pendidikan','pendidikan.create','pendidikan.edit','hakakses','hakakses.create','hakakses.edit','karyawan','karyawan.create','karyawan.edit','pengguna','pengguna.create','pengguna.edit','pengguna.resetpassword','klasifikasi','jenis_surat','jenis_surat.create','jenis_surat.edit','sifat_surat','sifat_surat.create','sifat_surat.edit','jenis_disposisi','jenis_disposisi.create','jenis_disposisi.edit','retensi_aktif','retensi_aktif.create','retensi_aktif.edit','retensi_inaktif','retensi_inaktif.create','retensi_inaktif.edit','retensi_deskripsi','retensi_deskripsi.create','retensi_deskripsi.edit','urusan_bagian','urusan_bagian.create','urusan_bagian.edit','jenis_disposisi_bagian','jenis_disposisi_bagian.create','jenis_disposisi_bagian.edit','tim','tim.create','tim.edit']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-database"></i>

                            <span class="menu-text">
                                Master Data
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active_open(['bagian','bagian.create','bagian.edit','urusan_bagian','urusan_bagian.create','urusan_bagian.edit','tim','tim.create','tim.edit']) }}">
                                <a href="" class="menu-dropdown">
                                    <span class="menu-text">
                                        Data Bagian
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>

                                <ul class="submenu">
                                    <li class="{{ set_active(['bagian','bagian.create','bagian.edit']) }}">
                                        <a href="{{ route('bagian') }}">
                                            <span class="menu-text">Bagian</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['urusan_bagian','urusan_bagian.create','urusan_bagian.edit']) }}">
                                        <a href="{{ route('urusan_bagian') }}">
                                            <span class="menu-text">Urusan Bagian</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['tim','tim.create','tim.edit']) }}">
                                        <a href="{{ route('tim') }}">
                                            <span class="menu-text">TIM</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @if(Auth::user()->id_role == 1)
                            <li class="{{ set_active(['jabatan','jabatan.create','jabatan.edit']) }}">
                                <a href="{{ route('jabatan') }}"><span class="menu-text">Data Jabatan</span></a>
                            </li>
                            <li class="{{ set_active(['golongan','golongan.create','golongan.edit']) }}">
                                <a href="{{ route('golongan') }}"><span class="menu-text">Data Golongan</span></a>
                            </li>
                            <li class="{{ set_active(['masakerja','masakerja.create','masakerja.edit']) }}">
                                <a href="{{ route('masakerja') }}"><span class="menu-text">Data Masa Kerja</span></a>
                            </li>
                            <li class="{{ set_active(['pendidikan','pendidikan.create','pendidikan.edit']) }}">
                                <a href="{{ route('pendidikan') }}"><span class="menu-text">Data Pendidikan</span></a>
                            </li>
                            <li class="{{ set_active_open(['jenis_surat','jenis_surat.create','jenis_surat.edit','sifat_surat','sifat_surat.create','sifat_surat.edit','jenis_disposisi','jenis_disposisi.create','jenis_disposisi.edit','jenis_disposisi_bagian','jenis_disposisi_bagian.create','jenis_disposisi_bagian.edit']) }}">
                                <a href="" class="menu-dropdown">
                                    <span class="menu-text">
                                        Data Surat
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>

                                <ul class="submenu">
                                    <li class="{{ set_active(['jenis_surat','jenis_surat.create','jenis_surat.edit']) }}">
                                        <a href="{{ route('jenis_surat') }}">
                                            <span class="menu-text">Jenis Surat</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['sifat_surat','sifat_surat.create','sifat_surat.edit']) }}">
                                        <a href="{{ route('sifat_surat') }}">
                                            <span class="menu-text">Sifat Surat</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['jenis_disposisi','jenis_disposisi.create','jenis_disposisi.edit']) }}">
                                        <a href="{{ route('jenis_disposisi') }}">
                                            <span class="menu-text">Jenis Disposisi Direksi</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['jenis_disposisi_bagian','jenis_disposisi_bagian.create','jenis_disposisi_bagian.edit']) }}">
                                        <a href="{{ route('jenis_disposisi_bagian') }}">
                                            <span class="menu-text">Jenis Disposisi Bagian</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            <li class="{{ set_active_open(['klasifikasi','retensi_aktif','retensi_aktif.create','retensi_aktif.edit','retensi_inaktif','retensi_inaktif.create','retensi_inaktif.edit','retensi_deskripsi','retensi_deskripsi.create','retensi_deskripsi.edit']) }}">
                                <a href="" class="menu-dropdown">
                                    <span class="menu-text">
                                        Data Klasifikasi Surat
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>

                                <ul class="submenu">
                                    <li class="{{ set_active(['klasifikasi']) }}">
                                        <a href="{{ route('klasifikasi') }}">
                                            <span class="menu-text">Klasifikasi Surat</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['retensi_aktif','retensi_aktif.create','retensi_aktif.edit']) }}">
                                        <a href="{{ route('retensi_aktif') }}">
                                            <span class="menu-text">Retensi Aktif</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['retensi_inaktif','retensi_inaktif.create','retensi_inaktif.edit']) }}">
                                        <a href="{{ route('retensi_inaktif') }}">
                                            <span class="menu-text">Retensi Inaktif</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['retensi_deskripsi','retensi_deskripsi.create','retensi_deskripsi.edit']) }}">
                                        <a href="{{ route('retensi_deskripsi') }}">
                                            <span class="menu-text">Deskripsi Retensi</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @if(Auth::user()->id_role == 1)
                            <li class="{{ set_active(['hakakses','hakakses.create','hakakses.edit']) }}">
                                <a href="{{ route('hakakses') }}"><span class="menu-text">Data Hak Akses</span></a>
                            </li>
                            <li class="{{ set_active(['karyawan','karyawan.create','karyawan.edit']) }}">
                                <a href="{{ route('karyawan') }}"><span class="menu-text">Data Karyawan</span></a>
                            </li>
                            <li class="{{ set_active(['pengguna','pengguna.create','pengguna.edit','pengguna.resetpassword']) }}">
                                <a href="{{ route('pengguna') }}"><span class="menu-text">Data Pengguna</span></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <!-- AGENDA SENTRAL -->
                    <li class="{{ set_active_open(['surat_keluar_internal','surat_keluar_internal.create','surat_keluar_internal.upload','surat_keluar_internal.detail','surat_keluar_internal.edit','surat_keluar_direksi_internal.edit','surat_keluar_eksternal','surat_keluar_eksternal.create','surat_keluar_eksternal.upload','surat_keluar_eksternal.detail','surat_keluar_eksternal.edit','surat_keluar_karyawan','surat_keluar_karyawan.create','surat_keluar_karyawan.upload','surat_keluar_karyawan.detail','surat_keluar_karyawan.edit','surat_keluar_direksi_internal','surat_keluar_direksi_internal.create','surat_keluar_direksi_internal.upload','surat_keluar_direksi_internal.detail','surat_keluar_direksi_eksternal','surat_keluar_direksi_eksternal.create','surat_keluar_direksi_eksternal.detail','surat_keluar_direksi_eksternal.upload','surat_keluar_direksi_eksternal.edit','surat_masuk_eksternal','surat_masuk_eksternal.create','surat_masuk_eksternal.upload','surat_masuk_eksternal.detail','surat_masuk_eksternal.edit','surat_masuk_internal','surat_masuk_internal.create','surat_masuk_internal.detail']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-book"></i>

                            <span class="menu-text">
                                Agenda Sentral
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            @if(Auth::user()->id_role == 3 || Auth::user()->id_role == 4 || Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
                            <li class="{{ set_active(['surat_masuk_eksternal','surat_masuk_eksternal.create','surat_masuk_eksternal.upload','surat_masuk_eksternal.detail','surat_masuk_eksternal.edit']) }}">
                                <a href="{{ route('surat_masuk_eksternal') }}"><span class="menu-text">Surat Masuk Eksternal</span></a>
                            </li>
                            <li class="{{ set_active(['surat_masuk_internal','surat_masuk_internal.create','surat_masuk_internal.detail']) }}">
                                <a href="{{ route('surat_masuk_internal') }}"><span class="menu-text">Surat Masuk Internal</span></a>
                            </li>
                            @endif
                            @if(Auth::user()->id_role == 1 || Auth::user()->id_role == 5)
                            <li class="{{ set_active_open(['surat_keluar_direksi_internal','surat_keluar_direksi_internal.create','surat_keluar_direksi_internal.upload','surat_keluar_direksi_internal.detail','surat_keluar_direksi_internal.edit','surat_keluar_direksi_eksternal','surat_keluar_direksi_eksternal.create','surat_keluar_direksi_eksternal.detail','surat_keluar_direksi_eksternal.edit','surat_keluar_direksi_eksternal.upload']) }}">
                                <a href="#" class="menu-dropdown">
                                    <span class="menu-text">
                                        Surat Keluar Direksi
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>

                                <ul class="submenu">
                                    <li class="{{ set_active(['surat_keluar_direksi_internal','surat_keluar_direksi_internal.create','surat_keluar_direksi_internal.upload','surat_keluar_direksi_internal.detail','surat_keluar_direksi_internal.edit']) }}">
                                        <a href="{{ route('surat_keluar_direksi_internal') }}">
                                            <span class="menu-text">Internal</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active(['surat_keluar_direksi_eksternal','surat_keluar_direksi_eksternal.create','surat_keluar_direksi_eksternal.detail','surat_keluar_direksi_eksternal.upload','surat_keluar_direksi_eksternal.edit']) }}">
                                        <a href="{{ route('surat_keluar_direksi_eksternal') }}">
                                            <span class="menu-text">Eksternal</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ set_active(['surat_keluar_internal','surat_keluar_internal.create','surat_keluar_internal.edit','surat_keluar_internal.detail','surat_keluar_internal.upload','surat_keluar_internal.edit']) }}">
                                <a href="{{ route('surat_keluar_internal') }}"><span class="menu-text">Surat Keluar Internal</span></a>
                            </li>
                            <li class="{{ set_active(['surat_keluar_eksternal','surat_keluar_eksternal.create','surat_keluar_eksternal.edit','surat_keluar_eksternal.detail','surat_keluar_eksternal.upload','surat_keluar_eksternal.edit']) }}">
                                <a href="{{ route('surat_keluar_eksternal') }}"><span class="menu-text">Surat Keluar Eksternal</span></a>
                            </li>
                            <li class="{{ set_active(['surat_keluar_karyawan','surat_keluar_karyawan.create','surat_keluar_karyawan.detail','surat_keluar_karyawan.upload','surat_keluar_karyawan.edit']) }}">
                                <a href="{{ route('surat_keluar_karyawan') }}"><span class="menu-text">Surat Keluar Karyawan</span></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <!-- AGENDA DIREKSI -->
                    @if(Auth::user()->id_role == 1 || Auth::user()->id_role == 2)
                    <li class="{{ set_active_open(['surat_masuk_direksi_sentral','surat_masuk_direksi_sentral.create_eks','surat_masuk_direksi_sentral.create_int','surat_masuk_direksi_langsung','surat_masuk_direksi_langsung.create','disposisi_direksi_surat_masuk','disposisi_direksi_surat_masuk.ubah','agenda_direksi_surat_keluar','agenda_direksi_surat_keluar.edit']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user-secret"></i>

                            <span class="menu-text">
                                Agenda Direksi
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active_open(['surat_masuk_direksi_sentral','surat_masuk_direksi_sentral.create_eks','surat_masuk_direksi_sentral.create_int','surat_masuk_direksi_langsung','surat_masuk_direksi_langsung.create']) }}">
                                <a href="" class="menu-dropdown">
                                    <span class="menu-text">
                                        Surat Masuk Direksi
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>

                                <ul class="submenu">
                                    <li class="{{ set_active_open(['surat_masuk_direksi_sentral','surat_masuk_direksi_sentral.create_eks','surat_masuk_direksi_sentral.create_int']) }}">
                                        <a href="{{ route('surat_masuk_direksi_sentral') }}">
                                            <span class="menu-text">Sentral</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active_open(['surat_masuk_direksi_langsung','surat_masuk_direksi_langsung.create']) }}">
                                        <a href="{{ route('surat_masuk_direksi_langsung') }}">
                                            <span class="menu-text">Langsung</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ set_active(['agenda_direksi_surat_keluar','agenda_direksi_surat_keluar.edit']) }}">
                                <a href="{{ route('agenda_direksi_surat_keluar') }}"><span class="menu-text">Surat Keluar Direksi</span></a>
                            </li>
                            <li class="{{ set_active(['disposisi_direksi_surat_masuk','disposisi_direksi_surat_masuk.ubah']) }}">
                                <a href="{{ route('disposisi_direksi_surat_masuk') }}"><span class="menu-text">Disposisi Direksi</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="{{ set_active(['laporan_surat_masuk','laporan_surat_masuk.detail','laporan_surat_masuk.detail_eksternal']) }}">
                        <a href="{{ route('laporan_surat_masuk') }}">
                            <i class="menu-icon fa fa-envelope"></i>
                            <span class="menu-text">Laporan Surat Masuk</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="menu-icon fa fa-lock"></i>
                            <span class="menu-text">Keluar</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>

            <div class="page-content">
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        @yield('breadcrumb')
                    </ul>
                </div>
                
                <!-- <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            @yield('title')
                        </h1>
                    </div>
                </div> -->
                
                <div class="page-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!--Basic Scripts-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!--Beyond Scripts-->
    <script src="{{ asset('assets/js/beyond.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
    @yield('script')
</body>
</html>