@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li class="active">Retensi Deksripsi</li>
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
                <div class="widget-header bg-danger">
                    <span class="widget-caption">Tabel Data Retensi Deskripsi Klasifikasi</span>
                </div>
                <div class="widget-body">
                    @if(Auth::user()->id_role == 1)
                    <button class="btn btn-danger" onclick="location.href='{{ route('retensi_deskripsi.create') }}'"><i class="fa fa-plus"> Tambah Data</i></button><hr>
                    @endif
                    <table class="table bordered-danger table-striped table-bordered table-hover responsive" id="tblRetensi" width="100%">
                        <thead class="bordered-danger">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama Deskripsi Retensi</th>
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

            oTable = $('#tblRetensi').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblRetensi_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('retensi_deskripsi.data') }}",
                    "type": "GET"
                },
                "ordering": false,
                "columnDefs": [
                    {
                        className: "text-center",
                        targets: [0,2],
                        width: "3%"
                    },
                    {
                        orderable: false,
                        targets: [0,2]
                    }
                ]
            });
        });
    </script>
@endsection