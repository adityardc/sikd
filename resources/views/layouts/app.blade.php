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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">

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

                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">
                            <li>
                                <a href="#" class="login-area dropdown-toggle" data-toggle="dropdown">
                                    <div class="avatar" title="View your public profile">
                                        <img src="{{ asset('assets/img/icons8-circled-user-male-skin-type-5.png') }}">
                                    </div>
                                    <section>
                                        <h2><span class="profile"><span>{{ Auth::user()->name }}</span></span></h2>
                                    </section>
                                </a>
                                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                    <li class="username"><a>{{ Auth::user()->name }}</a></li>
                                    <li class="email"><a>{{ Auth::user()->email }}</a></li>
                                    <li>
                                        <div class="avatar-area">
                                            <img src="{{ asset('assets/img/icons8-circled-user-male-skin-type-5.png') }}" class="avatar">
                                        </div>
                                    </li>
                                    <li class="edit">
                                        <a href="#" class="pull-left">Profile</a>
                                        <a href="#" class="pull-right">Setting</a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            Keluar
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container container-fluid">
        <div class="page-container">
            <div class="page-sidebar sidebar-fixed" id="sidebar">
                <ul class="nav sidebar-menu">
                    <li class="{{ set_active('home') }}">
                        <a href="{{ route('home') }}">
                            <i class="menu-icon fa fa-university"></i>
                            <span class="menu-text">Beranda</span>
                        </a>
                    </li>
                    <li class="{{ set_active_open(['bagian','jabatan','golongan','masakerja','pendidikan','hakakses','karyawan','pengguna','parentKlasifikasi','childKlasifikasi','jenis_surat','sifat_surat','disposisi']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-database"></i>

                            <span class="menu-text">
                                Master Data
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active('bagian') }}">
                                <a href="{{ route('bagian') }}"><span class="menu-text">Data Bagian</span></a>
                            </li>
                            <li class="{{ set_active('jabatan') }}">
                                <a href="{{ route('jabatan') }}"><span class="menu-text">Data Jabatan</span></a>
                            </li>
                            <li class="{{ set_active('golongan') }}">
                                <a href="{{ route('golongan') }}"><span class="menu-text">Data Golongan</span></a>
                            </li>
                            <li class="{{ set_active('masakerja') }}">
                                <a href="{{ route('masakerja') }}"><span class="menu-text">Data Masa Kerja</span></a>
                            </li>
                            <li class="{{ set_active('pendidikan') }}">
                                <a href="{{ route('pendidikan') }}"><span class="menu-text">Data Pendidikan</span></a>
                            </li>
                            <li class="{{ set_active('hakakses') }}">
                                <a href="{{ route('hakakses') }}"><span class="menu-text">Data Hak Akses</span></a>
                            </li>
                            <li class="{{ set_active('jenis_surat') }}">
                                <a href="{{ route('jenis_surat') }}"><span class="menu-text">Data Jenis Surat</span></a>
                            </li>
                            <li class="{{ set_active('disposisi') }}">
                                <a href="{{ route('disposisi') }}"><span class="menu-text">Data Jenis Disposisi Direksi</span></a>
                            </li>
                            <li class="{{ set_active('sifat_surat') }}">
                                <a href="{{ route('sifat_surat') }}"><span class="menu-text">Data Sifat Surat</span></a>
                            </li>
                            <li class="{{ set_active('karyawan') }}">
                                <a href="{{ route('karyawan') }}"><span class="menu-text">Data Karyawan</span></a>
                            </li>
                            <li class="{{ set_active('pengguna') }}">
                                <a href="{{ route('pengguna') }}"><span class="menu-text">Data Pengguna</span></a>
                            </li>
                            <li class="{{ set_active_open(['parentKlasifikasi','childKlasifikasi']) }}">
                                <a href="#" class="menu-dropdown">
                                    <span class="menu-text">
                                        Data Klasifikasi
                                    </span>

                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="{{ set_active('parentKlasifikasi') }}">
                                        <a href="{{ route('parentKlasifikasi') }}">
                                            <i class="menu-icon fa fa-hand-o-right"></i>
                                            <span class="menu-text">Parent Klasifikasi</span>
                                        </a>
                                    </li>
                                    <li class="{{ set_active('childKlasifikasi') }}">
                                        <a href="{{ route('childKlasifikasi') }}">
                                            <i class="menu-icon fa fa-hand-o-right"></i>
                                            <span class="menu-text">Child Klasifikasi</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ set_active_open(['surat_keluar','sm_eksternal','sm_internal']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-book"></i>

                            <span class="menu-text">
                                Agenda Sentral
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active('sm_eksternal') }}">
                                <a href="{{ route('sm_eksternal') }}"><span class="menu-text">Surat Masuk Eksternal</span></a>
                            </li>
                            <li class="{{ set_active('sm_internal') }}">
                                <a href="{{ route('sm_internal') }}"><span class="menu-text">Surat Masuk Internal</span></a>
                            </li>
                            <li class="{{ set_active('surat_keluar') }}">
                                <a href="{{ route('surat_keluar') }}"><span class="menu-text">Surat Keluar</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ set_active_open(['agenda_direksi']) }}">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user-secret"></i>

                            <span class="menu-text">
                                Agenda Direksi
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active('agenda_direksi') }}">
                                <a href="{{ route('agenda_direksi') }}"><span class="menu-text">Surat Masuk Direksi</span></a>
                            </li>
                            <li class="{{ set_active('jabatan') }}">
                                <a href="#"><span class="menu-text">Disposisi Direksi</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-area-chart"></i>

                            <span class="menu-text">
                                Laporan
                            </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li class="{{ set_active('bagian') }}">
                                <a href="#"><span class="menu-text">Surat Masuk Sentral</span></a>
                            </li>
                            <li class="{{ set_active('bagian') }}">
                                <a href="#"><span class="menu-text">Surat Keluar</span></a>
                            </li>
                            <li class="{{ set_active('jabatan') }}">
                                <a href="#"><span class="menu-text">Surat Masuk Direksi</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="page-content">
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        @yield('breadcrumb')
                    </ul>
                </div>
                
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            @yield('title')
                        </h1>
                    </div>
                </div>
                
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