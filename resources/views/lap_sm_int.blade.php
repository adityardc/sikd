@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-home"></i>
        <a href="#">Beranda</a>
    </li>
    <li class="active">Laporan Surat Masuk Internal - Sentral</li>
@endsection

@section('title')
    Halaman Laporan Surat Masuk Internal - Sentral
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5 col-sm-5 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-palegreen">
                    <span class="widget-caption">Pencarian Surat Masuk Direksi Internal - Sentral</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmCari" novalidate="novalidate">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="status_hakakses">Tahun</label>
                                    <select class="form-control" name="tahun" id="tahun">
                                        @for ($i = date("Y"); $i >= 2017; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-palegreen" id="btnTampil">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-palegreen">
                    <span class="widget-caption">Tabel Surat Masuk Direksi Internal - Sentral</span>
                </div>
                <div class="widget-body">
                    <p class="text-center"><img src="{{ asset('assets/img/Ellipsis.gif') }}" id="imgLoader"></p>
                    <table class="table bordered-palegreen table-striped table-bordered table-hover responsive" id="tbl_sm_int" width="100%">
                        <thead class="bordered-palegreen">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">NO. STRL</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">TGL SURAT</th>
                                <th class="text-center">PERIHAL</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL SURAT -->
    <div class="modal fade bs-example-modal-sm" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <div class="modal-header bordered-purple">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Detail Surat Masuk Internal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div id="tampilSurat"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-purple" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        // FUNCTION SURAT MASUK DIREKSI / AGENDA DIREKSI
        function detail(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "laporan_surat_masuk_internal/"+id+"/detail",
                type: "GET",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#tampilSurat').html(data);
                    $('#imgLoaderModal').hide();
                    $('#modal_detail').modal('show');
                },
                complete: function(){
                    $('#imgLoader').hide();
                },
                error: function(){
                    alert("Tidak dapat menampilkan data!");
                }
            });
        }

        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            $('#imgLoader').hide();

            $('#btnTampil').click(function(){
                oTableSurat.fnDraw();
            });

            // TABLE SURAT MASUK EKSTERNAL DIREKSI
            var oTableSurat = $('#tbl_sm_int').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tbl_sm_int_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "pageLength": 20,
                "lengthMenu": [5, 10, 15, 20],
                "ajax": {
                    "url": "{{ route('lap_sm_int.data') }}",
                    // "type": "GET"
                    "data": function(d){
                        d.tahun = $('#tahun').val();
                    }
                },
                "aoColumnDefs": [{
                    "aTargets": [0,5],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "8%",
                    "sClass": "text-right"
                },{
                    "aTargets": [2],
                    "sWidth": "17%"
                },{
                    "aTargets": [3],
                    "sWidth": "11%",
                    "sClass": "text-center"
                }]
            });
        });
    </script>
@endsection