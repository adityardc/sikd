<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coSm_internal extends Controller
{
    public function index()
    {
    	return view('sm_internal');
    }

    public function listSurat_internal()
    {
        $listSurat = DB::table("tbl_surat_keluar")
        				->select('id_surat_keluar','nomor_surat','tanggal_surat')
                        ->where('tipe_suratkeluar', 'I')
                        ->where('status_agenda', 'N')
                        ->orderBy('tanggal_surat', 'desc')
        				->get();
        $no = 0;
        $data = array();
        foreach ($listSurat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_surat;
            $row[] = $list->tanggal_surat;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' onclick='detail_surat(".$list->id_surat_keluar.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only purple tooltip-purple' onclick='agenda_surat(".$list->id_surat_keluar.")' data-toggle='tooltip' data-placement='top' data-original-title='Agenda Surat' href='javascript:void(0);'><i class='fa fa-pencil'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listSurat_sentral()
    {
        $listSurat = DB::table("tbl_surat_masuk")
        				->select('id_surat_masuk','nomor_agenda','nomor_surat','nama_pengirim','nama_bagian')
        				->join('tbl_bagian', 'tbl_surat_masuk.id_tujuan', '=', 'tbl_bagian.id_bagian')
                        ->where('tipe_agenda', 'I')
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
            $row[] = $list->nama_pengirim;
            $row[] = $list->nama_bagian;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' onclick='detail_surat(".$list->id_surat_masuk.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function detailSurat($id)
    {
        $detail = DB::table('tbl_surat_masuk')
                    ->join('tbl_bagian', 'tbl_surat_masuk.id_tujuan', '=', 'tbl_bagian.id_bagian')
                    ->where('id_surat_masuk', $id)->first();
        $arrTindasan = explode(',', $detail->tindasan);
        $arrTindasan = array_map('floatval', $arrTindasan);
        $tindasan = DB::table('tbl_bagian')->whereIn('id_bagian', $arrTindasan)->get();
        return view('modal_detailsuratmasuk', compact(['detail', 'tindasan']));
    }

    public function agenda_sentral($id)
    {
        $detail = DB::table('tbl_surat_keluar')
                    ->join('tbl_karyawan', 'tbl_surat_keluar.id_konseptor', '=', 'tbl_karyawan.id_karyawan')
                    ->join('users', 'tbl_surat_keluar.id_pembuat', '=', 'users.id')
                    ->where('id_surat_keluar', $id)->first();
        $arrTindasan = explode(',', $detail->tindasan);
        $arrTindasan = array_map('floatval', $arrTindasan);
        $tindasan = DB::table('tbl_bagian')->whereIn('id_bagian', $arrTindasan)->get();
        return view('modal_agendasentral', compact(['detail', 'tindasan']));
    }

    public function store(Request $request)
    {
    	$detail = DB::table('tbl_surat_keluar')
    				->select('id_surat_keluar','nomor_surat','tanggal_surat','tbl_surat_keluar.id_bagian','nama_bagian','id_tujuan','perihal','id_klasifikasi','tbl_surat_keluar.tindasan')
    				->join('tbl_bagian', 'tbl_surat_keluar.id_bagian', '=', 'tbl_bagian.id_bagian')
    				->where('id_surat_keluar', $request->id_surat_keluar)->first();
    	$thn = substr($request->tanggal_agenda, 0, 4);
    	$getNumber = DB::table('tbl_temp_surat_masuk')->where('tahun', $thn)->first();

    	if($getNumber == NULL){
            $urut = 1;
            DB::table('tbl_temp_surat_masuk')->insert([
                'tahun' => $thn,
                'nomor_urut' => $urut,
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

        DB::table('tbl_surat_masuk')->insert([
            'tipe_agenda' => "I",
            'tanggal_agenda' => $request->tanggal_agenda,
            'nomor_agenda' => $urut,
            'nomor_surat' => $detail->nomor_surat,
            'tanggal_surat' => $detail->tanggal_surat,
            'id_pengirim' => $detail->id_bagian,
            'nama_pengirim' => $detail->nama_bagian,
            'id_tujuan' => $detail->id_tujuan,
            'perihal' => $detail->perihal,
            'id_klasifikasi' => $detail->id_klasifikasi,
            'tindasan' => $detail->tindasan,
            'id_surat_keluar' => $detail->id_surat_keluar,
            'status_agenda_dir' => "N",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('tbl_surat_keluar')->where('id_surat_keluar', $detail->id_surat_keluar)->update([
            'status_agenda' => "Y",
            'updated_at' => \Carbon\Carbon::now()
        ]);

    	return response()->json(['status'=>'1', 'nomor'=>$urut]);
    }
}
