@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-envelope"></i>
        <a href="#">Laporan Surat Masuk</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Pencarian Surat Masuk</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label for="key">Kata Kunci Pencarian</label>
                                    <select class="form-control" name="key" id="key">
                                        <option value="1">SURAT INTERNAL</option>
                                        <option value="2">SURAT EKSTERNAL</option>
                                        <option value="3">SURAT DIREKSI</option>
                                        <option value="4">DISPOSISI DIREKSI</option>
                                    </select>
                                </div>
                            </div>
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
                        <div class="row">
                            <div class="col-lg-8 col-sm-8 col-xs-12 divAsal">
                                <div class="form-group">
                                    <label for="asal">Asal Surat</label>
                                    <select class="form-control" name="asal" id="asal">
                                        <option value="1">INTERNAL</option>
                                        <option value="2">EKSTERNAL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-azure" id="btnTampil">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Tabel Surat Masuk</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-azure table-striped table-bordered table-hover responsive" id="tblSuratmasuk" width="100%">
                        <thead class="bordered-azure">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">AKSI</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">TGL SURAT</th>
                                <th class="text-center">TUJUAN</th>
                                <th class="text-center">PERIHAL</th>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            $('.divAsal').hide();

            $('#btnTampil').click(function(){
                oTableSuratMasuk.fnDraw();
            });

            $('#key').change(function(){
                if($(this).val() == 4 || $(this).val() == 3){
                    $('.divAsal').show();
                }else{
                    $('.divAsal').hide();
                }
            });

            var oTableSuratMasuk = $('#tblSuratmasuk').dataTable({
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
                "pageLength": 20,
                "lengthMenu": [5, 10, 15, 20],
                "ajax": {
                    "url": "{{ route('laporan_surat_masuk.data') }}",
                    // "type": "GET",
                    "data": function(d){
                        d.key = $('#key').val();
                        d.tahun = $('#tahun').val();
                        d.asal = $('#asal').val();
                    }
                },
                "aoColumnDefs": [{
                    "aTargets": [0,1],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [2],
                    "sWidth": "17%",
                },{
                    "aTargets": [3],
                    "sWidth": "12%",
                    "sClass": "text-center"
                },{
                    "aTargets": [4],
                    "sWidth": "20%"
                }]
            });
        });
    </script>
@endsection