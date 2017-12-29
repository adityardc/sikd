@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .modal-body-panjang {
            height:500px;
            overflow:auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li class="active">Surat Masuk Internal</li>
@endsection

@section('title')
    Halaman Surat Masuk Internal
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-magenta">
                    <span class="widget-caption">Tabel Surat Masuk Internal</span>
                </div>
                <div class="widget-body">
                    <p class="text-center"><img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoader"></p>
                    <table class="table bordered-magenta table-striped table-bordered table-hover responsive" id="tblSuratinternal">
                        <thead class="bordered-magenta">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">TANGGAL SURAT</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bg-magenta">
                    <span class="widget-caption">Tabel Surat Masuk Internal</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-magenta table-striped table-bordered table-hover responsive" id="tblSuratmasuk">
                        <thead class="bordered-magenta">
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
    <div class="modal fade bs-example-modal-sm" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <div class="modal-header bordered-magenta">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Detail Surat Internal</h4>
                </div>
                <div class="modal-body modal-body-panjang">
                    <div id="detailSurat"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-magenta" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="modalAgenda" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <form class="bv-form" role="form" id="frmAgendasentral" novalidate="novalidate">
                    <div class="modal-header bordered-magenta">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="mySmallModalLabel">Form Agenda Surat Masuk Internal</h4>
                    </div>
                    <div class="modal-body modal-body-panjang">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-lg-8 col-sm-8 col-xs-12">
                                    <div class="text-center">
                                        <div id="tampilSurat"></div>
                                    </div>      
                                </div>
                                <div class="col-lg-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="tanggal_agenda"><span class="label label-success">TANGGAL AGENDA</span></label>
                                        <input type="text" class="form-control tgl" id="tanggal_agenda" name="tanggal_agenda" data-bv-field="tanggal_agenda">
                                        <i class="form-control-feedback" data-bv-field="tanggal_agenda" style="display: none;"></i>
                                        <img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoaderModal">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-magenta" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
        // Function detail surat masuk
        function detail_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "sm_internal/"+id+"/detail",
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

        // Function agenda surat masuk internal
        function agenda_surat(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "sm_internal/"+id+"/agenda",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#tampilSurat').html(data);
                    $('#imgLoaderModal').hide();
                    $('#modalAgenda').modal('show');
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
            $('#imgLoader').hide();

            var tgl_agenda = $('#tanggal_agenda').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_agenda.hide();
                $('#frmAgendasentral').bootstrapValidator('revalidateField', 'tanggal_agenda');
            }).data('datepicker');

            // TABLE SURAT KELUAR INTERNAL
            var oTableSuratkeluar = $('#tblSuratinternal').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblSuratinternal_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "pageLength": 5,
                "lengthMenu": [5, 10, 15, 20],
                "ajax": {
                    "url": "{{ route('sm_internal.data') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sClass": "text-right"
                },{
                   "aTargets": [2],
                    "sWidth": "25%",
                    "sClass": "text-center"
                },{
                   "aTargets": [3],
                    "sWidth": "17%",
                    "sClass": "text-center" 
                }]
            });

            // TABLE SURAT MASUK SENTRAL INTERNAL
            var oTableSuratinternal = $('#tblSuratmasuk').dataTable({
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
                    "url": "{{ route('sm_internal.sentral') }}",
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
                    "sWidth": "5%",
                    "sClass": "text-center" 
                }]
            });

            $('#frmAgendasentral').bootstrapValidator({
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
                    }
                }
            }).on('success.form.bv', function(e){
                $.ajax({
                    url: "{{ route('sm_internal.simpan') }}",
                    type: "POST",
                    data: $('#frmAgendasentral').serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#imgLoaderModal').show();
                    },
                    success: function(data){
                        if(data.status == 1){
                            swal({
                                title: "Nomor Surat : "+data.nomor,
                                text: "Surat masuk berhasil diagenda.",
                                type: "success",
                                width: "50%"
                            });

                            oTableSuratkeluar.fnDraw();
                            oTableSuratinternal.fnDraw();
                        }else{
                            swal('Gagal !', 'Data surat gagal diagenda.', 'error');
                        }
                    },
                    complete: function(){
                        $('#imgLoaderModal').hide();
                    }
                });
                $('#modalAgenda').modal('hide');
                $('#frmAgendasentral').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
            });
        });
    </script>
@endsection