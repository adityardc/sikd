@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li class="active">Data Jenis Disposisi Direksi</li>
@endsection

@section('title')
    Halaman Data Jenis Disposisi Direksi
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-5 col-sm-5 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Form Jenis Disposisi Direksi</span>
                </div>
                <div class="widget-body">
                	<div id="horizontal-form">
                		<form class="form-horizontal bv-form" role="form" id="frmDisposisi" novalidate="novalidate">
                            {{ csrf_field() }} {{ method_field('POST') }}
                			<div class="form-group">
                                <label for="nama_disposisi" class="col-sm-4 control-label no-padding-right">Nama Disposisi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama_disposisi" id="nama_disposisi" data-bv-field="nama_disposisi" onkeyup="upNama()" autofocus>
                                    <i class="form-control-feedback" data-bv-field="nama_disposisi" style="display: none;"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status_aktif" class="col-sm-4 control-label no-padding-right">Status Aktif</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status_aktif" id="status_aktif">
	                                    <option value="Y">Aktif</option>
	                                    <option value="N">Tidak Aktif</option>
	                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-purple" id="btnSimpan">Simpan</button>
                                    <button type="button" class="btn btn-yellow" id="btnBatal">Batal</button>
                                    <img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoader">
                                    <input type="text" name="id_disposisi_direksi" id="id_disposisi_direksi" class="form-control" style="display: none;">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12" id="alertNotif" style="display: none;"></div>
                            </div>
                		</form>
                	</div>
                </div>
			</div>
		</div>
		<div class="col-lg-7 col-sm-7 col-xs-12">
			<div class="widget">
				<div class="widget-header bg-purple">
                    <span class="widget-caption">Tabel Data Jenis Disposisi Direksi</span>
                </div>
                <div class="widget-body">
                	<table class="table bordered-purple table-striped table-bordered table-hover responsive" id="tblDisposisi">
                		<thead class="bordered-purple">
                			<tr>
	                			<th class="text-center col-md-1">#</th>
	                			<th class="text-center">Nama Disposisi</th>
	                			<th class="text-center">Status Aktif</th>
	                			<th class="text-center col-md-1">Aksi</th>
	                		</tr>
                		</thead>
                        <tbody></tbody>
                	</table>
                </div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables.bootstrap.min.js') }}"></script>
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
        function upNama(){
            var i = document.getElementById("nama_disposisi");
            i.value = i.value.toUpperCase();
        }

        // Function ketika tombol edit
        function editData(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "disposisi/"+id+"/edit",
                type: "GET",
                dataType: "JSON",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmDisposisi').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('#nama_disposisi').val(data.nama_disposisi);
                    $('#status_aktif').val(data.status_aktif);
                    $('#id_disposisi_direksi').val(data.id_disposisi_direksi)
                    $('#btnBatal').show();
                    $('#nama_disposisi').focus();
                },
                complete: function(){
                    $('#imgLoader').hide();
                },
                error: function(){
                    alert("Tidak dapat menampilkan data!");
                }
            });
            return false;
        }

        $(document).ready(function(){
        	$('#btnBatal').hide();
            $('#imgLoader').hide();
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('#btnBatal').click(function(){
                $('#frmDisposisi')[0].reset();
                $('#btnBatal').hide();
                $('#nama_disposisi').focus();
            });

            oTable = $('#tblDisposisi').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblDisposisi_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('disposisi.data') }}",
                    "type": "GET"
                },
                "columnDefs": [
                    {
                        className: "text-center",
                        targets: [0,2,3]
                    },
                    {
                        orderable: false,
                        targets: [0,2,3]
                    }
                ]
            });

            $('#frmDisposisi').bootstrapValidator({
            	excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_disposisi: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
		                        max: 100,
		                        message: 'Maksimal 100 karakter yang diperbolehkan'
		                    }
                        }
                    }
                }
            }).on('success.form.bv', function(e){
            	e.preventDefault();
                var id = $('#id_disposisi_direksi').val();
                if(id == ""){
                    url = "{{ route('disposisi.simpan') }}";
                    type = "POST";
                }else{
                    url = "disposisi/"+id;
                    type = "PUT";
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: $('#frmDisposisi').serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#imgLoader').show();
                    },
                    success: function(data){
                        if(data.status == 1){
                            var alertStatus = ['alert-success', 'Sukses!', 'Data berhasil disimpan.'];
                        }else if(data.status == 2){
                            var alertStatus = ['alert-success', 'Sukses!', 'Data berhasil diubah.'];
                        }else{
                            var alertStatus = ['alert-danger', 'Gagal!', 'Data gagal disimpan/diubah.'];
                        }

                        $('#alertNotif').html("<div class='alert "+alertStatus[0]+" alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>"+alertStatus[1]+"</strong> "+alertStatus[2]+"</div>");
                        $('#alertNotif').fadeTo(4000, 500).slideUp(500, function(){
                            $('#alertNotif').slideUp(500);
                        });
                        $('#nama_disposisi').focus();
                        $('#btnBatal').hide();
                        oTable.ajax.reload();
                    },
                    complete: function(){
                        $('#imgLoader').hide();
                    }
                });
                $('#id_disposisi_direksi').val("");
                $('#frmDisposisi').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
            });
        });
    </script>
@endsection