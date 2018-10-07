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
use Auth;
use Hash;
use Redirect;
use DataTables;
use Validator;
use Storage;
use File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bag = DB::table('tbl_bagian')->select('nama_bagian','kode_bagian')->where('id_bagian', Auth::user()->id_bagian)->first();
        $foto = DB::table('tbl_karyawan')->select('foto')->where('id_karyawan', Auth::user()->id_karyawan)->first();
        $ha = DB::table('tbl_hakakses')->select('nama_hakakses')->where('id_hakakses', Auth::user()->id_role)->first();
        $sk = DB::table('tbl_surat_keluar')->where('id_pembuat', Auth::user()->id)->count();
        $ksp = DB::table('tbl_surat_keluar')->where('id_konseptor', Auth::user()->id)->count();
        return view('home', compact(['bag','foto','ha','sk','ksp']));
    }

    public function ganti_password()
    {
        $id = Auth::user()->id;
        $url = url('ganti_password/'.$id.'/update_password');
        return view('ganti_password', compact(['id','url']));
    }

    public function update_password(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'password' => Hash::make($request->new_pwd_1),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        
        return Redirect::to('home')->with('message', 'Data berhasil diubah.');
    }

    public function forbidden()
    {
        return view('forbidden');
    }

    public function listKlasifikasi()
    {
        $klas = DB::table("tbl_klasifikasi")->select('id_klas','kode_klas','nama_klas')->get();
        $no = 0;
        $data = array();
        foreach ($klas as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->id_klas;
            $row[] = $list->kode_klas;
            $row[] = $list->nama_klas;
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function edit($id)
    {
        $data = DB::table('tbl_karyawan')->where('id_karyawan', $id)->first();
        $url = url('home/'.$id.'/update_profile');
        return view('update_profile', compact(['data','url']));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make(request()->all(), [
            'email' => 'unique:users,email,'.Auth::user()->id.',id'
        ]);

        if($validation->fails()){
            return Redirect::to('home')->with('status', "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Gagal !</strong> Alamat email <strong>".$request->email."</strong> sudah terdaftar.
        </div>")->withInput();
        }else{
            if(empty($request->file_suratkeluar)){
                DB::table('tbl_karyawan')->where('id_karyawan', $id)->update([
                    'email' => $request->email,
                ]);

                if($request->pass1 == ""){
                    DB::table('users')->where('id_karyawan', $id)->update([
                        'email' => $request->email,
                    ]);
                }else{
                    DB::table('users')->where('id_karyawan', $id)->update([
                        'email' => $request->email,
                        'password' => Hash::make($request->pass1),
                    ]);
                }

                return Redirect::to('home')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Username <strong>".$request->email."</strong> berhasil disimpan.
        </div>")->withInput();
            }else{
                $data = DB::table('tbl_karyawan')->where('id_karyawan', $id)->first();
                Storage::delete($data->foto);
                $extensionfile = $request->file_suratkeluar->getClientOriginalExtension();
                $email = preg_replace('/\./', '', $request->email);
                $fullEmail = $email.'.'.$extensionfile;
                Storage::disk('public')->put($fullEmail, File::get($request->file_suratkeluar));
                $url = Storage::url($fullEmail);

                DB::table('tbl_karyawan')->where('id_karyawan', $id)->update([
                    'email' => $request->email,
                ]);

                if($request->pass1 == ""){
                    DB::table('users')->where('id_karyawan', $id)->update([
                        'email' => $request->email,
                    ]);
                }else{
                    DB::table('users')->where('id_karyawan', $id)->update([
                        'email' => $request->email,
                        'password' => Hash::make($request->pass1),
                    ]);
                }

                return Redirect::to('home')->with('status', "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <strong>Sukses !</strong> Username <strong>".$request->email."</strong> berhasil disimpan.
        </div>")->withInput();
            }
        }
    }
}
