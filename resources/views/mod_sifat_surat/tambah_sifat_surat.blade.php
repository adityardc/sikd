@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Sifat Surat</li>
    <li class="active">Tambah Data</li>
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
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-palegreen">
                    <span class="widget-caption">Form Sifat Surat</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmSifatsurat" novalidate="novalidate" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
                                <div class="form-group">
                                    <label for="nama_sifat">Nama Sifat</label>
                                    <input type="text" class="form-control" name="nama_sifat" id="nama_sifat" maxlength="20" onkeyup="upNama()" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="kode_sifat">Kode Sifat</label>
                                    <input type="text" class="form-control" name="kode_sifat" id="kode_sifat" maxlength="5" onkeyup="upKode()">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="status_sifat">Status Sifat</label>
                                    <select class="form-control" name="status_sifat" id="status_sifat">
                                        <option value="Y">AKTIF</option>
                                        <option value="N">TIDAK AKTIF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" rows="3" id="deskripsi" name="deskripsi" onkeyup="upDeskripsi()" maxlength="150"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-palegreen" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('sifat_surat') }}'">Batal/Kembali</button>
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
            var i = document.getElementById("nama_sifat");
            i.value = i.value.toUpperCase();
        }

        // Function upper input kode jenis
        function upKode(){
            var i = document.getElementById("kode_sifat");
            i.value = i.value.toUpperCase();
        }

        // Function upper input deskripsi
        function upDeskripsi(){
            var i = document.getElementById("deskripsi");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('#frmSifatsurat').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_sifat: {
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
                    kode_sifat: {
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