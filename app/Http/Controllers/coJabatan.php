<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coJabatan extends Controller
{
    public function index()
    {
    	return view('jabatan');
    }

    public function listData()
    {
        $jabatan = DB::table('tbl_jabatan')->get();
        $no = 0;
        $data = array();
        foreach ($jabatan as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_jabatan;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_jabatan.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_jabatan.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_jabatan')->insert([
    		'nama_jabatan' => $request->nama_jabatan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $jabatan = DB::table('tbl_jabatan')->where('id_jabatan', $id)->first();
        echo json_encode($jabatan);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_jabatan')->where('id_jabatan', $id)->update([
        	'nama_jabatan' => $request->nama_jabatan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_jabatan')->where('id_jabatan', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
