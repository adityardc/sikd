@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>
        <a href="#">Data Klasifikasi</a>
    </li>
    <li class="active">Child Klasifikasi</li>
@endsection

@section('title')
    Halaman Data Child Klasifikasi
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="widget">
				<div class="widget-header bg-yellow">
                    <span class="widget-caption">Tabel Data Child Klasifikasi</span>
                </div>
                <div class="widget-body">
                	<table class="table bordered-yellow table-striped table-bordered table-hover responsive" id="tblChild">
                		<thead class="bordered-yellow">
                			<tr>
	                			<th class="text-center col-md-1">#</th>
	                			<th class="text-center col-md-2">Kode Klasifikasi</th>
                                <th class="text-center col-md-4">Pokok Masalah</th>
	                			<th class="text-center col-md-5">Kamus Arsip</th>
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
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#imgLoader').hide();
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            oTable = $('#tblChild').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblChild_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('childKlasifikasi.data') }}",
                    "type": "GET"
                },
                "pageLength": 50,
                "ordering": false,
                "columnDefs": [
                    {
                        className: "text-center",
                        targets: [0]
                    }
                ]
            });
        });
    </script>
@endsection