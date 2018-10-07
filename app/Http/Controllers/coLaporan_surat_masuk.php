<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;

class coLaporan_surat_masuk extends Controller
{
    public function index()
    {
    	return view('mod_laporan_surat_masuk/index_laporan_surat_masuk');
    }

    public function listData(Request $request)
    {
    	if($request->key == 1){ // INTERNAL
    		$dataSurat = DB::table("tbl_surat_keluar")
    						->where('tipe_surat', 1)
    						->where('sifat_surat', 1)
    						->whereRaw("((',' || RTRIM(tujuan_surat) || ',') LIKE '%,".Auth::user()->id_bagian.",%'
                                        OR (',' || RTRIM(tindasan_surat) || ',') LIKE '%,".Auth::user()->id_bagian.",%')
                                AND extract(year from tanggal_surat) = ".$request->tahun)
	                        ->orderBy('created_at', 'DESC')->get();

	        $no = 0;
	        $data = array();
	        foreach ($dataSurat as $list) {
	            $baris = array();
	        	$arrTujuan = explode(',', $list->tujuan_surat);
	            $arrTujuan = array_map('floatval', $arrTujuan);
	            $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

	            foreach($tujuan as $bag => $x) {
	                $y = $bag+1;
	                $baris[] = $x->nama_bagian;
	            }

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = "<a href='laporan_surat_masuk/".$list->id_surat_keluar."/detail' target='_blank' class='btn btn-default btn-xs shiny icon-only azure tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Detail Data'><i class='fa fa-search-plus'></i></a>";
	            $row[] = $list->nomor_surat;
	            $row[] = date('d M Y', strtotime($list->tanggal_surat));
	            $row[] = (($list->tipe_surat == 1 || $list->tipe_surat == 4) ? $baris : $list->tujuan_surat);
	            $row[] = $list->perihal_surat;
	            $data[] = $row;
	        }
    	}elseif($request->key == 2){ // EKSTERNAL
    		$dataSurat = DB::table("tbl_surat_masuk")
    						->whereRaw("((',' || RTRIM(tujuan_surat) || ',') LIKE '%,".Auth::user()->id_bagian.",%')
                                AND extract(year from tanggal_surat) = ".$request->tahun)
	                        ->orderBy('created_at', 'DESC')->get();

	        $no = 0;
	        $data = array();
	        foreach ($dataSurat as $list) {
	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = "<a href='laporan_surat_masuk/".$list->id_surat_masuk."/detail' target='_blank' class='btn btn-default btn-xs shiny icon-only azure tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Detail Data'><i class='fa fa-search-plus'></i></a>";
	            $row[] = $list->nomor_surat;
	            $row[] = date('d M Y', strtotime($list->tanggal_surat));
	            $row[] = $list->tujuan_surat;
	            $row[] = $list->perihal_surat;
	            $data[] = $row;
	        }
    	}elseif($request->key == 3){ // TINDASAN
            $dataSurat = DB::table("tbl_surat_keluar")
                            ->where('sifat_surat', 1)
                            ->whereRaw("((',' || RTRIM(tindasan_surat) || ',') LIKE '%,".Auth::user()->id_bagian.",%')
                                AND extract(year from tanggal_surat) = ".$request->tahun)
                            ->orderBy('created_at', 'DESC')->get();

            $no = 0;
            $data = array();
            foreach ($dataSurat as $list) {
                $baris = array();
                $arrTujuan = explode(',', $list->tujuan_surat);
                $arrTujuan = array_map('floatval', $arrTujuan);
                $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

                foreach($tujuan as $bag => $x) {
                    $y = $bag+1;
                    $baris[] = $x->nama_bagian;
                }

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = "<a href='laporan_surat_masuk/".$list->id_surat_keluar."/detail' target='_blank' class='btn btn-default btn-xs shiny icon-only azure tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Detail Data'><i class='fa fa-search-plus'></i></a>";
                $row[] = $list->nomor_surat;
                $row[] = date('d M Y', strtotime($list->tanggal_surat));
                $row[] = (($list->tipe_surat == 1 || $list->tipe_surat == 4) ? $baris : $list->tujuan_surat);
                $row[] = $list->perihal_surat;
                $data[] = $row;
            }
        }else{ // DISPOSISI DIREKSI
            if($request->asal == "1"){ // INTERNAL
                $dataSurat = DB::table("tbl_surat_keluar")
                            ->select('tbl_surat_keluar.*','tbl_agenda_direksi.tujuan_bagian_agenda')
                            ->join('tbl_agenda_direksi','tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_direksi.id_surat')
                            ->where('tbl_surat_keluar.sifat_surat', 1)
                            ->where('tbl_agenda_direksi.tipe_surat', 'INT')
                            ->whereRaw("((',' || RTRIM(tbl_agenda_direksi.tujuan_bagian_agenda) || ',') LIKE '%,".Auth::user()->id_bagian.",%')
                                AND extract(year from tanggal_surat) = ".$request->tahun)
                            ->orderBy('tbl_surat_keluar.created_at', 'DESC')->get();

                $no = 0;
                $data = array();
                foreach ($dataSurat as $list) {
                    $baris = array();
                    $arrTujuan = explode(',', $list->tujuan_surat);
                    $arrTujuan = array_map('floatval', $arrTujuan);
                    $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

                    foreach($tujuan as $bag => $x) {
                        $y = $bag+1;
                        $baris[] = $x->nama_bagian;
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = "<a href='laporan_surat_masuk/".$list->id_surat_keluar."/detail' target='_blank' class='btn btn-default btn-xs shiny icon-only azure tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Detail Data'><i class='fa fa-search-plus'></i></a>";
                    $row[] = $list->nomor_surat;
                    $row[] = date('d M Y', strtotime($list->tanggal_surat));
                    $row[] = (($list->tipe_surat == 1 || $list->tipe_surat == 4) ? $baris : $list->tujuan_surat);
                    $row[] = $list->perihal_surat;
                    $data[] = $row;
                }
            }else{ // EKSTERNAL
                $dataSurat = DB::table("tbl_surat_masuk")
                            ->select('tbl_surat_masuk.*','tbl_agenda_direksi.tujuan_bagian_agenda')
                            ->join('tbl_agenda_direksi','tbl_surat_masuk.id_surat_masuk','=','tbl_agenda_direksi.id_surat')
                            ->where('tbl_agenda_direksi.tipe_surat', 'EKS')
                            ->whereRaw("((',' || RTRIM(tbl_agenda_direksi.tujuan_bagian_agenda) || ',') LIKE '%,".Auth::user()->id_bagian.",%')
                                AND extract(year from tanggal_surat) = ".$request->tahun)
                            ->orderBy('tbl_surat_masuk.created_at', 'DESC')->get();

                $no = 0;
                $data = array();
                foreach ($dataSurat as $list) {
                    $baris = array();
                    $arrTujuan = explode(',', $list->tujuan_surat);
                    $arrTujuan = array_map('floatval', $arrTujuan);
                    $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

                    foreach($tujuan as $bag => $x) {
                        $y = $bag+1;
                        $baris[] = $x->nama_bagian;
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = "<a href='laporan_surat_masuk/".$list->id_surat_masuk."/detail_eksternal' target='_blank' class='btn btn-default btn-xs shiny icon-only azure tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Detail Data'><i class='fa fa-search-plus'></i></a>";
                    $row[] = $list->nomor_surat;
                    $row[] = date('d M Y', strtotime($list->tanggal_surat));
                    $row[] = $baris;
                    $row[] = $list->perihal_surat;
                    $data[] = $row;
                }
            }
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function detail($id)
    {
        $data = DB::table('tbl_surat_keluar')
                ->select('tbl_surat_keluar.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas','tbl_karyawan.nama_karyawan','users.name')
                ->join('tbl_klasifikasi','tbl_surat_keluar.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                ->join('tbl_karyawan','tbl_surat_keluar.id_konseptor','=','tbl_karyawan.id_karyawan')
                ->join('users','tbl_surat_keluar.id_pembuat','=','users.id')
                ->where('id_surat_keluar', $id)->first();
        $dispo_dir = DB::table('tbl_agenda_direksi')->where('id_surat', $id)->get();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $dir = DB::table('tbl_bagian')->where('grup_bagian', 0)->where('status_bagian', "Y")->orderBy('id_bagian')->get();
        $bag = DB::table('tbl_bagian')->where('grup_bagian', 1)->where('status_bagian', "Y")->orderBy('id_bagian')->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();

        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        $data_dispo = array();
        $no = 0;

        if($data->status_agenda_sentral != NULL && $data->status_agenda_dir != NULL){
            $data_sentral = DB::table('tbl_agenda_sentral')
                            ->select('tbl_agenda_sentral.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_sentral.id_bagian','tbl_bagian.id_bagian')
                            ->where('id_surat_keluar', $id)->get();

            $data_dir = DB::table('tbl_agenda_direksi')
                            ->select('tbl_agenda_direksi.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_direksi.tujuan_direksi_agenda','=','tbl_bagian.id_bagian')
                            ->where('tipe_surat', "INT")->where('id_surat', $id)->get();

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

            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk', compact(['data','all','tujuan','tindasan','dir','bag','sifat','data_sentral','data_dispo']));
        }elseif($data->status_agenda_sentral != NULL && $data->status_agenda_dir == NULL){
            $data_sentral = DB::table('tbl_agenda_sentral')
                            ->select('tbl_agenda_sentral.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_sentral.id_bagian','tbl_bagian.id_bagian')
                            ->where('id_surat_keluar', $id)->get();

            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk', compact(['data','all','tujuan','tindasan','dir','bag','sifat','data_sentral']));
        }elseif($data->status_agenda_sentral == NULL && $data->status_agenda_dir != NULL){
            $data_dir = DB::table('tbl_agenda_direksi')
                            ->select('tbl_agenda_direksi.*','tbl_bagian.nama_bagian')
                            ->join('tbl_bagian','tbl_agenda_direksi.tujuan_direksi_agenda','=','tbl_bagian.id_bagian')
                            ->where('tipe_surat', "INT")->where('id_surat', $id)->get();

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

            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk', compact(['data','all','tujuan','tindasan','dir','bag','sifat','data_dispo']));
        }else{
            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk', compact(['data','all','tujuan','tindasan','dir','bag','sifat']));
        }
    }

    public function detail_eksternal($id)
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

            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk_eksternal', compact(['data','all','tujuan','tindasan','dir','bag','sifat','data_dispo']));
        }else{
            return view('mod_laporan_surat_masuk/detail_laporan_surat_masuk_eksternal', compact(['data','all','tujuan','tindasan']));
        }
    }
}
 