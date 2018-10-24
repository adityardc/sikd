@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li class="active">Karyawan</li>
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
				<div class="widget-header bg-sky">
                    <span class="widget-caption">Tabel Data Karyawan</span>
                </div>
                <div class="widget-body">
                    <button class="btn btn-sky" onclick="location.href='{{ route('karyawan.create') }}'"><i class="fa fa-plus"> Tambah Data</i></button><hr>
                	<table class="table bordered-sky table-striped table-bordered table-hover responsive" id="tblKaryawan" width="100%">
                		<thead class="bordered-sky">
                			<tr>
	                			<th class="text-center">#</th>
	                			<th class="text-center">Nama Karyawan</th>
                                <th class="text-center">Bagian</th>
                                <th class="text-center">Jabatan</th>
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

            oTable = $('#tblKaryawan').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblKaryawan_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('karyawan.data') }}",
                    "type": "GET"
                },
                "ordering": false,
                "columnDefs": [
                    {
                        className: "text-center",
                        targets: [0,4],
                        width: "1%",
                        orderable: false,
                    }
                ]
            });
        });
    </script>
@endsection