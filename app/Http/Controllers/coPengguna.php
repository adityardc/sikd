<?php

// ==================================================================================
// *   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
// *   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
// *   
// *   :: plz..don't remove this text if u are "the real open-sourcer" ::
// ====================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Hash;
use Redirect;
use Validator;

class coPengguna extends Controller
{
    public function index()
    {
    	return view('mod_pengguna/index_pengguna');
    }

    public function listData()
    {
        $pengguna = DB::table('users')->join('tbl_hakakses', 'users.id_role', '=', 'tbl_hakakses.id_hakakses')->join('tbl_bagian', 'users.id_bagian', '=', 'tbl_bagian.id_bagian')->get();
        $no = 0;
        $data = array();
        foreach ($pengguna as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->name;
            $row[] = $list->email;
            $row[] = $list->nama_bagian;
            $row[] = $list->nama_hakakses;
            $row[] = "<a href='pengguna/".$list->id."/edit' class='btn btn-default btn-xs shiny icon-only magenta tooltip-magenta' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>
            <a href='pengguna/".$list->id."/resetpassword' class='btn btn-default btn-xs shiny icon-only magenta tooltip-magenta' data-toggle='tooltip' data-placement='top' data-original-title='Reset Password'><i class='fa fa-eye'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $karyawan = DB::table('tbl_karyawan')->orderBy('nama_karyawan')->get();
        $role = DB::table('tbl_hakakses')->get();
        $url = url('pengguna/store');
        return view('mod_pengguna/tambah_pengguna', compact(['url','karyawan','role']));
    }

    public function store(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'karyawan' => 'unique:users,id_karyawan'
        ]);

        if($validation->fails()){
            $data = DB::table('users')->where('id_karyawan', $request->karyawan)->first();
            return Redirect::to('pengguna/create')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Gagal !</strong> Akun karyawan <strong>".$data->name."</strong> sudah terdaftar.
        </div>");
        }else{
            $detailKaryawan = DB::table('tbl_karyawan')
                                ->select('tbl_karyawan.*','tbl_bagian.grup_bagian')
                                ->join('tbl_bagian','tbl_karyawan.id_bagian','=','tbl_bagian.id_bagian')
                                ->where('tbl_karyawan.id_karyawan', $request->karyawan)->first();

            DB::table('users')->insert([
                'name' => $detailKaryawan->nama_karyawan,
                'email' => $detailKaryawan->email,
                'password' => Hash::make("ptpn9jaya"),
                'id_role' => $request->role,
                'id_karyawan' => $request->karyawan,
                'id_bagian' => $detailKaryawan->id_bagian,
                'status_pengguna' => $request->status_pengguna,
                'grup_bagian' => $detailKaryawan->grup_bagian,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            return Redirect::to('pengguna/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Akun karyawan <strong>".$detailKaryawan->nama_karyawan."</strong> berhasil di daftarkan.
        </div>");
        }
    }

    public function edit($id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        $url = url('pengguna/'.$id.'/update');
        $role = DB::table('tbl_hakakses')->get();
        return view('mod_pengguna/ubah_pengguna', compact(['data','url','role']));
    }

    public function resetpassword($id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        $url = url('pengguna/'.$id.'/updatepassword');
        $role = DB::table('tbl_hakakses')->get();
        return view('mod_pengguna/reset_password_pengguna', compact(['data','url','role']));
    }

    public function update(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
        	'id_role' => $request->role,
            'status_pengguna' => $request->status_pengguna,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        $data = DB::table('users')->where('id', $id)->first();
        
        return Redirect::to('pengguna')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Akun <strong>".$data->name."</strong> berhasil disimpan.
        </div>");
    }

    public function updatepassword(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'password' => Hash::make("ptpn9jaya"),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        $data = DB::table('users')->where('id', $id)->first();
        
        return Redirect::to('pengguna')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Password Akun <strong>".$data->name."</strong> berhasil direset.
        </div>");
    }
}
