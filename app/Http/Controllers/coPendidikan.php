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

class coPendidikan extends Controller
{
    public function index()
    {
    	return view('mod_pendidikan/index_pendidikan');
    }

    public function listData()
    {
        $ddk = DB::table('tbl_pendidikan')->orderBy('id_pendidikan')->get();
        $no = 0;
        $data = array();
        foreach ($ddk as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_pendidikan == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_pendidikan;
            $row[] = "<a href='pendidikan/".$list->id_pendidikan."/edit' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('pendidikan/store');
        return view('mod_pendidikan/tambah_pendidikan', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_pendidikan')->insert([
    		'nama_pendidikan' => $request->nama_pendidikan,
            'status_pendidikan' => $request->status_pendidikan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('pendidikan/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Pendidikan <strong>".$request->nama_pendidikan."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_pendidikan')->where('id_pendidikan', $id)->first();
        $url = url('pendidikan/'.$id.'/update');
        return view('mod_pendidikan/ubah_pendidikan', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_pendidikan')->where('id_pendidikan', $id)->update([
        	'nama_pendidikan' => $request->nama_pendidikan,
            'status_pendidikan' => $request->status_pendidikan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('pendidikan')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Pendidikan <strong>".$request->nama_pendidikan."</strong> berhasil disimpan.
        </div>");
    }
}
