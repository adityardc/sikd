<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coAgenda_direksi extends Controller
{
    public function index()
    {
    	$agenda = DB::table('tbl_jenis_surat')->get();
    	$tujuan = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	$sifat = DB::table('tbl_sifat_surat')->get();
    	$jenis = DB::table('tbl_jenis_surat')->get();
    	return view('agenda_direksi', compact(['agenda','tujuan','sifat','jenis']));
    }

    public function listSentral()
    {
        $listSurat = DB::table("tbl_surat_masuk")
        				->select('id_surat_masuk','nomor_agenda','nomor_surat','tanggal_surat')
                        ->where('status_agenda_dir', 'N')
                        ->whereIn('id_tujuan', [16,18,19])
                        ->orderBy('nomor_agenda', 'desc')
        				->get();
        $no = 0;
        $data = array();
        foreach ($listSurat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_agenda;
            $row[] = $list->nomor_surat;
            $row[] = $list->tanggal_surat;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listAgenda()
    {
        $listSurat = DB::table("tbl_agenda_direksi")
        				->select('tbl_agenda_direksi.id_agenda_direksi','tbl_agenda_direksi.nomor_agenda','tbl_agenda_direksi.tanggal_agenda','tbl_surat_masuk.nomor_surat','tbl_bagian.nama_bagian')
        				->join('tbl_surat_masuk', 'tbl_agenda_direksi.id_surat_masuk', '=', 'tbl_surat_masuk.id_surat_masuk')
        				->join('tbl_bagian', 'tbl_agenda_direksi.id_tujuan', '=', 'tbl_bagian.id_bagian')
                        ->orderBy('tanggal_agenda', 'desc')
        				->get();
        $no = 0;
        $data = array();
        foreach ($listSurat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_agenda;
            $row[] = $list->tanggal_agenda;
            $row[] = $list->nomor_surat;
            $row[] = $list->nama_bagian;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only azure tooltip-warning' onclick='detail_surat(".$list->id_agenda_direksi.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function agenda_direksi($id)
    {
        $detail = DB::table('tbl_surat_masuk')
        			->select('id_surat_masuk', 'tanggal_agenda', 'nomor_agenda', 'nomor_surat', 'nama_pengirim', 'nama_bagian', 'perihal', 'tbl_surat_masuk.tindasan')
        			->join('tbl_bagian', 'tbl_surat_masuk.id_tujuan', '=', 'tbl_bagian.id_bagian')
                    ->where('id_surat_masuk', $id)->first();
        $arrTindasan = explode(',', $detail->tindasan);
        $arrTindasan = array_map('floatval', $arrTindasan);
        $tindasan = DB::table('tbl_bagian')->whereIn('id_bagian', $arrTindasan)->get();
        return view('modal_agendadireksi', compact(['detail', 'tindasan']));
    }

    public function store(Request $request)
    {
    	$thn = substr($request->tanggal_agenda, 0, 4);
    	$nomor = DB::table('tbl_temp_agenda_direksi')
    				->where('id_direksi', $request->id_tujuan)
    				->where('id_jenis_surat', $request->id_jenis_surat)
    				->where('tahun', $thn)
    				->first();

    	if($nomor == NULL){
            $urut = 1;
            DB::table('tbl_temp_agenda_direksi')->insert([
                'id_direksi' => $request->id_tujuan,
                'id_jenis_surat' => $request->id_jenis_surat,
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

        $kodeBagian = DB::table('tbl_bagian')->select('kode_bagian')->where('id_bagian', $request->id_tujuan)->first();
        $kodeJenis = DB::table('tbl_jenis_surat')->select('kode_jenis')->where('id_jenis_surat', $request->id_jenis_surat)->first();
        $no_agenda = $kodeBagian->kode_bagian."/".$urut."/".$kodeJenis->kode_jenis;

        DB::table('tbl_agenda_direksi')->insert([
            'id_jenis_surat' => $request->id_jenis_surat,
            'id_tujuan' => $request->id_tujuan,
            'tanggal_agenda' => $request->tanggal_agenda,
            'id_surat_masuk' => $request->id_surat_masuk,
            'nomor_agenda' => $no_agenda,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('tbl_surat_masuk')->where('id_surat_masuk', $request->id_surat_masuk)->update([
            'status_agenda_dir' => "Y",
            'updated_at' => \Carbon\Carbon::now()
        ]);

    	return response()->json(['status'=>'1', 'nomor'=> $no_agenda]);
    }
}
