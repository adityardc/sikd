@extends('layouts.app')

@section('breadcrumb')
    <li>
        <i class="fa fa-hdd-o"></i>
        <a href="#">Master Data</a>
    </li>
    <li>Retensi Inaktif</li>
    <li class="active">Tambah Data</li>
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
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-darkorange">
                    <span class="widget-caption">Form Retensi Inaktif Klasifikasi</span>
                </div>
                <div class="widget-body">
                    <form class="bv-form" role="form" id="frmRetensi" novalidate="novalidate" method="POST" action="{{ $url }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nama_retensi">Nama Retensi</label>
                            <input type="text" class="form-control" name="nama_retensi" id="nama_retensi" maxlength="150" onkeyup="upNama()" autofocus>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="status_retensi">Status Aktif</label>
                                    <select class="form-control" name="status_retensi" id="status_retensi">
                                        <option value="Y">Aktif</option>
                                        <option value="N">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-darkorange" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-yellow" id="btnBatal" onclick="location.href='{{ route('retensi_inaktif') }}'">Batal/Kembali</button>
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

        // Function upper input nama bagian
        function upNama(){
            var i = document.getElementById("nama_retensi");
            i.value = i.value.toUpperCase();
        }

        $(document).ready(function(){
            $('#frmRetensi').bootstrapValidator({
                excluded: [':hidden', ':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama_retensi: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom harus diisi !'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Maksimal 150 karakter yang diperbolehkan'
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