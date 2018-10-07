<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;
use Storage;
use File;
use Auth;

class coSurat_masuk_internal extends Controller
{
    public function index()
    {
    	return view('mod_surat_masuk_int/index_surat_masuk_int');
    }

    public function listData()
    {
        if(Auth::user()->grup_bagian == 1){ // BAGIAN
            $list_bag = DB::table('tbl_bagian')->select('id_bagian')->where('grup_bagian','<>',2)->get();
            $arr = collect($list_bag)->map(function($x){return (array) $x;})->toArray();
            $dataSurat = DB::table("tbl_surat_keluar")->select('tbl_surat_keluar.*','tbl_agenda_sentral.id_agenda_sentral')
                                                      ->join('tbl_bagian','tbl_surat_keluar.id_bagian','=','tbl_bagian.id_bagian')
                                                      ->leftjoin('tbl_agenda_sentral','tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_sentral.id_surat_keluar')
                                                      ->where('tbl_surat_keluar.tipe_surat', 1)
                                                      ->where('tbl_bagian.grup_bagian', '<>', Auth::user()->grup_bagian)
                                                      ->whereIn('tbl_surat_keluar.tujuan_surat', $arr)
                                                      ->orderBy('created_at', 'DESC')->get();
        }else{ // UNIT KERJA
            $dataSurat = DB::table("tbl_surat_keluar")->select('tbl_surat_keluar.*','tbl_agenda_sentral.id_agenda_sentral')
                                                      ->join('tbl_bagian','tbl_surat_keluar.id_bagian','=','tbl_bagian.id_bagian')
                                                      ->leftjoin('tbl_agenda_sentral', function($join){
                                                            $join->on('tbl_surat_keluar.id_surat_keluar','=','tbl_agenda_sentral.id_surat_keluar')
                                                                 ->where('tbl_agenda_sentral.id_bagian', Auth::user()->id_bagian);
                                                      })
                                                      ->whereRaw("((',' || RTRIM(tbl_surat_keluar.tujuan_surat) || ',') LIKE '%,".Auth::user()->id_bagian.",%') AND (tbl_surat_keluar.tipe_surat = 1 OR tbl_surat_keluar.tipe_surat = 4)")
                                                      ->orderBy('created_at', 'DESC')->get();
        }

        $no = 0;
        $data = array();
        foreach ($dataSurat as $list) {
            $arrTujuan = explode(',', $list->tujuan_surat);
            $arrTujuan = array_map('floatval', $arrTujuan);
            $tujuan = DB::table('tbl_bagian')->select('nama_bagian')->whereIn('id_bagian', $arrTujuan)->get();

            $no++;
            $baris = array();
            $row = array();

            foreach($tujuan as $bag => $x) {
                $y = $bag+1;
                $baris[] = $x->nama_bagian;
            }
            $row[] = $no;
            $row[] = (($list->id_agenda_sentral != NULL) ? "<a href='surat_masuk_internal/".$list->id_surat_keluar."/detail' target='_blank' class='btn btn-default btn-xs shiny icon-only magenta tooltip-magenta' data-toggle='tooltip' data-placement='top' data-original-title='Detail Surat'><i class='fa fa-pencil'></i></a>" : "<a href='surat_masuk_internal/".$list->id_surat_keluar."/create' class='btn btn-default btn-xs shiny icon-only magenta tooltip-magenta' data-toggle='tooltip' data-placement='top' data-original-title='Agenda Surat'><i class='fa fa-pencil'></i></a>");
            $row[] = $list->nomor_surat;
            $row[] = date('d M Y', strtotime($list->tanggal_surat));
            $row[] = $baris;
            $row[] = $list->perihal_surat;
            $row[] = (($list->id_agenda_sentral != NULL) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Sudah Agenda'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Belum Agenda'><i class='menu-icon fa fa-close'></i></span> ");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create($id)
    {
        $data = DB::table('tbl_surat_keluar')->select('tbl_surat_keluar.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas','tbl_karyawan.nama_karyawan','users.name')
                                             ->join('tbl_klasifikasi','tbl_surat_keluar.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                                             ->join('tbl_karyawan','tbl_surat_keluar.id_konseptor','=','tbl_karyawan.id_karyawan')
                                             ->join('users','tbl_surat_keluar.id_pembuat','=','users.id')
                                             ->where('id_surat_keluar', $id)->first();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        $url = url('surat_masuk_internal/'.$id.'/update');
        return view('mod_surat_masuk_int/tambah_surat_masuk_int', compact(['data','all','sifat','tindasan','tujuan','url']));
    }

    public function update(Request $request, $id)
    {
        $thn = substr($request->tanggal_agenda_sentral, 0, 4);
        $getNumber = DB::table('tbl_temp_surat_masuk')->where('tahun', $thn)->where('id_bagian', Auth::user()->id_bagian)->first();

        if($getNumber == NULL){
            $urut = 1;
            DB::table('tbl_temp_surat_masuk')->insert([
                'tahun' => $thn,
                'nomor_urut' => $urut,
                'id_bagian' => Auth::user()->id_bagian,
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

        DB::table('tbl_agenda_sentral')->insert([
            'id_surat_keluar' => $id,
            'id_bagian' => Auth::user()->id_bagian,
            'nomor_agenda_sentral' => $urut,
            'tanggal_agenda_sentral' => $request->tanggal_agenda_sentral,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('tbl_surat_keluar')->where('id_surat_keluar', $id)->update([
            'status_agenda_sentral' => 1,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return Redirect::to('surat_masuk_internal')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Surat masuk berhasil diagenda dengan Nomor : <h1><strong>".$urut."</strong></h1>
        </div>");
    }

    public function detail($id)
    {
        $data = DB::table('tbl_surat_keluar')->select('tbl_surat_keluar.*','tbl_klasifikasi.kode_klas','tbl_klasifikasi.nama_klas','tbl_karyawan.nama_karyawan','users.name')
                                             ->join('tbl_klasifikasi','tbl_surat_keluar.id_klasifikasi','=','tbl_klasifikasi.id_klas')
                                             ->join('tbl_karyawan','tbl_surat_keluar.id_konseptor','=','tbl_karyawan.id_karyawan')
                                             ->join('users','tbl_surat_keluar.id_pembuat','=','users.id')
                                             ->where('id_surat_keluar', $id)->first();
        $sentral = DB::table('tbl_agenda_sentral')
                   ->select('tbl_bagian.nama_bagian','tbl_agenda_sentral.nomor_agenda_sentral','tbl_agenda_sentral.tanggal_agenda_sentral')
                   ->join('tbl_bagian','tbl_agenda_sentral.id_bagian','=','tbl_bagian.id_bagian')
                   ->where('id_surat_keluar', $id)->get();
        $all = DB::table('tbl_bagian')->where('status_bagian', "Y")->orderBy('grup_bagian')->orderBy('id_bagian')->get();
        $sifat = DB::table('tbl_sifat_surat')->where('status_sifat', "Y")->orderBy('id_sifat_surat')->get();
        $tindasan = explode(",", $data->tindasan_surat);
        $tujuan = explode(",", $data->tujuan_surat);
        $url = url('surat_masuk_internal/'.$id.'/update');
        return view('mod_surat_masuk_int/detail_surat_masuk_int', compact(['data','all','sifat','tindasan','tujuan','url','sentral']));
    }

}
