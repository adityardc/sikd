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

class coJenisdisposisi_bagian extends Controller
{
    public function index()
    {
    	return view('mod_jenis_disposisi_bagian/index_jenis_disposisi_bagian');
    }

    public function listData()
    {
        $dis = DB::table('tbl_jenis_disposisi_bagian')->orderBy('id_jenis_disposisi_bagian')->get();
        $no = 0;
        $data = array();
        foreach ($dis as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_disposisi_bagian == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_disposisi_bagian;
            $row[] = "<a href='jenis_disposisi_bagian/".$list->id_jenis_disposisi_bagian."/edit' class='btn btn-default btn-xs shiny icon-only azure tooltip-azure' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('jenis_disposisi_bagian/store');
        return view('mod_jenis_disposisi_bagian/tambah_jenis_disposisi_bagian', compact(['url']));
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jenis_disposisi_bagian')->insert([
    		'nama_disposisi_bagian' => $request->nama_disposisi_bagian,
    		'status_disposisi_bagian' => $request->status_disposisi_bagian,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	
        return Redirect::to('jenis_disposisi_bagian/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jenis Disposisi Bagian <strong>".$request->nama_disposisi_bagian."</strong> berhasil disimpan.
        </div>");
    }

    public function edit($id)
    {
        $data = DB::table('tbl_jenis_disposisi_bagian')->where('id_jenis_disposisi_bagian', $id)->first();
        $url = url('jenis_disposisi_bagian/'.$id.'/update');
        return view('mod_jenis_disposisi_bagian/ubah_jenis_disposisi_bagian', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jenis_disposisi_bagian')->where('id_jenis_disposisi_bagian', $id)->update([
        	'nama_disposisi_bagian' => $request->nama_disposisi_bagian,
        	'status_disposisi_bagian' => $request->status_disposisi_bagian,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('jenis_disposisi_bagian')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Jenis Disposisi Bagian <strong>".$request->nama_disposisi_bagian."</strong> berhasil disimpan.
        </div>");
    }
}
