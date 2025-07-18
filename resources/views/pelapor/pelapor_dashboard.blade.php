@extends('template.master')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 font-weight-bold" style="font-size: 25px; ">Beranda</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalLaporan }}</h3>
                    <p>Total Laporan</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalSelesai }}</h3>
                    <p>Total Laporan Selesai</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalAntrian }}</h3>
                    <p>Total Dalam Antrian</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalDiproses }}</h3>
                    <p>Total Sedang Diproses</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection