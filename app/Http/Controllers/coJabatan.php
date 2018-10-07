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

class coJabatan extends Controller
{
    public function index()
    {
    	return view('mod_jabatan/index_jabatan');
    }

    public function listData()
    {
        $jabatan = DB::table('tbl_jabatan')->orderBy('id_jabatan')->get();
        $no = 0;
        $data = array();
        foreach ($jabatan as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_jabatan == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_jabatan;
            $row[] = "<a href='jabatan/".$list->id_jabatan."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('jabatan/store');
        return view('mod_jabatan/tambah_jabatan', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jabatan')->insert([
    		'nama_jabatan' => $request->nama_jabatan,
            'status_jabatan' => $request->status_jabatan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('jabatan/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_jabatan."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_jabatan')->where('id_jabatan', $id)->first();
        $url = url('jabatan/'.$id.'/update');
        return view('mod_jabatan/ubah_jabatan', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jabatan')->where('id_jabatan', $id)->update([
        	'nama_jabatan' => $request->nama_jabatan,
            'status_jabatan' => $request->status_jabatan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);

        return Redirect::to('jabatan')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_jabatan."</strong> berhasil disimpan.
        </div>");
    }
}
