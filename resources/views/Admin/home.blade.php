@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-home"></i> Home</a></li>
        </ol>
    </section>
    <section class="content">
        <br>
        <div class="row">
            <div class="col-md-12">
                <!-- Bar chart -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Grafik Sebaran Kasus Narkotika Provinsi Kalimantan Selatan</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="bar-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-sm-12">
                <div id="map" style="width:100%;height:480px;"></div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="{{ asset('adminlte/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/Flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/Flot/jquery.flot.categories.js') }}"></script>
    <script>
        var marker;

        function initialize() {

            // Variabel untuk menyimpan informasi (desc)
            var infoWindow = new google.maps.InfoWindow;

            //  Variabel untuk menyimpan peta Roadmap
            var propertiPeta = {
                center: new google.maps.LatLng(-3.36858077824835, 114.69636791372943),
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            // Pembuatan petanya
            var map = new google.maps.Map(document.getElementById('map'), propertiPeta);

            // Variabel untuk menyimpan batas kordinat
            var bounds = new google.maps.LatLngBounds();

            // Pengambilan data dari database
            @foreach ($barangBukti as $value)
                addMarker({{ $value->latitude }}, {{ $value->longitude }})
            @endforeach

            // Proses membuat marker 
            function addMarker(lat, lng, info) {
                var lokasi = new google.maps.LatLng(lat, lng);
                bounds.extend(lokasi);
                var marker = new google.maps.Marker({
                    map: map,
                    position: lokasi
                });
                map.fitBounds(bounds);
                bindInfoWindow(marker, map, infoWindow, info);
            }

            // Menampilkan informasi pada masing-masing marker yang diklik
            function bindInfoWindow(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            }

        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script>
        $(function() {
            var bar_data = {
                data: [
                    ['Kabupaten Balangan', {{ count($kabupatenBalangan) }}],
                    ['Kabupaten Banjar', {{ count($kabupatenBanjar) }}],
                    ['Kabupaten Barito Kuala', {{ count($kabupatenBaritoKuala) }}],
                    ['Kabupaten Hulu Sungai Selatan', {{ count($kabupatenHuluSungaiSelatan) }}],
                    ['Kabupaten Hulu Sungai Tengah', {{ count($kabupatenHuluSungaiTengah) }}],
                    ['Kabupaten Hulu Sungai Utara', {{ count($kabupatenHuluSungaiUtara) }}],
                    ['Kabupaten Kotabaru', {{ count($kabupatenKotabaru) }}],
                    ['Kabupaten Tabalong', {{ count($kabupatenTabalong) }}],
                    ['Kabupaten Tanah Bumbu', {{ count($kabupatenTanahBumbu) }}],
                    ['Kabupaten Tanah Laut', {{ count($kabupatenTanahLaut) }}],
                    ['Kabupaten Tapin', {{ count($kabupatenTapin) }}],
                    ['Kota Banjarbaru', {{ count($kotaBanjarbaru) }}],
                    ['Kota Banjarmasin', {{ count($kotaBanjarmasin) }}],
                ],
                color: '#3c8dbc'
            }
            $.plot('#bar-chart', [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor: '#f3f3f3'
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: 'center'
                    }
                },
                xaxis: {
                    mode: 'categories',
                    tickLength: 0
                }
            });
        });
    </script>
@endsection
