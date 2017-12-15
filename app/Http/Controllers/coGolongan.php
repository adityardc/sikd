<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coGolongan extends Controller
{
    public function index()
    {
    	return view('golongan');
    }

    public function listData()
    {
        $gol = DB::table('tbl_golongan')->get();
        $no = 0;
        $data = array();
        foreach ($gol as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_golongan;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_golongan.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_golongan.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_golongan')->insert([
    		'nama_golongan' => $request->nama_golongan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $gol = DB::table('tbl_golongan')->where('id_golongan', $id)->first();
        echo json_encode($gol);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_golongan')->where('id_golongan', $id)->update([
        	'nama_golongan' => $request->nama_golongan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_golongan')->where('id_golongan', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
