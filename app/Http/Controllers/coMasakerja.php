<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coMasakerja extends Controller
{
    public function index()
    {
    	return view('masakerja');
    }

    public function listData()
    {
        $mk = DB::table('tbl_masakerja')->get();
        $no = 0;
        $data = array();
        foreach ($mk as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_masakerja;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_masakerja.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_masakerja.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_masakerja')->insert([
    		'nama_masakerja' => $request->nama_masakerja,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $mk = DB::table('tbl_masakerja')->where('id_masakerja', $id)->first();
        echo json_encode($mk);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_masakerja')->where('id_masakerja', $id)->update([
        	'nama_masakerja' => $request->nama_masakerja,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_masakerja')->where('id_masakerja', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
