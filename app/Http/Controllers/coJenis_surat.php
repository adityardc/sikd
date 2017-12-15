<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coJenis_surat extends Controller
{
    public function index()
    {
    	return view('jenis_surat');
    }

    public function listData()
    {
        $jns = DB::table('tbl_jenis_surat')->get();
        $no = 0;
        $data = array();
        foreach ($jns as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_jenis;
            $row[] = $list->deskripsi;
            $row[] = $list->kode_jenis;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_jenis_surat.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_jenis_surat.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jenis_surat')->insert([
    		'nama_jenis' => $request->nama_jenis,
    		'kode_jenis' => $request->kode_jenis,
    		'deskripsi' => $request->deskripsi,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $jns = DB::table('tbl_jenis_surat')->where('id_jenis_surat', $id)->first();
        echo json_encode($jns);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jenis_surat')->where('id_jenis_surat', $id)->update([
        	'nama_jenis' => $request->nama_jenis,
        	'kode_jenis' => $request->kode_jenis,
        	'deskripsi' => $request->deskripsi,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_jenis_surat')->where('id_jenis_surat', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
