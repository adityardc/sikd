@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li class="active">Surat Masuk Eksternal</li>
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
                <div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Tabel Surat Masuk Eksternal</span>
                    <div class="widget-buttons buttons-bordered">
                        <button class="btn btn-purple btn-sm" onclick="location.href='{{ route('surat_masuk_eksternal.create') }}'"><i class='fa fa-plus'></i> Tambah Data</button>
                    </div>
                </div>
                <div class="widget-body">
                    <table class="table bordered-purple table-striped table-bordered table-hover responsive" id="tbl_sm_eks" width="100%">
                        <thead class="bordered-purple">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">AKSI</th>
                                <th class="text-center">NO. STRL</th>
                                <th class="text-center">TGL STRL</th>
                                <th class="text-center">NO. SURAT</th>
                                <th class="text-center">PERIHAL</th>
                                <th class="text-center">FILE</th>
                                <th class="text-center">SEKDIR</th>
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
            var oTableSurat = $('#tbl_sm_eks').dataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tbl_sm_eks_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('surat_masuk_eksternal.data') }}",
                    "type": "GET"
                },
                "aoColumnDefs": [{
                    "aTargets": [0,1,6,7],
                    "sWidth": "2%",
                    "sClass": "text-center"
                },{
                    "aTargets": [2],
                    "sWidth": "8%",
                    "sClass": "text-right"
                },{
                    "aTargets": [3],
                    "sWidth": "10%",
                    "sClass": "text-center"
                },{
                    "aTargets": [4],
                    "sWidth": "20%"
                }]
            });
    	});	
    </script>
@endsection