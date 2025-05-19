@extends('template.master')  <!-- Menyebutkan bahwa ini menggunakan layout master -->

@section('content') <!-- Konten utama untuk halaman ini -->
<div class="container-fluid">
    <h4 class="mb-4 font-weight-bold">BERANDA</h4>
    <div class="row">
        <!-- Total Laporan -->
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>49</h3>
                    <p>Total Laporan</p>
                </div>
            </div>
        </div>

        <!-- Total Laporan Selesai -->
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>10</h3>
                    <p>Total Laporan Selesai</p>
                </div>
            </div>
        </div>

        <!-- Total Dalam Antrian -->
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>3</h3>
                    <p>Total Dalam Antrian</p>
                </div>
            </div>
        </div>

        <!-- Total Sedang Diproses -->
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>6</h3>
                    <p>Total Sedang Diproses</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mt-5 mb-3 font-weight-bold">LAPORAN YANG SEDANG DIPROSES</h5>
    <div class="row">
        @for ($i = 1; $i <= 4; $i++)
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ rand(5, 12) }}</h3>
                    <p>Krani {{ $i }}</p>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
