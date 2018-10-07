@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li>Surat Masuk Direksi</li>
    <li class="active">Sentral</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-yellow">
                    <span class="widget-caption">Pencarian Surat Masuk Direksi Sentral</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmCari">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="status_hakakses">Direktur</label>
                            <select class="form-control" name="direktur" id="direktur">
                                @foreach($direksi as $rowTujuan)
                                    <option value="{{ $rowTujuan->id_bagian }}">{{ $rowTujuan->nama_bagian }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label for="asal_surat">Asal Surat</label>
                                    <select class="form-control" name="asal_surat" id="asal_surat">
                                            <option value="1">SURAT MASUK EKSTERNAL</option>
                                            <option value="2">SURAT MASUK INTERNAL</option>
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
                        <div class="form-group">
                            <button type="button" class="btn btn-yellow" id="btnTampil">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
            @if(Session::has('status'))
                {!! Session::get('status') !!}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-yellow">
                    <span class="widget-caption">Tabel Surat Masuk Direksi Sentral</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-yellow table-striped table-bordered table-hover responsive" id="tblSuratdireksi" width="100%">
                        <thead class="bordered-yellow">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">AKSI</th>
                                <th class="text-center">NO. STRL</th>
                                <th class="text-center">TGL STRL</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">PERIHAL</th>
                                <th class="text-center">AGENDA</th>
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

            $('#btnTampil').click(function(){
                oTableSuratdireksi.fnDraw();
            });

            // TABLE SURAT MASUK EKSTERNAL DIREKSI
            var oTableSuratdireksi = $('#tblSuratdireksi').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblSuratdireksi_filter input').off('.DT').on('keyup.DT', function(e){
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
                    "url": "{{ route('surat_masuk_direksi_sentral.data') }}",
                    // "type": "GET",
                    "data": function(d){
                        d.id_direksi = $('#direktur').val();
                        d.tahun = $('#tahun').val();
                        d.asal = $('#asal_surat').val();
                    }
                },
                "aoColumnDefs": [{
                    "aTargets": [0,1,6],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [2],
                    "sWidth": "8%",
                    "sClass": "text-right"
                },{
                    "aTargets": [3],
                    "sWidth": "13%",
                    "sClass": "text-center"
                },{
                    "aTargets": [4],
                    "sWidth": "20%"
                }]
            });
        });
    </script>
@endsection