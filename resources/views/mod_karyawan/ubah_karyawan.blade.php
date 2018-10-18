@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Karyawan</li>
    <li class="active">Ubah Data</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="widget">
				<div class="widget-header bordered-bottom bordered-sky">
                    <span class="widget-caption">Form Karyawan</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmKaryawan" novalidate="novalidate" enctype="multipart/form-data" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-title">
                                            Data Pribadi Karyawan
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_karyawan">Nama Karyawan</label>
                                            <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" maxlength="150" onkeyup="upNama()" autofocus value="{{ $data->nama_karyawan }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="text" class="form-control tgl" id="tanggal_lahir" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}">
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_karyawan">Tanggal Pengangkatan</label>
                                                    <input type="text" class="form-control tgl" id="tanggal_karyawan" name="tanggal_karyawan" value="{{ $data->tanggal_karyawan }}">
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Alamat Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" data-bv-field="email" maxlength="150" value="{{ $data->email }}">
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_karyawan">Jenis Kelamin</label>
                                                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                                        <option value="1" {{ ($data->jenis_kelamin == "1" ? "selected":"") }}>Laki - Laki</option>
                                                        <option value="2" {{ ($data->jenis_kelamin == "2" ? "selected":"") }}>Perempuan</option>
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="foto_karyawan">Foto Karyawan</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-sky btn-file">
                                                        Browse <input type="file" name="foto" id="foto" accept="image/*">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @if($data->foto != NULL)
                                            <img src="{{ url($data->foto) }}" class="header-avatar" height="200" width="200">
                                            @else
                                            Foto belum diupload !
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat">
                                    <div class="widget-body">
                                        <div class="form-title">
                                            Data Pekerjaan Karyawan
                                        </div>
                                        <div class="form-group">
                                            <label for="bagian">Bagian</label>
                                            <select class="form-control" name="bagian" id="bagian">
                                                @foreach($bagian as $rowBagian)
                                                    <option value="{{ $rowBagian->id_bagian }}" {{ ($data->id_bagian == $rowBagian->id_bagian ? "selected":"") }}>{{ $rowBagian->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <select class="form-control" name="jabatan" id="jabatan">
                                                @foreach($jbt as $rowJabatan)
                                                    <option value="{{ $rowJabatan->id_jabatan }}" {{ ($data->id_jabatan == $rowJabatan->id_jabatan ? "selected":"") }}>{{ $rowJabatan->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label for="golongan">Golongan</label>
                                                    <select class="form-control" name="golongan" id="golongan">
                                                        @foreach($gol as $rowGolongan)
                                                            <option value="{{ $rowGolongan->id_golongan }}" {{ ($data->id_golongan == $rowGolongan->id_golongan ? "selected":"") }}>{{ $rowGolongan->nama_golongan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pendidikan">Pendidikan</label>
                                                    <select class="form-control" name="pendidikan" id="pendidikan">
                                                        @foreach($ddk as $rowPendidikan)
                                                            <option value="{{ $rowPendidikan->id_pendidikan }}" {{ ($data->id_pendidikan == $rowPendidikan->id_pendidikan ? "selected":"") }}>{{ $rowPendidikan->nama_pendidikan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status_konseptor">Status Konseptor Surat</label>
                                                    <select class="form-control" name="status_konseptor" id="status_konseptor">
                                                        <option value="1" {{ ($data->status_konseptor == "1" ? "selected":"") }}>Aktif</option>
                                                        <option value="2" {{ ($data->status_konseptor == "2" ? "selected":"") }}>Tidak Aktif</option>
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status_karyawan">Status Karyawan</label>
                                                    <select class="form-control" name="status_karyawan" id="status_karyawan">
                                                        <option value="1" {{ ($data->status_karyawan == "1" ? "selected":"") }}>Aktif</option>
                                                        <option value="2" {{ ($data->status_karyawan == "2" ? "selected":"") }}>Tidak Aktif</option>
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sky" id="btnSimpan">Simpan</button>
                                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('karyawan') }}'">Batal/Kembali</button>
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
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        // Function upper input nama karyawan
        function upNama(){
            var i = document.getElementById("nama_karyawan");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            var tgl_lahir = $('#tanggal_lahir').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_lahir.hide();
                $('#frmKaryawan').bootstrapValidator('revalidateField', 'tanggal_lahir');
            }).data('datepicker');

            var tgl_angkat = $('#tanggal_karyawan').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(ev){
                tgl_angkat.hide();
                $('#frmKaryawan').bootstrapValidator('revalidateField', 'tanggal_karyawan');
            }).data('datepicker');

            $('#frmKaryawan').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_karyawan: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Maksimal 150 karakter yang diperbolehkan'
                            }
                        }
                    },
                    tanggal_lahir: {
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
                    tanggal_karyawan: {
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
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Maksimal 150 karakter yang diperbolehkan'
                            }
                        }
                    },
                    foto: {
                        validators: {
                            file: {
                                extension: 'jpg,jpeg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 1048576,
                                message: 'File foto harus format jpg dan berukuran maksimal 1 Mb.'
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