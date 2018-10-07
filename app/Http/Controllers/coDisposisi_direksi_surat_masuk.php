<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coDisposisi_direksi_surat_masuk extends Controller
{
    public function index()
    {
    	$url = url('disposisi_direksi_surat_masuk/store');
    	return view('mod_disposisi_direksi_surat_masuk/index_disposisi_direksi_surat_masuk', compact(['url','']));
    }

    public function listData()
    {
        $agenda = DB::table("tbl_agenda_direksi")->orderBy('id_agenda_direksi')->get();
        $no = 0;
        $data = array();
        foreach ($agenda as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_agenda;
            $row[] = $list->tanggal_agenda;
            $row[] = $list->uraian_disposisi;
            $row[] = (($list->file_disposisi != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah upload'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum upload'><i class='menu-icon fa fa-close'></i></span> ");
            $row[] = "<a href='disposisi_direksi_surat_masuk/".$list->id_agenda_direksi."/edit' class='btn btn-default btn-xs shiny icon-only purple tooltip-purple' data-toggle='tooltip' data-placement='top' data-original-title='Tambah Disposisi'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function edit($id)
    {
        $dataSurat = DB::table('tbl_agenda_direksi')->where('id_agenda_direksi', $id)->first();
        $url = url('disposisi_direksi_surat_masuk/'.$dataSurat->id_agenda_direksi.'/update');
        $dir = DB::table('tbl_bagian')->where('grup_bagian', 0)->where('status_bagian', 'Y')->orderBy('id_bagian')->get();
        $bag = DB::table('tbl_bagian')->where('grup_bagian', 1)->where('status_bagian', 'Y')->orderBy('id_bagian')->get();
        $dispo = DB::table('tbl_jenis_disposisi_direksi')->where('status_aktif', 'Y')->orderBy('id_disposisi_direksi')->get();

        if($dataSurat->tipe_surat == "EKS"){
            $detail_surat = DB::table('tbl_agenda_direksi')
                                ->select('tbl_surat_masuk.nomor_surat','tbl_surat_masuk.perihal_surat','tbl_agenda_direksi.*')
                                ->join('tbl_surat_masuk','tbl_agenda_direksi.id_surat','=','tbl_surat_masuk.id_surat_masuk')
                                ->where('tbl_surat_masuk.id_surat_masuk', $dataSurat->id_surat)
                                ->where('tbl_agenda_direksi.tipe_surat', 'EKS')
                                ->where('tbl_agenda_direksi.id_agenda_direksi', $id)->first();
            $selected_disposisi = explode(",", $detail_surat->disposisi_direksi);
            $selected_tujuan = explode(",", $detail_surat->tujuan_bagian_agenda);
        }else{
            $detail_surat = DB::table('tbl_agenda_direksi')
                                ->select('tbl_surat_keluar.nomor_surat','tbl_surat_keluar.perihal_surat','tbl_agenda_direksi.*')
                                ->join('tbl_surat_keluar','tbl_agenda_direksi.id_surat','=','tbl_surat_keluar.id_surat_keluar')
                                ->where('tbl_surat_keluar.id_surat_keluar', $dataSurat->id_surat)
                                ->where('tbl_agenda_direksi.tipe_surat', 'INT')
                                ->where('tbl_agenda_direksi.id_agenda_direksi', $id)->first();
            $selected_disposisi = explode(",", $detail_surat->disposisi_direksi);
            $selected_tujuan = explode(",", $detail_surat->tujuan_bagian_agenda);
        }

        return view('mod_disposisi_direksi_surat_masuk/tambah_disposisi_direksi_surat_masuk', compact(['url','dir','bag','dispo','detail_surat','selected_tujuan','selected_disposisi']));
    }

    public function update(Request $request, $id)
    {
        if(empty($request->tujuan_bagian_agenda)){
            $arrTujuan = "";
        }else{
            $arrTujuan = implode(',', $request->tujuan_bagian_agenda);
        }

        if(empty($request->disposisi_direksi)){
            $arrDisposisi = "";
        }else{
            $arrDisposisi = implode(',', $request->disposisi_direksi);
        }

        if(!empty($request->file_suratkeluar)){
            $dataFile = DB::table('tbl_agenda_direksi')->select('file_disposisi')->where('id_agenda_direksi', $id)->first();
            if($dataFile->file_disposisi == NULL){
                $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
                $fullName = time().'.'.$extensionfile;
                Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
                $url = Storage::url($fullName);
            }else{
                $nama_file = substr($dataFile->file_disposisi, 9);
                $public_path = public_path().$dataFile->file_disposisi;
                File::delete($public_path);
                $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
                $fullName = time().'.'.$extensionfile;
                Storage::disk('public')->put($fullName, File::get($request->file_suratkeluar));
                $url = Storage::url($fullName);
            }
        }else{
            $url = NULL;
        }

        DB::table('tbl_agenda_direksi')->where('id_agenda_direksi', $id)->update([
            'tujuan_bagian_agenda' => $arrTujuan,
            'disposisi_direksi' => $arrDisposisi,
            'uraian_disposisi' => $request->uraian_disposisi,
            'tanggal_distribusi_disposisi' => $request->tanggal_distribusi_disposisi,
            'file_disposisi' => $url,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('disposisi_direksi_surat_masuk')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Agenda Direksi nomor <strong>".$request->nomor_agenda."</strong> berhasil ditambahkan disposisi.
        </div>");
    }
}
