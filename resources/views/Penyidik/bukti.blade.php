@extends('layouts.penyidik')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <li class="active">Data Barang Bukti</li>
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
                        <h3 class="box-title">Data Penyerahan Barang Bukti</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('print_penyerahan') }}" class="btn btn-warning btn-xs"><i
                                    class="fa fa-print"></i>
                                Print</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-karyawan">
                            <thead>
                                <tr>
                                    <th>ID Bukti</th>
                                    <th>Foto</th>
                                    <th>Nomor Kasus</th>
                                    <th>Tanggal</th>
                                    <th>Kota</th>
                                    <th>Jenis </th>
                                    <th>Petugas </th>
                                    <th>Jumlah</th>
                                    <th>Kondisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$penyerahan as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id_barang_bukti }}</td>
                                        <td><img src="{{ asset('uploads/' . $value->foto_barang_bukti) }}" class="zoom">
                                        </td>
                                        <td>{{ @$value->id_kasus }}</td>
                                        <td>{{ @$value->tgl_penyerahan }}</td>
                                        <td>{{ @$value->kota }}</td>
                                        <td>{{ @$value->jenis_barbuk }}</td>
                                        <td>{{ @$value->petugas }}</td>
                                        <td>{{ @$value->jumlah_barbuk }}</td>
                                        <td>{{ @$value->kondisi_barbuk }}</td>
                                        <td>{{ @$value->status }}</td>
                                        <td>
                                            <a href="{{ route('detail_bukti', $value->id_barang_bukti) }}"
                                                class="btn btn-xs btn-success"><i class="fa fa-eye"></i>Detail</a>
                                            @if (@$value->status == 'Diserahkan')
                                                <button class="btn btn-xs btn-success btn-selesai"><i class="fa fa-check">
                                                        Selesai</i></button> &nbsp;
                                                <button class="btn btn-xs btn-danger btn-edit-karyawan"><i
                                                        class="fa fa-edit">
                                                        Pengembalian</i></button>
                                            @else
                                            @endif

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
    <div class="modal fade" id="modal-form-edit-karyawan" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Pengembalian</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengembalian_bukti') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label for="">ID Barang Bukti</label>
                            <input type="text" name="id_barang_bukti" readonly class="form-control" placeholder="ID ">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Nomor Kasus</label>
                            <input type="text" name="noKasus" readonly class="form-control" placeholder="ID ">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Foto Pengembalian:</label>
                            <input type="file" name="foto" class="form-control" id="foto">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" cols="5" rows="3"></textarea>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Pengembalian</button>
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
    <div class="modal fade" id="modal-form-selesai" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Selesai</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('selesai') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label for="">ID Barang Bukti</label>
                            <input type="text" name="id_barang_bukti" readonly class="form-control"
                                placeholder="ID ">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Nomor Kasus</label>
                            <input type="text" name="noKasus" readonly class="form-control" placeholder="ID ">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Hukuman</label>
                            <select name="hukuman" id="hukuman" class="form-control" required>
                                <option value="">Pilih Hukuman</option>
                                <option value="Pidana">Pidana</option>
                                <option value="Rehabilitasi">Rehabilitasi</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Pasal :</label>
                            <select class="js-example-basic-multiple form-control" style="width: 100%" name="pasal[]"
                                multiple="multiple" required>
                                <option value="">Pilih</option>
                                <option value="Pasal 280 jo Pasal 68 ayat (1)">Pasal 280 jo Pasal 68 ayat (1)</option>
                                <option value="Pasal 281 jo Pasal 77 ayat (1)">Pasal 281 jo Pasal 77 ayat (1)</option>
                                <option value="Pasal 285 ayat (1) Jo Pasal 106 ayat (3)">Pasal 285 ayat (1) Jo Pasal 106
                                    ayat (3)</option>
                                <option value="Pasal 286 jo Pasal 106 ayat (3) jo Pasal 48 ayat (3)">Pasal 286 jo Pasal 106
                                    ayat (3) jo Pasal 48 ayat (3)</option>
                                <option value="Pasal 287 ayat (1) jo Pasal 106 ayat (4) huruf a">Pasal 287 ayat (1) jo
                                    Pasal
                                    106 ayat (4) huruf a</option>
                                <option value="Pasal 287 ayat (1) jo Pasal 106 ayat (4) huruf b">Pasal 287 ayat (1) jo
                                    Pasal
                                    106 ayat (4) huruf b</option>
                                <option value="Pasal 287 ayat (2) jo Pasal 106 ayat (4) huruf c">Pasal 287 ayat (2) jo
                                    Pasal
                                    106 ayat (4) huruf c</option>
                                <option value="Pasal 288 ayat (1) jo Pasal 70 ayat (2)">Pasal 288 ayat (1) jo Pasal 70 ayat
                                    (2)</option>
                                <option value="Pasal 288 ayat (1) jo Pasal 106 ayat (5) huruf a">Pasal 288 ayat (1) jo
                                    Pasal
                                    106 ayat (5) huruf a</option>
                                <option value="Pasal 288 ayat (2) jo Pasal 106 ayat (5) huruf b">Pasal 288 ayat (2) jo
                                    Pasal 106 ayat (5) huruf b</option>
                                <option value="Pasal 291 ayat (1) Jo Pasal 106 ayat (8)">Pasal 291 ayat (1) Jo Pasal 106
                                    ayat (8)</option>
                                <option value="Pasal 291 ayat (2) Jo Pasal 106 ayat (8)">Pasal 291 ayat (2) Jo Pasal 106
                                    ayat (8)</option>
                                <option value="Pasal 292 jo Pasal 106 ayat (9)">Pasal 292 jo Pasal 106 ayat (9)</option>
                                <option value="Pasal 293 ayat (2) jo Pasal 107 ayat (2)">Pasal 293 ayat (2) jo Pasal 107
                                    ayat (2)</option>
                                <option value="Pasal 296 jo Pasal 114 huruf a">Pasal 296 jo Pasal 114 huruf a</option>
                                <option value="Pasal 307 Jo Pasal 169 ayat (1)">Pasal 307 Jo Pasal 169 ayat (1)</option>
                            </select>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Selesai</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        var table = $('#data-karyawan').DataTable();

        $('#data-karyawan').on('click', '.btn-edit-karyawan', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id_barang_bukti]').val(row[0]);
            $('input[name=noKasus]').val(row[2]);
            $('#modal-form-edit-karyawan').modal('show');
        });

        $('#data-karyawan').on('click', '.btn-selesai', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id_barang_bukti]').val(row[0]);
            $('input[name=noKasus]').val(row[2]);
            $('input[name=jenis]').val(row[4]);
            $('input[name=jumlah]').val(row[6]);
            $('input[name=kondisi]').val(row[7]);
            $('#modal-form-selesai').modal('show');
        });
        $('#modal-form-tambah-karyawan').on('show.bs.modal', function() {
            $('input[name=id_barang_bukti]').val('');
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
