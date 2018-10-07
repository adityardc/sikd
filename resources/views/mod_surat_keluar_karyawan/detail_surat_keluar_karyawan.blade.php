@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Keluar Karyawan</li>
    <li class="active">Detail Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-justified" id="myTab5">
                    <li class="active">
                        <a data-toggle="tab" href="#home1">
                            Detail Surat Keluar Karyawan
                        </a>
                    </li>
                    @if($data->status_agenda_dir != NULL)
                    <li class="tab-palegreen">
                        <a data-toggle="tab" href="#home2">
                            Disposisi Direksi
                        </a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div id="home1" class="tab-pane in active">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                    <input type="text" class="form-control" value="{{ $data->kode_klas }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label for="kode_klasifikasi">Nomor Surat</label>
                                                    <input type="text" class="form-control" value="{{ $data->nomor_surat }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" id="pokok_masalah" disabled>{!! $data->nama_klas !!}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_surat">Tanggal Surat</label>
                                                    <input type="text" class="form-control" value="{{ $data->tanggal_surat }}" disabled>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 divSifat">
                                                <div class="form-group">
                                                    <label for="sifat_surat">Sifat Surat</label>
                                                    <select class="form-control" name="sifat_surat" id="sifat_surat" disabled>
                                                        @foreach($sifat as $row)
                                                        <option value="{{ $row->id_sifat_surat }}" {{ $data->sifat_surat == $row->id_sifat_surat ? 'selected="selected"' : '' }}>{{ $row->nama_sifat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tujuan_surat">Tujuan / Nama Karyawan</label>
                                            <select class="form-control chosen" id="tujuan_surat" multiple="multiple" data-placeholder="Pilih Karyawan . . ." disabled>
                                                <option value=""></option>
                                                @foreach($kry as $row)
                                                    <option value="{{ $row->id_karyawan }}" {{ (in_array($row->id_karyawan, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_karyawan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="perihal_surat">Perihal</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $data->perihal_surat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-group">
                                            <label for="konseptor">Konseptor</label>
                                            <input type="text" class="form-control" value="{{ $data->nama_karyawan }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="konseptor">Pembuat Nomor</label>
                                            <input type="text" class="form-control" value="{{ $data->name }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tembusan Internal</label>
                                            <select class="form-control chosen" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . ." disabled>
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tembusan Eksternal</label>
                                            <textarea class="form-control" rows="3" id="tindasan_eks" name="tindasan_eks" disabled>{{ $data->tindasan_eks }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            @if($data->file_surat == NULL)
                                                File tidak tersedia !
                                            @else
                                                <a href="{{ asset($data->file_surat) }}" target="_blank" class='btn btn-sky'><i class='fa fa-download'></i> Download File</a>
                                            @endif
                                            <button type="button" class="btn btn-yellow" onclick="location.href='{{ route('surat_keluar_karyawan') }}'">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($data->status_agenda_dir != NULL)
                    <div id="home2" class="tab-pane">
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
                                            <button type="button" class="btn btn-yellow" onclick="location.href='{{ route('surat_keluar_karyawan') }}'">Kembali</button>
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