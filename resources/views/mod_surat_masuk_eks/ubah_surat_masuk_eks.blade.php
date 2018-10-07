@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Masuk Eksternal</li>
    <li class="active">Ubah Data</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Form Surat Masuk Eksternal</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmSuratmasuk" method="POST" action="{{ $url }}">
                		{{ csrf_field() }}
                		<div class="row">
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
					                    <div class="row">
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tanggal_agenda_sentral">Tanggal Agenda Sentral</label>
					                                <input type="text" class="form-control" id="tanggal_agenda_sentral" name="tanggal_agenda_sentral" value="{{ $data->tanggal_agenda_sentral }}">
					                            </div>
					                        </div>
					                    </div>
					                    <div class="form-group">
			                                <label for="nomor_surat">Nomor Surat</label>
			                                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" onkeyup="upNomorsurat()" placeholder="Isi dengan TN untuk surat tanpa nomor" value="{{ $data->nomor_surat }}">
			                            </div>
			                            <div class="row">
			                            	<div class="col-md-6">
				                            	<div class="form-group">
                                                    <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="kode_klasifikasi" name="kode_klasifikasi" readonly="true" value="{{ $klas->kode_klas }}">
                                                    </div>
                                                </div>
				                            </div>
			                            	<div class="col-md-6">
				                            	<div class="form-group">
					                                <label for="tanggal_surat">Tanggal Surat</label>
					                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ $data->tanggal_surat }}">
					                            </div>
				                            </div>
			                            </div>
			                            <div class="form-group">
                                            <textarea class="form-control" rows="3" name="pokok_masalah" readonly="true">{{ $klas->nama_klas }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_pengirim">Nama Pengirim</label>
                                            <textarea class="form-control" rows="1" name="nama_pengirim" id="nama_pengirim" onkeyup="upNamapengirim()">{{ $data->nama_pengirim }}</textarea>
                                        </div>
                					</div>
                				</div>
                			</div>
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
                                        <div class="form-group">
                                            <label for="tujuan_surat">Tujuan</label>
                                            <select class="form-control" id="tujuan_surat" name="tujuan_surat[]" multiple="multiple" data-placeholder="Pilih Tujuan . . .">
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="perihal_surat">Perihal</label>
                                            <textarea class="form-control" rows="3" id="perihal_surat" name="perihal_surat" onkeyup="upPerihal()" maxlength="150">{{ $data->perihal_surat }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tindasan</label>
                                            <select class="form-control" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . .">
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-purple" id="btnSimpan">Simpan</button>
                                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('surat_masuk_eksternal') }}'">Batal</button>
                                        </div>
                					</div>
                				</div>
                			</div>
                		</div>
                	</form>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables.bootstrap.min.js') }}"></script>
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

        // Function upper input nomor surat
        function upNomorsurat(){
            var i = document.getElementById("nomor_surat");
            i.value = i.value.toUpperCase();
        }

        // Function upper input nama pengirim
        function upNamapengirim(){
            var i = document.getElementById("nama_pengirim");
            i.value = i.value.toUpperCase();
        }

        // Function upper input nomor surat
        function upPerihal(){
            var i = document.getElementById("perihal_surat");
            i.value = i.value.toUpperCase();
        }

    	$(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('#tindasan_surat').chosen({
                no_results_text: "Oops, data tidak ditemukan!"
            });

    		var tgl_surat = $('#tanggal_surat').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'tanggal_surat');
            }).data('datepicker');

            var tgl_agenda = $('#tanggal_agenda_sentral').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_agenda.hide();
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'tanggal_agenda_sentral');
            }).data('datepicker');

            $('#frmSuratmasuk').find('[name="tujuan_surat[]"]').chosen().change(function(e){
                $('#frmSk_internal').bootstrapValidator('revalidateField', 'tujuan_surat[]');
            }).end().bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    'tujuan_surat[]': {
                        validators: {
                            callback: {
                                message: 'Pilih minimal 1 tujuan',
                                callback: function(value, validator) {
                                    var options = validator.getFieldElements('tujuan_surat[]').val();
                                    return (options != null && options.length >= 1);
                                }
                            },
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    nomor_surat: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    tanggal_surat: {
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
                    nama_pengirim: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    perihal_surat: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
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