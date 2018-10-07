<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coSurat_keluar_direksi_eksternal extends Controller
{
    public function index()
    {
    	return view('mod_surat_keluar_direksi_eksternal/index_surat_keluar_direksi_eksternal');
    }

    public function listData()
    {
        $dataSurat = DB::table("tbl_surat_keluar")->where('tipe_surat', 5)
        										  ->where('id_bagian', Auth::user()->id_bagian)
        										  ->orderBy('created_at', 'desc')->get();
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
                                <a href='surat_keluar_direksi_eksternal/".$list->id_surat_keluar."/detail'>Detail Surat</a>
                            </li>
                            <li>
                                <a href='surat_keluar_direksi_eksternal/".$list->id_surat_keluar."/edit'>Ubah Data Surat</a>
                            </li>
                            <li class='divider'></li>
                            <li>
                                <a href='surat_keluar_direksi_eksternal/".$list->id_surat_keluar."/upload'>Upload File Surat</a>
                            </li>
                        </ul>
                    </div>";
            $row[] = $list->nomor_surat;
            $row[] = date('d M Y', strtotime($list->tanggal_surat));
            $row[] = $list->tujuan_surat;
            $row[] = $list->perihal_surat;
            $row[] = (($list->file_surat != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah upload File'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum upload File'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = (($list->status_agenda_dir != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah diagenda Sekdir'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum diagenda Sekdir'><i class='menu-icon fa fa-close'></i></span> ");
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
        $url = url('surat_keluar_direksi_eksternal/store');
        return view('mod_surat_keluar_direksi_eksternal/tambah_surat_keluar_direksi_eksternal', compact(['sifat','all','url','konseptor']));
    }

    public function store(Request $request)
    {
    	$thn = substr($request->tanggal_surat, 0, 4);
        $getNumber = DB::table('tbl_temp_surat_keluar')->where('tahun', $thn)->where('id_klasifikasi', $request->id_klasifikasi)->first();

        if(empty($request->tindasan_surat)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan_surat);
        }

        if($getNumber == NULL){
            $urut = 1;
            DB::table('tbl_temp_surat_keluar')->insert([
                'tahun' => $thn,
                'id_klasifikasi' => $request->id_klasifikasi,
                'nomor_urut' => $urut,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $urut = $getNumber->nomor_urut;
            $urut += 1;
            DB::table('tbl_temp_surat_keluar')->where('id_temp_surat_keluar', $getNumber->id_temp_surat_keluar)->update([
                'nomor_urut' => $urut,
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
            	'tipe_surat' => 5,
            	'id_bagian' => Auth::user()->id_bagian,
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $noSurat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'sifat_surat' => $request->sifat_surat,
	            'tujuan_surat' => $request->tujuan_surat,
	            'perihal_surat' => $request->perihal_surat,
	            'id_pembuat' => Auth::user()->id,
	            'id_konseptor' => $request->id_konseptor,
	            'id_hak_akses' => Auth::user()->id_role,
	            'tindasan_surat' => $arrTindasan,
	            'file_surat' => $url,
                'tindasan_eks' => $request->tindasan_eks,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }else{
        	DB::table('tbl_surat_keluar')->insert([
            	'tipe_surat' => 5,
            	'id_bagian' => Auth::user()->id_bagian,
	            'id_klasifikasi' => $request->id_klasifikasi,
	            'nomor_surat' => $noSurat,
	            'tanggal_surat' => $request->tanggal_surat,
	            'sifat_surat' => $request->sifat_surat,
	            'tujuan_surat' => $request->tujuan_surat,
	            'perihal_surat' => $request->perihal_surat,
	            'id_pembuat' => Auth::user()->id,
	            'id_konseptor' => $request->id_konseptor,
	            'id_hak_akses' => Auth::user()->id_role,
	            'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);
        }

        return Redirect::to('surat_keluar_direksi_eksternal/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat keluar berhasil diagenda dengan Nomor : <h1><strong>".$noSurat."</strong></h1>
        </div>");
    }

    public function upload($id)
    {
        $data = DB::table('tbl_surat_keluar')->select('nomor_surat','perihal_surat','tujuan_surat')->where('id_surat_keluar', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $url = url('surat_keluar_direksi_eksternal/'.$id.'/update_upload');
        return view('mod_surat_keluar_direksi_eksternal/upload_surat_keluar_direksi_eksternal', compact(['data','url','all']));
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

        return Redirect::to('surat_keluar_direksi_eksternal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
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

        return view('mod_surat_keluar_direksi_eksternal/detail_surat_keluar_direksi_eksternal', compact(['data','all','tujuan','tindasan','sifat']));
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

        if($data->tanggal_distribusi == NULL){
            $konseptor = DB::table("tbl_karyawan")->where('id_bagian', Auth::user()->id_bagian)->where('status_konseptor', 1)->where('status_karyawan', 1)->get();
            $url = url('surat_keluar_direksi_eksternal/'.$id.'/update');
            $edit_konseptor = explode(",", $data->id_konseptor);
            return view('mod_surat_keluar_direksi_eksternal/ubah_surat_keluar_direksi_eksternal', compact(['data','all','tujuan','tindasan','sifat','konseptor','edit_konseptor','url']));
        }else{
            return Redirect::to('surat_keluar_direksi_eksternal')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Surat keluar nomor ".$data->nomor_surat." tidak bisa diubah !</strong> Sudah diagenda oleh Sekretaris Direksi.
        </div>");
        }
    }

    public function update(Request $request, $id)
    {
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
                'tujuan_surat' => $request->tujuan_surat,
                'perihal_surat' => $request->perihal_surat,
                'id_konseptor' => $request->id_konseptor,
                'tindasan_surat' => $arrTindasan,
                'tindasan_eks' => $request->tindasan_eks,
                'file_surat' => $url,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'tanggal_surat' => $request->tanggal_surat,
                'sifat_surat' => $request->sifat_surat,
                'tujuan_surat' => $request->tujuan_surat,
                'perihal_surat' => $request->perihal_surat,
                'id_konseptor' => $request->id_konseptor,
                'tindasan_eks' => $request->tindasan_eks,
                'tindasan_surat' => $arrTindasan,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return Redirect::to('surat_keluar_direksi_eksternal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat keluar nomor ".$data_surat->nomor_surat." berhasil diubah.
        </div>");
    }
}
