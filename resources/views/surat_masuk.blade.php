@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .modal-body-panjang {
            height:550px;
            overflow:auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li class="active">Surat Masuk</li>
@endsection

@section('title')
    Halaman Surat Masuk
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Form Surat Masuk</span>
                </div>
                <div class="widget-body">
                	<form class="bv-form" role="form" id="frmSuratmasuk" novalidate="novalidate">
                		{{ csrf_field() }} {{ method_field('POST') }}
                		<div class="row">
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
                						<div class="form-title">
					                        Data Surat Masuk
					                    </div>
					                    <div class="row">
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tipe_agenda">Tipe Agenda</label>
					                                <select class="form-control" name="tipe_agenda" id="tipe_agenda">
					                                    <option value="I">INTERNAL</option>
					                                    <option value="E">EKSTERNAL</option>
					                                </select>
					                            </div>  
					                        </div>
					                        <div class="col-md-6">
					                            <div class="form-group">
					                                <label for="tanggal_agenda">Tanggal Agenda</label>
					                                <input type="text" class="form-control" id="tanggal_agenda" name="tanggal_agenda" data-bv-field="tanggal_agenda">
					                                <i class="form-control-feedback" data-bv-field="tanggal_agenda" style="display: none;"></i>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="form-group">
			                                <label for="nomor_surat">Nomor Surat</label>
			                                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" data-bv-field="nomor_surat" onkeyup="upNomorsurat()" placeholder="Isi dengan TN untuk surat tanpa nomor">
			                                <i class="form-control-feedback" data-bv-field="nomor_surat" style="display: none;"></i>
			                            </div>
			                            <div class="row">
			                            	<div class="col-md-6">
				                            	<div class="form-group">
                                                    <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-purple" type="button" id="btnKlasifikasi" data-toggle="modal" data-target="#modalKlasifikasi"><i class="fa fa-search-plus"></i></button>
                                                        </span>
                                                        <input type="text" class="form-control" id="kode_klasifikasi" name="kode_klasifikasi" data-bv-field="kode_klasifikasi" readonly="true">
                                                    </div>
                                                    <i class="form-control-feedback" data-bv-field="kode_klasifikasi" style="display: none;"></i>
                                                </div>
				                            </div>
			                            	<div class="col-md-6">
				                            	<div class="form-group">
					                                <label for="tanggal_surat">Tanggal Surat</label>
					                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" data-bv-field="tanggal_surat">
					                                <i class="form-control-feedback" data-bv-field="tanggal_surat" style="display: none;"></i>
					                            </div>
				                            </div>
			                            </div>
			                            <div class="form-group">
                                            <textarea class="form-control" rows="3" name="pokok_masalah" readonly="true"></textarea>
                                            <i class="form-control-feedback" data-bv-field="pokok_masalah" style="display: none;"></i>
                                        </div>
			                            <div class="form-group">
                                            <label for="pengirim">Pengirim</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-purple" type="button" id="btnPengirim" data-toggle="modal" data-target="#modalPengirim"><i class="fa fa-search-plus"></i></button>
                                                </span>
                                                <input type="text" class="form-control" name="pengirim" data-bv-field="pengirim" readonly="true">
                                            </div>
                                            <i class="form-control-feedback" data-bv-field="pengirim" style="display: none;"></i>
                                        </div>
                                        <div class="form-group divNamapengirim">
                                            <label for="nama_pengirim">Nama Pengirim</label>
                                            <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" onkeyup="upNamapengirim()" data-bv-field="nama_pengirim">
                                            <i class="form-control-feedback" data-bv-field="nama_pengirim" style="display: none;"></i>
                                        </div>
                                        <div class="form-group">
                                            <label for="tujuan">Tujuan</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-purple" type="button" id="btnTujuan" data-toggle="modal" data-target="#modalTujuan"><i class="fa fa-search-plus"></i></button>
                                                </span>
                                                <input type="text" class="form-control" name="tujuan" data-bv-field="tujuan" readonly="true">
                                            </div>
                                            <i class="form-control-feedback" data-bv-field="tujuan" style="display: none;"></i>
                                        </div>
                                        <div class="form-group">
                                            <label for="perihal">Perihal</label>
                                            <textarea class="form-control" rows="3" id="perihal" name="perihal" onkeyup="upPerihal()" maxlength="150"></textarea>
                                            <i class="form-control-feedback" data-bv-field="perihal" style="display: none;"></i>
                                        </div>
                					</div>
                				</div>
                			</div>
                			<div class="col-lg-6 col-sm-6 col-xs-12">
                				<div class="widget flat">
                					<div class="widget-body">
                						<div class="form-title">
                                            Tindasan
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        @foreach($direktur as $row)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="tindasan[]" value="{{ $row->id_bagian }}">
                                                                    <span class="text">{{ $row->nama_bagian }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div> 
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        @foreach($bagian as $row)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="tindasan[]" value="{{ $row->id_bagian }}">
                                                                    <span class="text">{{ $row->nama_bagian }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        @foreach($unitkerja as $row)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="tindasan[]" value="{{ $row->id_bagian }}">
                                                                    <span class="text">{{ $row->nama_bagian }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-purple" id="btnSimpan">Simpan</button>
                                            <button type="button" class="btn btn-yellow" id="btnBatal">Batal</button>
                                            <input type="text" name="id_suratmasuk" class="form-control" style="display: none;">
                                            <input type="text" name="id_pengirim" class="form-control" style="display: none;">
                                            <input type="text" name="id_klasifikasi" class="form-control" style="display: none;">
                                            <input type="text" name="id_tujuan" class="form-control" style="display: none;">
                                            <img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoader">
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
                <div class="widget-header bg-purple">
                    <span class="widget-caption">Tabel Surat Masuk</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-purple table-striped table-bordered table-hover responsive" id="tblSuratmasuk">
                        <thead class="bordered-purple">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">NO. AGENDA</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">PENGIRIM</th>
                                <th class="text-center">TUJUAN</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade bs-example-modal-sm" id="modalKlasifikasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bordered-purple">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Tabel Klasifikasi Surat</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div class="table-responsive">
                        <table class="table bordered-purple table-striped table-bordered table-hover" id="tblKlasifikasi" width="100%">
                            <thead class="bordered-purple">
                                <th class="text-center">No</th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Kamus Arsip</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalPengirim" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bordered-purple">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Tabel Bagian</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div class="table-responsive">
                        <table class="table bordered-purple table-striped table-bordered table-hover" id="tblPengirim" width="100%">
                            <thead class="bordered-purple">
                                <th class="text-center">No</th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Bagian/Unit kerja</th>
                                <th class="text-center">Kode</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalTujuan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bordered-purple">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Tabel Bagian</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div class="table-responsive">
                        <table class="table bordered-purple table-striped table-bordered table-hover" id="tblTujuan" width="100%">
                            <thead class="bordered-purple">
                                <th class="text-center">No</th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Bagian/Unit kerja</th>
                                <th class="text-center">Kode</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <div class="modal-header bordered-purple">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Detail Surat Masuk</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div id="detailSurat"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalUnggah" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <form class="bv-form" role="form" id="frmUnggah" novalidate="novalidate" enctype="multipart/form-data">
                    <div class="modal-header bordered-purple">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="mySmallModalLabel">Unggah Berkas Surat Masuk</h4>
                    </div>
                    <div class="modal-body modal-body-pendek">
                        <div id="tampilSurat"></div>
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
                        <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                    </div>
                </form>
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

        // Function upper input nama pengirim
        function upNamapengirim(){
            var i = document.getElementById("nama_pengirim");
            i.value = i.value.toUpperCase();
        }

        // Function upper input nomor surat
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
                url: "surat_masuk/"+id+"/edit",
                type: "GET",
                dataType: "JSON",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmSuratmasuk').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('[name="tipe_agenda"]').val(data.tipe_agenda);
                    $('[name="tanggal_agenda"]').val(data.tanggal_agenda);
                    $('[name="nomor_surat"]').val(data.nomor_surat);
                    $('[name="kode_klasifikasi"]').val(data.sd1);
                    $('[name="tanggal_surat"]').val(data.tanggal_surat);
                    $('[name="pokok_masalah"]').val(data.sd3);
                    $('[name="pengirim"]').val(data.pengirim);
                    $('[name="nama_pengirim"]').val(data.nama_pengirim);
                    $('[name="tujuan"]').val(data.tujuan);
                    $('[name="perihal"]').val(data.perihal);
                    $('[name="id_suratmasuk"]').val(data.id_surat_masuk);
                    $('[name="id_pengirim"]').val(data.id_pengirim);
                    $('[name="id_klasifikasi"]').val(data.id_klasifikasi);
                    $('[name="id_tujuan"]').val(data.id_tujuan);

                    if(data.id_pengirim == "17"){
                        $('.divNamapengirim').show();
                    }else{
                        $('.divNamapengirim').hide();
                    }

                    $('[name="tanggal_agenda"]').attr('disabled', true);
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

        // Function detail surat masuk
        function detail_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "surat_masuk/"+id+"/detail",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#detailSurat').html(data);
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

        // Function Unggah Data surat masuk
        function unggah_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "surat_masuk/"+id+"/unggah",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmSuratmasuk').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('#tampilSurat').html(data);
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

    	$(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            $('#btnBatal').hide();
            $('#imgLoader').hide();
            $('.divNamapengirim').hide();

            $('#btnBatal').click(function(){
                $('#frmSuratmasuk')[0].reset();
                $('#frmSuratmasuk').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                $('.divNamapengirim').hide();
                $('[name="tanggal_agenda"]').attr('disabled', false);
                $('#btnBatal').hide();
            });

            $('[name="tipe_agenda"]').change(function(){
                if($(this).val() == "E"){
                    $('.divNamapengirim').show();
                    $('#btnPengirim').hide();
                    $('[name="pengirim"]').val("LAIN-LAIN");
                    $('[name="nama_pengirim"]').val("");
                    $('[name="id_pengirim"]').val("17");
                }else{
                    $('.divNamapengirim').hide();
                    $('#btnPengirim').show();
                    $('[name="pengirim"]').val("");
                    $('[name="nama_pengirim"]').val("");
                    $('[name="id_pengirim"]').val("");
                }
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'pengirim');
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'nama_pengirim');
            });

    		var tgl_surat = $('#tanggal_surat').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'tanggal_surat');
            }).data('datepicker');

            var tgl_agenda = $('#tanggal_agenda').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_agenda.hide();
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'tanggal_agenda');
            }).data('datepicker');

            // TABLE SURAT
            var oTableSurat = $('#tblSuratmasuk').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblSuratmasuk_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('surat_masuk.data') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "10%",
                    "sClass": "text-right"
                },{
                   "aTargets": [2],
                    "sWidth": "23%"
                },{
                   "aTargets": [3,4],
                    "sWidth": "23%"
                },{
                   "aTargets": [5],
                    "sWidth": "10%",
                    "sClass": "text-center" 
                }]
            });

            // TABLE KLASIFIKASI
            var oTableKlasifikasi = $('#tblKlasifikasi').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblKlasifikasi_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('surat_masuk.klasifikasi') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "5%",
                    "sClass": "text-center",
                    "mRender": function( data, type, full) {
                        return "<td><button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue btnPilihKlas' data-toggle='tooltip' data-placement='top' title='Pilih Klasifikasi'><span class='fa fa-pencil'></span></button></td>";
                    }
                },{
                    "aTargets": [2],
                    "sWidth": "20%",
                },{
                    "aTargets": [3],
                }]
            });

            // TABLE PENGIRIM
            var oTablePengirim = $('#tblPengirim').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblPengirim_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('surat_masuk.pengirim') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "5%",
                    "sClass": "text-center",
                    "mRender": function( data, type, full) {
                        return "<td><button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue btnPilihPengirim' data-toggle='tooltip' data-placement='top' title='Pilih Klasifikasi'><span class='fa fa-pencil'></span></button></td>";
                    }
                },{
                    "aTargets": [3],
                    "sWidth": "20%",
                }]
            });

            // TABLE TUJUAN
            var oTableTujuan = $('#tblTujuan').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblTujuan_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('surat_masuk.tujuan') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "5%",
                    "sClass": "text-center",
                    "mRender": function( data, type, full) {
                        return "<td><button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue btnPilihTujuan' data-toggle='tooltip' data-placement='top' title='Pilih Klasifikasi'><span class='fa fa-pencil'></span></button></td>";
                    }
                },{
                    "aTargets": [3],
                    "sWidth": "20%",
                }]
            });

            // TOMBOL PILIH KLASIFIKASI
            $('#tblKlasifikasi tbody').on('click', '.btnPilihKlas', function(){
                var tr = $(this).closest('tr');
                var index = oTableKlasifikasi.fnGetPosition(tr[0]);
                var kodeKlas = oTableKlasifikasi.fnGetData(index)[2];
                var pokokKlas = oTableKlasifikasi.fnGetData(index)[3];
                var idKlas = oTableKlasifikasi.fnGetData(index)[1];

                $('[name="kode_klasifikasi"]').val(kodeKlas);
                $('[name="pokok_masalah').val(pokokKlas);
                $('[name="id_klasifikasi').val(idKlas);
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'kode_klasifikasi');
                $('#modalKlasifikasi').modal('hide');
                return false;
            });

            // TOMBOL PILIH BAGIAN
            $('#tblPengirim tbody').on('click', '.btnPilihPengirim', function(){
                var tr = $(this).closest('tr');
                var index = oTablePengirim.fnGetPosition(tr[0]);
                var idBagian = oTablePengirim.fnGetData(index)[1];
                var namaBagian = oTablePengirim.fnGetData(index)[2];

                if(idBagian == "17"){
                    $('.divNamapengirim').show();
                    $('[name="nama_pengirim"]').val("");
                }else{
                    $('.divNamapengirim').hide();
                    $('[name="nama_pengirim"]').val(namaBagian);
                }

                $('[name="pengirim"]').val(namaBagian);
                $('[name="id_pengirim"]').val(idBagian);
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'pengirim');
                $('#modalPengirim').modal('hide');
                return false;
            });

            // TOMBOL PILIH TUJUAN
            $('#tblTujuan tbody').on('click', '.btnPilihTujuan', function(){
                var tr = $(this).closest('tr');
                var index = oTableTujuan.fnGetPosition(tr[0]);
                var idBagian = oTableTujuan.fnGetData(index)[1];
                var namaBagian = oTableTujuan.fnGetData(index)[2];

                $('[name="tujuan"]').val(namaBagian);
                $('[name="id_tujuan"]').val(idBagian);
                $('#frmSuratmasuk').bootstrapValidator('revalidateField', 'tujuan');
                $('#modalTujuan').modal('hide');
                return false;
            });

            $('#modalKlasifikasi').on('shown.bs.modal', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('#modalPengirim').on('shown.bs.modal', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('#modalTujuan').on('shown.bs.modal', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('#frmSuratmasuk').bootstrapValidator({
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
                    nomor_surat: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    kode_klasifikasi: {
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
                    pengirim: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
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
                    tujuan: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    perihal: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e){
                e.preventDefault();
                var id = $('[name="id_suratmasuk"]').val();
                if(id == ""){
                    url = "{{ route('surat_masuk.simpan') }}";
                    type = "POST";
                }else{
                    url = "surat_masuk/"+id;
                    type = "PUT";
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: $('#frmSuratmasuk').serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#imgLoader').show();
                    },
                    success: function(data){
                        if(data.status == 1){
                            swal({
                                title: "Nomor Agenda : "+data.nomor,
                                text: "Surat masuk berhasil diagenda.",
                                type: "success",
                                width: "50%"
                            });
                        }else if(data.status == 2){
                            swal({
                                title: "Berhasil !",
                                text: "Surat masuk berhasil diubah.",
                                type: "success",
                                width: "50%"
                            });
                        }else{
                            swal('Gagal !', 'Data surat gagal disimpan.', 'error');
                        }

                        $('.divNamapengirim').hide();
                        $('#btnBatal').hide();
                        $('#frmSuratmasuk')[0].reset();
                        $('#btnKlasifikasi').show();
                        $('[name="tanggal_agenda"]').attr('disabled', false);
                        oTableSurat.fnDraw();
                    },
                    complete: function(){
                        $('#imgLoader').hide();
                    }
                });

                $('[name="id_suratmasuk"]').val("");
                $('[name="id_klasifikasi"]').val("");
                $('[name="id_pengirim"]').val("");
                $('[name="id_tujuan"]').val("");
                $('#frmSuratmasuk').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
            });
    	});	
    </script>
@endsection