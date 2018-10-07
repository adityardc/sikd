@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Jenis Surat Direksi</li>
    <li class="active">Ubah Data</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-danger">
                    <span class="widget-caption">Form Jenis Surat Direksi</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmJenissurat" novalidate="novalidate" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama_jenis">Nama Jenis</label>
                            <input type="text" class="form-control" name="nama_jenis" id="nama_jenis" maxlength="20" onkeyup="upNama()" autofocus value="{{ $data->nama_jenis }}">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="kode_jenis">Kode Jenis</label>
                                    <input type="text" class="form-control" name="kode_jenis" id="kode_jenis" maxlength="5" onkeyup="upKode()" value="{{ $data->kode_jenis }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="status_jenis">Status Jenis Surat</label>
                                    <select class="form-control" name="status_jenis" id="status_jenis">
                                        <option value="Y" {{ $data->status_jenis == "Y" ? 'selected="selected"' : '' }}>AKTIF</option>
                                        <option value="N" {{ $data->status_jenis == "N" ? 'selected="selected"' : '' }}>TIDAK AKTIF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" rows="3" id="deskripsi" name="deskripsi" onkeyup="upDeskripsi()" maxlength="150">{{ $data->deskripsi }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('jenis_surat') }}'">Batal/Kembali</
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input nama jenis
        function upNama(){
            var i = document.getElementById("nama_jenis");
            i.value = i.value.toUpperCase();
        }

        // Function upper input kode jenis
        function upKode(){
            var i = document.getElementById("kode_jenis");
            i.value = i.value.toUpperCase();
        }

        // Function upper input deskripsi
        function upDeskripsi(){
            var i = document.getElementById("deskripsi");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('#frmJenissurat').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_jenis: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
		                        max: 20,
		                        message: 'Maksimal 20 karakter yang diperbolehkan'
		                    }
                        }
                    },
                    kode_jenis: {
                    	validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
		                        max: 5,
		                        message: 'Maksimal 5 karakter yang diperbolehkan'
		                    }
                        }
                    },
                    deskripsi: {
                    	validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
		                        max: 150,
		                        message: 'Maksimal 150 karakter yang diperbolehkan'
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