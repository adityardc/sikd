@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li>
        <a href="#">Disposisi Direksi</a>
    </li>
    <li class="active">Surat Masuk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-purple">
                    <span class="widget-caption">Form Disposisi Direksi - Surat Masuk</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmAgenda" enctype="multipart/form-data" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-8 col-md-8 col-xs-12">
                                       <div class="form-group">
                                            <label for="nomor_surat">Nomor Surat</label>
                                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" disabled value="{{ $detail_surat->nomor_surat }}">
                                        </div> 
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="tanggal_agenda">Tanggal Agenda</label>
                                            <input type="text" class="form-control text-center" id="tanggal_agenda" disabled value="{{ date('d M Y', strtotime($detail_surat->tanggal_agenda)) }}">
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 col-md-8 col-xs-12">
                                        <div class="form-group">
                                            <label for="perihal_surat">Perihal Surat</label>
                                            <textarea class="form-control" rows="2" id="perihal_surat" name="perihal_surat" disabled>{{ $detail_surat->perihal_surat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="nomor_agenda">Nomor Agenda</label>
                                            <input type="text" class="form-control text-center" id="nomor_agenda" name="nomor_agenda" disabled value="{{ $detail_surat->nomor_agenda }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 col-md-8 col-xs-12">
                                        <div class="form-group">
                                            <label for="uraian_disposisi">Uraian Disposisi</label>
                                            <textarea class="form-control" rows="8" id="uraian_disposisi" name="uraian_disposisi" onkeyup="upUraian()">{{ $detail_surat->uraian_disposisi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="tanggal_distribusi_disposisi">Tanggal bagian</label>
                                            <input type="text" class="form-control text-center
                                            " id="tanggal_distribusi_disposisi" name="tanggal_distribusi_disposisi" value="{{ $detail_surat->tanggal_distribusi_disposisi }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="upload_file">Upload Disposisi</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-purple btn-file">
                                                Browse <input type="file" name="file_suratkeluar" id="file_suratkeluar" accept="image/jpeg,image/png,application/pdf" onchange="document.getElementById('file_nama').value = this.value.split('\\').pop().split('/').pop()">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" name="file_nama" id="file_nama" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-purple" id="btnSimpan">Simpan</button>
                                    <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('disposisi_direksi_surat_masuk') }}'">Batal</button>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-7 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-7 col-sm-7 col-xs-12">
                                        @foreach($dir as $row)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="colored-danger" name="tujuan_bagian_agenda[]" required value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $selected_tujuan)) ? 'checked' : '' }}>
                                                <span class="text">{{ $row->nama_bagian }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                        <br>
                                        @foreach($bag as $row)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="colored-danger" name="tujuan_bagian_agenda[]" value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $selected_tujuan)) ? 'checked' : '' }}>
                                                <span class="text">{{ $row->nama_bagian }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-5 col-sm-5 col-xs-12">
                                        @foreach($dispo as $row)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="colored-danger" name="disposisi_direksi[]" required value="{{ $row->id_disposisi_direksi }}" {{ (in_array($row->id_disposisi_direksi, $selected_disposisi)) ? 'checked' : '' }}>
                                                <span class="text">{{ $row->nama_disposisi }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script src="{{ asset('assets/js/datetime/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // FUNCTION UPPER URAIAN DISPOSISI
        function upUraian(){
            var i = document.getElementById("uraian_disposisi");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            var tgl_agenda = $('#tanggal_distribusi_disposisi').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_agenda.hide();
                $('#frmAgenda').bootstrapValidator('revalidateField', 'tanggal_distribusi_disposisi');
            }).data('datepicker');

            $('#frmAgenda').bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    uraian_disposisi: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    tanggal_distribusi_disposisi: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'Format tanggal tidak valid'
                            }
                        }
                    },
                    file_suratkeluar: {
                        validators: {
                            file: {
                                extension: 'jpeg,png,pdf',
                                type: 'image/jpeg,image/png,application/pdf',
                                maxSize: 1048576,
                                message: 'File harus format jpeg/png/pdf dan berukuran maksimal 1 Mb.'
                            }
                        }
                    }
                }
            }).on('success.field.bv', function(e, data){
                var $parent = data.element.parents('.form-group');
                $parent.removeClass('has-success');
                $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
            });
        });
    </script>
@endsection