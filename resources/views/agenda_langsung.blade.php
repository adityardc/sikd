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
                                            <input type="text" name="id_agenda_dir" id="id_agenda_dir" class="form-control" style="display: none;">
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
					                        <div class="col-md-4">
					                            <div class="form-group">
					                                <label for="tanggal_surat">Tanggal Surat</label>
					                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" data-bv-field="tanggal_surat">
					                                <i class="form-control-feedback" data-bv-field="tanggal_surat" style="display: none;"></i>
					                            </div> 
					                        </div>
					                        <div class="col-md-8">
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
    <div class="modal fade bs-example-modal-sm" id="modalUnggah" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <form class="bv-form" role="form" id="frmUnggah" novalidate="novalidate" enctype="multipart/form-data">
                    <div class="modal-header bordered-azure">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="mySmallModalLabel">Unggah Berkas Disposisi</h4>
                    </div>
                    <div class="modal-body modal-body-pendek">
                        <div id="tampilAgenda"></div>
                        <!-- <div class="form-group">
                            <label for="file_surat">Upload Surat</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-palegreen btn-file">
                                        Browse <input type="file" name="file_surat" id="file_surat" accept="application/pdf">
                                    </span>
                                </span>
                                <input type="text" class="form-control" name="namaFile" id="namaFile" readonly>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-azure" data-dismiss="modal">Tutup</button>
                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <div class="modal-header bordered-azure">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Detail Surat Masuk</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div id="detailAgenda"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-azure" data-dismiss="modal">Tutup</button>
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
                url: "agenda_langsung/"+id+"/edit",
                type: "GET",
                dataType: "JSON",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmAgendalangsung').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('[name="tujuan"]').val(data.id_tujuan);
                    $('[name="tipe_agenda"]').val(data.id_jenis_surat);
                    $('[name="tanggal_agenda"]').val(data.tanggal_agenda);
                    $('[name="sifat_surat"]').val(data.sifat_surat);
                    $('[name="tanggal_surat"]').val(data.tanggal_surat);
                    $('[name="nomor_surat"]').val(data.nomor_surat);
                    $('[name="pengirim"]').val(data.pengirim);
                    $('[name="perihal"]').val(data.perihal);
                    $('[name="id_agenda_dir"]').val(data.id_agenda_dir);

                    $('[name="tujuan"]').attr('disabled', true);
                    $('[name="tipe_agenda"]').attr('disabled', true);
                    $('#btnBatal').show();
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

        // Function Unggah disposisi direksi
        function unggah_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "agenda_langsung/"+id+"/unggah",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmAgendalangsung').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('#tampilAgenda').html(data);
                    $("#modalUnggah").modal('show');
                },
                complete: function(){
                    $('#imgLoader').hide();
                },
                error: function(){
                    alert("Tidak dapat menampilkan data!");
                }
            });
        }

        // Function detail agenda direksi
        function detail_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "agenda_langsung/"+id+"/detail",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#detailAgenda').html(data);
                    $('#modalDetail').modal('show');
                },
                complete: function(){
                    $('#imgLoader').hide();
                },
                error: function(){
                    alert("Tidak dapat menampilkan data!");
                }
            });
        }

        $(document).ready(function(){
            $('#btnBatal').hide();
            $('#imgLoader').hide();
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('#btnBatal').click(function(){
                $('#frmAgendalangsung')[0].reset();
                $('[name="tujuan"]').attr('disabled', false);
                $('[name="tipe_agenda"]').attr('disabled', false);
                $('#btnBatal').hide();
            });

            var tgl_surat = $('#tanggal_surat').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frmAgendalangsung').bootstrapValidator('revalidateField', 'tanggal_surat');
            }).data('datepicker');

            var tgl_agenda = $('#tanggal_agenda').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_agenda.hide();
                $('#frmAgendalangsung').bootstrapValidator('revalidateField', 'tanggal_agenda');
            }).data('datepicker');

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
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "10%"
                },{
                   "aTargets": [2],
                    "sWidth": "18%"
                },{
                   "aTargets": [3,4],
                    "sWidth": "25%"
                },{
                   "aTargets": [5],
                    "sWidth": "10%",
                    "sClass": "text-center" 
                }]
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
                var id = $('#id_agenda_dir').val();
                if(id == ""){
                    url = "{{ route('agenda_langsung.simpan') }}";
                    type = "POST";
                }else{
                    url = "agenda_langsung/"+id;
                    type = "PUT";
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: $('#frmAgendalangsung').serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#imgLoader').show();
                    },
                    success: function(data){
                        if(data.status == 1){
                            swal({
                                title: "Nomor Agenda Direksi : "+data.nomor,
                                text: "Surat masuk berhasil disimpan.",
                                type: "success",
                                width: "50%"
                            });
                        }else if(data.status == 2){
                            swal({
                                title: "Berhasil !",
                                text: "Surat keluar berhasil diubah.",
                                type: "success",
                                width: "50%"
                            });
                        }else{
                            swal('Gagal !', 'Data surat gagal disimpan.', 'error');
                        }

                        $('#btnBatal').hide();
                        $('[name="tujuan"]').attr('disabled', false);
                        $('[name="tipe_agenda"]').attr('disabled', false);
                        $('#frmAgendalangsung')[0].reset();
                        oTable.ajax.reload();
                    },
                    complete: function(){
                        $('#imgLoader').hide();
                    }
                });
                $('#id_agenda_dir').val("");
                $('#frmAgendalangsung').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
            });
        });
    </script>
@endsection