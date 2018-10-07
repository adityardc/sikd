@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li>Surat Masuk Direksi Sentral</li>
    <li class="active">Tambah Agenda</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-lg-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-warning">
                    <span class="widget-caption">Form Agenda Surat Masuk Direksi</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frm_internal" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_agenda">Tanggal Agenda Direksi</label>
                                    <input type="text" class="form-control" id="tanggal_agenda" name="tanggal_agenda">
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="status_hakakses">Direktur Tujuan</label>
                                    <select class="form-control" name="direktur" id="direktur">
                                        @foreach($direksi as $rowTujuan)
                                            <option value="{{ $rowTujuan->id_bagian }}">{{ $rowTujuan->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_agenda">Jenis Surat</label>
                                    <select class="form-control" name="jenis_agenda" id="jenis_agenda">
                                        @foreach($jns_surat as $row)
                                            <option value="{{ $row->id_jenis_surat }}">{{ $row->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="keterangan_agenda">Keterangan Agenda</label>
                                    <textarea class="form-control" rows="3" name="keterangan_agenda" id="keterangan_agenda" onkeyup="upKeterangan()"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-palegreen" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('surat_masuk_direksi_sentral') }}'">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-lg-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-warning">
                    <span class="widget-caption">Detail Surat Masuk Direksi Sentral Internal</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nomor Agenda</label>
                                    <input type="text" class="form-control text-center" value="{{ $data->nomor_agenda_sentral }}" disabled>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Agenda</label>
                                    <input type="text" class="form-control text-center" value="{{ date('d M Y', strtotime($data->tanggal_agenda_sentral)) }}" disabled>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" class="form-control" value="{{ $data->nomor_surat }}" disabled>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Perihal Surat</label>
                            <textarea class="form-control" rows="3" disabled>{{ $data->perihal_surat }}</textarea>
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
                        <div class="form-group">
                            <label for="tindasan_surat">Tindasan</label>
                            <select class="form-control chosen" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . ." disabled>
                                <option value=""></option>
                                @foreach($all as $row)
                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script src="{{ asset('assets/js/datetime/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chosen/v1.7.0/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input keterangan
        function upKeterangan(){
            var i = document.getElementById("keterangan_agenda");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('.chosen').chosen({
                no_results_text: "Oops, data tidak ditemukan!"
            });

            var tgl_surat = $('#tanggal_agenda').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frm_internal').bootstrapValidator('revalidateField', 'tanggal_agenda');
            }).data('datepicker');

            $('#frm_internal').bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    tanggal_agenda: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'Format tanggal tidak valid'
                            }
                        }
                    },
                    keterangan_agenda: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 250,
                                message: 'Maksimal 250 karakter yang diperbolehkan'
                            }
                        }
                    }
                }
            }).on('success.field.bv', function(e, data){
                var $parent = data.element.parents('.form-group');
                $parent.removeClass('has-success');
                $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
            });
        });
    </script>
@endsection