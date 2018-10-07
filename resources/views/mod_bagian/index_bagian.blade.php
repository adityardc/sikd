@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li class="active">Data Bagian</li>
@endsection

@section('title')
    Halaman Data Bagian
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
				<div class="widget-header bg-palegreen">
                    <span class="widget-caption">Tabel Data Bagian</span>
                </div>
                <div class="widget-body">
                    @if(Auth::user()->id_role == 1)
                    <button class="btn btn-palegreen" onclick="location.href='{{ route('bagian.create') }}'"><i class="fa fa-plus"> Tambah Data</i></button><hr>
                    @endif
                	<table class="table bordered-palegreen table-striped table-bordered table-hover responsive" id="tblBagian" width="100%">
                		<thead class="bordered-palegreen">
                			<tr>
	                			<th class="text-center">#</th>
	                			<th class="text-center">Nama Bagian</th>
	                			<th class="text-center">Kode Bagian</th>
                                <th class="text-center">Grup</th>
                                <th class="text-center">Status Tindasan</th>
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
        // Function ketika tombol edit
        function editData(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "bagian/"+id+"/edit",
                type: "GET",
                dataType: "JSON",
                beforeSend: function(){
                    $('#imgLoader').show();
                },
                success: function(data){
                    $('#frmBagian').bootstrapValidator('disableSubmitButtons', false).bootstrapValidator('resetForm', true);
                    $('#nama_bagian').val(data.nama_bagian);
                    $('#kode_bagian').val(data.kode_bagian);
                    $('#id_bagian').val(data.id_bagian);
                    $('#tindasan').val(data.tindasan);
                    $('#grup_bagian').val(data.grup_bagian);
                    $('#status_bagian').val(data.status_bagian);
                    $('#btnBatal').show();
                    $('#nama_bagian').focus();
                },
                complete: function(){
                    $('#imgLoader').hide();
                },
                error: function(){
                    alert("Tidak dapat menampilkan data!");
                }
            });
            return false;
        }

        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            oTable = $('#tblBagian').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#tblBagian_filter input').off('.DT').on('keyup.DT', function(e){
                        if(e.keyCode == 13){
                            api.search(this.value).draw();
                        }
                    });
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('bagian.data') }}",
                    "type": "GET"
                },
                "ordering": false,
                "columnDefs": [
                    {
                        width: "1%",
                        className: "text-center",
                        targets: [0]
                    },{
                        width: "10%",
                        className: "text-center",
                        targets: [2]
                    },{
                        width: "17%",
                        className: "text-center",
                        targets: [3]
                    },{
                        width: "15%",
                        className: "text-center",
                        targets: [4]
                    },{
                        width: "1%",
                        className: "text-center",
                        targets: [5]
                    }
                ]
            });
        });
    </script>
@endsection