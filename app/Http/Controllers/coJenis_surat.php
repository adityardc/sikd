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

class coJenis_surat extends Controller
{
    public function index()
    {
    	return view('mod_jenis_surat/index_jenis_surat');
    }

    public function listData()
    {
        $jns = DB::table('tbl_jenis_surat')->orderBy('id_jenis_surat')->get();
        $no = 0;
        $data = array();
        foreach ($jns as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_jenis == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_jenis;
            $row[] = $list->deskripsi;
            $row[] = $list->kode_jenis;
            $row[] = "<a href='jenis_surat/".$list->id_jenis_surat."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('jenis_surat/store');
        return view('mod_jenis_surat/tambah_jenis_surat', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jenis_surat')->insert([
    		'nama_jenis' => $request->nama_jenis,
    		'kode_jenis' => $request->kode_jenis,
    		'deskripsi' => $request->deskripsi,
            'status_jenis' => $request->status_jenis,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('jenis_surat/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_jenis."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_jenis_surat')->where('id_jenis_surat', $id)->first();
        $url = url('jenis_surat/'.$id.'/update');
        return view('mod_jenis_surat/ubah_jenis_surat', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jenis_surat')->where('id_jenis_surat', $id)->update([
        	'nama_jenis' => $request->nama_jenis,
        	'kode_jenis' => $request->kode_jenis,
        	'deskripsi' => $request->deskripsi,
            'status_jenis' => $request->status_jenis,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('jenis_surat')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jabatan <strong>".$request->nama_jenis."</strong> berhasil disimpan.
        </div>");
    }
}
