<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kasus;
use App\Models\BarangBukti;
use App\Models\Penyerahan;
use App\Models\Pengembalian;
use Auth;
use DB;
use Redirect;
use Codedge\Fpdf\Fpdf\Fpdf;

class PenyidikController extends Controller
{
    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf('P','mm');
    }

    public function index(){
        $data['title'] = "Dashboard";
        return view('Penyidik/home',$data);
    }

    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }
    public function profile()
    {
        $data['title'] = "Profile";
        $id = Auth::user()->id;
        $data['penyidik'] = User::where('id','=',$id)->first();
        return view('Penyidik/profile',$data);
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
                return Redirect::route('penyidik_profile');
           }else{
                $data=array(
                    'nama'=>$request->nama,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                    'no_hp' => $request->no_hp
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('penyidik_profile');
           }
    }
    public function data_petugas()
    {
        $data['title'] = "Data Petugas";
        $data['petugas'] = User::where('jabatan','=','Petugas')->get();
        return view('Penyidik/petugas',$data);
    }
    public function tambah_petugas(Request $request)
    {
        
            $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
            $extention = $request->file('lampiran')->extension();
            $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
            $destination = base_path() .'/public/uploads';
            $request->file('lampiran')->move($destination,$lampiran);

            $namalampiran1 = "Foto Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                    'jabatan'=> 'Petugas',
                    'lampiran' =>$lampiran,
                    'foto_user' =>$foto,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                \Session::flash('msg_simpan_data','Petugas Berhasil Ditambah!');
                return \Redirect::back();
          
    }
    public function update_petugas(Request $request)
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
                            'jabatan'=> 'Petugas',
                            'updated_at' => date('Y-m-d H:i:s')
                        );
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
                        'jabatan'=> 'Petugas',
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_petugas');
                    }
                }else{
                    $namafoto = "Foto Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                            'jabatan'=> 'Petugas',
                            'foto_user' =>$foto,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
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
                        'jabatan'=> 'Petugas',
                        'foto_user' =>$foto,
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    User::where('id','=',$request->id)->update($data);
                    \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                    return Redirect::route('data_petugas');
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
                            'jabatan'=> 'Petugas',
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

                            $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                        'jabatan'=> 'Petugas',
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

                            $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                    $namafoto = "Foto Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                            'jabatan'=> 'Petugas',
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

                            $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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

                            $namalampiran1 = "Foto Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
                        'jabatan'=> 'Petugas',
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

                            $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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

                            $namalampiran1 = "Foto Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
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
    public function delete_petugas($id)
    {
            $data = User::where('id','=',$id);
			$query = $data->first();
			if(\File::exists(public_path('uploads/'.$query->lampiran)) || \File::exists(public_path('uploads/'.$query->foto_user))){
				\File::delete(public_path('uploads/'.$query->lampiran));
                \File::delete(public_path('uploads/'.$query->foto_user));
			}else{
			    \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                 return Redirect::route('data_petugas');
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Petugas Berhasil Dihapus!');
			return \Redirect::back();
    }
    public function print_petugas()
    {
        // $image = asset('bnn.png');
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetTitle("Laporan Data Petugas");
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->addPage('L','A4');
        $this->fpdf->Image('bnn.png',15,9,32);
        $this->fpdf->setX(80);
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"BADAN NARKOTIKA NASIONAL REPUBLIK INDONESIA",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"PROVINSI KALIMANTAN SELATAN",0,2,'C');
		$this->fpdf->SetFont('Helvetica','','11');
		$this->fpdf->cell(135,6,"Jalan Mayjen Jl. D. I. Panjaitan No.41,Banjarmasin",0,2,'C');
        $this->fpdf->cell(135,6,"Telepon (21) 8087-1566 | (21) 8087-1567",0,2,'C');
        $this->fpdf->cell(135,6,"e-mail : bnnpkalsel@gmail.com",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','12');
		$this->fpdf->cell(135,6,"",0,2,'C');
		$this->fpdf->line(10,($this->fpdf->getY()+3),285,($this->fpdf->getY()+3));
        $this->fpdf->line(10,($this->fpdf->getY()+4),285,($this->fpdf->getY()+4));
		$this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'Nomor Induk',1,0,'C');
			$this->fpdf->cell(45,6,'Nama',1,0,'C');
			$this->fpdf->cell(40,6,'Jabatan',1,0,'C');
            $this->fpdf->cell(80,6,'Alamat',1,0,'C');
            $this->fpdf->cell(40,6,'No HP',1,0,'C');
			$this->fpdf->cell(35,6,'Status',1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
            $petugas = User::where('jabatan','Petugas')->get();
            foreach ($petugas as $key => $value) {
					$this->fpdf->cell(35,6,$value->nip,1,0,'C');
					$this->fpdf->cell(45,6,$value->nama,1,0,'C');
					$this->fpdf->cell(40,6,$value->jabatan,1,0,'C');
                    $this->fpdf->cell(80,6,$value->alamat,1,0,'C');
                    $this->fpdf->cell(40,6,$value->no_hp,1,0,'C');
					$this->fpdf->cell(35,6,$value->status,1,0,'C');
					$this->fpdf->ln();
				}
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(108,6,'',0,0,'');
			$this->fpdf->cell(40,6,"Banjarmasin, ".date('d-M-Y'),0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(93,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Kepala Badan Narkotika Nasional',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(102,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Provinsi Kalimantan Selatan,',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(97,6,'',0,0,'');
            $this->fpdf->cell(40,6,'WISNU ANDAYANA, S.S.T.,Mk',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
        $this->fpdf->Output('data_petugas_bnn_kalsel.pdf','I');
        exit;
    }

    public function data_kasus()
    {
        $data['title'] = "Data Kasus";
        $data['kasus'] = Kasus::get();
        return view('Penyidik/kasus',$data);
    }
    public function detail_kasus($id_kasus)
    {
        $data['title'] = "Data Kasus";
        $data['kasus'] = Kasus::where('id_kasus',$id_kasus)->first();
        return view('Penyidik/detail_kasus',$data);
    }
    public function tambah_kasus(Request $request)
    {
        // return $request->tgl_kasus;
        $namalampiran = "Surat Perintah"." ".date("Y-m-d H-i-s");
        $extention = $request->file('lampiran')->extension();
        $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
        $destination = base_path() .'/public/uploads';
        $request->file('lampiran')->move($destination,$lampiran);
        $kasus=array(
                'id_kasus'=> $request->id_kasus,
                'tanggal_kasus' => $request->tanggal,
                'surat_perintah'=> $lampiran,
                'penyidik' => Auth::User()->nama,
            );
            Kasus::insert($kasus);
             \Session::flash('msg_simpan_data','Petugas Berhasil Ditambah!');
            return \Redirect::back();
    }
    public function update_kasus(Request $request)
    {
        if (empty($request->lampiran)) {
            $data=array(
                    'tanggal_kasus' => $request->tgl_kasus,
                );
                Kasus::where('id_kasus','=',$request->id_kasus)->update($data);
                \Session::flash('msg_update_data','Data Petugas Berhasil di Update!');
                return Redirect::route('data_kasus');
        }else{
            $data=array(
                    'tanggal_kasus' => $request->tgl_kasus,
                );
                if ($request->file('lampiran')) 
                    {
                        if(\File::exists(public_path('uploads/'.$request->lampiran_lama))){
                            \File::delete(public_path('uploads/'.$request->lampiran_lama));
                        }else{
                            \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                            return Redirect::route('data_kasus');
                        }

                        $namalampiran = "Petugas"."  ".$request->nip." ".date("Y-m-d H-i-s");
                        $extention = $request->file('lampiran')->extension();
                        $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
                        $destination = base_path() .'/public/uploads';
                        $request->file('lampiran')->move($destination,$lampiran);
                        $data['lampiran'] = $lampiran;
                    }
                Kasus::where('id_kasus','=',$request->id_kasus)->update($data);
                \Session::flash('msg_update_data','Data Kasus Berhasil di Update!');
                return Redirect::route('data_kasus');
        }
    }
    public function delete_kasus($id_kasus)
    {
            $data = Kasus::where('id_kasus','=',$id_kasus);
			$query = $data->first();
			if(\File::exists(public_path('uploads/'.$query->surat_perintah))){
				\File::delete(public_path('uploads/'.$query->surat_perintah));
			}else{
			    \Session::flash('msg_gagal_foto','Gagal Hapus Foto!');
                 return Redirect::route('data_kasus');
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Kasus Berhasil Dihapus!');
			return \Redirect::back();
    }
    public function penyerahan_bukti()
    {
        $data['title'] = "Penyerahan Barang Bukti";
        $data['penyerahan'] = Penyerahan::join('barang_bukti','penyerahan.id_barang_bukti','barang_bukti.id_barang_bukti')->
        join('kasus','barang_bukti.id_kasus','kasus.id_kasus')->get();
        return view('Penyidik/bukti',$data);
    }
    public function pengembalian_bukti(Request $request)
    {
        $data=array(
            'status' => 'Dikembalikan',
        );
        $bukti = BarangBukti::where('id_barang_bukti','=',$request->id_barang_bukti)->first();
        BarangBukti::where('id_barang_bukti','=',$request->id_barang_bukti)->update($data);
        // $namalampiran = "Pengembalian"."  ".$request->noKasus." ".date("Y-m-d H-i-s");
        // $extention = $request->file('lampiran')->extension();
        // $lampiran = sprintf('%s.%0.8s', $namalampiran, $extention);
        // $destination = base_path() .'/public/uploads';
        // $request->file('lampiran')->move($destination,$lampiran);
        $pengembalian=array(
            'id_barang_bukti' => $request->id_barang_bukti,
            'penyidik' => Auth::User()->nama,
            'tgl_pengembalian' => $request->tanggal,
            // 'foto_pengembalian' => $lampiran,
            'keterangan' => $request->keterangan
        );
        Pengembalian::insert($pengembalian);
        \Session::flash('msg_update_data','Data Kasus Berhasil di Update!');
        return \Redirect::back();
    }
    public function selesai($id)
    {
        $data=array(
            'status' => 'Selesai',
        );
        BarangBukti::where('id_barang_bukti','=',$id)->update($data);
        \Session::flash('msg_update_data','Data Kasus Selesai!');
        return \Redirect::back();
    }

    public function data_pengembalian()
    {
        $data['title'] = "Pengembalian Barang Bukti";
        $data['pengembalian'] = Pengembalian::join('barang_bukti','pengembalian.id_barang_bukti','barang_bukti.id_barang_bukti')->
        join('kasus','barang_bukti.id_kasus','kasus.id_kasus')->get();
        return view('Penyidik/pengembalian',$data);
    }

    public function print_kasus()
    {
        // $image = asset('bnn.png');
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetTitle("Laporan Data Kasus");
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->addPage('P','A4');
        $this->fpdf->Image('bnn.png',10,9,30);
        $this->fpdf->setX(40);
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(150,6,"BADAN NARKOTIKA NASIONAL REPUBLIK INDONESIA",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(150,6,"PROVINSI KALIMANTAN SELATAN",0,2,'C');
		$this->fpdf->SetFont('Helvetica','','11');
		$this->fpdf->cell(150,6,"Jalan Mayjen Jl. D. I. Panjaitan No.41,Banjarmasin",0,2,'C');
        $this->fpdf->cell(150,6,"Telepon (21) 8087-1566 | (21) 8087-1567",0,2,'C');
        $this->fpdf->cell(150,6,"e-mail : bnnpkalsel@gmail.com",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','12');
		$this->fpdf->cell(135,6,"",0,2,'C');
		$this->fpdf->line(10,($this->fpdf->getY()+3),200,($this->fpdf->getY()+3));
        $this->fpdf->line(10,($this->fpdf->getY()+4),200,($this->fpdf->getY()+4));
		$this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'Nomor Kasus',1,0,'C');
			$this->fpdf->cell(40,6,'Tanggal Kasus',1,0,'C');
			$this->fpdf->cell(80,6,'Surat Perintah',1,0,'C');
            $this->fpdf->cell(35,6,'Penyidik',1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
            $kasus = Kasus::get();
            foreach ($kasus as $key => $value) {
					$this->fpdf->cell(35,6,$value->id_kasus,1,0,'C');
					$this->fpdf->cell(40,6,$value->tanggal_kasus,1,0,'C');
					$this->fpdf->cell(80,6,$value->surat_perintah,1,0,'C');
                    $this->fpdf->cell(35,6,$value->penyidik,1,0,'C');
					$this->fpdf->ln();
				}
            $this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(107,6,'',0,0,'');
            $this->fpdf->cell(80,6,"Banjarmasin, ".date('d-M-Y'),0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(92,6,'',0,0,'');
            $this->fpdf->cell(80,6,'Kepala Badan Narkotika Nasional',0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
            $this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(101,6,'',0,0,'');
            $this->fpdf->cell(80,6,'Provinsi Kalimantan Selatan,',0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(100,6,'',0,0,'');
            $this->fpdf->cell(80,6,'WISNU ANDAYANA, S.S.T.,Mk',0,0,'');
            $this->fpdf->cell(35,6,'',0,0,'');
        $this->fpdf->Output('data_kasus_bnn_kalsel.pdf','I');
        exit;
    }

    public function print_penyerahan()
    {
        // $image = asset('bnn.png');
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetTitle("Laporan Data Penyerahan Bukti");
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->addPage('L','A4');
        $this->fpdf->Image('bnn.png',15,9,32);
        $this->fpdf->setX(80);
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(150,6,"BADAN NARKOTIKA NASIONAL REPUBLIK INDONESIA",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(150,6,"PROVINSI KALIMANTAN SELATAN",0,2,'C');
		$this->fpdf->SetFont('Helvetica','','11');
		$this->fpdf->cell(150,6,"Jalan Mayjen Jl. D. I. Panjaitan No.41,Banjarmasin",0,2,'C');
        $this->fpdf->cell(150,6,"Telepon (21) 8087-1566 | (21) 8087-1567",0,2,'C');
        $this->fpdf->cell(150,6,"e-mail : bnnpkalsel@gmail.com",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','12');
		$this->fpdf->cell(135,6,"",0,2,'C');
		$this->fpdf->line(10,($this->fpdf->getY()+3),285,($this->fpdf->getY()+3));
        $this->fpdf->line(10,($this->fpdf->getY()+4),285,($this->fpdf->getY()+4));
		$this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'Nomor Kasus',1,0,'C');
			$this->fpdf->cell(45,6,'Tanggal',1,0,'C');
			$this->fpdf->cell(40,6,'Jenis',1,0,'C');
            $this->fpdf->cell(40,6,'Kondisi',1,0,'C');
            $this->fpdf->cell(40,6,'Jumlah',1,0,'C');
            $this->fpdf->cell(40,6,'Petugas',1,0,'C');
			$this->fpdf->cell(35,6,'Status',1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
            $penyerahan = Penyerahan::join('barang_bukti','penyerahan.id_barang_bukti','barang_bukti.id_barang_bukti')->
        join('kasus','barang_bukti.id_kasus','kasus.id_kasus')->get();
            foreach ($penyerahan as $key => $value) {
					$this->fpdf->cell(35,6,$value->id_kasus,1,0,'C');
					$this->fpdf->cell(45,6,$value->tgl_penyerahan,1,0,'C');
					$this->fpdf->cell(40,6,$value->jenis_barbuk,1,0,'C');
                    $this->fpdf->cell(40,6,$value->kondisi_barbuk,1,0,'C');
                    $this->fpdf->cell(40,6,$value->jumlah_barbuk,1,0,'C');
                    $this->fpdf->cell(40,6,$value->petugas,1,0,'C');
					$this->fpdf->cell(35,6,$value->status,1,0,'C');
					$this->fpdf->ln();
				}
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(108,6,'',0,0,'');
			$this->fpdf->cell(40,6,"Banjarmasin, ".date('d-M-Y'),0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(93,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Kepala Badan Narkotika Nasional',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(102,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Provinsi Kalimantan Selatan,',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(97,6,'',0,0,'');
            $this->fpdf->cell(40,6,'WISNU ANDAYANA, S.S.T.,Mk',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
        $this->fpdf->Output('data_penyerahan_bukti_bnn_kalsel.pdf','I');
        exit;
    }
    public function print_pengembalian()
    {
        // $image = asset('bnn.png');
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetTitle("Laporan Data Pengembalian Bukti");
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->addPage('L','A4');
        $this->fpdf->Image('bnn.png',15,9,32);
        $this->fpdf->setX(80);
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"BADAN NARKOTIKA NASIONAL REPUBLIK INDONESIA",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"PROVINSI KALIMANTAN SELATAN",0,2,'C');
		$this->fpdf->SetFont('Helvetica','','11');
		$this->fpdf->cell(135,6,"Jalan Mayjen Jl. D. I. Panjaitan No.41,Banjarmasin",0,2,'C');
        $this->fpdf->cell(135,6,"Telepon (21) 8087-1566 | (21) 8087-1567",0,2,'C');
        $this->fpdf->cell(135,6,"e-mail : bnnpkalsel@gmail.com",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','12');
		$this->fpdf->cell(135,6,"",0,2,'C');
		$this->fpdf->line(10,($this->fpdf->getY()+3),285,($this->fpdf->getY()+3));
        $this->fpdf->line(10,($this->fpdf->getY()+4),285,($this->fpdf->getY()+4));
		$this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'ID Pengembalian',1,0,'C');
			$this->fpdf->cell(45,6,'No Kasus',1,0,'C');
			$this->fpdf->cell(40,6,'Tanggal',1,0,'C');
            $this->fpdf->cell(80,6,'Keterangan',1,0,'C');
            $this->fpdf->cell(40,6,'Penyidik',1,0,'C');
			$this->fpdf->cell(35,6,'Status',1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
            $pengembalian = Pengembalian::join('barang_bukti','pengembalian.id_barang_bukti','barang_bukti.id_barang_bukti')->
        join('kasus','barang_bukti.id_kasus','kasus.id_kasus')->get();
            foreach ($pengembalian as $key => $value) {
					$this->fpdf->cell(35,6,$value->id_pengembalian,1,0,'C');
					$this->fpdf->cell(45,6,$value->id_kasus,1,0,'C');
					$this->fpdf->cell(40,6,$value->tgl_pengembalian,1,0,'C');
                    $this->fpdf->cell(80,6,$value->keterangan,1,0,'C');
                    $this->fpdf->cell(40,6,$value->penyidik,1,0,'C');
					$this->fpdf->cell(35,6,$value->status,1,0,'C');
					$this->fpdf->ln();
				}
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(108,6,'',0,0,'');
			$this->fpdf->cell(40,6,"Banjarmasin, ".date('d-M-Y'),0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(93,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Kepala Badan Narkotika Nasional',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
            $this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(102,6,'',0,0,'');
			$this->fpdf->cell(40,6,'Provinsi Kalimantan Selatan,',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->cell(65,6,'',0,0,'');
			$this->fpdf->cell(55,6,'',0,0,'');
            $this->fpdf->cell(97,6,'',0,0,'');
            $this->fpdf->cell(40,6,'WISNU ANDAYANA, S.S.T.,Mk',0,0,'');
			$this->fpdf->cell(40,6,'',0,0,'');
        $this->fpdf->Output('data_pengembalian_bukti_bnn_kalsel.pdf','I');
        exit;
    }
    public function edit_bukti(Request $request)
    {
        $data=array(
            'jenis_barbuk' => $request->jenis,
            'kondisi_barbuk' => $request->kondisi,
            'jumlah_barbuk' => $request->jumlah,
        );
        BarangBukti::where('id_barang_bukti','=',$request->id_barang_bukti)->update($data);
        \Session::flash('msg_update_data','Data Kasus Selesai!');
        return \Redirect::back();
    }
    public function print_profile()
    {
        // $image = asset('bnn.png');
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetTitle("Data Profile Penyidik");
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->addPage('P','A4');
        $this->fpdf->Image('bnn.png',10,9,30);
        $this->fpdf->setX(40);
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"BADAN NARKOTIKA NASIONAL REPUBLIK INDONESIA",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','13');
		$this->fpdf->cell(135,6,"PROVINSI KALIMANTAN SELATAN",0,2,'C');
		$this->fpdf->SetFont('Helvetica','','11');
		$this->fpdf->cell(135,6,"Jalan Mayjen Jl. D. I. Panjaitan No.41,Banjarmasin",0,2,'C');
        $this->fpdf->cell(135,6,"Telepon (21) 8087-1566 | (21) 8087-1567",0,2,'C');
        $this->fpdf->cell(135,6,"e-mail : bnnpkalsel@gmail.com",0,2,'C');
		$this->fpdf->SetFont('Helvetica','B','12');
		$this->fpdf->line(10,($this->fpdf->getY()+3),200,($this->fpdf->getY()+3));
        $this->fpdf->line(10,($this->fpdf->getY()+4),200,($this->fpdf->getY()+4));
		$this->fpdf->ln();
            $this->fpdf->ln();
            $user = User::where('id',Auth::user()->id)->first();
            $this->fpdf->cell(40,6,$this->fpdf->Image('uploads/'.$user->foto_user,90,50,25),0,0,'C');
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'Nomor Induk',1,0,'C');
			$this->fpdf->cell(40,6,'Nama',1,0,'C');
            $this->fpdf->cell(40,6,'Jabatan',1,0,'C');
			$this->fpdf->cell(40,6,'No Handphone',1,0,'C');
            $this->fpdf->cell(35,6,'Status',1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','','11');
            $this->fpdf->cell(35,6,$user->nip,1,0,'C');
			$this->fpdf->cell(40,6,$user->nama,1,0,'C');
            $this->fpdf->cell(40,6,$user->jabatan,1,0,'C');
			$this->fpdf->cell(40,6,$user->no_hp,1,0,'C');
            $this->fpdf->cell(35,6,$user->status,1,0,'C');
			$this->fpdf->SetFont('Helvetica','','11');
			$this->fpdf->ln();
        $this->fpdf->cell(135,6,"",0,2,'C');
		$this->fpdf->line(10,($this->fpdf->getY()+3),200,($this->fpdf->getY()+3));
		$this->fpdf->ln();
            $this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(107,6,'',0,0,'');
            $this->fpdf->cell(80,6,"Banjarmasin, ".date('d-M-Y'),0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->ln();
            $this->fpdf->SetFont('Helvetica','B','11');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(92,6,'',0,0,'');
            $this->fpdf->cell(80,6,'Kepala Badan Narkotika Nasional',0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
            $this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(101,6,'',0,0,'');
            $this->fpdf->cell(80,6,'Provinsi Kalimantan Selatan,',0,0,'');
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->ln();
			$this->fpdf->cell(35,6,'',0,0,'');
			$this->fpdf->cell(100,6,'',0,0,'');
            $this->fpdf->cell(80,6,'WISNU ANDAYANA, S.S.T.,Mk',0,0,'');
            $this->fpdf->cell(35,6,'',0,0,'');
        $this->fpdf->Output('profile_penyidik_bnn_kalsel.pdf','I');
        exit;
    }
}
