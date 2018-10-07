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
use Auth;

class coRetensi_deskripsi extends Controller
{
    public function index()
    {
    	return view('mod_retensi_deskripsi/index_retensi_deskripsi');
    }

    public function listData()
    {
        $x = DB::table('tbl_retensi_keterangan')->orderBy('id_retensi_ket')->get();
        $no = 0;
        $data = array();
        foreach ($x as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_ket == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_ket;
            $row[] = ((Auth::user()->id_role == 1) ? "<a href='retensi_deskripsi/".$list->id_retensi_ket."/edit' class='btn btn-default btn-xs shiny icon-only palegreen tooltip-palegreen' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>" : "-");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('retensi_deskripsi/store');
        return view('mod_retensi_deskripsi/tambah_retensi_deskripsi', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_retensi_keterangan')->insert([
    		'nama_ket' => $request->nama_ket,
            'status_ket' => $request->status_ket,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('retensi_deskripsi/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Deskripsi Retensi <strong>".$request->nama_ket."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_retensi_keterangan')->where('id_retensi_ket', $id)->first();
        $url = url('retensi_deskripsi/'.$id.'/update');
        return view('mod_retensi_deskripsi/ubah_retensi_deskripsi', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_retensi_keterangan')->where('id_retensi_ket', $id)->update([
        	'nama_ket' => $request->nama_ket,
            'status_ket' => $request->status_ket,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('retensi_deskripsi')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Deskripsi Retensi <strong>".$request->nama_ket."</strong> berhasil disimpan.
        </div>");
    }
}
