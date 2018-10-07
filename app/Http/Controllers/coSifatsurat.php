<?php

// ==================================================================================
// *   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
// *   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
// *   
// *   :: plz..don't remove this text if u are "the real open-sourcer" ::
// ====================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Redirect;

class coSifatsurat extends Controller
{
    public function index()
    {
    	return view('mod_sifat_surat/index_sifat_surat');
    }

    public function listData()
    {
        $sifat = DB::table('tbl_sifat_surat')->orderBy('id_sifat_surat')->get();
        $no = 0;
        $data = array();
        foreach ($sifat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_sifat == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_sifat;
            $row[] = $list->deskripsi;
            $row[] = $list->kode_sifat;
            $row[] = "<a href='sifat_surat/".$list->id_sifat_surat."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('sifat_surat/store');
        return view('mod_sifat_surat/tambah_sifat_surat', compact(['url']));
    }

    public function store(Request $request)
    {
    	// DB::table('tbl_sifat_surat')->insert([
    	// 	'nama_sifat' => $request->nama_sifat,
    	// 	'kode_sifat' => $request->kode_sifat,
    	// 	'deskripsi' => $request->deskripsi,
     //        'status_sifat' => $request->status_sifat,
    	// 	'created_at' => \Carbon\Carbon::now(),
    	// 	'updated_at' => \Carbon\Carbon::now()
    	// ]);
    	
        return Redirect::to('sifat_surat/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_sifat."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_sifat_surat')->where('id_sifat_surat', $id)->first();
        $url = url('sifat_surat/'.$id.'/update');
        return view('mod_sifat_surat/ubah_sifat_surat', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        // DB::table('tbl_sifat_surat')->where('id_sifat_surat', $id)->update([
        // 	'nama_sifat' => $request->nama_sifat,
        // 	'kode_sifat' => $request->kode_sifat,
        // 	'deskripsi' => $request->deskripsi,
        //     'status_sifat' => $request->status_sifat,
        // 	'updated_at' => \Carbon\Carbon::now()
        // ]);
        
        return Redirect::to('sifat_surat')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_sifat."</strong> berhasil disimpan.
        </div>");
    }
}
