<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SEKRETARIS PERUSAHAAN
        $jml_90 = DB::table('tbl_surat_keluar')->where('id_bagian', 1)->count();
        $upload_90 = DB::table('tbl_surat_keluar')->where('id_bagian', 1)->whereNull('path_surat')->count();
        $prg_90 = ($jml_90 == 0) ? 0 : (100 - (($upload_90/$jml_90)*100));

        // SPI
        $jml_91 = DB::table('tbl_surat_keluar')->where('id_bagian', 3)->count();
        $upload_91 = DB::table('tbl_surat_keluar')->where('id_bagian', 3)->whereNull('path_surat')->count();
        $prg_91 = ($jml_91 == 0) ? 0 : (100 - (($upload_91/$jml_91)*100));
        return view('home', compact(['jml_90','upload_90','prg_90','jml_91','upload_91','prg_91']));
    }
}
