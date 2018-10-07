<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Auth;

class coSurat_masuk_direksi_langsung extends Controller
{
    public function index()
    {
    	$direksi = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	return view('mod_surat_masuk_direksi_langsung/index_surat_masuk_direksi_langsung', compact(['direksi']));
    }

    public function listData(Request $request)
    {
    	$tes = $request->id_direktur;
    	$list_bag = DB::table('tbl_bagian')->select('id_bagian')->where('grup_bagian',1)->get();
        $arr = collect($list_bag)->map(function($x){return (array) $x;})->toArray();
    	$dataSurat = DB::table('tbl_surat_keluar')
    						->select('tbl_surat_keluar.*','tbl_agenda_direksi.id_agenda_direksi')
							->leftjoin('tbl_agenda_direksi', function($join) use ($tes){
                                $join->on('tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_direksi.id_surat')
                                     ->where('tbl_agenda_direksi.tujuan_direksi_agenda', $tes)
                                     ->where('tbl_agenda_direksi.tipe_surat', 'INT');
                          	})
                          	->whereIn('id_bagian', $arr)
							->whereRaw("((',' || RTRIM(tujuan_surat) || ',') LIKE '%,".$request->id_direktur.",%'
                                OR (',' || RTRIM(tindasan_surat) || ',') LIKE '%,".$request->id_direktur.",%')
                                AND (tbl_surat_keluar.tipe_surat = 1 OR tbl_surat_keluar.tipe_surat = 2 OR tbl_surat_keluar.tipe_surat = 3) AND extract(year from tanggal_surat) = ".$request->tahun)
							->orderBy('created_at', 'DESC')->get();

		$no = 0;
        $data = array();
        foreach ($dataSurat as $list) {
        	$baris = array();
        	$arrTujuan = explode(',', $list->tujuan_surat);
            $arrTujuan = array_map('floatval', $arrTujuan);
            if($list->tipe_surat != 3){
                $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();
                foreach($tujuan as $bag => $x) {
                    $y = $bag+1;
                    $baris[] = $x->nama_bagian;
                }
            }else{
                $tujuan = DB::table('tbl_karyawan')->select('nama_karyawan')->whereIn('id_karyawan', $arrTujuan)->get();
                foreach($tujuan as $bag => $x) {
                    $y = $bag+1;
                    $baris[] = $x->nama_karyawan;
                }
            }

            $no++;
            $row = array();

            $row[] = $no;
            $row[] = (($list->id_agenda_direksi != NULL) ? "-" : "<a href='surat_masuk_direksi_langsung/".$list->id_surat_keluar."/create' class='btn btn-default btn-xs shiny icon-only darkorange tooltip-darkorange' data-toggle='tooltip' data-placement='top' data-original-title='Agenda Surat'><i class='fa fa-pencil'></i></a>");
            $row[] = $list->nomor_surat;
            $row[] = date('d M Y', strtotime($list->tanggal_surat));
            $row[] = (($baris == NULL) ? $list->tujuan_surat : $baris);
            $row[] = $list->perihal_surat;
            $row[] = (($list->id_agenda_direksi != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda'><i class='menu-icon fa fa-close'></i></span> ");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create($id)
    {
    	$all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $kry = DB::table('tbl_karyawan')->where('status_karyawan', 1)->get();
    	$direksi = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	$jns_surat = DB::table('tbl_jenis_surat')->where('status_jenis', "Y")->orderBy('id_jenis_surat')->get();
    	$data = DB::table('tbl_surat_keluar')
                ->select('tbl_surat_keluar.*','tbl_bagian.nama_bagian')
                ->join('tbl_bagian','tbl_surat_keluar.id_bagian','=','tbl_bagian.id_bagian')
                ->where('tbl_surat_keluar.id_surat_keluar', $id)->first();
        $url = url('surat_masuk_direksi_langsung/'.$id.'/update');
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        return view('mod_surat_masuk_direksi_langsung/tambah_surat_masuk_direksi_langsung', compact(['all','url','direksi','jns_surat','data','tindasan','tujuan','kry']));
    }

    public function update(Request $request, $id)
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

	        return Redirect::to('surat_masuk_direksi_langsung')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Sukses !</strong> Surat masuk berhasil diagenda direksi dengan Nomor : <h1><strong>".$no_agenda."</strong></h1>
	        </div>");
    	}else{
    		return Redirect::to('surat_masuk_direksi_langsung')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	            <strong>Gagal !</strong> Surat masuk <strong>sudah</strong> di agenda dengan nomor agenda : <h1><strong>".$cek_agenda->nomor_agenda."</strong></h1>
	        </div>");
    	}
    }
}
