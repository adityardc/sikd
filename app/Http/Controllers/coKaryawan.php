<?php

// ==================================================================================
// *   Web Analyst + Design + Develop by Aditya Rizky Dinna Cahya - Staf TI PT Perkebunan Nusantara IX
// *   Project : Sistem Informasi Kesekretariatan - Surakarta, 01 April 2018
// *   
// *   :: plz..don't remove this text if u are "the real open-sourcer" ::
// ====================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use Storage;
use File;
use Validator;
use Redirect;
use Auth;

class coKaryawan extends Controller
{
    public function index()
    {
    	return view('mod_karyawan/index_karyawan');
    }

    public function listData()
    {
        $karyawan = DB::table('tbl_karyawan')
                    ->join('tbl_bagian', 'tbl_karyawan.id_bagian', '=', 'tbl_bagian.id_bagian')
                    ->join('tbl_jabatan', 'tbl_karyawan.id_jabatan', '=', 'tbl_jabatan.id_jabatan')
                    ->orderBy('id_karyawan')
                    ->get();
        $no = 0;
        $data = array();
        foreach ($karyawan as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = (($list->status_karyawan == 1) ? "<span class='badge badge-success tooltip-success' data-toggle='tooltip' data-placement='top' title='Status Aktif'><i class='menu-icon fa fa-check'></i></span> " : "<span class='badge badge-danger tooltip-danger' data-toggle='tooltip' data-placement='top' title='Status Non Aktif'><i class='menu-icon fa fa-close'></i></span> ").$list->nama_karyawan;
            $row[] = $list->nama_bagian;
            $row[] = $list->nama_jabatan;
            $row[] = "<a href='karyawan/".$list->id_karyawan."/edit' class='btn btn-default btn-xs shiny icon-only sky tooltip-sky' data-toggle='tooltip' data-placement='top' data-original-title='Ubah Data'><i class='fa fa-pencil'></i></a>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function create()
    {
        $url = url('karyawan/store');
        $bagian = DB::table('tbl_bagian')->where('status_bagian', 'Y')->orderBy('id_bagian')->get();
        $jbt = DB::table('tbl_jabatan')->where('status_jabatan', 'Y')->orderBy('id_jabatan')->get();
        $gol = DB::table('tbl_golongan')->where('status_golongan', 'Y')->orderBy('id_golongan')->get();
        $ddk = DB::table('tbl_pendidikan')->where('status_pendidikan', 'Y')->orderBy('id_pendidikan')->get();
        return view('mod_karyawan/tambah_karyawan', compact(['url','bagian','jbt','gol','ddk']));
    }

    public function store(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'email' => 'unique:users,email'
        ]);

        if($validation->fails()){
            return Redirect::to('karyawan/create')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Gagal !</strong> Alamat email <strong>".$request->email."</strong> sudah terdaftar.
        </div>")->withInput();
        }else{
            $extensionfile = $request->foto->getClientOriginalExtension();
            $email = preg_replace('/\./', '', $request->email);
            $fullEmail = $email.'.'.$extensionfile;
            Storage::disk('public')->put($fullEmail, File::get($request->foto));
            $url = Storage::url($fullEmail);

            DB::table('tbl_karyawan')->insert([
                'nama_karyawan' => $request->nama_karyawan,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_karyawan' => $request->tanggal_karyawan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'id_bagian' => $request->bagian,
                'id_jabatan' => $request->jabatan,
                'id_golongan' => $request->golongan,
                'id_pendidikan' => $request->pendidikan,
                'status_karyawan' => $request->status_karyawan,
                'status_konseptor' => $request->status_konseptor,
                'foto' => $url,
                'email' => $request->email,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            return Redirect::to('karyawan/create')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Karyawan <strong>".$request->nama_karyawan."</strong> berhasil disimpan.
        </div>");
        }
    }

    public function edit($id)
    {
        $data = DB::table('tbl_karyawan')->where('id_karyawan', $id)->first();
        $url = url('karyawan/'.$id.'/update');
        $bagian = DB::table('tbl_bagian')->where('status_bagian', 'Y')->orderBy('id_bagian')->get();
        $jbt = DB::table('tbl_jabatan')->where('status_jabatan', 'Y')->orderBy('id_jabatan')->get();
        $gol = DB::table('tbl_golongan')->where('status_golongan', 'Y')->orderBy('id_golongan')->get();
        $ddk = DB::table('tbl_pendidikan')->where('status_pendidikan', 'Y')->orderBy('id_pendidikan')->get();
        $foto = Storage::url($data->foto);
        return view('mod_karyawan/ubah_karyawan', compact(['data','url','bagian','jbt','gol','ddk','foto']));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make(request()->all(), [
            'email' => 'unique:users,email,'.Auth::user()->id.',id'
        ]);

        if($validation->fails()){
            return Redirect::to('karyawan')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Gagal !</strong> Alamat email <strong>".$request->email."</strong> sudah terdaftar.
        </div>")->withInput();
        }else{
            if(empty($request->foto)){
                DB::table('tbl_karyawan')->where('id_karyawan', $id)->update([
                    'nama_karyawan' => $request->nama_karyawan,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'tanggal_karyawan' => $request->tanggal_karyawan,
                    'email' => $request->email,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'id_bagian' => $request->bagian,
                    'id_jabatan' => $request->jabatan,
                    'id_golongan' => $request->golongan,
                    'id_pendidikan' => $request->pendidikan,
                    'status_konseptor' => $request->status_konseptor,
                    'status_karyawan' => $request->status_karyawan
                ]);

                DB::table('users')->where('id_karyawan', $id)->update([
                    'id_bagian' => $request->bagian,
                    'name' => $request->nama_karyawan,
                    'email' => $request->email,
                    'updated_at' => \Carbon\Carbon::now()
                ]);

                return Redirect::to('karyawan')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Karyawan <strong>".$request->nama_karyawan."</strong> berhasil disimpan.
        </div>")->withInput();
            }else{
                $data = DB::table('tbl_karyawan')->where('id_karyawan', $id)->first();
                Storage::delete($data->foto);
                $extensionfile = $request->foto->getClientOriginalExtension();
                $email = preg_replace('/\./', '', $request->email);
                $fullEmail = $email.'.'.$extensionfile;
                Storage::disk('public')->put($fullEmail, File::get($request->foto));
                $url = Storage::url($fullEmail);

                DB::table('tbl_karyawan')->where('id_karyawan', $id)->update([
                    'nama_karyawan' => $request->nama_karyawan,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'tanggal_karyawan' => $request->tanggal_karyawan,
                    'email' => $request->email,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'id_bagian' => $request->bagian,
                    'id_jabatan' => $request->jabatan,
                    'id_golongan' => $request->golongan,
                    'id_pendidikan' => $request->pendidikan,
                    'status_konseptor' => $request->status_konseptor,
                    'status_karyawan' => $request->status_karyawan,
                    'foto' => $url
                ]);

                DB::table('users')->where('id_karyawan', $id)->update([
                    'id_bagian' => $request->bagian,
                    'name' => $request->nama_karyawan,
                    'email' => $request->email,
                    'updated_at' => \Carbon\Carbon::now()
                ]);

                return Redirect::to('karyawan')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Karyawan <strong>".$request->nama_karyawan."</strong> berhasil disimpan.
        </div>")->withInput();
            }
        }
    }
}
