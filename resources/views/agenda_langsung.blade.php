@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li class="active">Surat Masuk Langsung</li>
@endsection

@section('title')
    Halaman Surat Masuk Langsung Direksi
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Form Agenda Direksi</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmAgendalangsung" novalidate="novalidate">
                		{{ csrf_field() }} {{ method_field('POST') }}
                		<div class="row">
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
                						<div class="form-title">
					                        Data Agenda Direksi
					                    </div>
					                    <div class="row">
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tujuan">Surat ke Direksi</label>
					                                <select class="form-control" name="tujuan" id="tujuan">
					                                    @foreach($tujuan as $rowDireksi)
					                                    	<option value="{{ $rowDireksi->id_bagian }}">{{ $rowDireksi->nama_bagian }}</option>
					                                    @endforeach
					                                </select>
					                            </div>  
					                        </div>
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tipe_agenda">Tipe Agenda</label>
					                                <select class="form-control" name="tipe_agenda" id="tipe_agenda">
					                                    @foreach($agenda as $row)
					                                    	<option value="{{ $row->id_jenis_surat }}">{{ $row->nama_jenis }}</option>
					                                    @endforeach
					                                </select>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="row">
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tanggal_agenda">Tanggal Agenda Surat</label>
					                                <input type="text" class="form-control" id="tanggal_agenda" name="tanggal_agenda" data-bv-field="tanggal_agenda">
					                                <i class="form-control-feedback" data-bv-field="tanggal_agenda" style="display: none;"></i>
					                            </div> 
					                        </div>
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="sifat_surat">Sifat Surat</label>
					                                <select class="form-control" name="sifat_surat" id="sifat_surat">
					                                    @foreach($sifat as $rowSifat)
					                                    	<option value="{{ $rowSifat->id_sifat_surat }}">{{ $rowSifat->nama_sifat }}</option>
					                                    @endforeach
					                                </select>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="form-group">
                                            <button type="submit" class="btn btn-azure" id="btnSimpan">Simpan</button>
                                            <button type="button" class="btn btn-yellow" id="btnBatal">Batal</button>
                                            <img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoader">
                                            <input type="text" name="id_agenda_dir" id="id_agenda_dir" class="form-control" style="display: block;">
                                        </div>
                					</div>
                				</div>
                			</div>
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
                						<div class="form-title">
					                        Data Surat Masuk
					                    </div>
					                    <div class="row">
					                        <div class="col-md-3">
					                            <div class="form-group">
					                                <label for="tanggal_surat">Tanggal Surat</label>
					                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" data-bv-field="tanggal_surat">
					                                <i class="form-control-feedback" data-bv-field="tanggal_surat" style="display: none;"></i>
					                            </div> 
					                        </div>
					                        <div class="col-md-9">
					                            <div class="form-group">
					                                <label for="nomor_surat">Nomor Surat</label>
					                                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" data-bv-field="nomor_surat" onkeyup="upNomorsurat()" maxlength="100">
					                                <i class="form-control-feedback" data-bv-field="nomor_surat" style="display: none;"></i>
					                            </div>
					                        </div>
					                    </div>
			                            <div class="form-group">
                                            <label for="pengirim">Pengirim</label>
                                            <input type="text" class="form-control" id="pengirim" name="pengirim" data-bv-field="pengirim" onkeyup="upPengirim()" maxlength="150">
                                            <i class="form-control-feedback" data-bv-field="pengirim" style="display: none;"></i>
                                        </div>
			                            <div class="form-group">
                                            <label for="perihal">Perihal</label>
                                            <textarea class="form-control" rows="3" id="perihal" name="perihal" onkeyup="upPerihal()" maxlength="150"></textarea>
                                            <i class="form-control-feedback" data-bv-field="perihal" style="display: none;"></i>
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
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bg-azure">
                    <span class="widget-caption">Tabel Data Agenda Direksi</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-azure table-striped table-bordered table-hover responsive" id="tblAgenda_langsung">
                        <thead class="bordered-azure">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nomor Agenda</th>
                                <th class="text-center">Tujuan</th>
                                <th class="text-center">Pengirim</th>
                                <th class="text-center">Perihal</th>
                                <th class="text-center">Aksi</th>
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

        // Function upper input nomor surat
        function upNomorsurat(){
            var i = document.getElementById("nomor_surat");
            i.value = i.value.toUpperCase();
        }

        // Function upper input pengirim
        function upPengirim(){
            var i = document.getElementById("pengirim");
            i.value = i.value.toUpperCase();
        }

        // Function upper input perihal
        function upPerihal(){
            var i = document.getElementById("perihal");
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
                url: "jabatan/"+id+"/edit",
                type: "GET",
                dataType: "JSON",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmJabatan').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('#nama_jabatan').val(data.nama_jabatan);
                    $('#id_jabatan').val(data.id_jabatan);
                    $('#btnBatal').show();
                    $('#nama_jabatan').focus();
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

        // Function ketika tombol hapus
        function deleteData(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            swal({
                title: "Konfirmasi !",
                text: "Anda yakin menghapus data jabatan ini ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes !'
            }).then(function(){
                $.ajax({
                    url: "jabatan/"+id,
                    type: "DELETE",
                    dataType: 'json',
                    beforeSend: function(){
                        $('#imgLoader').show();
                    },
                    success:function(response){
                        if(response.status == 3){
                            var alertStatus = ['alert-success', 'Sukses!', 'Data berhasil dihapus.'];
                        }else{
                            var alertStatus = ['alert-danger', 'Gagal!', 'Data gagal dihapus.'];
                        }

                        $('#alertNotif').html("<div class='alert "+alertStatus[0]+" alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>"+alertStatus[1]+"</strong> "+alertStatus[2]+"</div>");
                        $('#alertNotif').fadeTo(4000, 500).slideUp(500, function(){
                            $('#alertNotif').slideUp(500);
                        });
                        $('#nama_jabatan').focus();
                        $('#btnBatal').hide();
                        oTable.ajax.reload();
                    },
                    complete: function(){
                        $('#imgLoader').hide();
                    }
                });
            }).catch(swal.noop);
        }

        $(document).ready(function(){
            $('#btnBatal').hide();
            $('#imgLoader').hide();
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('#btnBatal').click(function(){
                $('#frmAgendalangsung')[0].reset();
                $('#btnBatal').hide();
            });

            oTable = $('#tblAgenda_langsung').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblAgenda_langsung_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('agenda_langsung.data') }}",
                    "type": "GET"
                },
                "columnDefs": [
                    {
                        className: "text-center",
                        targets: [0,5]
                    },
                    {
                        orderable: false,
                        targets: [0,5]
                    }
                ]
            });

            $('#frmAgendalangsung').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
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
                    nomor_surat: {
                    	validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
		                        max: 100,
		                        message: 'Maksimal 100 karakter yang diperbolehkan'
		                    }
                        }
                    },
                    pengirim: {
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
                    perihal: {
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
            }).on('success.form.bv', function(e){
                e.preventDefault();
                var id = $('#id_jabatan').val();
                if(id == ""){
                    url = "{{ route('jabatan.simpan') }}";
                    type = "POST";
                }else{
                    url = "jabatan/"+id;
                    type = "PUT";
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: $('#frmJabatan').serialize(),
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
                        $('#nama_jabatan').focus();
                        $('#btnBatal').hide();
                        oTable.ajax.reload();
                    },
                    complete: function(){
                        $('#imgLoader').hide();
                    }
                });
                $('#id_jabatan').val("");
                $('#frmJabatan').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
            });
        });
    </script>
@endsection