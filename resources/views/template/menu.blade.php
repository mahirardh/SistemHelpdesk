@extends('template.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 font-weight-bold">BERANDA</h4>

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

    <h5 class="mt-5 mb-3 font-weight-bold">LAPORAN YANG SEDANG DIPROSES</h5>
        <div class="row">
            @foreach ($laporanPerPIC as $pic)
            <div class="col-md-3 mb-3">
                <div class="small-box bg-light">
                    <div class="inner text-center">
                        <h3>{{ $pic->laporan_pic_count }}</h3>
                        <p>{{ $pic->name }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
</div>
@endsection