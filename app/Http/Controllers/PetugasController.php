<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\BarangBukti;
use App\Models\Penyerahan;
use App\Models\Kasus;
use App\Models\History;
use DB;

class PetugasController extends Controller
{
    public function index(){
        $data['title'] = "Dashboard";
        return view('Petugas/home',$data);
    }

    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }

    public function data_bukti()
    {
        $data['title'] = "Data Barang Bukti";
        $data['bukti'] = BarangBukti::get();
        $data['kasus'] = Kasus::get();
        return view('Petugas/barangBukti',$data);
    }
    public function tambah_bukti(Request $request)
    {
            $namalampiran = "Bukti"."  ".$request->noKasus." ".date("Y-m-d H-i-s");
            $extention = $request->file('lampiran')->extension();
            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
            $destination = base_path() .'/public/uploads';
            $request->file('lampiran')->move($destination,$lampiran);
            $bukti=array(
                    'id_kasus'=> $request->noKasus,
                    'jenis_barbuk' => $request->jenis,
                    'foto_barbuk'=> $lampiran,
                    'kondisi_barbuk' => $request->kondisi,
                    'jumlah_barbuk' => $request->jumlah,
                    'status' => 'Diproses',
                    'kota' => $request->kota,
                    'latitude' => $request->lat,
                    'longitude' => $request->lng,
                );
                BarangBukti::insert($bukti);

                $history = new History;
                $history->id_kasus = $request->noKasus;
                $history->status = 'Barang Bukti Kasus Ditambahkan';
                $history->save();

                \Session::flash('msg_simpan_data','Bukti Berhasil Ditambah!');
                return \Redirect::back();
    }
    public function delete_bukti($id)
    {
        $data = BarangBukti::where('id_barang_bukti','=',$id);
			$query = $data->first();
			if(\File::exists(public_path('uploads/'.$query->foto_barbuk))){
				\File::delete(public_path('uploads/'.$query->foto_barbuk));
			}else{
			    \Session::flash('msg_gagal_foto','Gagal Hapus Foto!');
                 return Redirect::route('data_bukti');
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Bukti Berhasil Dihapus!');
			return \Redirect::back();
    }
    public function proses_bukti($id)
    {
            $data=array(
                'status' => 'Diserahkan',
            );
            $bukti = BarangBukti::where('id_barang_bukti','=',$id)->first();
            BarangBukti::where('id_barang_bukti','=',$id)->update($data);
            $penyerahan=array(
                'id_barang_bukti' => $bukti->id_barang_bukti,
                'id_kasus' => $bukti->id_kasus,
                'petugas' => Auth::User()->nama,
                'tgl_penyerahan' => date('Y-m-d'),
                'foto_barang_bukti' => $bukti->foto_barbuk,
            );
            Penyerahan::insert($penyerahan);

            $history = new History;
            $history->id_kasus = $bukti->id_kasus;
            $history->status = 'Barang Bukti Kasus Diproses';
            $history->save();

            \Session::flash('msg_update_data','Data Kasus Berhasil di Update!');
            return \Redirect::route('data_bukti');
    }
    public function profile_petugas()
    {
        $data['title'] = "Profile";
        $id = Auth::user()->id;
        $data['petugas'] = User::where('id','=',$id)->first();
        return view('Petugas/profile',$data);
    }
}
