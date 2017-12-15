<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;

class coSuratkeluar extends Controller
{
    public function index()
    {
    	$direktur = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 0)->orderBy('id_bagian')->get();
        $bagian = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 1)->orderBy('id_bagian')->get();
        $unitkerja = DB::table('tbl_bagian')->where('tindasan', 1)->where('grup_bagian', 2)->orderBy('id_bagian')->get();
        $idBagian = DB::table('tbl_bagian')->where('id_bagian', Auth::user()->id_bagian)->first();
        $sifat = DB::table('tbl_sifat_surat')->get();
        $kdBagian = $idBagian->kode_bagian;
    	return view('surat_keluar', compact(['direktur','bagian','kdBagian','unitkerja','sifat']));
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

    public function listBagian()
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

    public function listKonseptor()
    {
        $konseptor = DB::table("tbl_karyawan")->select('id_karyawan','nama_karyawan')->where('id_bagian', Auth::user()->id_bagian)->where('status_konseptor', 1)->get();
        $no = 0;
        $data = array();
        foreach ($konseptor as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->id_karyawan;
            $row[] = $list->nama_karyawan;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listSurat()
    {
        $listSurat = DB::table("tbl_surat_keluar")->where('id_bagian', Auth::user()->id_bagian)->get();
        $no = 0;
        $data = array();
        foreach ($listSurat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nomor_surat;
            $row[] = $list->nama_tujuan;
            $row[] = $list->perihal;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_surat_keluar.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only warning tooltip-warning' onclick='detail_surat(".$list->id_surat_keluar.")' data-toggle='tooltip' data-placement='top' data-original-title='Lihat Data' href='javascript:void(0);'><i class='fa fa-eye'></i></button>
                      <button type='button' class='btn btn-default btn-xs shiny icon-only purple tooltip-purple' onclick='unggah_surat(".$list->id_surat_keluar.")' data-toggle='tooltip' data-placement='top' data-original-title='Unggah Data' href='javascript:void(0);'><i class='fa fa-upload'></i></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $thn = substr($request->tanggal_surat, 0, 4);
        $getNumber = DB::table('tbl_surat_keluar')
                        ->whereRaw('EXTRACT(YEAR from tanggal_surat) = '.$thn)
                        ->whereRaw('id_bagian ='.Auth::user()->id_bagian)
                        ->whereRaw('id_klasifikasi = '.$request->id_klas)
                        ->orderBy('tanggal_surat', 'desc')->first();
        $getSifat = DB::table('tbl_sifat_surat')->where('id_sifat_surat', $request->sifat_surat)->first();

        if(empty($request->tindasan)){
            $arrTindasan = "";
        }else{
            $arrTindasan = implode(',', $request->tindasan);
        }

        if($getNumber == NULL){
            $urut = 1;
        }else{
            $urut = $getNumber->nomor;
            $urut += 1;
        }

        if($getSifat->kode_sifat == "RHS"){
            $sifat = "/".$getSifat->kode_sifat;
        }else{
            $sifat = "";
        }

        $noSurat = $request->kode_klasifikasi."/".$urut.$sifat."/".$request->kd_bagian."/".$thn;
        DB::table('tbl_surat_keluar')->insert([
            'id_bagian' => Auth::user()->id_bagian,
            'id_klasifikasi' => $request->id_klas,
            'nomor' => $urut,
            'tanggal_surat' => $request->tanggal_surat,
            'sifat_surat' => $request->sifat_surat,
            'id_tujuan' => $request->id_tujuan,
            'nama_tujuan' => $request->tujuanLain,
            'perihal' => $request->perihal,
            'id_pembuat' => Auth::user()->id,
            'id_konseptor' => $request->id_konseptor,
            'tindasan' => $arrTindasan,
            'nomor_surat' => $noSurat,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return response()->json(['status'=>'1', 'nomor'=>$noSurat]);
    }

    public function detailSurat($id)
    {
        $detail = DB::table('tbl_surat_keluar')
                    ->join('tbl_karyawan', 'tbl_surat_keluar.id_konseptor', '=', 'tbl_karyawan.id_karyawan')
                    ->join('users', 'tbl_surat_keluar.id_pembuat', '=', 'users.id')
                    ->where('id_surat_keluar', $id)->first();
        $arrTindasan = explode(',', $detail->tindasan);
        $arrTindasan = array_map('floatval', $arrTindasan);
        $tindasan = DB::table('tbl_bagian')->whereIn('id_bagian', $arrTindasan)->get();
        return view('modal_detailsuratkeluar', compact(['detail', 'tindasan']));
    }

    public function edit($id)
    {
        $surat = DB::table('tbl_surat_keluar')
                ->select('id_surat_keluar', 'id_klasifikasi', 'sd1','sd3', 'tanggal_surat','sifat_surat','id_tujuan', 'nama_bagian', 'nama_tujuan as tujuan_lain','perihal','id_konseptor','nama_karyawan')
                ->join('tbl_child_klasifikasi', 'tbl_child_klasifikasi.id_trans', '=', 'tbl_surat_keluar.id_klasifikasi')
                ->join('tbl_karyawan', 'tbl_karyawan.id_karyawan', '=', 'tbl_surat_keluar.id_konseptor')
                ->join('tbl_bagian', 'tbl_bagian.id_bagian', '=', 'tbl_surat_keluar.id_tujuan')
                ->where('id_surat_keluar', $id)->first();
        echo json_encode($surat);
    }

    public function update(Request $request, $id)
    {
        if(empty($request->tindasan)){
            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'tanggal_surat' => $request->tanggal_surat,
                'id_tujuan' => $request->id_tujuan,
                'nama_tujuan' => $request->tujuanLain,
                'perihal' => $request->perihal,
                'id_konseptor' => $request->id_konseptor,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }else{
            $arrTindasan = implode(',', $request->tindasan);
            DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
                'tanggal_surat' => $request->tanggal_surat,
                'id_tujuan' => $request->id_tujuan,
                'nama_tujuan' => $request->tujuanLain,
                'perihal' => $request->perihal,
                'id_konseptor' => $request->id_konseptor,
                'tindasan' => $arrTindasan,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        return response()->json(['status'=>'2']);
    }

    public function unggah_surat($id)
    {
        $detail = DB::table('tbl_surat_keluar')->select('id_surat_keluar','nomor_surat')->where('id_surat_keluar', $id)->first();
        $idSurat = $detail->id_surat_keluar;
        $noSurat = $detail->nomor_surat;
        return view('modal_unggahsuratkeluar', compact(['idSurat','noSurat']));
    }    

    public function updateSurat(Request $request, $id)
    {
        $extensionfile = $request->file_surat->getClientOriginalExtension();
        $nosurat = preg_replace('^[a-zćęłńóśźżA-Z0-9\s\.\/]+$', '', $request->noUnggah);
        $fullEmail = $nosurat.'.'.$extensionfile;
        // Storage::disk('public')->delete($request->pathFoto);
        // Storage::disk('public')->put($fullEmail, File::get($request->ubahFoto));

        // DB::table('tbl_karyawan')->where('id_karyawan', $id)->update([
        //     'foto' => $fullEmail,
        // ]);
        return response()->json(['status'=>'1','tes'=>$fullEmail]);
    }
}