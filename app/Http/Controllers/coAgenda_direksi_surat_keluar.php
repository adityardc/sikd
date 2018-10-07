<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coAgenda_direksi_surat_keluar extends Controller
{
    public function index()
    {
    	return view('mod_agenda_direksi_surat_keluar/index_agenda_direksi_surat_keluar');
    }

    public function listData()
    {
        $surat = DB::table('tbl_surat_keluar')
        			->where('tbl_surat_keluar.tipe_surat', 4)
        			->orWhere('tbl_surat_keluar.tipe_surat', 5)
        			->orderBy('id_surat_keluar', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($surat as $list) {
        	if($list->tipe_surat == 4){
        		$baris = array();
	        	$arrTujuan = explode(',', $list->tujuan_surat);
	            $arrTujuan = array_map('floatval', $arrTujuan);
	            $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

	            foreach($tujuan as $bag => $x) {
	                $y = $bag+1;
	                $baris[] = $x->nama_bagian;
	            }
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_surat;
            $row[] = date('d M Y', strtotime($list->tanggal_surat));
            $row[] = (($list->tipe_surat == 4) ? $baris : $list->tujuan_surat);
            $row[] = $list->perihal_surat;
            $row[] = (($list->tanggal_distribusi != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = "<a href='agenda_direksi_surat_keluar/".$list->id_surat_keluar."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Tambah Agenda'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function edit($id)
    {
        $detail_surat = DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $tindasan = explode(",", $detail_surat->tindasan_surat);
        $tujuan = explode(",", $detail_surat->tujuan_surat);
        $url = url('agenda_direksi_surat_keluar/'.$id.'/update');
        return view('mod_agenda_direksi_surat_keluar/ubah_agenda_direksi_surat_keluar', compact(['detail_surat','all','tindasan','tujuan','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
        	'tanggal_distribusi' => $request->tanggal_distribusi,
        	'keterangan_distribusi' => $request->keterangan_distribusi,
            'status_agenda_dir' => 1,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('agenda_direksi_surat_keluar')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Agenda Surat Keluar Direksi berhasil disimpan.
        </div>");
    }
}