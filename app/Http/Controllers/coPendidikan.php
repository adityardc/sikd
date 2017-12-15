<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coPendidikan extends Controller
{
    public function index()
    {
    	return view('pendidikan');
    }

    public function listData()
    {
        $ddk = DB::table('tbl_pendidikan')->get();
        $no = 0;
        $data = array();
        foreach ($ddk as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_pendidikan;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_pendidikan.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_pendidikan.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_pendidikan')->insert([
    		'nama_pendidikan' => $request->nama_pendidikan,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $ddk = DB::table('tbl_pendidikan')->where('id_pendidikan', $id)->first();
        echo json_encode($ddk);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_pendidikan')->where('id_pendidikan', $id)->update([
        	'nama_pendidikan' => $request->nama_pendidikan,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_pendidikan')->where('id_pendidikan', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
