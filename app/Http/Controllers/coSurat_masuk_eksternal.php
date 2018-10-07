<?php
// ==================================================================================
// *   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
// *   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
// *   
// *   :: plz..don't remove this text if u are "the real open-sourcer" ::
// ====================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coSurat_masuk_eksternal extends Controller
{
    public function index()
    {
    	return view('mod_surat_masuk_eks/index_surat_masuk_eks');
    }

    public function listData()
    {
        $dataSurat = DB::table("tbl_surat_masuk")->where('id_bagian', Auth::user()->id_bagian)->orderBy('created_at', 'DESC')->get();
        $no = 0;
        $data = array();
        foreach ($dataSurat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<div class='btn-group'>
                        <a class='btn btn-default btn-xs dropdown-toggle shiny icon-only purple' data-toggle='dropdown'>
                            <i class='fa fa-unsorted'></i></i>
                        </a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='surat_masuk_eksternal/".$list->id_surat_masuk."/detail' target='_blank'>Detail Surat</a>
                            </li>
                            <li>
                                <a href='surat_masuk_eksternal/".$list->id_surat_masuk."/edit'>Ubah Data Surat</a>
                            </li>
                            <li class='divider'></li>
                            <li>
                                <a href='surat_masuk_eksternal/".$list->id_surat_masuk."/upload'>Upload File Surat</a>
                            </li>
                        </ul>
                    </div>";
            $row[] = $list->nomor_agenda_sentral;
            $row[] = date('d M Y', strtotime($list->tanggal_agenda_sentral));
            $row[] = $list->nomor_surat;
            $row[] = $list->perihal_surat;
            $row[] = (($list->file_surat != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah upload'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum upload'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = (($list->status_agenda_dir != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah diagenda Sekdir'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum diagenda Sekdir'><i class='menu-icon fa fa-close'></i></span> ");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $all = DB::table('tbl_bagian')->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $cek_data = DB::table('users')->select('tbl_bagian.grup_bagian')->join('tbl_bagian','users.id_bagian','=','tbl_bagian.id_bagian')->where('id', Auth::user()->id)->first();
        $url = url('surat_masuk_eksternal/store');
        return view('mod_surat_masuk_eks/tambah_surat_masuk_eks', compact(['all','url','cek_data']));
    }

    public function store(Request $request)
    {
    	$thn = substr($request->tanggal_agenda_sentral, 0, 4);
        $getNumber = DB::table('tbl_temp_surat_masuk')->where('tahun', $thn)->where('id_bagian', Auth::user()->id_bagian)->first();
        $cek_data = DB::table('users')
                    ->select('tbl_bagian.grup_bagian')->join('tbl_bagian','users.id_bagian','=','tbl_bagian.id_bagian')
                    ->where('id', Auth::user()->id)->first();

        if(empty($request->tindasan_surat)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan_surat);
        }

        if(empty($request->tujuan_surat)){
            $arrTujuan = "";
        }else{
            $arrTujuan = implode(',', $request->tujuan_surat);
        }

        if($getNumber == NULL){
            $urut = 1;
            DB::table('tbl_temp_surat_masuk')->insert([
                'tahun' => $thn,
                'nomor_urut' => $urut,
                'id_bagian' => Auth::user()->id_bagian,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $urut = $getNumber->nomor_urut;
            $urut += 1;
            DB::table('tbl_temp_surat_masuk')->where('id_temp_surat_masuk', $getNumber->id_temp_surat_masuk)->update([
                'nomor_urut' => $urut,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        if(!empty($request->file_suratmasuk)){
        	$extensionfile = $request->file_suratmasuk->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratmasuk));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_masuk')->insert([
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $request->nomor_surat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'nama_pengirim' => $request->nama_pengirim,
	            'tujuan_surat' => (($cek_data->grup_bagian == 1) ? $arrTujuan : Auth::user()->id_bagian),
	            'perihal_surat' => $request->perihal_surat,
	            'tindasan_surat' => (($cek_data->grup_bagian == 1) ? $arrTindasan : NULL),
	            'tanggal_agenda_sentral' => $request->tanggal_agenda_sentral,
	            'nomor_agenda_sentral' => $urut,
	            'status_agenda_dir' => 0,
	            'file_surat' => $url,
                'id_bagian' => Auth::user()->id_bagian,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }else{
        	DB::table('tbl_surat_masuk')->insert([
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $request->nomor_surat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'nama_pengirim' => $request->nama_pengirim,
	            'tujuan_surat' => (($cek_data->grup_bagian == 1) ? $arrTujuan : Auth::user()->id_bagian),
	            'perihal_surat' => $request->perihal_surat,
	            'tindasan_surat' => (($cek_data->grup_bagian == 1) ? $arrTindasan : NULL),
	            'tanggal_agenda_sentral' => $request->tanggal_agenda_sentral,
	            'nomor_agenda_sentral' => $urut,
	            'status_agenda_dir' => 0,
                'id_bagian' => Auth::user()->id_bagian,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }

        return Redirect::to('surat_masuk_eksternal/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat masuk berhasil diagenda dengan Nomor : <h1><strong>".$urut."</strong></h1>
        </div>");
    }

    public function upload($id)
    {
        $data = DB::table('tbl_surat_masuk')->select('nomor_surat','nama_pengirim')->where('id_surat_masuk', $id)->first();
        $url = url('surat_masuk_eksternal/'.$id.'/update_upload');
        return view('mod_surat_masuk_eks/upload_surat_masuk_eks', compact(['data','url']));
    }

    public function update_upload(Request $request, $id)
    {
    	$data = DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->first();
    	if($data->file_surat == NULL){
            $extensionfile = $request->file_suratmasuk->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratmasuk));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
                'file_surat' => $url
            ]);
    	}else{
    		$nama_file = substr($data->file_surat, 9);
    		$public_path = public_path().$data->file_surat;
    		File::delete($public_path);
    		$extensionfile = $request->file_suratmasuk->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratmasuk));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
                'file_surat' => $url
            ]);
    	}

        return Redirect::to('surat_masuk_eksternal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> File berhasil disimpan.
        </div>");
    }

    public function detail($id)
    {
        $data = DB::table('tbl_surat_masuk')
                    ->select('tbl_surat_masuk.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas')
                    ->join('tbl_klasifikasi','tbl_surat_masuk.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                    ->where('id_surat_masuk', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        $no = 0;

        if($data->status_agenda_dir == 1){
            $data_dir = DB::table('tbl_agenda_direksi')
                            ->select('tbl_agenda_direksi.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_direksi.tujuan_direksi_agenda','=','tbl_bagian.id_bagian')
                            ->where('tipe_surat', "EKS")->where('id_surat', $id)->get();

            foreach ($data_dir as $list) {
                $arrTujuan = explode(',', $list->tujuan_bagian_agenda);
                $arrTujuan = array_map('floatval', $arrTujuan);
                $tujuan_dispo = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

                $arrDispo = explode(',', $list->disposisi_direksi);
                $arrDispo = array_map('floatval', $arrDispo);
                $dispo = DB::table('tbl_jenis_disposisi_direksi')->select('nama_disposisi')->whereIn('id_disposisi_direksi', $arrDispo)->get();

                $no++;
                $bag_dispo = array();
                $jns_dispo = array();
                $row = array();

                foreach($tujuan_dispo as $bag => $x) {
                    $y = $bag+1;
                    $bag_dispo[] = $y.". ".$x->nama_bagian;
                }

                foreach($dispo as $bag_2 => $x_2) {
                    $y_2 = $bag_2+1;
                    $jns_dispo[] = $y_2.". ".$x_2->nama_disposisi;
                }

                $row[] = $no;
                $row[] = $list->nama_bagian;
                $row[] = $list->nomor_agenda;
                $row[] = $list->uraian_disposisi;
                $row[] = $bag_dispo;
                $row[] = $jns_dispo;
                $data_dispo[] = $row;
            }

            return view('mod_surat_masuk_eks/detail_surat_masuk_eks', compact(['data','all','tujuan','tindasan','dir','bag','sifat','data_dispo']));
        }else{
            return view('mod_surat_masuk_eks/detail_surat_masuk_eks', compact(['data','all','tujuan','tindasan']));
        }
    }

    public function edit($id)
    {
    	$data = DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->first();
    	$klas = DB::table('tbl_klasifikasi')->where('id_klas', $data->id_klasifikasi)->first();
        $all = DB::table('tbl_bagian')->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $url = url('surat_masuk_eksternal/'.$id.'/update');
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);

        if($data->status_agenda_dir == 1){
            return Redirect::to('surat_masuk_eksternal')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Surat masuk Eksternal nomor ".$data->nomor_surat." tidak bisa diubah !</strong> Sudah diagenda oleh Sekretaris Direksi.
        </div>");
        }else{
            return view('mod_surat_masuk_eks/ubah_surat_masuk_eks', compact(['all','url','data','klas','tindasan','tujuan']));
        }
    }

    public function update(Request $request, $id)
    {
    	if(empty($request->tindasan_surat)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan_surat);
        }

        $arrTujuan = implode(',', $request->tujuan_surat);

    	DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
            'tanggal_agenda_sentral' => $request->tanggal_agenda_sentral,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'nama_pengirim' => $request->nama_pengirim,
            'tujuan_surat' => $arrTujuan,
            'perihal_surat' => $request->perihal_surat,
            'tindasan_surat' => $arrTindasan,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return Redirect::to('surat_masuk_eksternal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Data surat masuk nomor : ".$request->nomor_surat.", berhasil disimpan.
        </div>");
    }
}
