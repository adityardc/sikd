@extends('layouts.app')

@section('breadcrumb')
    <li class="active"><i class="fa fa-home"></i> Beranda</li>
@endsection

@section('title')
    Halaman Beranda
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-palegreen">
                    <span class="widget-caption">Selamat Datang</span>
                </div>
                <div class="widget-body text-justify">
                    <p>Sistem Informasi Kesekretariatan (SIK) adalah bentuk pemutakhiran data oleh PT Perkebunan Nusantara IX - Divisi Tanaman Semusim. Semoga Aplikasi SIK ini dapat memberikan manfaat dan mengakomodir kebutuhan di bidang sekretariatan.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
                @if(Session::has('status'))
                    {!! Session::get('status') !!}
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-container">
                    <div class="profile-header row">
                        <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                            <img src="{{ url($foto->foto) }}" alt="foto_karyawan" class="header-avatar" />
                        </div>
                        <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                            <div class="header-fullname">{{ Auth::user()->name }}</div>
                            <a href="home/{{ Auth::user()->id_karyawan }}/edit_profile" class="btn btn-palegreen btn-sm  btn-follow">
                                <i class="fa fa-check"></i>
                                Ubah Data
                            </a>
                            <div class="header-information">
                                <table class="table">
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bagian/Unitkerja</td>
                                        <td>:</td>
                                        <td>{{ $bag->nama_bagian }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kode Bagian/Unitkerja</td>
                                        <td>:</td>
                                        <td>{{ $bag->kode_bagian }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stats-col">
                                    <div class="stats-value pink">{{ $sk }}</div>
                                    <div class="stats-title">SURAT KELUAR</div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stats-col">
                                    <div class="stats-value pink">{{ $ksp }}</div>
                                    <div class="stats-title">KONSEPTOR</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 inlinestats-col">
                                    Hak Akses : <strong>{{ $ha->nama_hakakses }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
