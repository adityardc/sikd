@extends('layouts.detail')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Masuk Internal</li>
    <li class="active">Detail Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-justified" id="myTab5">
                    <li class="active">
                        <a data-toggle="tab" href="#home1">
                            Detail Surat Masuk Internal
                        </a>
                    </li>
                    <li class="tab-red">
                        <a data-toggle="tab" href="#home2">
                            Detail Agenda Sentral
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home1" class="tab-pane in active">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-group">
                                            @if($data->file_surat == NULL)
                                                File tidak tersedia !
                                            @else
                                                <a href="{{ asset($data->file_surat) }}" target="_blank" class='btn btn-sky'><i class='fa fa-download'></i> Download File</a>
                                            @endif
                                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="closeTab()">TUTUP</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                    <input type="text" class="form-control" value="{{ $data->kode_klas }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label for="nomor_surat">Nomor Surat</label>
                                                    <input type="text" class="form-control" value="{{ $data->nomor_surat }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" disabled>{{ $data->nama_klas }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_surat">Tanggal Surat</label>
                                                    <input type="text" class="form-control" value="{{ $data->tanggal_surat }}" disabled>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sifat_surat">Sifat Surat</label>
                                                    <select class="form-control" disabled>
                                                        @foreach($sifat as $row)
                                                        <option value="{{ $row->id_sifat_surat }}">{{ $row->nama_sifat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tujuan_surat">Tujuan Surat</label>
                                            <select class="form-control chosen" id="tujuan_surat" name="tujuan_surat[]" multiple="multiple" data-placeholder="Pilih Tujuan . . ." disabled>
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-group">
                                            <label for="perihal_surat">Perihal</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $data->perihal_surat }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="konseptor">Konseptor</label>
                                            <input type="text" class="form-control" value="{{ $data->nama_karyawan }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="konseptor">Pembuat Nomor</label>
                                            <input type="text" class="form-control" value="{{ $data->name }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tindasan</label>
                                            <select class="form-control chosen" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . ." disabled>
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}">{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="home2" class="tab-pane">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <th class="text-center" style="width: 1%">#</th>
                                <th class="text-center">Nama Bagian/Unit Kerja</th>
                                <th class="text-center" style="width: 15%">Nomor Agenda</th>
                                <th class="text-center" style="width: 15%">Tanggal Agenda</th>
                            </thead>
                            <tbody>
                                @foreach($sentral as $row => $val)
                                    <tr>
                                        <td class="text-center">{{ $row+1 }}</td>
                                        <td>{{ $val->nama_bagian }}</td>
                                        <td class="text-center">{{ $val->nomor_agenda_sentral }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($val->tanggal_agenda_sentral)) }}</td>
                                    </tr>
                                @endforeach
                                <div class="form-group">
                                    <button type="button" class="btn btn-yellow" id="btnBatal" onclick="closeTab()">TUTUP</button>
                                </div>
                            </tbody>
                        </table>
                    </div>
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