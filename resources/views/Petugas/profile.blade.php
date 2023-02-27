@extends('layouts.petugas')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('petugas_home') }}"><i class="fa fa-home"></i> Home</a></li>
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
                        <h3 class="box-title">Profile Petugas</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <form action="#" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback">
                                <input type="hidden" name="id" readonly class="form-control"
                                    value="{{ $petugas->id }}" readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nomor Induk Pegawai</label>
                                <input type="text" name="nip" class="form-control" value="{{ $petugas->nip }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nama </label>
                                <input type="text" name="nama" class="form-control" value="{{ $petugas->nama }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Jabatan </label>
                                <input type="text" name="jabatan" class="form-control" value="{{ $petugas->jabatan }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Username </label>
                                <input type="text" name="username" class="form-control" value="{{ $petugas->username }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Lampiran</label>
                                <iframe src="{{ asset('uploads/' . $petugas->lampiran) }}" align="top" height="300"
                                    width="100%" frameborder="0" scrolling="auto"></iframe>
                                <br>
                                {{-- <input type="text" name="lampiran" class="form-control"
                                    value="{{ $penyidik->lampiran }}" readonly> --}}
                            </div>
                            <div class="form-group has-feedback">
                                <label>Status</label>
                                <input type="text" name="status" class="form-control" value="{{ $petugas->status }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" cols="10" rows="5" readonly>{{ $petugas->alamat }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-xs-2 col-xs-offset-5">
                                    {{-- <button type="submit" class="btn btn-primary btn-block btn-flat">Ubah Data</button> --}}
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
