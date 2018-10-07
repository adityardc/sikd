@extends('layouts.detail')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Masuk Eksternal</li>
    <li class="active">Detail Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-justified" id="myTab5">
                    <li class="active">
                        <a data-toggle="tab" href="#home1">
                            Detail Surat Masuk
                        </a>
                    </li>
                    @if($data->status_agenda_dir != NULL)
                    <li class="tab-palegreen">
                        <a data-toggle="tab" href="#home3">
                            Disposisi Direksi
                        </a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div id="home1" class="tab-pane in active">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="widget flat">
                                            <div class="widget-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_agenda_sentral">Tanggal Agenda Sentral</label>
                                                            <input type="text" class="form-control" disabled value="{{ $data->tanggal_agenda_sentral }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nomor_surat">Nomor Surat</label>
                                                    <input type="text" class="form-control" disabled value="{{ $data->nomor_surat }}">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                            <input type="text" class="form-control" disabled value="{{ $data->kode_klas }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_surat">Tanggal Surat</label>
                                                            <input type="text" class="form-control" disabled value="{{ $data->tanggal_surat }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" disabled>{{ $data->nama_klas }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_pengirim">Nama Pengirim</label>
                                                    <textarea class="form-control" rows="1" disabled>{{ $data->nama_pengirim }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="widget flat">
                                            <div class="widget-body">
                                                <div class="form-group">
                                                    <label for="tujuan_surat">Tujuan</label>
                                                    <select class="form-control chosen" id="tujuan_surat" multiple="multiple" disabled>
                                                        <option value=""></option>
                                                        @foreach($all as $row)
                                                            <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="perihal_surat">Perihal</label>
                                                    <textarea class="form-control" rows="3" disabled>{{ $data->perihal_surat }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tindasan_surat">Tindasan</label>
                                                    <select class="form-control chosen" id="tindasan_surat" multiple="multiple" disabled>
                                                        <option value=""></option>
                                                        @foreach($all as $row)
                                                            <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    @if($data->file_surat == NULL)
                                                        File tidak tersedia !
                                                    @else
                                                        <a href="{{ asset($data->file_surat) }}" target="_blank" class='btn btn-blue'><i class='fa fa-download'></i> Download File</a>
                                                    @endif
                                                    <button type="button" class="btn btn-yellow" onclick="closeTab()">TUTUP</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($data->status_agenda_dir != NULL)
                    <div id="home3" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <th style="width: 1%;text-align: center;">#</th>
                                                <th style="width: 17%;text-align: center;">Direktur</th>
                                                <th style="width: 12%;text-align: center;">Agenda Direksi</th>
                                                <th style="text-align: center;">Uraian Disposisi</th>
                                                <th style="text-align: center;">Tujuan Disposisi</th>
                                                <th style="text-align: center;">Disposisi</th>
                                            </thead>
                                            <tbody>
                                                @foreach($data_dispo as $row)
                                                <tr>
                                                    <td style="text-align: center;">{{ $row[0] }}</td>
                                                    <td>{{ $row[1] }}</td>
                                                    <td style="text-align: center;">{{ $row[2] }}</td>
                                                    <td>{{ $row[3] }}</td>
                                                    <td>
                                                        @foreach($row[4] as $key => $list)
                                                        {{ $list }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($row[5] as $key_dispo => $list_dispo)
                                                        {{ $list_dispo }}<br>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table><br>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-yellow" onclick="closeTab()">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/chosen/v1.7.0/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('.chosen').chosen({
                no_results_text: "Oops, data tidak ditemukan!"
            });
    	});	
    </script>
@endsection