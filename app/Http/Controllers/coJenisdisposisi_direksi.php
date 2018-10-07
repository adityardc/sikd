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

class coJenisdisposisi_direksi extends Controller
{
    public function index()
    {
    	return view('mod_jenis_disposisi_direksi/index_jenis_disposisi_direksi');
    }

    public function listData()
    {
        $dis = DB::table('tbl_jenis_disposisi_direksi')->orderBy('id_disposisi_direksi')->get();
        $no = 0;
        $data = array();
        foreach ($dis as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_aktif == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_disposisi;
            $row[] = "<a href='jenis_disposisi/".$list->id_disposisi_direksi."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('jenis_disposisi/store');
        return view('mod_jenis_disposisi_direksi/tambah_jenis_disposisi_direksi', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jenis_disposisi_direksi')->insert([
    		'nama_disposisi' => $request->nama_disposisi,
    		'status_aktif' => $request->status_aktif,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('jenis_disposisi/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jenis Disposisi Direksi <strong>".$request->nama_disposisi."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_jenis_disposisi_direksi')->where('id_disposisi_direksi', $id)->first();
        $url = url('jenis_disposisi/'.$id.'/update');
        return view('mod_jenis_disposisi_direksi/ubah_jenis_disposisi_direksi', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jenis_disposisi_direksi')->where('id_disposisi_direksi', $id)->update([
        	'nama_disposisi' => $request->nama_disposisi,
        	'status_aktif' => $request->status_aktif,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('jenis_disposisi')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jenis Disposisi Direksi <strong>".$request->nama_disposisi."</strong> berhasil disimpan.
        </div>");
    }
}
