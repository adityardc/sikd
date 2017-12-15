<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coBagian extends Controller
{
    public function index()
    {
    	return view('bagian');
    }

    public function listData()
    {
        $bagian = DB::table("tbl_bagian")->select(DB::raw("id_bagian, nama_bagian, kode_bagian, tindasan, grup_bagian, CASE tindasan WHEN 0 THEN 'TIDAK AKTIF' WHEN 1 THEN 'AKTIF' END AS status, CASE grup_bagian WHEN 0 THEN 'DIREKSI' WHEN 1 THEN 'BAGIAN KANTOR DIREKSI' WHEN 2 THEN 'UNIT KERJA' WHEN 3 THEN 'AGROWISATA' WHEN 4 THEN 'LAIN - LAIN' END AS grup"))->get();
        $no = 0;
        $data = array();
        foreach ($bagian as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_bagian;
            $row[] = $list->kode_bagian;
            $row[] = $list->grup;
            $row[] = $list->status;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_bagian.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_bagian.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_bagian')->insert([
    		'nama_bagian' => $request->nama_bagian,
    		'kode_bagian' => $request->kode_bagian,
            'tindasan' => $request->tindasan,
            'grup_bagian' => $request->grup_bagian,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $bagian = DB::table('tbl_bagian')->where('id_bagian', $id)->first();
        echo json_encode($bagian);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_bagian')->where('id_bagian', $id)->update([
        	'nama_bagian' => $request->nama_bagian,
        	'kode_bagian' => $request->kode_bagian,
            'tindasan' => $request->tindasan,
            'grup_bagian' => $request->grup_bagian,
            'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_bagian')->where('id_bagian', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
