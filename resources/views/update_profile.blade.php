@extends('layouts.app')

@section('breadcrumb')
    <li class="active"><i class="fa fa-home"></i> Beranda</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-palegreen">
                    <span class="widget-caption">Update Profile</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmProfile" enctype="multipart/form-data" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama_masakerja">Nama Karyawan</label>
                            <input type="text" class="form-control" value="{{ $data->nama_karyawan }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $data->email }}">
                        </div>
                        <div class="form-group">
                            <label for="pass1">Password</label>
                            <input type="password" class="form-control" name="pass1" id="pass1">
                        </div>
                        <div class="form-group">
                            <label for="pass2">re-Type Password</label>
                            <input type="password" class="form-control" name="pass2" id="pass2">
                        </div>
                        <div class="form-group">
                            <label for="upload_file">Upload Foto</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-palegreen btn-file">
                                        Browse <input type="file" name="file_suratkeluar" id="file_suratkeluar" accept="image/jpeg,image/png" onchange="document.getElementById('file_nama').value = this.value.split('\\').pop().split('/').pop()">
                                    </span>
                                </span>
                                <input type="text" class="form-control" name="file_nama" id="file_nama" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-palegreen" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('home') }}'">Batal/Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/validation/bootstrapValidator.js') }}"></script>
    <script type="text/javascript">
        // Function mencegah submit form dari tombol enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }
        document.onkeypress = stopRKey;

        $(document).ready(function(){
            $('#frmProfile').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            emailAddress: {
                                message: 'Mohon masukkan email yang valid !'
                            }
                        }
                    },
                    pass2: {
                        validators: {
                            identical: {
                                field: 'pass1',
                                message: 'Password tidak cocok !'
                            }
                        }
                    },
                    pass1: {
                        validators: {
                            identical: {
                                field: 'pass2',
                                message: 'Password tidak cocok !'
                            }
                        }
                    },
                    file_suratkeluar: {
                        validators: {
                            file: {
                                extension: 'jpeg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 1048576,
                                message: 'File harus format jpeg/png dan berukuran maksimal 1 Mb.'
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
