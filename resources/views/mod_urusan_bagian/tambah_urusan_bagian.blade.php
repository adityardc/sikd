@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Urusan Bagian</li>
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
		<div class="col-lg-8 col-sm-8 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-magenta">
                    <span class="widget-caption">Form Urusan Bagian</span>
                </div>
                <div class="widget-body">
                	<div id="horizontal-form">
                		<form class="form-horizontal bv-form" role="form" id="frmUrusan" novalidate="novalidate" method="POST" action="{{ $url }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="karyawan" class="col-sm-2 control-label no-padding-right">Bagian</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_bagian" id="id_bagian">
                                        @foreach($bagian as $row)
                                            <option value="{{ $row->id_bagian }}">{{ $row->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label no-padding-right">Nama Urusan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="nama_urusan_bagian" id="nama_urusan_bagian" onkeyup="upUrusan()" maxlength="150">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label no-padding-right">Status Urusan</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="status_urusan_bagian" id="status_urusan_bagian">
                                        <option value="Y">AKTIF</option>
                                        <option value="N">TIDAK AKTIF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-magenta" id="btnSimpan">Simpan</button>
                                    <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('urusan_bagian') }}'">Batal/Kembali</button>
                                </div>
                            </div>
                		</form>
                	</div>
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

        // Function upper input nama bagian
        function upUrusan(){
            var i = document.getElementById("nama_urusan_bagian");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('#frmUrusan').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_urusan_bagian: {
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