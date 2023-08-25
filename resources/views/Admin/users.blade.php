@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        img.zoom {
            width: 130px;
            height: 100px;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
        }

        .transisi {
            -webkit-transform: scale(1.8);
            -moz-transform: scale(1.8);
            -o-transform: scale(1.8);
            transform: scale(1.8);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('penyidik_home') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Petugas</li>
        </ol>
        <br />
    </section>
    <section class="content">
        @if (\Session::has('msg_simpan_data'))
            <h5>
                <div class="alert alert-info">
                    {{ \Session::get('msg_simpan_data') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_hapus_data'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_hapus_data') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_update_data'))
            <h5>
                <div class="alert alert-warning">
                    {{ \Session::get('msg_update_data') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_gagal'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_gagal') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_gagal_foto'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_gagal_foto') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Data Petugas</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('print_petugas') }}" class="btn btn-warning btn-xs"><i
                                    class="fa fa-print"></i> Print</a>
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                data-target="#modal-form-tambah-karyawan"><i class="fa fa-user-plus"> Tambah Data Petugas
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-karyawan">
                            <thead>
                                <tr>
                                    <th style="display: none;" width="10">ID</th>
                                    <th>Nomor Induk</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th style="display: none;">Username</th>
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th style="display: none;">Lampiran</th>
                                    <th style="display: none;">Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$users as $key => $value)
                                    <tr>
                                        <td style="display: none;">{{ $value->id }}</td>
                                        <td>{{ @$value->nip }}</td>
                                        <td><img src="{{ asset('uploads/' . $value->foto_user) }}" class="zoom"></td>
                                        <td>{{ @$value->nama }}</td>
                                        <td>{{ @$value->no_hp }}</td>
                                        <td style="display: none;">{{ @$value->username }}</td>
                                        <td>{{ @$value->alamat }}</td>
                                        <td>{{ @$value->jabatan }}</td>
                                        <td>{{ @$value->status }}</td>
                                        <td style="display: none;">{{ $value->lampiran }}</td>
                                        <td style="display: none;">{{ $value->foto_user }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-success btn-edit-karyawan"><i class="fa fa-edit">
                                                    Detail</i></button> &nbsp;
                                            <a href="{{ route('delete_user', $value->id) }}"><button
                                                    class=" btn btn-xs btn-danger"
                                                    onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                        class="fa fa-trash"> Hapus</i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-form-tambah-karyawan" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Petugas</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_user') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label for="alamat">Nomor Induk:</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Nama Lengkap:</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Petugas" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">No HP :</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="No HP/WA Petugas"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Username:</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan Password"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="jabatan">Jabatan:</label>
                            <select name="jabatan" id="jabatan" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                <option value="Penyidik">Penyidik</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Alamat:</label>
                            <textarea name="alamat" cols="5" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Foto :</label>
                            <input type="file" name="foto" class="form-control" id="foto" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Lampiran :</label>
                            <input type="file" name="lampiran" class="form-control" id="lampiran" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-form-edit-karyawan" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Update Petugas</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_user') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID ">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Nomor Induk :</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Nama Lengkap :</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Petugas"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">No HP :</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="No HP/WA Petugas"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Username:</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="jabatan">Jabatan:</label>
                            <select name="jabatan" id="jabatan" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                <option value="Penyidik">Penyidik</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Password Baru:</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukan Password Baru">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="alamat">Alamat:</label>
                            <textarea name="alamat" cols="5" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Foto Baru:</label>
                            <input type="text" name="foto_lama" class="form-control" id="foto_lama">
                            <input type="file" name="foto" class="form-control" id="foto">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Lampiran Baru:</label>
                            {{-- <iframe src="{{ asset('uploads/' . $penyidik->lampiran) }}" align="top" height="300"
                                width="100%" frameborder="0" scrolling="auto"></iframe>
                            <br> --}}
                            <input type="hidden" name="lampiran_lama" class="form-control" id="lampiran_lama">
                            <input type="file" name="lampiran" class="form-control" id="lampiran">
                        </div>
                        <div lass="form-group has-feedback">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-karyawan').DataTable();

        $('#data-karyawan').on('click', '.btn-edit-karyawan', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=nip]').val(row[1]);
            $('input[name=nama]').val(row[3]);
            $('input[name=no_hp]').val(row[4]);
            $('input[name=username]').val(row[5]);
            $('textarea[name=alamat]').val(row[6]);
            $('select[name=jabatan]').val(row[7]);
            $('select[name=status]').val(row[8]);
            $('input[name=lampiran_lama]').val(row[9]);
            $('input[name=foto_lama]').val(row[10]);
            $('#modal-form-edit-karyawan').modal('show');
        });
        $('#modal-form-tambah-karyawan').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=nip]').val('');
            $('input[name=nama]').val('');
            $('input[name=no_hp]').val('');
            $('input[name=username]').val('');
            $('select[name=jabatan]').val('');
            $('input[name=status]').val('');
            $('textarea[name=alamat]').val('');
        });

        $(document).ready(function() {
            $('.zoom').hover(function() {
                $(this).addClass('transisi');
            }, function() {
                $(this).removeClass('transisi');
            });
        });
    </script>
@endsection
