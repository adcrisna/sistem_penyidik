@extends('layouts.penyidik')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('penyidik_home') }}"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ route('data_kasus') }}">Data Kasus</a></li>
            <li class="active">Detail Kasus</li>
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
                        <h3 class="box-title">Detail Kasus</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <form action="{{ route('update_kasus') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback">
                                <input type="hidden" name="id" readonly class="form-control"
                                    value="{{ $kasus->id_kasus }}" readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nomor Kasus</label>
                                <input type="text" name="id_kasus" class="form-control" value="{{ $kasus->id_kasus }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Tanggal </label>
                                <input type="date" name="tgl_kasus" class="form-control"
                                    value="{{ $kasus->tanggal_kasus }}" required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Surat Perintah </label>
                                <iframe src="{{ asset('uploads/' . $kasus->surat_perintah) }}" align="top"
                                    height="300" width="100%" frameborder="0" scrolling="auto"></iframe>
                                <br>
                                <input type="hidden" name="lampiran_lama" class="form-control"
                                    value="{{ $kasus->surat_perintah }}">
                                <input type="file" name="lampiran" class="form-control" id="lampiran">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Penyidik</label>
                                <input type="text" name="penyidik" class="form-control" value="{{ $kasus->penyidik }}"
                                    readonly>
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
