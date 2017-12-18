<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coAgenda_langsung extends Controller
{
    public function index()
    {
    	$agenda = DB::table('tbl_jenis_surat')->get();
    	$tujuan = DB::table('tbl_bagian')->where('grup_bagian', 0)->orderBy('id_bagian')->get();
    	$sifat = DB::table('tbl_sifat_surat')->get();
    	return view('agenda_langsung', compact(['agenda','tujuan','sifat']));
    }

    public function listAgenda()
    {
    	$agenda = DB::table("tbl_agenda_langsung")
                    ->join('tbl_bagian', 'tbl_agenda_langsung.id_tujuan', '=', 'tbl_bagian.id_bagian')
                    ->get();
        $no = 0;
        $data = array();
        foreach ($agenda as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_agenda;
            $row[] = $list->nama_bagian;
            $row[] = $list->pengirim;
            $row[] = $list->perihal;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_agenda_dir.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' onclick='detail_surat(".$list->id_agenda_dir.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only purple tooltip-purple' onclick='unggah_surat(".$list->id_agenda_dir.")' data-toggle='tooltip' data-placement='top' data-original-title='Unggah Data' href='javascript:void(0);'><i class='fa fa-upload'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $nomor = DB::table('tbl_temp_agenda_langsung')->where('id_direksi', $request->tujuan)->where('id_jenis_surat', $request->tipe_agenda)->first();
        if($nomor == NULL){
            $urut = 1;
            DB::table('tbl_temp_agenda_langsung')->insert([
                'id_direksi' => $request->tujuan,
                'id_jenis_surat' => $request->tipe_agenda,
                'nomor_urut' => $urut,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $urut = $nomor->nomor_urut;
            $urut += 1;
            DB::table('tbl_temp_agenda_langsung')->where('id_temp_agenda', $nomor->id_temp_agenda)->update([
                'nomor_urut' => $urut,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $kodeBagian = DB::table('tbl_bagian')->select('kode_bagian')->where('id_bagian', $request->tujuan)->first();
        $kodeJenis = DB::table('tbl_jenis_surat')->select('kode_jenis')->where('id_jenis_surat', $request->tipe_agenda)->first();
        $no_agenda = $kodeBagian->kode_bagian."/".$urut."/".$kodeJenis->kode_jenis;

        DB::table('tbl_agenda_langsung')->insert([
            'id_jenis_surat' => $request->tipe_agenda,
            'id_tujuan' => $request->tujuan,
            'tanggal_agenda' => $request->tanggal_agenda,
            'nomor_agenda' => $no_agenda,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'id_jenis_surat' => $request->tipe_agenda,
            'pengirim' => $request->pengirim,
            'sifat_surat' => $request->sifat_surat,
            'perihal' => $request->perihal,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return response()->json(['status'=>'1','nomor'=>$no_agenda]);
    }

    public function edit($id)
    {
        $agenda = DB::table('tbl_agenda_langsung')->where('id_agenda_dir', $id)->first();
        echo json_encode($agenda);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_agenda_langsung')->where('id_agenda_dir', $id)->update([
            'tanggal_agenda' => $request->tanggal_agenda,
            'sifat_surat' => $request->sifat_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'nomor_surat' => $request->nomor_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function unggah_disposisi($id)
    {
        $detail = DB::table('tbl_agenda_langsung')->select('id_agenda_dir','nomor_agenda','nomor_surat')->where('id_agenda_dir', $id)->first();
        $idAgenda = $detail->id_agenda_dir;
        $noAgenda = $detail->nomor_agenda;
        $noSurat = $detail->nomor_surat;
        return view('modal_unggahdisposisi', compact(['idAgenda','noAgenda','noSurat']));
    }

    public function detailAgenda($id)
    {
        $detail = DB::table('tbl_agenda_langsung')
                    ->select('nomor_agenda','tanggal_agenda','nomor_surat','pengirim','nama_bagian','perihal')
                    ->join('tbl_bagian', 'tbl_agenda_langsung.id_tujuan', '=', 'tbl_bagian.id_bagian')
                    ->where('id_agenda_dir', $id)->first();
        return view('modal_detailagenda', compact(['detail']));
    }
}
