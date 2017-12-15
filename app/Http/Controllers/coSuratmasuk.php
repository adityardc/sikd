<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coSuratmasuk extends Controller
{
    public function index()
    {
    	$direktur = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 0)->orderBy('id_bagian')->get();
        $bagian = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 1)->orderBy('id_bagian')->get();
        $unitkerja = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 2)->orderBy('id_bagian')->get();
    	return view('surat_masuk', compact(['direktur','bagian','unitkerja']));
    }

    public function listSurat()
    {
        $listSurat = DB::table("tbl_surat_masuk")
        				->select('id_surat_masuk','nomor_agenda','nomor_surat','nama_pengirim','nama_bagian')
        				->join('tbl_bagian', 'tbl_surat_masuk.id_tujuan', '=', 'tbl_bagian.id_bagian')
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
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_surat_masuk.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' onclick='detail_surat(".$list->id_surat_masuk.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only purple tooltip-purple' onclick='unggah_surat(".$list->id_surat_masuk.")' data-toggle='tooltip' data-placement='top' data-original-title='Unggah Data' href='javascript:void(0);'><i class='fa fa-upload'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listKlasifikasi()
    {
    	$klas = DB::table("tbl_child_klasifikasi")->select('id_trans','sd1','sd3')->get();
        $no = 0;
        $data = array();
        foreach ($klas as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->id_trans;
            $row[] = $list->sd1;
            $row[] = $list->sd3;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listTujuan()
    {
        $bagian = DB::table("tbl_bagian")->select('id_bagian','nama_bagian','kode_bagian')->get();
        $no = 0;
        $data = array();
        foreach ($bagian as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->id_bagian;
            $row[] = $list->nama_bagian;
            $row[] = $list->kode_bagian;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listPengirim()
    {
        $bagian = DB::table("tbl_bagian")->select('id_bagian','nama_bagian','kode_bagian')->get();
        $no = 0;
        $data = array();
        foreach ($bagian as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->id_bagian;
            $row[] = $list->nama_bagian;
            $row[] = $list->kode_bagian;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $thn = substr($request->tanggal_agenda, 0, 4);
        $getNumber = DB::table('tbl_surat_masuk')->orderBy('nomor_agenda', 'desc')->first();

        if(empty($request->tindasan)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan);
        }

        if($getNumber == NULL){
            $urut = 1;
        }else{
            $urut = $getNumber->nomor_agenda;
            $urut += 1;
        }

        DB::table('tbl_surat_masuk')->insert([
            'tipe_agenda' => $request->tipe_agenda,
            'tanggal_agenda' => $request->tanggal_agenda,
            'nomor_agenda' => $urut,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'id_pengirim' => $request->id_pengirim,
            'nama_pengirim' => $request->nama_pengirim,
            'id_tujuan' => $request->id_tujuan,
            'perihal' => $request->perihal,
            'id_klasifikasi' => $request->id_klasifikasi,
            'tindasan' => $arrTindasan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return response()->json(['status'=>'1', 'nomor'=>$urut]);
    }

    public function detailSurat($id)
    {
        $detail = DB::table('tbl_surat_masuk')
                    ->select('nomor_agenda','tanggal_agenda','nomor_surat','nama_pengirim','nama_bagian','perihal','tbl_surat_masuk.tindasan')
                    ->join('tbl_bagian', 'tbl_surat_masuk.id_tujuan', '=', 'tbl_bagian.id_bagian')
                    ->where('id_surat_masuk', $id)->first();
        $arrTindasan = explode(',', $detail->tindasan);
        $arrTindasan = array_map('floatval', $arrTindasan);
        $tindasan = DB::table('tbl_bagian')->whereIn('id_bagian', $arrTindasan)->get();
        return view('modal_detailsuratmasuk', compact(['detail','tindasan']));
    }

    public function unggah_surat($id)
    {
        $detail = DB::table('tbl_surat_masuk')->select('id_surat_masuk','nomor_agenda')->where('id_surat_masuk', $id)->first();
        $idSurat = $detail->id_surat_masuk;
        $noAgenda = $detail->nomor_agenda;
        return view('modal_unggahsuratmasuk', compact(['idSurat','noAgenda']));
    }

    public function edit($id)
    {
        $surat = DB::table('tbl_surat_masuk')
                ->select('id_surat_masuk', 'tipe_agenda', 'tanggal_agenda','nomor_surat', 'tanggal_surat','id_pengirim','id_klasifikasi','nama_pengirim','id_tujuan','perihal','sd1','sd3','aa.nama_bagian as pengirim','bb.nama_bagian as tujuan')
                ->join('tbl_child_klasifikasi', 'tbl_child_klasifikasi.id_trans', '=', 'tbl_surat_masuk.id_klasifikasi')
                ->join('tbl_bagian as aa', 'aa.id_bagian', '=', 'tbl_surat_masuk.id_pengirim')
                ->join('tbl_bagian as bb', 'bb.id_bagian', '=', 'tbl_surat_masuk.id_tujuan')
                ->where('id_surat_masuk', $id)->first();
        echo json_encode($surat);
    }

    public function update(Request $request, $id)
    {
        if(empty($request->tindasan)){
            DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
                'nomor_surat' => $request->nomor_surat,
                'id_klasifikasi' => $request->id_klasifikasi,
                'tanggal_surat' => $request->tanggal_surat,
                'id_pengirim' => $request->id_pengirim,
                'nama_pengirim' => $request->nama_pengirim,
                'id_tujuan' => $request->id_tujuan,
                'perihal' => $request->perihal,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $arrTindasan = implode(',', $request->tindasan);
            DB::table('tbl_surat_masuk')->where('id_surat_masuk', $id)->update([
                'nomor_surat' => $request->nomor_surat,
                'id_klasifikasi' => $request->id_klasifikasi,
                'tanggal_surat' => $request->tanggal_surat,
                'id_pengirim' => $request->id_pengirim,
                'nama_pengirim' => $request->nama_pengirim,
                'id_tujuan' => $request->id_tujuan,
                'perihal' => $request->perihal,
                'tindasan' => $arrTindasan,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        return response()->json(['status'=>'2']);
    }
}
