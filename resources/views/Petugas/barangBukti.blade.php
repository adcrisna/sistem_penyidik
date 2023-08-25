@extends('layouts.petugas')
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
            <li><a href="{{ route('petugas_home') }}"><i class="fa fa-home"></i> Home</a></li>
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
                        <h3 class="box-title">Data Barang Bukti</h3>
                        <div class="box-tools pull-right">
                            {{-- <a href="{{ route('print_petugas') }}" class="btn btn-warning btn-xs">Print</a> --}}
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                data-target="#modal-form-tambah-karyawan"><i class="fa fa-plus"> Tambah Data Bukti
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-karyawan">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nomor Kasus</th>
                                    <th>Kota</th>
                                    <th>Jenis </th>
                                    <th>Kondisi </th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$bukti as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id_barang_bukti }}</td>
                                        <td><img src="{{ asset('uploads/' . $value->foto_barbuk) }}" class="zoom"></td>
                                        <td>{{ @$value->id_kasus }}</td>
                                        <td>{{ @$value->kota }}</td>
                                        <td>{{ @$value->jenis_barbuk }}</td>
                                        <td>{{ @$value->kondisi_barbuk }}</td>
                                        <td>{{ @$value->jumlah_barbuk }}</td>
                                        <td>{{ @$value->status }}</td>
                                        <td>
                                            @if (@$value->status == 'Diproses')
                                                <a href="{{ route('proses_bukti', @$value->id_barang_bukti) }}"><button
                                                        class=" btn btn-xs btn-success"
                                                        onclick="return confirm('Apakah anda ingin menyerahkan bukti ini ?')"><i
                                                            class="fa fa-edit">
                                                            Proses</i></button></a>
                                                &nbsp;
                                                <a href="{{ route('delete_bukti', @$value->id_barang_bukti) }}"><button
                                                        class=" btn btn-xs btn-danger"
                                                        onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                            class="fa fa-trash"> Hapus</i></button></a>
                                            @elseif ($value->status == 'Dikembalikan')
                                                <a href="{{ route('delete_bukti', @$value->id_barang_bukti) }}"><button
                                                        class=" btn btn-xs btn-danger"
                                                        onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                            class="fa fa-trash"> Hapus</i></button></a>
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
    <div class="modal fade" id="modal-form-tambah-karyawan" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Bukti</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_bukti') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label for="">No Kasus</label>
                            <select name="noKasus" class="form-control" id="noKasus" required>
                                <option value="">Pilih</option>
                                @foreach (@$kasus as $key => $value)
                                    <option value="{{ $value->id_kasus }}">{{ $value->id_kasus }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Jenis</label>
                            <input type="text" class="form-control" name="jenis" id="jenis" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Kondisi</label>
                            <input type="text" class="form-control" name="kondisi" id="kondisi" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Foto :</label>
                            <input type="file" name="lampiran" class="form-control" id="lampiran" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Kota/Kabupaten</label>
                            <select name="kota" id="kota" class="form-control" required>
                                <option value="">Pilih Kota</option>
                                <option value="Kabupaten Balangan">Kabupaten Balangan</option>
                                <option value="Kabupaten Banjar">Kabupaten Banjar</option>
                                <option value="Kabupaten Barito Kuala">Kabupaten Barito Kuala</option>
                                <option value="Kabupaten Hulu Sungai Selatan">Kabupaten Hulu Sungai Selatan</option>
                                <option value="Kabupaten Hulu Sungai Tengah">Kabupaten Hulu Sungai Tengah</option>
                                <option value="Kabupaten Hulu Sungai Utara">Kabupaten Hulu Sungai Utara</option>
                                <option value="Kabupaten Kotabaru">Kabupaten Kotabaru</option>
                                <option value="Kabupaten Tabalong">Kabupaten Tabalong</option>
                                <option value="Kabupaten Tanah Bumbu">Kabupaten Tanah Bumbu</option>
                                <option value="Kabupaten Tanah Laut">Kabupaten Tanah Laut</option>
                                <option value="Kabupaten Tapin">Kabupaten Tapin</option>
                                <option value="Kota Banjarbaru">Kota Banjarbaru</option>
                                <option value="Kota Banjarmasin">Kota Banjarmasin</option>
                            </select>
                        </div>
                        <br>
                        <div id="googleMap" style="width:100%;height:380px;"></div>
                        <br />
                        <div class="form-group has-feedback">
                            <label>Latitude :</label>
                            <input type="text" id="lat" name="lat" class="form-control" value=""
                                readonly required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Longitude</label>
                            <input type="text" id="lng" name="lng" value="" class="form-control"
                                readonly required>
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
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
        var table = $('#data-karyawan').DataTable();

        $('#data-karyawan').on('click', '.btn-edit-karyawan', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=nip]').val(row[1]);
            $('input[name=nama]').val(row[2]);
            $('input[name=username]').val(row[3]);
            $('textarea[name=alamat]').val(row[4]);
            $('input[name=jabatan]').val(row[5]);
            $('select[name=status]').val(row[6]);
            $('input[name=lampiran_lama]').val(row[7]);
            $('#modal-form-edit-karyawan').modal('show');
        });
        $('#modal-form-tambah-karyawan').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=nip]').val('');
            $('input[name=nama]').val('');
            $('input[name=username]').val('');
            $('input[name=jabatan]').val('');
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
    <script>
        // variabel global marker
        var marker;

        function taruhMarker(peta, posisiTitik) {

            if (marker) {
                // pindahkan marker
                marker.setPosition(posisiTitik);
            } else {
                // buat marker baru
                marker = new google.maps.Marker({
                    position: posisiTitik,
                    map: peta
                });
            }

            // isi nilai koordinat ke form
            document.getElementById("lat").value = posisiTitik.lat();
            document.getElementById("lng").value = posisiTitik.lng();

        }

        function initialize() {
            var propertiPeta = {
                center: new google.maps.LatLng(-3.36858077824835, 114.69636791372943),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);


            // even listner ketika peta diklik
            google.maps.event.addListener(peta, 'click', function(event) {
                taruhMarker(this, event.latLng);
            });

        }

        // event jendela di-load  
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection
