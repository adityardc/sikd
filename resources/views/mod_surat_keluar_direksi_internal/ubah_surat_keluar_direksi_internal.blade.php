@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/js/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/chosen/v1.7.0/chosen.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Agenda Sentral</a>
    </li>
    <li>Surat Keluar Direksi Internal</li>
    <li class="active">Ubah Data</li>
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
        <div class="col-lg-12 col-sm-12 col-lg-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-danger">
                    <span class="widget-caption">Form Surat Keluar Direksi Internal</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frm_dir_internal" enctype="multipart/form-data" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="kode_klasifikasi">Kode Klasifikasi</label>
                                                    <input type="text" class="form-control" value="{{ $data->kode_klas }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label for="kode_klasifikasi">Nomor Surat</label>
                                                    <input type="text" class="form-control" value="{{ $data->nomor_surat }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" id="pokok_masalah" name="pokok_masalah" readonly>{{ $data->nama_klas }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_surat">Tanggal Surat</label>
                                                    <input type="text" class="form-control tgl" id="tanggal_surat" name="tanggal_surat" value="{{ $data->tanggal_surat }}">
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sifat_surat">Sifat Surat</label>
                                                    <select class="form-control" name="sifat_surat" id="sifat_surat">
                                                        @foreach($sifat as $row)
                                                        <option value="{{ $row->id_sifat_surat }}" {{ $data->sifat_surat == $row->id_sifat_surat ? 'selected="selected"' : '' }}>{{ $row->nama_sifat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jns_tujuan">Tujuan Surat</label>
                                            <select class="form-control" name="jns_tujuan" id="jns_tujuan">
                                                <option value="0">DEFAULT</option>
                                                @foreach($tim as $rowTim)
                                                    <option value="{{ $rowTim->id_tim }}" {{ $data->jns_tujuan == $rowTim->id_tim ? 'selected="selected"' : '' }}>{{ $rowTim->nama_tim }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group divTujuan">
                                            <select class="form-control" id="tujuan_surat" name="tujuan_surat[]" multiple="multiple" data-placeholder="Pilih Tujuan . . .">
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tujuan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="perihal_surat">Perihal</label>
                                            <textarea class="form-control" rows="3" id="perihal_surat" name="perihal_surat" onkeyup="upPerihal()">{{ $data->perihal_surat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-group">
                                            <label for="konseptor">Konseptor</label>
                                            <select class="form-control chosen" id="id_konseptor" name="id_konseptor" data-placeholder="Pilih Konseptor . . .">
                                                <option value=""></option>
                                                @foreach($konseptor as $rowKonsep)
                                                    <option value="{{ $rowKonsep->id_karyawan }}" {{ (in_array($rowKonsep->id_karyawan, $edit_konseptor)) ? 'selected' : '' }}>{{ $rowKonsep->nama_karyawan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tindasan</label>
                                            <select class="form-control chosen" id="tindasan_surat" name="tindasan_surat[]" multiple="multiple" data-placeholder="Pilih Tindasan . . .">
                                                <option value=""></option>
                                                @foreach($all as $row)
                                                    <option value="{{ $row->id_bagian }}" {{ (in_array($row->id_bagian, $tindasan)) ? 'selected' : '' }}>{{ $row->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tindasan_surat">Tembusan Eksternal</label>
                                            <textarea class="form-control" rows="3" id="tindasan_eks" name="tindasan_eks" onkeyup="upTindasanEks()">{{ $data->tindasan_eks }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="upload_file">Upload File</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-danger btn-file">
                                                        Browse <input type="file" name="file_suratkeluar" id="file_suratkeluar" accept="image/jpeg,image/png,application/pdf" onchange="document.getElementById('file_nama').value = this.value.split('\\').pop().split('/').pop()">
                                                    </span>
                                                </span>
                                                <input type="text" class="form-control" name="file_nama" id="file_nama" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger" id="btnSimpan">Simpan</button>
                                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('surat_keluar_direksi_internal') }}'">Batal/Kembali</button>
                                            <input type="text" class="form-control" id="id_klasifikasi" name="id_klasifikasi" readonly style="display: none;">
                                        </div>
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
    <script src="{{ asset('assets/js/chosen/v1.7.0/chosen.jquery.min.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input perihal
        function upPerihal(){
            var i = document.getElementById("perihal_surat");
            i.value = i.value.toUpperCase();
        }

        function upTindasanEks(){
            var i = document.getElementById("tindasan_eks");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('.chosen').chosen({
                no_results_text: "Oops, data tidak ditemukan!"
            });

            $('#jns_tujuan').change(function(){
                var sel = $(this).val();
                if(sel == 0){
                    $('#tujuan_surat').prop('disabled', false).trigger("chosen:updated");
                    $('.divTujuan').show();
                }else{
                    $('#tujuan_surat').prop('disabled', true).val("").trigger("chosen:updated");
                    $('.divTujuan').hide();
                }
                $('#frm_dir_internal').bootstrapValidator('revalidateField', 'tujuan_surat[]');
                $('#frm_dir_internal').bootstrapValidator('disableSubmitButtons', false);
            });

            var tgl_surat = $('#tanggal_surat').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_surat.hide();
                $('#frm_dir_internal').bootstrapValidator('revalidateField', 'tanggal_surat');
            }).data('datepicker');

            $('#frm_dir_internal').find('[name="tujuan_surat[]"]').chosen().change(function(e){
                $('#frm_dir_internal').bootstrapValidator('revalidateField', 'tujuan_surat[]');
            }).end().bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    'tujuan_surat[]': {
                        validators: {
                            callback: {
                                message: 'Pilih minimal 1 tujuan',
                                callback: function(value, validator) {
                                    var options = validator.getFieldElements('tujuan_surat[]').val();
                                    return (options != null && options.length >= 1);
                                }
                            },
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            }
                        }
                    },
                    tanggal_surat: {
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
                    perihal_surat: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 250,
                                message: 'Maksimal 250 karakter yang diperbolehkan'
                            }
                        }
                    },
                    id_konseptor: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
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
                    },
                    tindasan_eks: {
                        validators: {
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