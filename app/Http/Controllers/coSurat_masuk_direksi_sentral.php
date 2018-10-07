<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coSurat_masuk_direksi_sentral extends Controller
{
    public function index()
    {
    	$direksi = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	return view('mod_surat_masuk_direksi_sentral/index_surat_masuk_direksi_sentral', compact(['direksi']));
    }

    public function listData(Request $request)
    {
    	if($request->asal == 1){ // DARI EKSTERNAL
    		$tes = $request->id_direksi;
    		$dataSurat = DB::table('tbl_surat_masuk')
    							->select('tbl_surat_masuk.*','tbl_agenda_direksi.id_agenda_direksi')
    							->leftjoin('tbl_agenda_direksi', function($join) use ($tes){
                                        $join->on('tbl_surat_masuk.id_surat_masuk','=','tbl_agenda_direksi.id_surat')
                                             ->where('tbl_agenda_direksi.tujuan_direksi_agenda', $tes)
                                             ->where('tbl_agenda_direksi.tipe_surat', 'EKS');
                                  })
    							->whereRaw("((',' || RTRIM(tujuan_surat) || ',') LIKE '%,".$request->id_direksi.",%'
                                    OR (',' || RTRIM(tindasan_surat) || ',') LIKE '%,".$request->id_direksi.",%')
                                    AND extract(year from tanggal_surat) = ".$request->tahun)
    							->orderBy('nomor_agenda_sentral', 'DESC')->get();

    		$no = 0;
	        $data = array();
	        foreach ($dataSurat as $list) {
	            $no++;
	            $row = array();

	            $row[] = $no;
	            $row[] = (($list->id_agenda_direksi != NULL) ? "-" : "<a href='surat_masuk_direksi_sentral/".$list->id_surat_masuk."/create_eks' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' data-toggle='tooltip' data-placement='top' data-original-title='Agenda Surat'><i class='fa fa-pencil'></i></a>");
	            $row[] = $list->nomor_agenda_sentral;
	            $row[] = date('d M Y', strtotime($list->tanggal_agenda_sentral));
	            $row[] = $list->nomor_surat;
	            $row[] = $list->perihal_surat;
	            $row[] = (($list->id_agenda_direksi != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda'><i class='menu-icon fa fa-close'></i></span> ");
	            $data[] = $row;
	        }
    	}else{ // DARI INTERNAL
    		$tes = $request->id_direksi;
    		$dataSurat = DB::table('tbl_surat_keluar')
    							->select('tbl_surat_keluar.*','tbl_agenda_direksi.id_agenda_direksi','tbl_agenda_sentral.nomor_agenda_sentral','tbl_agenda_sentral.tanggal_agenda_sentral')
    							->join('tbl_agenda_sentral', function($join) use ($tes){
                                        $join->on('tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_sentral.id_surat_keluar')
                                             ->where('tbl_agenda_sentral.id_bagian', Auth::user()->id_bagian);
                                  })
    							->leftjoin('tbl_agenda_direksi', function($join) use ($tes){
                                        $join->on('tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_direksi.id_surat')
                                             ->where('tbl_agenda_direksi.tujuan_direksi_agenda', $tes)
                                             ->where('tbl_agenda_direksi.tipe_surat', 'INT');
                                  })
    							->whereRaw("((',' || RTRIM(tujuan_surat) || ',') LIKE '%,".$request->id_direksi.",%'
                                    OR (',' || RTRIM(tindasan_surat) || ',') LIKE '%,".$request->id_direksi.",%')
                                    AND extract(year from tanggal_surat) = ".$request->tahun)
    							->orderBy('tbl_agenda_sentral.nomor_agenda_sentral', 'DESC')->get();

    		$no = 0;
	        $data = array();
	        foreach ($dataSurat as $list) {
	            $no++;
	            $row = array();

	            $row[] = $no;
	            $row[] = (($list->id_agenda_direksi != NULL) ? "-" : "<a href='surat_masuk_direksi_sentral/".$list->id_surat_keluar."/create_int' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' data-toggle='tooltip' data-placement='top' data-original-title='Agenda Surat'><i class='fa fa-pencil'></i></a>");
	            $row[] = $list->nomor_agenda_sentral;
	            $row[] = date('d M Y', strtotime($list->tanggal_agenda_sentral));
	            $row[] = $list->nomor_surat;
	            $row[] = $list->perihal_surat;
	            $row[] = (($list->id_agenda_direksi != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda'><i class='menu-icon fa fa-close'></i></span> ");
	            $data[] = $row;
	        }
    	}

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create_eks($id)
    {
    	$all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
    	$direksi = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	$jns_surat = DB::table('tbl_jenis_surat')->where('status_jenis', "Y")->orderBy('id_jenis_surat')->get();
    	$data = DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->first();
        $url = url('surat_masuk_direksi_sentral/'.$id.'/update_eks');
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        return view('mod_surat_masuk_direksi_sentral/tambah_surat_masuk_direksi_sentral_eks', compact(['all','url','direksi','jns_surat','data','tindasan','tujuan']));
    }

    public function create_int($id)
    {
    	$all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
    	$direksi = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	$jns_surat = DB::table('tbl_jenis_surat')->where('status_jenis', "Y")->orderBy('id_jenis_surat')->get();
    	$data = DB::table('tbl_surat_keluar')->select('tbl_surat_keluar.*','tbl_agenda_sentral.nomor_agenda_sentral','tbl_agenda_sentral.tanggal_agenda_sentral')->join('tbl_agenda_sentral','tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_sentral.id_surat_keluar')->where('tbl_surat_keluar.id_surat_keluar', $id)->first();
        $url = url('surat_masuk_direksi_sentral/'.$id.'/update_int');
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        return view('mod_surat_masuk_direksi_sentral/tambah_surat_masuk_direksi_sentral_int', compact(['all','url','direksi','jns_surat','data','tindasan','tujuan']));
    }

    public function update_eks(Request $request, $id)
    {
        $thn = substr($request->tanggal_agenda, 0, 4);
    	$nomor = DB::table('tbl_temp_agenda_direksi')
    				->where('id_direksi', $request->direktur)
    				->where('id_jenis_surat', $request->jenis_agenda)
    				->where('tahun', $thn)
    				->first();

    	$cek_agenda = DB::table('tbl_agenda_direksi')->where('tipe_surat', 'EKS')->where('id_surat', $id)->where('tujuan_direksi_agenda', $request->direktur)->first();

    	if($cek_agenda == NULL){
    		if($nomor == NULL){
	            $urut = 1;
	            DB::table('tbl_temp_agenda_direksi')->insert([
	                'id_direksi' => $request->direktur,
	                'id_jenis_surat' => $request->jenis_agenda,
	                'nomor_urut' => $urut,
	                'tahun' => $thn,
	                'created_at' => \Carbon\Carbon::now(),
	                'updated_at' => \Carbon\Carbon::now()
	            ]);
	        }else{
	            $urut = $nomor->nomor_urut;
	            $urut += 1;
	            DB::table('tbl_temp_agenda_direksi')->where('id_temp_agenda', $nomor->id_temp_agenda)->update([
	                'nomor_urut' => $urut,
	                'updated_at' => \Carbon\Carbon::now()
	            ]);
	        }

	        $kodeBagian = DB::table('tbl_bagian')->select('kode_bagian')->where('id_bagian', $request->direktur)->first();
	        $kodeJenis = DB::table('tbl_jenis_surat')->select('kode_jenis')->where('id_jenis_surat', $request->jenis_agenda)->first();
	        $no_agenda = $kodeBagian->kode_bagian."/".$urut."/".$kodeJenis->kode_jenis;

	        DB::table('tbl_agenda_direksi')->insert([
	        	'tipe_surat' => "EKS",
	            'id_surat' => $id,
	            'nomor_agenda' => $no_agenda,
	            'tanggal_agenda' => $request->tanggal_agenda,
	            'keterangan_agenda' => $request->keterangan_agenda,
	            'jenis_agenda' => $request->jenis_agenda,
	            'tujuan_direksi_agenda' => $request->direktur,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);

	        DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
	            'status_agenda_dir' => 1,
	            'updated_at' => \Carbon\Carbon::now()
	        ]);

	        return Redirect::to('surat_masuk_direksi_sentral')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Sukses !</strong> Surat masuk berhasil diagenda direksi dengan Nomor : <h1><strong>".$no_agenda."</strong></h1>
	        </div>");
    	}else{
    		return Redirect::to('surat_masuk_direksi_sentral')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Gagal !</strong> Surat masuk <strong>sudah</strong> di agenda dengan nomor agenda : <h1><strong>".$cek_agenda->nomor_agenda."</strong></h1>
	        </div>");
    	}
    }

    public function update_int(Request $request, $id)
    {
        $thn = substr($request->tanggal_agenda, 0, 4);
    	$nomor = DB::table('tbl_temp_agenda_direksi')
    				->where('id_direksi', $request->direktur)
    				->where('id_jenis_surat', $request->jenis_agenda)
    				->where('tahun', $thn)
    				->first();

    	$cek_agenda = DB::table('tbl_agenda_direksi')->where('tipe_surat', 'INT')->where('id_surat', $id)->where('tujuan_direksi_agenda', $request->direktur)->first();

    	if($cek_agenda == NULL){
    		if($nomor == NULL){
	            $urut = 1;
	            DB::table('tbl_temp_agenda_direksi')->insert([
	                'id_direksi' => $request->direktur,
	                'id_jenis_surat' => $request->jenis_agenda,
	                'nomor_urut' => $urut,
	                'tahun' => $thn,
	                'created_at' => \Carbon\Carbon::now(),
	                'updated_at' => \Carbon\Carbon::now()
	            ]);
	        }else{
	            $urut = $nomor->nomor_urut;
	            $urut += 1;
	            DB::table('tbl_temp_agenda_direksi')->where('id_temp_agenda', $nomor->id_temp_agenda)->update([
	                'nomor_urut' => $urut,
	                'updated_at' => \Carbon\Carbon::now()
	            ]);
	        }

	        $kodeBagian = DB::table('tbl_bagian')->select('kode_bagian')->where('id_bagian', $request->direktur)->first();
	        $kodeJenis = DB::table('tbl_jenis_surat')->select('kode_jenis')->where('id_jenis_surat', $request->jenis_agenda)->first();
	        $no_agenda = $kodeBagian->kode_bagian."/".$urut."/".$kodeJenis->kode_jenis;

	        DB::table('tbl_agenda_direksi')->insert([
	        	'tipe_surat' => "INT",
	            'id_surat' => $id,
	            'nomor_agenda' => $no_agenda,
	            'tanggal_agenda' => $request->tanggal_agenda,
	            'keterangan_agenda' => $request->keterangan_agenda,
	            'jenis_agenda' => $request->jenis_agenda,
	            'tujuan_direksi_agenda' => $request->direktur,
	            'created_at' => \Carbon\Carbon::now(),
	            'updated_at' => \Carbon\Carbon::now()
	        ]);

	        DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
	            'status_agenda_dir' => 1,
	            'status_disposisi_dir' => 1,
	            'updated_at' => \Carbon\Carbon::now()
	        ]);

	        return Redirect::to('surat_masuk_direksi_sentral')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Sukses !</strong> Surat masuk berhasil diagenda direksi dengan Nomor : <h1><strong>".$no_agenda."</strong></h1>
	        </div>");
    	}else{
    		return Redirect::to('surat_masuk_direksi_sentral')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Gagal !</strong> Surat masuk <strong>sudah</strong> di agenda dengan nomor agenda : <h1><strong>".$cek_agenda->nomor_agenda."</strong></h1>
	        </div>");
    	}
    }
}
