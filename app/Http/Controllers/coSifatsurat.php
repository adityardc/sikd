<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class coSifatsurat extends Controller
{
    public function index()
    {
    	return view('sifat_surat');
    }

    public function listData()
    {
        $sifat = DB::table('tbl_sifat_surat')->get();
        $no = 0;
        $data = array();
        foreach ($sifat as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_sifat;
            $row[] = $list->deskripsi;
            $row[] = $list->kode_sifat;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_sifat_surat.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>
            		  <a class='btn btn-default btn-xs shiny icon-only danger tooltip-danger' onclick='deleteData(".$list->id_sifat_surat.")' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Data' href='javascript:void(0);'><i class='fa fa-times'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_sifat_surat')->insert([
    		'nama_sifat' => $request->nama_sifat,
    		'kode_sifat' => $request->kode_sifat,
    		'deskripsi' => $request->deskripsi,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $sifat = DB::table('tbl_sifat_surat')->where('id_sifat_surat', $id)->first();
        echo json_encode($sifat);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_sifat_surat')->where('id_sifat_surat', $id)->update([
        	'nama_sifat' => $request->nama_sifat,
        	'kode_sifat' => $request->kode_sifat,
        	'deskripsi' => $request->deskripsi,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }

    public function destroy($id)
    {
        DB::table('tbl_sifat_surat')->where('id_sifat_surat', $id)->delete();
        return response()->json(['status'=>'3']);
    }
}
