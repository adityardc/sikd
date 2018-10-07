@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Pengguna</li>
    <li class="active">Reset Password</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-8 col-sm-8 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-magenta">
                    <span class="widget-caption">Form Pengguna</span>
                </div>
                <div class="widget-body">
                	<div id="horizontal-form">
                		<form class="form-horizontal bv-form" role="form" id="frmPengguna" novalidate="novalidate" method="POST" action="{{ $url }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="karyawan" class="col-sm-2 control-label no-padding-right">Nama Karyawan</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $data->name }}" disabled="true" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label no-padding-right">Hak Akses</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="role" id="role" disabled="true">
                                        @foreach($role as $rowRole)
                                            <option value="{{ $rowRole->id_hakakses }}" {{ $data->id_role == $rowRole->id_hakakses ? 'selected="selected"' : '' }}>{{ $rowRole->nama_hakakses }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label no-padding-right">Status Pengguna</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="status_pengguna" id="status_pengguna" disabled="true">
                                        <option value="Y" {{ $data->status_pengguna == "Y" ? 'selected="selected"' : '' }}>AKTIF</option>
                                        <option value="N" {{ $data->status_pengguna == "N" ? 'selected="selected"' : '' }}>TIDAK AKTIF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-magenta" id="btnSimpan">Reset Password</button>
                                    <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('pengguna') }}'">Batal/Kembali</button>
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
    </script>
@endsection