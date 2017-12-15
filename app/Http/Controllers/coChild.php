<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class coChild extends Controller
{
    public function index()
    {
    	return view('childKlasifikasi');
    }

    public function listData()
    {
        $ck = DB::table('tbl_child_klasifikasi')->get();
        $no = 0;
        $data = array();
        foreach ($ck as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->sd1;
            $row[] = $list->sd2;
            $row[] = $list->sd3;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }
}
