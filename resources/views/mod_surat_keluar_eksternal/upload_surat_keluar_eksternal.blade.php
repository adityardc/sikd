@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Keluar Eksternal</li>
    <li class="active">Upload Data</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-xs-6">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-magenta">
                    <span class="widget-caption">Form Surat Keluar Eksternal Upload File</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmSuratkeluar" enctype="multipart/form-data" method="POST" action="{{ $url }}">
                		{{ csrf_field() }}
                        <div class="form-group">
                            <label for="nomor_surat">Nomor Surat</label>
                            <input type="text" class="form-control" value="{{ $data->nomor_surat }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nama_pengirim">Perihal Surat</label>
                            <textarea class="form-control" rows="3" name="perihal_surat" id="perihal_surat" disabled>{{ $data->perihal_surat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tujuan_surat">Tujuan Surat</label>
                            <textarea class="form-control" rows="3" name="tujuan_surat" id="tujuan_surat" disabled>{{ $data->tujuan_surat }}</textarea>
                        </div>
                		<div class="form-group">
                            <label for="upload_file">Upload File</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-magenta btn-file">
                                        Browse <input type="file" name="file_suratkeluar" id="file_suratkeluar" accept="image/jpeg,image/png,application/pdf" onchange="document.getElementById('file_nama').value = this.value.split('\\').pop().split('/').pop()">
                                    </span>
                                </span>
                                <input type="text" class="form-control" name="file_nama" id="file_nama" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-magenta" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('surat_keluar_eksternal') }}'">Batal/Kembali</button>
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

    	$(document).ready(function(){
            $('#frmSuratkeluar').bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    file_suratkeluar: {
                        validators: {
                            notEmpty: {
                                message: 'Pilih File terlebih dahulu !'
                            },
                            file: {
                                extension: 'jpeg,png,pdf',
                                type: 'image/jpeg,image/png,application/pdf',
                                maxSize: 1048576,
                                message: 'File harus format jpeg/png/pdf dan berukuran maksimal 1 Mb.'
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