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

class coMasakerja extends Controller
{
    public function index()
    {
    	return view('mod_masakerja/index_masakerja');
    }

    public function listData()
    {
        $mk = DB::table('tbl_masakerja')->orderBy('id_masakerja')->get();
        $no = 0;
        $data = array();
        foreach ($mk as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_masakerja == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_masakerja;
            $row[] = "<a href='masakerja/".$list->id_masakerja."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('masakerja/store');
        return view('mod_masakerja/tambah_masakerja', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_masakerja')->insert([
    		'nama_masakerja' => $request->nama_masakerja,
            'status_masakerja' => $request->status_masakerja,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('masakerja/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Masa kerja <strong>".$request->nama_masakerja."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_masakerja')->where('id_masakerja', $id)->first();
        $url = url('masakerja/'.$id.'/update');
        return view('mod_masakerja/ubah_masakerja', compact(['data', 'url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_masakerja')->where('id_masakerja', $id)->update([
        	'nama_masakerja' => $request->nama_masakerja,
            'status_masakerja' => $request->status_masakerja,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('masakerja')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Masa kerja <strong>".$request->nama_masakerja."</strong> berhasil diubah.
        </div>");
    }
}
