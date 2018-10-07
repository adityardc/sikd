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

class coUrusan_bagian extends Controller
{
    public function index()
    {
    	return view('mod_urusan_bagian/index_urusan_bagian');
    }

    public function listData()
    {
        $bagian = DB::table("tbl_urusan_bagian")->join('tbl_bagian','tbl_urusan_bagian.id_bagian','=','tbl_bagian.id_bagian')->orderBy('id_urusan_bagian')->get();
        $no = 0;
        $data = array();
        foreach ($bagian as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_urusan_bagian == "Y") ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_urusan_bagian;
            $row[] = $list->nama_bagian;
            $row[] = ((Auth::user()->id_role == 1) ? "<a href='urusan_bagian/".$list->id_urusan_bagian."/edit' class='btn btn-default btn-xs shiny icon-only magenta tooltip-magenta' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>" : "-");
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_urusan_bagian')->insert([
    		'id_bagian' => $request->id_bagian,
    		'nama_urusan_bagian' => $request->nama_urusan_bagian,
            'status_urusan_bagian' => $request->status_urusan_bagian,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);

        return Redirect::to('urusan_bagian/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Urusan <strong>".$request->nama_urusan_bagian."</strong> berhasil disimpan.
        </div>");
    }

    public function create()
    {
        $url = url('urusan_bagian/store');
        $bagian = DB::table('tbl_bagian')->orderBy('id_bagian')->where('grup_bagian', '!=', 0)->get();
        return view('mod_urusan_bagian/tambah_urusan_bagian', compact(['url','bagian']));
    }

    public function edit($id)
    {
        $data = DB::table('tbl_urusan_bagian')->where('id_urusan_bagian', $id)->first();
        $url = url('urusan_bagian/'.$id.'/update');
        $bagian = DB::table('tbl_bagian')->orderBy('id_bagian')->where('grup_bagian','!=',0)->get();
        return view('mod_urusan_bagian/ubah_urusan_bagian', compact(['data','url','bagian']));
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_urusan_bagian')->where('id_urusan_bagian', $id)->update([
        	'id_bagian' => $request->id_bagian,
        	'nama_urusan_bagian' => $request->nama_urusan_bagian,
            'status_urusan_bagian' => $request->status_urusan_bagian,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return Redirect::to('urusan_bagian')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Urusan <strong>".$request->nama_urusan_bagian."</strong> berhasil disimpan.
        </div>");
    }
}
