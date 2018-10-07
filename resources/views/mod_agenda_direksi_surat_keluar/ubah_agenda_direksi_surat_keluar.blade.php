@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Direksi</a>
    </li>
    <li class="active">Surat Keluar Direksi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-lg-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Form Agenda Direksi Surat Keluar</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmAgenda" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_distribusi">Tanggal Distribusi Surat</label>
                                    <input type="text" class="form-control" id="tanggal_distribusi" name="tanggal_distribusi" value="{{ $detail_surat->tanggal_distribusi }}">
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="keterangan_distribusi">Keterangan</label>
                                    <textarea class="form-control" rows="3" name="keterangan_distribusi" id="keterangan_distribusi" onkeyup="upKeterangan()">{{ $detail_surat->keterangan_distribusi }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-azure" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('agenda_direksi_surat_keluar') }}'">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-lg-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-azure">
                    <span class="widget-caption">Detail Surat Keluar Direksi</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" class="form-control" value="{{ $detail_surat->nomor_surat }}" disabled>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @if($detail_surat->file_surat == NULL)
                                        <label class="label label-danger"><strong>File tidak tersedia !</strong></label>
                                    @else
                                        <label>File</label><br>
                                        <a href="{{ asset($detail_surat->file_surat) }}" target="_blank" class='btn btn-azure'><i class='fa fa-download'></i> Download File</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Perihal Surat</label>
                            <textarea class="form-control" rows="3" disabled>{{ $detail_surat->perihal_surat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tujuan_surat">Tujuan Surat</label>
                            @if($detail_surat->tipe_surat == 5)
                                <textarea class="form-control" rows="3" disabled>{{ $detail_surat->tujuan_surat }}</textarea>
                            @else
                                <select class="form-control chosen" id="tujuan_surat" name="tujuan_surat[]" multiple="multiple" data-placeholder="Pilih Tujuan . . ." disabled>
                                    <option value=""></option>
                                    @foreach($all as $row)
                                        <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tindasan_surat">Tindasan</label>
                            <select class="form-control chosen" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . ." disabled>
                                <option value=""></option>
                                @foreach($all as $row)
                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                @endforeach
                            </select>
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
    <script src="{{ asset('assets/js/chosen/v1.7.0/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input keterangan
        function upKeterangan(){
            var i = document.getElementById("keterangan_distribusi");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $('.chosen').chosen({
                no_results_text: "Oops, data tidak ditemukan!"
            });

            var tgl_surat = $('#tanggal_distribusi').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frmAgenda').bootstrapValidator('revalidateField', 'tanggal_distribusi');
            }).data('datepicker');

            $('#frmAgenda').bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    tanggal_distribusi: {
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
                    keterangan: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 250,
                                message: 'Maksimal 250 karakter yang diperbolehkan'
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