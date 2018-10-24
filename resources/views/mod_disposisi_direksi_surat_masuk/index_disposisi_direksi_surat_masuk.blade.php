@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li>Disposisi Direksi</li>
    <li class="active">Surat Masuk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
            @if(Session::has('status'))
                {!! Session::get('status') !!}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Tabel Agenda Direksi</span>
                </div>
                <div class="widget-body">
                    <table class="table bordered-purple table-striped table-bordered table-hover responsive" id="tblAgenda" width="100%">
                        <thead class="bordered-purple">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">No. Agenda</th>
                                <th class="text-center">Tgl. Agenda</th>
                                <th class="text-center">Uraian Disposisi</th>
                                <th class="text-center">File</th>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            // TABLE SURAT
            var oTableSurat = $('#tblAgenda').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblAgenda_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('disposisi_direksi_surat_masuk.data') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0,4,5],
                    "sWidth": "1%",
                    "sClass": "text-center"
                },{
                    "aTargets": [1],
                    "sWidth": "10%"
                },{
                    "aTargets": [2],
                    "sWidth": "10%",
                    "sClass": "text-center"
                }]
            });
        });
    </script>
@endsection