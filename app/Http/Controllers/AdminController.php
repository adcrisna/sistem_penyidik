<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kasus;
use App\Models\BarangBukti;
use App\Models\Penyerahan;
use App\Models\Pengembalian;
use App\Models\History;
use Auth;
use DB;
use Redirect;
use Codedge\Fpdf\Fpdf\Fpdf;

class AdminController extends Controller
{
    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf('P','mm');
    }

    public function index(){
        $data['title'] = "Dashboard";
        $data['kabupatenBalangan'] = BarangBukti::where('kota','Kabupaten Balangan')->get();
        $data['kabupatenBanjar'] = BarangBukti::where('kota','Kabupaten Banjar')->get();
        $data['kabupatenBaritoKuala'] = BarangBukti::where('kota','Kabupaten Barito Kuala')->get();
        $data['kabupatenHuluSungaiSelatan'] = BarangBukti::where('kota','Kabupaten Hulu Sungai Selatan')->get();
        $data['kabupatenHuluSungaiTengah'] = BarangBukti::where('kota','Kabupaten Hulu Sungai Tengah')->get();
        $data['kabupatenHuluSungaiUtara'] = BarangBukti::where('kota','Kabupaten Hulu Sungai Utara')->get();
        $data['kabupatenKotabaru'] = BarangBukti::where('kota','Kabupaten Kotabaru')->get();
        $data['kabupatenTabalong'] = BarangBukti::where('kota','Kabupaten Tabalong')->get();
        $data['kabupatenTanahBumbu'] = BarangBukti::where('kota','Kabupaten Tanah Bumbu')->get();
        $data['kabupatenTanahLaut'] = BarangBukti::where('kota','Kabupaten Tanah Laut')->get();
        $data['kabupatenTapin'] = BarangBukti::where('kota','Kabupaten Tapin')->get();
        $data['kotaBanjarbaru'] = BarangBukti::where('kota','Kota Banjarbaru')->get();
        $data['kotaBanjarmasin'] = BarangBukti::where('kota','Kota Banjarmasin')->get();
        $data['barangBukti'] = BarangBukti::all();
        return view('Admin/home',$data);
    }
    public function profile()
    {
        $data['title'] = "Profile";
        $id = Auth::user()->id;
        $data['penyidik'] = User::where('id','=',$id)->first();
        return view('Admin/profile',$data);
    }
    public function update_profile(Request $request)
    {
        if (empty($request->password)) {
                $data=array(
                    'nama'=>$request->nama,
                    'alamat'=>$request->alamat,
                    'no_hp' => $request->no_hp
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('admin_profile');
           }else{
                $data=array(
                    'nama'=>$request->nama,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                    'no_hp' => $request->no_hp
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('admin_profile');
           }
    }
    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }
    public function data_user()
    {
        $data['title'] = "Data Users";
        $data['users'] = User::where('jabatan','!=','Admin')->get();
        return view('Admin/users',$data);
    }
    public function tambah_user(Request $request)
    {
        
            $namalampiran = $request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
            $extention = $request->file('lampiran')->extension();
            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
            $destination = base_path() .'/public/uploads';
            $request->file('lampiran')->move($destination,$lampiran);

            $namalampiran1 = "Foto ".$request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
            $extention1 = $request->file('foto')->extension();
            $foto = sprintf('%s.%0.8s', $namalampiran1, $extention1);
            $destination1 = base_path() .'/public/uploads';
            $request->file('foto')->move($destination1,$foto);
            $user = User::create([
                    'nip'=> $request->nip,
                    'nama' => $request->nama,
                    'username'=> $request->username,
                    'no_hp'=> $request->no_hp,
                    'status' => 'Aktif',
                    'password'=> bcrypt($request->password),
                    'alamat' => $request->alamat,
                    'jabatan'=> $request->jabatan,
                    'lampiran' =>$lampiran,
                    'foto_user' =>$foto,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                \Session::flash('msg_simpan_data','Petugas Berhasil Ditambah!');
                return \Redirect::back();
          
    }
    public function update_user(Request $request)
    {
 
            if (empty($request->lampiran)) {
                if (empty($request->foto)) {
                    if (empty($request->password)) {
                        $data=array(
                            'nip' => $request->nip,
                            'nama' => $request->nama,
                            'no_hp' => $request->no_hp,
                            'username'=> $request->username,
                            'status' => $request->status,
                            'alamat' => $request->alamat,
                            'jabatan'=> $request->jabatan,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        User::where('id','=',$request->id)->update($data);
                        \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                        return Redirect::route('data_user');
                    }else{
                        $data=array(
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'username'=> $request->username,
                        'no_hp' => $request->no_hp,
                        'status' => $request->status,
                        'password'=> bcrypt($request->password),
                        'alamat' => $request->alamat,
                        'jabatan'=> $request->jabatan,
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_user');
                    }
                }else{
                    $namafoto = "Foto ".$request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                    $extention1 = $request->file('foto')->extension();
                    $foto = sprintf('%s.%0.8s', $namafoto, $extention1);
                    $destination1 = base_path() .'/public/uploads';
                    $request->file('foto')->move($destination1,$foto);
                    if (empty($request->password)) {
                        $data=array(
                            'nip' => $request->nip,
                            'nama' => $request->nama,
                            'no_hp' => $request->no_hp,
                            'username'=> $request->username,
                            'status' => $request->status,
                            'alamat' => $request->alamat,
                            'jabatan'=> $request->jabatan,
                            'foto_user' =>$foto,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        User::where('id','=',$request->id)->update($data);
                        \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                        return Redirect::route('data_user');
                    }else{
                        $data=array(
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'username'=> $request->username,
                        'no_hp' => $request->no_hp,
                        'status' => $request->status,
                        'password'=> bcrypt($request->password),
                        'alamat' => $request->alamat,
                        'jabatan'=> $request->jabatan,
                        'foto_user' =>$foto,
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_user');
                    }
                }
            }else {
                if (empty($request->foto)) {
                    if (empty($request->password)) {
                        $data=array(
                            'nip' => $request->nip,
                            'nama' => $request->nama,
                            'no_hp' => $request->no_hp,
                            'username'=> $request->username,
                            'status' => $request->status,
                            'alamat' => $request->alamat,
                            'jabatan'=> $request->jabatan,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        if ($request->file('lampiran')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->lampiran_lama))){
                                \File::delete(public_path('uploads/'.$request->lampiran_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran = $request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention = $request->file('lampiran')->extension();
                            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
                            $destination = base_path() .'/public/uploads';
                            $request->file('lampiran')->move($destination,$lampiran);
                            $data['lampiran'] = $lampiran;
                        }
                        User::where('id','=',$request->id)->update($data);
                        \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                        return Redirect::route('data_petugas');
                    }else{
                        $data=array(
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'username'=> $request->username,
                        'no_hp' => $request->no_hp,
                        'status' => $request->status,
                        'password'=> bcrypt($request->password),
                        'alamat' => $request->alamat,
                        'jabatan'=> $request->jabatan,
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($request->file('lampiran')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->lampiran_lama))){
                                \File::delete(public_path('uploads/'.$request->lampiran_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran = $request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention = $request->file('lampiran')->extension();
                            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
                            $destination = base_path() .'/public/uploads';
                            $request->file('lampiran')->move($destination,$lampiran);
                            $data['lampiran'] = $lampiran;
                        }
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_petugas');
                    }
                }else{
                    $namafoto = "Foto ".$request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                    $extention1 = $request->file('foto')->extension();
                    $foto = sprintf('%s.%0.8s', $namafoto, $extention1);
                    $destination1 = base_path() .'/public/uploads';
                    $request->file('foto')->move($destination1,$foto);
                    if (empty($request->password)) {
                        $data=array(
                            'nip' => $request->nip,
                            'nama' => $request->nama,
                            'no_hp' => $request->no_hp,
                            'username'=> $request->username,
                            'status' => $request->status,
                            'alamat' => $request->alamat,
                            'jabatan'=> $request->jabatan,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        if ($request->file('lampiran')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->lampiran_lama))){
                                \File::delete(public_path('uploads/'.$request->lampiran_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran = $request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention = $request->file('lampiran')->extension();
                            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
                            $destination = base_path() .'/public/uploads';
                            $request->file('lampiran')->move($destination,$lampiran);
                            $data['lampiran'] = $lampiran;
                        }
                        if ($request->file('foto')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->foto_lama))){
                                \File::delete(public_path('uploads/'.$request->foto_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran1 = "Foto ".$request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention1 = $request->file('foto')->extension();
                            $foto = sprintf('%s.%0.8s', $namalampiran1, $extention1);
                            $destination1 = base_path() .'/public/uploads';
                            $request->file('foto')->move($destination1,$foto);
                            $data['foto_user'] = $foto;
                        }
                        User::where('id','=',$request->id)->update($data);
                        \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                        return Redirect::route('data_petugas');
                    }else{
                        $data=array(
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'username'=> $request->username,
                        'no_hp' => $request->no_hp,
                        'status' => $request->status,
                        'password'=> bcrypt($request->password),
                        'alamat' => $request->alamat,
                        'jabatan'=> $request->jabatan,
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($request->file('lampiran')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->lampiran_lama))){
                                \File::delete(public_path('uploads/'.$request->lampiran_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran = $request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention = $request->file('lampiran')->extension();
                            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
                            $destination = base_path() .'/public/uploads';
                            $request->file('lampiran')->move($destination,$lampiran);
                            $data['lampiran'] = $lampiran;
                        }
                        if ($request->file('foto')) 
                        {
                            if(\File::exists(public_path('uploads/'.$request->foto_lama))){
                                \File::delete(public_path('uploads/'.$request->foto_lama));
                            }else{
                                \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                                return Redirect::route('data_petugas');
                            }

                            $namalampiran1 = "Foto ".$request->jabatan."  ".$request->nip." ".date("Y-m-d H-i-s");
                            $extention1 = $request->file('foto')->extension();
                            $foto = sprintf('%s.%0.8s', $namalampiran1, $extention1);
                            $destination1 = base_path() .'/public/uploads';
                            $request->file('foto')->move($destination1,$foto);
                            $data['foto_user'] = $foto;
                        }
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_petugas');
                    }
                }
            }
    }
    public function delete_user($id)
    {
            $data = User::where('id','=',$id);
			$query = $data->first();
			if(\File::exists(public_path('uploads/'.$query->lampiran)) || \File::exists(public_path('uploads/'.$query->foto_user))){
				\File::delete(public_path('uploads/'.$query->lampiran));
                \File::delete(public_path('uploads/'.$query->foto_user));
			}else{
			    \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                 return Redirect::route('data_user');
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Petugas Berhasil Dihapus!');
			return \Redirect::back();
    }
    public function kasus()
    {
        $data['title'] = "Data Kasus";
        $data['kasus'] = Kasus::get();
        return view('Admin/kasus',$data);
    }
    public function bukti()
    {
        $data['title'] = "Penyerahan Barang Bukti";
        $data['penyerahan'] = Penyerahan::join('barang_bukti','penyerahan.id_barang_bukti','barang_bukti.id_barang_bukti')->
        join('kasus','barang_bukti.id_kasus','kasus.id_kasus')->get();
        return view('Admin/bukti',$data);
    }
    function data_history(){
        $data['title'] = "Data History";
        $data['history'] = History::all();
        return view('Admin/history',$data);
    }
    function data_selesai() {
        $data['title'] = "Data History";
        $data['selesai'] = Penyerahan::where('status_barbuk', 'Dimusnahkan')->get();
        return view('Admin/selesai',$data);
    }
}
