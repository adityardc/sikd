<?php

// ==================================================================================
// *   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
// *   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
// *   
// *   :: plz..don't remove this text if u are "the real open-sourcer" ::
// ====================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use Redirect;

class coHakakses extends Controller
{
    public function index()
    {
    	return view('mod_hak_akses/index_hak_akses');
    }

    public function listData()
    {
        $ha = DB::table('tbl_hakakses')->orderBy('id_hakakses')->get();
        $no = 0;
        $data = array();
        foreach ($ha as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_hakakses == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_hakakses;
            $row[] = "<a href='hakakses/".$list->id_hakakses."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('hakakses/store');
        return view('mod_hak_akses/tambah_hak_akses', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_hakakses')->insert([
    		'nama_hakakses' => $request->nama_hakakses,
            'status_hakakses' => $request->status_hakakses,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('hakakses/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Hak Akses <strong>".$request->nama_hakakses."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_hakakses')->where('id_hakakses', $id)->first();
        $url = url('hakakses/'.$id.'/update');
        return view('mod_hak_akses/ubah_hak_akses', compact(['data', 'url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_hakakses')->where('id_hakakses', $id)->update([
        	'nama_hakakses' => $request->nama_hakakses,
            'status_hakakses' => $request->status_hakakses,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('hakakses')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Hak Akses <strong>".$request->nama_hakakses."</strong> berhasil diubah.
        </div>");
    }
}
