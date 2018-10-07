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

class coGolongan extends Controller
{
    public function index()
    {
    	return view('mod_golongan/index_golongan');
    }

    public function listData()
    {
        $gol = DB::table('tbl_golongan')->orderBy('id_golongan')->get();
        $no = 0;
        $data = array();
        foreach ($gol as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_golongan == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_golongan;
            $row[] = "<a href='golongan/".$list->id_golongan."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('golongan/store');
        return view('mod_golongan/tambah_golongan', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_golongan')->insert([
    		'nama_golongan' => $request->nama_golongan,
            'status_golongan' => $request->status_golongan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('golongan/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Golongan <strong>".$request->nama_golongan."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_golongan')->where('id_golongan', $id)->first();
        $url = url('golongan/'.$id.'/update');
        return view('mod_golongan/ubah_golongan', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_golongan')->where('id_golongan', $id)->update([
        	'nama_golongan' => $request->nama_golongan,
            'status_golongan' => $request->status_golongan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('golongan')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Golongan <strong>".$request->nama_golongan."</strong> berhasil disimpan.
        </div>");
    }
}
