<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use Redirect;
use Auth;

class coTim extends Controller
{
    public function index()
    {
    	return view('mod_tim/index_tim');
    }

    public function listData()
    {
        $tim = DB::table("tbl_tim")->orderBy('id_tim')->get();
        $no = 0;
        $data = array();
        foreach ($tim as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_tim == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_tim;
            $row[] = ((Auth::user()->id_role == 1) ? "<a href='tim/".$list->id_tim."/edit' class='btn btn-default btn-xs shiny icon-only palegreen tooltip-palegreen' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>" : "-");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('tim/store');
        $bagian = DB::table('tbl_bagian')->where('status_bagian', 'Y')->where('grup_bagian','<>',0)->orderBy('id_bagian')->orderBy('grup_bagian')->get();
        $kry = DB::table('tbl_karyawan')->where('status_karyawan', 1)->orderBy('nama_karyawan')->get();
        return view('mod_tim/tambah_tim', compact(['url','bagian','kry']));
    }

    public function store(Request $request)
    {
        if($request->jns_tim == 1){
        	$anggota_tim = implode(',', $request->anggota_bagian);
        	$bagian_tim = implode(',', $request->anggota_bagian);
        	$jns = 1;
        }else{
        	$arrKaryawan = array();
        	$arrBagian = array();
        	foreach ($request->anggota_karyawan as $value) {
        		list($bag, $kry) = array_pad(explode("-", $value, 2), 2, NULL);
        		$arrBagian[] = $bag;
        		$arrKaryawan[] = $kry;
        	}
        	$anggota_tim = implode(',',  $arrKaryawan);
        	$bagian_tim = implode(',', $arrBagian);
        	$jns = 2;
        }

        DB::table('tbl_tim')->insert([
        	'nama_tim' => $request->nama_tim,
        	'anggota_tim' => $anggota_tim,
        	'bagian_tim' => $bagian_tim,
        	'status_tim' => $request->status_tim,
        	'jns_tim' => $jns,
            'grup_tim' => $request->grup_tim,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return Redirect::to('tim/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> TIM <strong>".$request->nama_tim."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_tim')->where('id_tim', $id)->first();
        $url = url('tim/'.$id.'/update');
        $bagian = DB::table('tbl_bagian')->where('status_bagian', 'Y')->where('grup_bagian','<>',0)->orderBy('id_bagian')->orderBy('grup_bagian')->get();
        $kry = DB::table('tbl_karyawan')->where('status_karyawan', 1)->orderBy('nama_karyawan')->get();
        $anggota_bagian = explode(",", $data->anggota_tim);
        $anggota_karyawan = explode(",", $data->bagian_tim);
        return view('mod_tim/ubah_tim', compact(['data','url','bagian','kry','anggota_bagian','anggota_karyawan']));
    }

    public function update(Request $request, $id)
    {
    	if($request->jns_tim == 1){
        	$anggota_tim = implode(',', $request->anggota_bagian);
        	$bagian_tim = implode(',', $request->anggota_bagian);
        	$jns = 1;
        }else{
        	$arrKaryawan = array();
        	$arrBagian = array();
        	foreach ($request->anggota_karyawan as $value) {
        		list($bag, $kry) = array_pad(explode("-", $value, 2), 2, NULL);
        		$arrBagian[] = $bag;
        		$arrKaryawan[] = $kry;
        	}
        	$anggota_tim = implode(',',  $arrKaryawan);
        	$bagian_tim = implode(',', $arrBagian);
        	$jns = 2;
        }

        DB::table('tbl_tim')->where('id_tim', $id)->update([
        	'nama_tim' => $request->nama_tim,
        	'anggota_tim' => $anggota_tim,
        	'bagian_tim' => $bagian_tim,
        	'status_tim' => $request->status_tim,
        	'jns_tim' => $jns,
            'grup_tim' => $request->grup_tim,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('tim')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> TIM <strong>".$request->nama_tim."</strong> berhasil disimpan.
        </div>");
    }
}
