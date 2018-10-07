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

class coRetensi_inaktif extends Controller
{
    public function index()
    {
    	return view('mod_retensi_inaktif/index_retensi_inaktif');
    }

    public function listData()
    {
        $x = DB::table('tbl_retensi_inaktif')->orderBy('id_retensi_inaktif')->get();
        $no = 0;
        $data = array();
        foreach ($x as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_retensi == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_retensi;
            $row[] = ((Auth::user()->id_role == 1) ? "<a href='retensi_inaktif/".$list->id_retensi_inaktif."/edit' class='btn btn-default btn-xs shiny icon-only palegreen tooltip-palegreen' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>" : "-");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('retensi_inaktif/store');
        return view('mod_retensi_inaktif/tambah_retensi_inaktif', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_retensi_inaktif')->insert([
    		'nama_retensi' => $request->nama_retensi,
            'status_retensi' => $request->status_retensi,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('retensi_inaktif/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Retensi Inaktif <strong>".$request->nama_retensi."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_retensi_inaktif')->where('id_retensi_inaktif', $id)->first();
        $url = url('retensi_inaktif/'.$id.'/update');
        return view('mod_retensi_inaktif/ubah_retensi_inaktif', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_retensi_inaktif')->where('id_retensi_inaktif', $id)->update([
        	'nama_retensi' => $request->nama_retensi,
            'status_retensi' => $request->status_retensi,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('retensi_inaktif')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Retensi Inaktif <strong>".$request->nama_retensi."</strong> berhasil disimpan.
        </div>");
    }
}
