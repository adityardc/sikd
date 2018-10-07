@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Keluar Direksi Eksternal</li>
    <li class="active">Detail Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-justified" id="myTab5">
                    <li class="active">
                        <a data-toggle="tab" href="#home1">
                            Detail Surat Keluar Direksi Eksternal
                        </a>
                    </li>
                    @if($data->tanggal_distribusi != NULL)
                    <li class="tab-red">
                        <a data-toggle="tab" href="#home2">
                            Keterangan Agenda Direksi
                        </a>
                    </li>
                    @endif
                    @if($data->status_agenda_sentral != NULL)
                    <li class="tab-azure">
                        <a data-toggle="tab" href="#home3">
                            Agenda Sentral
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
                                            <textarea class="form-control" rows="3" id="pokok_masalah" disabled>{{ $data->nama_klas }}</textarea>
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
                                                    <select class="form-control" name="sifat_surat" id="sifat_surat" disabled>
                                                        @foreach($sifat as $row)
                                                        <option value="{{ $row->id_sifat_surat }}" {{ $data->sifat_surat == $row->id_sifat_surat ? 'selected="selected"' : '' }}>{{ $row->nama_sifat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tujuan_surat">Tujuan Surat</label>
                                            <textarea class="form-control" rows="2" id="tujuan_surat" disabled>{{ $data->tujuan_surat }}</textarea>
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
                                                <a href="{{ asset($data->file_surat) }}" target="_blank" class='btn btn-purple'><i class='fa fa-download'></i> Download File</a>
                                            @endif
                                            <button type="button" class="btn btn-yellow" onclick="location.href='{{ route('surat_keluar_direksi_eksternal') }}'">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($data->tanggal_distribusi != NULL)
                    <div id="home2" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <div class="form-group">
                                                    <label for="tanggal_distribusi">Tanggal Distribusi Bagian</label>
                                                    <input type="text" class="form-control text-center" value="{{ date('d M y', strtotime($data->tanggal_distribusi)) }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea class="form-control" rows="3" id="pokok_masalah" disabled>{{ $data->keterangan_distribusi }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-yellow" onclick="location.href='{{ route('surat_keluar_direksi_eksternal') }}'">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($data->status_agenda_sentral != NULL)
                    <div id="home3" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <th>#</th>
                                                <th>Nama Bagian/Unitkerja</th>
                                                <th>Tanggal Agenda Sentral</th>
                                            </thead>
                                            <tbody>
                                                @foreach($data_sentral as $key => $row)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $row->nama_bagian }}</td>
                                                    <td>{{ date('d M Y', strtotime($data->tanggal_agenda_sentral)) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-yellow" onclick="location.href='{{ route('surat_keluar_direksi_eksternal') }}'">Kembali</button>
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