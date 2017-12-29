<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coDisposisi_direksi extends Controller
{
    public function index()
    {
    	return view('disposisi');
    }

    public function listData()
    {
        $dis = DB::table('tbl_disposisi_direksi')
        		->select(DB::raw("id_disposisi_direksi, nama_disposisi, status_aktif, CASE status_aktif WHEN 'Y' THEN 'AKTIF' WHEN 'N' THEN 'TIDAK AKTIF' END AS status"))
        		->orderBy('id_disposisi_direksi')
        		->get();
        $no = 0;
        $data = array();
        foreach ($dis as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_disposisi;
            $row[] = $list->status;
            $row[] = "<button type='button' class='btn btn-default btn-xs shiny icon-only blue tooltip-blue' onclick='editData(".$list->id_disposisi_direksi.")' data-toggle='tooltip' data-placement='top' title='Ubah Data'><span class='fa fa-pencil'></span></button>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
    	DB::table('tbl_disposisi_direksi')->insert([
    		'nama_disposisi' => $request->nama_disposisi,
    		'status_aktif' => $request->status_aktif,
    		'created_at' => \Carbon\Carbon::now(),
    		'updated_at' => \Carbon\Carbon::now()
    	]);
    	return response()->json(['status'=>'1']);
    }

    public function edit($id)
    {
        $dis = DB::table('tbl_disposisi_direksi')->where('id_disposisi_direksi', $id)->first();
        echo json_encode($dis);
    }

    public function update(Request $request, $id)
    {
        DB::table('tbl_disposisi_direksi')->where('id_disposisi_direksi', $id)->update([
        	'nama_disposisi' => $request->nama_disposisi,
        	'status_aktif' => $request->status_aktif,
        	'updated_at' => \Carbon\Carbon::now()
        ]);
        return response()->json(['status'=>'2']);
    }
}
