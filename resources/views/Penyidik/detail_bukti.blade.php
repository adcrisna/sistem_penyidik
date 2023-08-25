@extends('layouts.penyidik')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('penyidik_home') }}"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ route('penyerahan_bukti') }}">Data Penyerahan</a></li>
            <li class="active">Detail Penyerahan</li>
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
                        <h3 class="box-title">Detail Penyerahan</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <form action="{{ route('edit_bukti') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback">
                                <input type="hidden" name="id" readonly class="form-control"
                                    value="{{ $bukti->id_barang_bukti }}" readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Nomor Kasus</label>
                                <input type="text" name="id_kasus" class="form-control" value="{{ $bukti->id_kasus }}"
                                    readonly>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Jenis Barang Bukti</label>
                                <input type="text" name="jenis" class="form-control" value="{{ $bukti->jenis_barbuk }}"
                                    required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Kondisi Barang Bukti</label>
                                <input type="text" name="kondisi" class="form-control"
                                    value="{{ $bukti->kondisi_barbuk }}" required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Jumlah Barang Bukti</label>
                                <input type="text" name="jumlah" class="form-control"
                                    value="{{ $bukti->jumlah_barbuk }}" required>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Kota/Kabupaten</label>
                                <select name="kota" id="kota" class="form-control" required>
                                    <option value="">Pilih Kota</option>
                                    <option value="Kabupaten Balangan"
                                        {{ $bukti->kota == 'Kabupaten Balangan' ? 'selected' : '' }}>Kabupaten Balangan
                                    </option>
                                    <option value="Kabupaten Banjar"
                                        {{ $bukti->kota == 'Kabupaten Banjar' ? 'selected' : '' }}>Kabupaten Banjar
                                    </option>
                                    <option value="Kabupaten Barito Kuala"
                                        {{ $bukti->kota == 'Kabupaten Barito Kuala' ? 'selected' : '' }}>Kabupaten Barito
                                        Kuala</option>
                                    <option value="Kabupaten Hulu Sungai Selatan"
                                        {{ $bukti->kota == 'Kabupaten Hulu Sungai Selatan' ? 'selected' : '' }}>Kabupaten
                                        Hulu Sungai Selatan</option>
                                    <option value="Kabupaten Hulu Sungai Tengah"
                                        {{ $bukti->kota == 'Kabupaten Hulu Sungai Tengah' ? 'selected' : '' }}>Kabupaten
                                        Hulu Sungai Tengah</option>
                                    <option value="Kabupaten Hulu Sungai Utara"
                                        {{ $bukti->kota == 'Kabupaten Hulu Sungai Utara' ? 'selected' : '' }}>Kabupaten
                                        Hulu Sungai Utara</option>
                                    <option value="Kabupaten Kotabaru"
                                        {{ $bukti->kota == 'Kabupaten Kotabaru' ? 'selected' : '' }}>Kabupaten Kotabaru
                                    </option>
                                    <option value="Kabupaten Tabalong"
                                        {{ $bukti->kota == 'Kabupaten Tabalong' ? 'selected' : '' }}>Kabupaten Tabalong
                                    </option>
                                    <option value="Kabupaten Tanah Bumbu"
                                        {{ $bukti->kota == 'Kabupaten Tanah Bumbu' ? 'selected' : '' }}>Kabupaten Tanah
                                        Bumbu</option>
                                    <option value="Kabupaten Tanah Laut"
                                        {{ $bukti->kota == 'Kabupaten Tanah Laut' ? 'selected' : '' }}>Kabupaten Tanah
                                        Laut</option>
                                    <option value="Kabupaten Tapin"
                                        {{ $bukti->kota == 'Kabupaten Tapin' ? 'selected' : '' }}>Kabupaten Tapin</option>
                                    <option value="Kota Banjarbaru"
                                        {{ $bukti->kota == 'Kota Banjarbaru' ? 'selected' : '' }}>Kota Banjarbaru</option>
                                    <option value="Kota Banjarmasin"
                                        {{ $bukti->kota == 'Kota Banjarmasin' ? 'selected' : '' }}>Kota Banjarmasin
                                    </option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div id="gMap" style="width:100%;height:400px;"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Latitude :</label>
                                        <input type="text" name="latitude" id="latitude" class="form-control"
                                            value="{{ $bukti->latitude }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Logitude :</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control"
                                            value="{{ $bukti->longitude }}" readonly>
                                    </div>
                                </div>
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
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
        function lihatmarker() {
            var lati = parseFloat(document.getElementById("latitude").value);
            var long = parseFloat(document.getElementById("longitude").value);
            console.log(lati, long);
            var info_window = new google.maps.InfoWindow();

            // menentukan level zoom
            var zoom = 16;

            // menentikan latitude dan longitude
            var pos = new google.maps.LatLng({
                lat: lati,
                lng: long
            });

            // menentukan opsi peta
            var options = {
                'center': pos,
                'zoom': zoom,
                'mapTypeId': google.maps.MapTypeId.ROADMAP
            };

            // membuat peta
            var map = new google.maps.Map(document.getElementById('gMap'), options);
            info_window = new google.maps.InfoWindow({
                'content': 'loading...'
            });

            // membuat marker
            var marker = new google.maps.Marker({
                position: pos,
                title: 'here',

            });

            // set marker di peta
            marker.setMap(map);

            // membuat event ketika marker di click
            google.maps.event.addListener(marker, 'click', function() {
                info_window.setContent('<b>' + this.title + '</b>');
                info_window.open(map, this);
            });
        }
        google.maps.event.addDomListener(window, 'load', lihatmarker);
    </script>
@endsection
