<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coParentklasifikasi extends Controller
{
    public function index()
    {
    	return view('parentKlasifikasi');
    }

    public function listData()
    {
        $pk = DB::table('tbl_parent_klasifikasi')->get();
        $no = 0;
        $data = array();
        foreach ($pk as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->deskripsi_parent;
            $row[] = $list->kode_parent;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_parent.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_parent.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	$cek = DB::table('tbl_parent_klasifikasi')->where('deskripsi_parent', $request->nama_parent)->first();
    	if($cek == NULL){
    		DB::table('tbl_parent_klasifikasi')->insert([
    			'kode_parent' => $request->kode_parent,
    			'deskripsi_parent' => $request->nama_parent
    		]);

    		return response()->json(['status'=>'1']);
    	}else{
    		return response()->json(['status'=>'3']);
    	}
    }

    public function edit($id)
    {
        $pk = DB::table('tbl_parent_klasifikasi')->where('id_parent', $id)->first();
        echo json_encode($pk);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_parent_klasifikasi')->where('id_parent', $id)->update([
        	'deskripsi_parent' => $request->nama_parent,
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_parent_klasifikasi')->where('id_parent', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
