@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Data TIM</li>
    <li class="active">Ubah Data</li>
@endsection

@section('title')
    Halaman Ubah Data TIM
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
            @if(Session::has('status'))
                {!! Session::get('status') !!}
            @endif
        </div>
    </div>
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Form TIM</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmTim" novalidate="novalidate" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama_tim">Nama TIM</label>
                            <input type="text" class="form-control" name="nama_tim" id="nama_tim" maxlength="150" onkeyup="upNama()" autofocus value="{{ $data->nama_tim }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_anggota">Jenis Anggota TIM</label>
                            <select class="form-control" id="jns_tim" name="jns_tim">
                                <option value="">.:: PILIH SALAH SATU ::.</option>
                                <option value="1" {{ $data->jns_tim == 1 ? 'selected="selected"' : '' }}>BAGIAN</option>
                                <option value="2" {{ $data->jns_tim == 2 ? 'selected="selected"' : '' }}>KARYAWAN</option>
                            </select>
                        </div>
                        @if($data->jns_tim == 1)
                        <div class="form-group divBagian">
                            <label for="jenis_anggota">Nama Bagian</label>
                            <select class="form-control" id="anggota_bagian" name="anggota_bagian[]" multiple="multiple" data-placeholder="Pilih Bagian . . .">
                                <option value=""></option>
                                @foreach($bagian as $row)
                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $anggota_bagian)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="form-group divKaryawan">
                            <label for="jenis_anggota">Nama Karyawan</label>
                            <select class="form-control" id="anggota_karyawan" name="anggota_karyawan[]" multiple="multiple" data-placeholder="Pilih Karyawan . . .">
                                <option value=""></option>
                                @foreach($kry as $list)
                                    <option value="{{ $list->id_bagian }}-{{ $list->id_karyawan }}" {{ (in_array($list->id_karyawan, $anggota_karyawan)) ? 'selected' : '' }}>{{ $list->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="status_tim">Status TIM</label>
                                    <select class="form-control" name="status_tim" id="status_tim">
                                        <option value="Y" {{ $data->status_tim == "Y" ? 'selected="selected"' : '' }}>AKTIF</option>
                                        <option value="N" {{ $data->status_tim == "N" ? 'selected="selected"' : '' }}>TIDAK AKTIF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="grup_tim">Grup TIM</label>
                                    <select class="form-control" name="grup_tim" id="grup_tim">
                                        <option value="1" {{ $data->grup_tim == 1 ? 'selected="selected"' : '' }}>KANTOR DIREKSI</option>
                                        <option value="2" {{ $data->grup_tim == 2 ? 'selected="selected"' : '' }}>PABRIK GULA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-azure" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('tim') }}'">Batal/Kembali</button>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script src="{{ asset('assets/js/chosen/v1.7.0/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input nama jabatan
        function upNama(){
            var i = document.getElementById("nama_tim");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('#jns_tim').change(function(){
                var sel = $(this).val();
                if(sel == 1){
                    $('#anggota_karyawan').prop('disabled', true).val("").trigger("chosen:updated");
                    $('#anggota_bagian').prop('disabled', false).val("").trigger("chosen:updated");
                    $('.divKaryawan').hide();
                    $('.divBagian').show();
                }else{
                    $('#anggota_bagian').prop('disabled', true).val("").trigger("chosen:updated");
                    $('#anggota_karyawan').prop('disabled', false).val("").trigger("chosen:updated");
                    $('.divBagian').hide();
                    $('.divKaryawan').show();
                }
                $('#frmTim').bootstrapValidator('disableSubmitButtons', false);
            });

            $('#frmTim').find('[name="anggota_bagian[]"]').chosen().change(function(e){
                $('#frmTim').bootstrapValidator('revalidateField', 'anggota_bagian[]');
            }).end().find('[name="anggota_karyawan[]"]').chosen().change(function(e){
                $('#frmTim').bootstrapValidator('revalidateField', 'anggota_karyawan[]');
            }).end().bootstrapValidator({
                excluded: [':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    'anggota_karyawan[]': {
                        validators: {
                            callback: {
                                message: 'Pilih minimal 1 nama karyawan',
                                callback: function(value, validator) {
                                    var options = validator.getFieldElements('anggota_karyawan[]').val();
                                    return (options != null && options.length >= 1);
                                }
                            },
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    nama_tim: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Maksimal 150 karakter yang diperbolehkan'
                            }
                        }
                    },
                    jns_tim: {
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