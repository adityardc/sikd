@extends('layouts.app')

@section('breadcrumb')
    <li class="active"><i class="fa fa-home"></i> Beranda</li>
@endsection

@section('title')
    Halaman Beranda
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themesecondary">
                            <div class="databox-piechart">
                                <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="50" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)"><span class="white font-90">50%</span></div>
                            </div>
                        </div>
                        <div class="databox-right">
                            <span class="databox-number themesecondary">28</span>
                            <div class="databox-text darkgray">SURAT MASUK</div>
                            <div class="databox-stat themesecondary radius-bordered">
                                <i class="stat-icon icon-lg fa fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themethirdcolor">
                            <div class="databox-piechart">
                                <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="15" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.2)"><span class="white font-90">15%</span></div>
                            </div>
                        </div>
                        <div class="databox-right">
                            <span class="databox-number themethirdcolor">5</span>
                            <div class="databox-text darkgray">SURAT KELUAR</div>
                            <div class="databox-stat themethirdcolor radius-bordered">
                                <i class="stat-icon  icon-lg fa fa-envelope-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themeprimary">
                            <div class="databox-piechart">
                                <div id="users-pie" data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="76" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)"><span class="white font-90">76%</span></div>
                            </div>
                        </div>
                        <div class="databox-right">
                            <span class="databox-number themeprimary">92</span>
                            <div class="databox-text darkgray">SOFTCOPY SURAT KELUAR</div>
                            <div class="databox-state bg-themeprimary">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-blueberry">
                            <div class="databox-piechart">
                                <div id="users-pie" data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="76" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)"><span class="white font-90">76%</span></div>
                            </div>
                        </div>
                        <div class="databox-right">
                            <span class="databox-number blueberry">92</span>
                            <div class="databox-text darkgray">SOFTCOPY SURAT KELUAR</div>
                            <div class="databox-state bg-blueberry">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="well with-header with-footer">
                <div class="header bg-palegreen">
                    Data Surat Keluar
                </div>
                <table class="table table-hover table-striped table-bordered table-responsive">
                    <thead class="bordered-blueberry">
                        <tr>
                            <th rowspan="2" class="text-center col-md-1" style="vertical-align: middle;">#</th>
                            <th rowspan="2" class="text-center col-md-7" style="vertical-align: middle;" width="20%">Bagian</th>
                            <th colspan="2" class="text-center">Surat Keluar</th>
                            <th rowspan="2" class="text-center col-md-1" style="vertical-align: middle;">Progress %</th>
                        </tr>
                        <tr>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Belum diunggah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td class="text-left">Sekretaris Perusahaan</td>
                            <td>{{ $jml_90 }}</td>
                            <td><span class="red">{{ $upload_90 }}</span></td>
                            <td>{{ $prg_90 }} %</td>
                        </tr>
                        <tr class="text-center">
                            <td>2</td>
                            <td class="text-left">Satuan Pengawas Internal</td>
                            <td>{{ $jml_91 }}</td>
                            <td><span class="red">{{ $upload_91 }}</span></td>
                            <td>{{ $prg_91 }} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
