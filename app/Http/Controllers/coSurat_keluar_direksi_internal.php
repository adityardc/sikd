<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coSurat_keluar_direksi_internal extends Controller
{
    public function index()
    {
    	return view('mod_surat_keluar_direksi_internal/index_surat_keluar_direksi_internal');
    }

    public function listData()
    {
        $dataSurat = DB::table("tbl_surat_keluar")->where('tipe_surat', 4)
        										  ->where('id_bagian', Auth::user()->id_bagian)
        										  ->orderBy('tanggal_surat', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($dataSurat as $list) {
            $arrTujuan = explode(',', $list->tujuan_surat);
            $arrTujuan = array_map('floatval', $arrTujuan);
            $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

            $no++;
            $baris = array();
            $row = array();

            foreach($tujuan as $bag => $x) {
                $y = $bag+1;
                $baris[] = $x->nama_bagian;
            }

            $row[] = $no;
            $row[] = "<div class='btn-group'>
                        <a class='btn btn-default btn-xs dropdown-toggle shiny icon-only danger' data-toggle='dropdown'>
                            <i class='fa fa-unsorted'></i></i>
                        </a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='surat_keluar_direksi_internal/".$list->id_surat_keluar."/detail'>Detail Surat</a>
                            </li>
                            <li>
                                <a href='surat_keluar_direksi_internal/".$list->id_surat_keluar."/edit'>Ubah Data Surat</a>
                            </li>
                            <li class='divider'></li>
                            <li>
                                <a href='surat_keluar_direksi_internal/".$list->id_surat_keluar."/upload'>Upload File Surat</a>
                            </li>
                        </ul>
                    </div>";
            $row[] = $list->nomor_surat;
            $row[] = date('d M Y', strtotime($list->tanggal_surat));
            $row[] = $baris;
            $row[] = $list->perihal_surat;
            $row[] = (($list->file_surat != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah upload File'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum upload File'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = (($list->status_agenda_dir != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda Sekdir'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda Sekdir'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = (($list->status_agenda_sentral != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah diagenda Sentral'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum diagenda Sentral'><i class='menu-icon fa fa-close'></i></span> ");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
    	$konseptor = DB::table("tbl_karyawan")->where('id_bagian', Auth::user()->id_bagian)->where('status_konseptor', 1)->where('status_karyawan', 1)->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $url = url('surat_keluar_direksi_internal/store');
        if(Auth::user()->grup_bagian == 2){
            $tim = DB::table('tbl_tim')->where('status_tim', "Y")->where('grup_tim', 2)->orderBy('id_tim')->get();
        }else{
            $tim = DB::table('tbl_tim')->where('status_tim', "Y")->where('grup_tim', 1)->orderBy('id_tim')->get();
        }
        return view('mod_surat_keluar_direksi_internal/tambah_surat_keluar_direksi_internal', compact(['sifat','all','url','konseptor','tim']));
    }

    public function store(Request $request)
    {
    	$thn = substr($request->tanggal_surat, 0, 4);
        if(Auth::user()->grup_bagian == 1){
            $getNumber = DB::table('tbl_temp_surat_keluar')->where('tahun', $thn)->where('id_klasifikasi', $request->id_klasifikasi)->where('grup_bagian', Auth::user()->grup_bagian)->first();
        }else{
            $getNumber = DB::table('tbl_temp_surat_keluar')->where('tahun', $thn)->where('id_klasifikasi', $request->id_klasifikasi)->where('id_bagian', Auth::user()->id_bagian)->first();
        }

        if(empty($request->tindasan_surat)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan_surat);
        }

        if($request->jns_tujuan == 0){
            $arrTujuan = implode(',', $request->tujuan_surat);
        }else{
            $dataTim = DB::table('tbl_tim')->where('id_tim', $request->jns_tujuan)->first();
            if($dataTim->bagian_tim == ""){
                $arrTujuan = Auth::user()->id_bagian;
            }else{
                $arrTujuan = $dataTim->bagian_tim;
            }
        }

        if($getNumber == NULL){
            $urut = 1;
            DB::table('tbl_temp_surat_keluar')->insert([
                'tahun' => $thn,
                'id_klasifikasi' => $request->id_klasifikasi,
                'nomor_urut' => $urut,
                'id_bagian' => Auth::user()->id_bagian,
                'grup_bagian' => Auth::user()->grup_bagian,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $urut = $getNumber->nomor_urut;
            $urut += 1;
            DB::table('tbl_temp_surat_keluar')->where('id_temp_surat_keluar', $getNumber->id_temp_surat_keluar)->update([
                'nomor_urut' => $urut,
                'id_bagian' => Auth::user()->id_bagian,
                'grup_bagian' => Auth::user()->grup_bagian,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $kode_bagian = DB::table('tbl_bagian')->where('id_bagian', Auth::user()->id_bagian)->first();
        $noSurat = $request->kode_klasifikasi."/".$urut."/".$kode_bagian->kode_bagian."/".$thn;
        if(!empty($request->file_suratkeluar)){
        	$extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_keluar')->insert([
            	'tipe_surat' => 4,
            	'id_bagian' => Auth::user()->id_bagian,
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $noSurat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'sifat_surat' => $request->sifat_surat,
	            'tujuan_surat' => $arrTujuan,
	            'perihal_surat' => $request->perihal_surat,
	            'id_pembuat' => Auth::user()->id,
	            'id_konseptor' => $request->id_konseptor,
	            'id_hak_akses' => Auth::user()->id_role,
	            'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
	            'file_surat' => $url,
                'jns_tujuan' => $request->jns_tujuan,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }else{
        	DB::table('tbl_surat_keluar')->insert([
            	'tipe_surat' => 4,
            	'id_bagian' => Auth::user()->id_bagian,
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $noSurat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'sifat_surat' => $request->sifat_surat,
	            'tujuan_surat' => $arrTujuan,
	            'perihal_surat' => $request->perihal_surat,
	            'id_pembuat' => Auth::user()->id,
	            'id_konseptor' => $request->id_konseptor,
	            'id_hak_akses' => Auth::user()->id_role,
	            'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
                'jns_tujuan' => $request->jns_tujuan,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }

        return Redirect::to('surat_keluar_direksi_internal/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat keluar berhasil diagenda dengan Nomor : <h1><strong>".$noSurat."</strong></h1>
        </div>");
    }

    public function upload($id)
    {
        $data = DB::table('tbl_surat_keluar')->select('nomor_surat','perihal_surat','tujuan_surat')->where('id_surat_keluar', $id)->first();
        $tujuan = explode(",", $data->tujuan_surat);
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $url = url('surat_keluar_direksi_internal/'.$id.'/update_upload');
        return view('mod_surat_keluar_direksi_internal/upload_surat_keluar_direksi_internal', compact(['data','url','tujuan','all']));
    }

    public function update_upload(Request $request, $id)
    {
    	$data = DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->first();
    	if($data->file_surat == NULL){
            $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'file_surat' => $url
            ]);
    	}else{
    		$nama_file = substr($data->file_surat, 9);
    		$public_path = public_path().$data->file_surat;
    		File::delete($public_path);
    		$extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
            $fullName = time().'.'.$extensionfile;
            Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
            $url = Storage::url($fullName);

            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'file_surat' => $url
            ]);
    	}

        return Redirect::to('surat_keluar_direksi_internal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> File berhasil disimpan.
        </div>");
    }

    public function detail($id)
    {
        $data = DB::table('tbl_surat_keluar')
                ->select('tbl_surat_keluar.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas','tbl_karyawan.nama_karyawan','users.name')
                ->join('tbl_klasifikasi','tbl_surat_keluar.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                ->leftJoin('tbl_karyawan','tbl_surat_keluar.id_konseptor','=','tbl_karyawan.id_karyawan')
                ->join('users','tbl_surat_keluar.id_pembuat','=','users.id')
                ->where('tbl_surat_keluar.id_surat_keluar', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();

        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);

        if($data->status_agenda_sentral != NULL){
            $data_sentral = DB::table('tbl_agenda_sentral')
                            ->select('tbl_agenda_sentral.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_sentral.id_bagian','tbl_bagian.id_bagian')
                            ->where('id_surat_keluar', $id)->get();

            return view('mod_surat_keluar_direksi_internal/detail_surat_keluar_direksi_internal', compact(['data','all','tujuan','tindasan','sifat','data_sentral']));
        }else{
            return view('mod_surat_keluar_direksi_internal/detail_surat_keluar_direksi_internal', compact(['data','all','tujuan','tindasan','sifat']));
        }
    }

    public function edit($id)
    {
        $data = DB::table('tbl_surat_keluar')
                ->select('tbl_surat_keluar.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas','tbl_karyawan.nama_karyawan','users.name')
                ->join('tbl_klasifikasi','tbl_surat_keluar.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                ->leftJoin('tbl_karyawan','tbl_surat_keluar.id_konseptor','=','tbl_karyawan.id_karyawan')
                ->join('users','tbl_surat_keluar.id_pembuat','=','users.id')
                ->where('tbl_surat_keluar.id_surat_keluar', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();

        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);

        if(Auth::user()->grup_bagian == 2){
            $tim = DB::table('tbl_tim')->where('status_tim', "Y")->where('grup_tim', 2)->orderBy('id_tim')->get();
        }else{
            $tim = DB::table('tbl_tim')->where('status_tim', "Y")->where('grup_tim', 1)->orderBy('id_tim')->get();
        }

        if($data->status_agenda_sentral != NULL){
            return Redirect::to('surat_keluar_direksi_internal')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Surat keluar nomor ".$data->nomor_surat." tidak bisa diubah !</strong> Sudah diagenda oleh Sentral Kantor Direksi/Pabrik Gula.
        </div>");
        }else if($data->status_agenda_dir != NULL){
            return Redirect::to('surat_keluar_direksi_internal')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Surat keluar nomor ".$data->nomor_surat." tidak bisa diubah !</strong> Sudah diagenda oleh Sekretaris Direksi.
        </div>");
        }else{
            $konseptor = DB::table("tbl_karyawan")->where('id_bagian', Auth::user()->id_bagian)->where('status_konseptor', 1)->where('status_karyawan', 1)->get();
            $url = url('surat_keluar_direksi_internal/'.$id.'/update');
            $edit_konseptor = explode(",", $data->id_konseptor);
            return view('mod_surat_keluar_direksi_internal/ubah_surat_keluar_direksi_internal', compact(['data','all','tujuan','tindasan','sifat','konseptor','edit_konseptor','url','tim']));
        }
    }

    public function update(Request $request, $id)
    {
        if($request->jns_tujuan == 0){
            $arrTujuan = implode(',', $request->tujuan_surat);
        }else{
            $dataTim = DB::table('tbl_tim')->where('id_tim', $request->jns_tujuan)->first();
            if($dataTim->bagian_tim == ""){
                $arrTujuan = Auth::user()->id_bagian;
            }else{
                $arrTujuan = $dataTim->bagian_tim;
            }
        }

        if(empty($request->tindasan_surat)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan_surat);
        }

        $data_surat = DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->first();
        if(!empty($request->file_suratkeluar)){
            if($data_surat->file_surat == NULL){
                $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
                $fullName = time().'.'.$extensionfile;
                Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
                $url = Storage::url($fullName);
            }else{
                $nama_file = substr($data_surat->file_surat, 9);
                $public_path = public_path().$data_surat->file_surat;
                File::delete($public_path);
                $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
                $fullName = time().'.'.$extensionfile;
                Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
                $url = Storage::url($fullName);
            }

            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'tanggal_surat' => $request->tanggal_surat,
                'sifat_surat' => $request->sifat_surat,
                'tujuan_surat' => $arrTujuan,
                'perihal_surat' => $request->perihal_surat,
                'id_konseptor' => $request->id_konseptor,
                'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
                'file_surat' => $url,
                'jns_tujuan' => $request->jns_tujuan,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'tanggal_surat' => $request->tanggal_surat,
                'sifat_surat' => $request->sifat_surat,
                'tujuan_surat' => $arrTujuan,
                'perihal_surat' => $request->perihal_surat,
                'id_konseptor' => $request->id_konseptor,
                'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
                'jns_tujuan' => $request->jns_tujuan,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return Redirect::to('surat_keluar_direksi_internal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat keluar nomor ".$data_surat->nomor_surat." berhasil diubah.
        </div>");
    }
}
