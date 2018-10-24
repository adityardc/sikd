@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li class="active">Surat Masuk Internal</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-6">
            @if (Session::has('status'))
                {!! Session::get('status') !!}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-magenta">
                    <span class="widget-caption">Tabel Surat Masuk Internal</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-magenta table-striped table-bordered table-hover responsive" id="tblSuratinternal" width="100%">
                        <thead class="bordered-magenta">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">AKSI</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">TGL SURAT</th>
                                <th class="text-center">TUJUAN</th>
                                <th class="text-center">PERIHAL</th>
                                <th class="text-center">SENTRAL</th>
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
                "pageLength": 15,
                "lengthMenu": [5, 10, 15, 20],
                "ajax": {
                    "url": "{{ route('surat_masuk_internal.data') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0,1],
                    "sWidth": "1%",
                    "sClass": "text-center"
                },{
                   "aTargets": [2],
                    "sWidth": "17%"
                },{
                   "aTargets": [3],
                    "sWidth": "12%",
                    "sClass": "text-center"
                },{
                   "aTargets": [6],
                    "sWidth": "1%",
                    "sClass": "text-center"
                }]
            });
        });
    </script>
@endsection