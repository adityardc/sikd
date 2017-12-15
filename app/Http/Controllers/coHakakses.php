<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coHakakses extends Controller
{
    public function index()
    {
    	return view('hakakses');
    }

    public function listData()
    {
        $ha = DB::table('tbl_hakakses')->get();
        $no = 0;
        $data = array();
        foreach ($ha as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_hakakses;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_hakakses.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_hakakses.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_hakakses')->insert([
    		'nama_hakakses' => $request->nama_hakakses,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $ha = DB::table('tbl_hakakses')->where('id_hakakses', $id)->first();
        echo json_encode($ha);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_hakakses')->where('id_hakakses', $id)->update([
        	'nama_hakakses' => $request->nama_pendidikan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_hakakses')->where('id_hakakses', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
