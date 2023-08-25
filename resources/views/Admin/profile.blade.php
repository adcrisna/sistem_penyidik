@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
    <br />
    <br />
    <section class="content">
        @if (\Session::has('msg_update_profile'))
            <h5>
                <div class="alert alert-warning">
                    {{ \Session::get('msg_update_profile') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Profile Penyidik</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('print_profile') }}" class="btn btn-warning btn-xs"><i
                                    class="fa fa-print"></i>
                                Print</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <form action="{{ route('update_admin') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback">
                                <input type="hidden" name="id" readonly class="form-control"
                                    value="{{ $penyidik->id }}" readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nomor Induk Pegawai</label>
                                <input type="text" name="nip" class="form-control" value="{{ $penyidik->nip }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nama </label>
                                <input type="text" name="nama" class="form-control" value="{{ $penyidik->nama }}"
                                    required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>No HP </label>
                                <input type="text" name="no_hp" class="form-control" value="{{ $penyidik->no_hp }}"
                                    required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Jabatan </label>
                                <input type="text" name="jabatan" class="form-control" value="{{ $penyidik->jabatan }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Username </label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ $penyidik->username }}" readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Password </label>
                                <input type="password" name="password" class="form-control"
                                    placeholder=" Masukan Password Baru">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Foto</label>
                                <img src="{{ asset('uploads/' . $penyidik->foto_user) }}" width="200px" height="150px"
                                    class="zoom">
                                <br>
                                {{-- <input type="text" name="lampiran" class="form-control"
                                    value="{{ $penyidik->lampiran }}" readonly> --}}
                            </div>
                            <div class="form-group has-feedback">
                                <label>Lampiran</label>
                                <iframe src="{{ asset('uploads/' . $penyidik->lampiran) }}" align="top" height="300"
                                    width="100%" frameborder="0" scrolling="auto"></iframe>
                                <br>
                                {{-- <input type="text" name="lampiran" class="form-control"
                                    value="{{ $penyidik->lampiran }}" readonly> --}}
                            </div>
                            <div class="form-group has-feedback">
                                <label>Status</label>
                                <input type="text" name="status" class="form-control" value="{{ $penyidik->status }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" cols="10" rows="5">{{ $penyidik->alamat }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-xs-2 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ubah Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br />
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/raphael/raphael-min.js') }}"></script>
@endsection
