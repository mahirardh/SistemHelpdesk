@extends('template.master')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-xl shadow-md px-8 py-6">

    {{-- Judul --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">PROFIL</h2>

    {{-- Profil Utama --}}
    <div class="flex flex-col md:flex-row md:space-x-8 space-y-4 md:space-y-0">
        {{-- Avatar --}}
        <div class="md:w-1/3 flex justify-center md:justify-start">
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=000000&color=fff&size=150"
                alt="Avatar"
                class="w-36 h-36 rounded-md shadow-lg border" />
        </div>

        {{-- Biodata --}}
        <div class="md:w-2/3 grid grid-cols-2 gap-y-3 text-gray-700 text-sm">
            <div class="font-semibold">Nama</div>
            <div>: {{ $user->name }}</div>
            <div class="font-semibold">No SAP</div>
            <div>: {{ $user->no_sap ?? '-' }}</div>
            <div class="font-semibold">Departemen</div>
            <div>: {{ $user->departemen ?? '-' }}</div>
            <div class="font-semibold">No HP</div>
            <div>: {{ $user->no_hp ?? '-' }}</div>
            <div class="font-semibold">Email</div>
            <div>: {{ $user->email }}</div>
        </div>
    </div>

    {{-- Box Performa --}}
    @if (in_array($user->role, ['asisten', 'krani']))
    <div class="mt-8 p-5 bg-gray-100 rounded-lg shadow-inner border border-gray-200">
        <h3 class="text-md font-semibold mb-4 text-gray-800">PERFORMA</h3>
        <div class="row text-center">
            <div class="col-md-3 mb-2">
                <div class="small-box bg-light p-2">
                    <div class="inner">
                        <h4>{{ $totalLaporan }}</h4>
                        <p>Total Laporan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="small-box bg-light p-2">
                    <div class="inner">
                        <h4>{{ $laporanSelesai }}</h4>
                        <p>Laporan Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="small-box bg-light p-2">
                    <div class="inner">
                        <h4>{{ $totalAntrian }}</h4>
                        <p>Laporan Dalam Antrian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="small-box bg-light p-2">
                    <div class="inner">
                        <h4>{{ $totalDiproses }}</h4>
                        <p>Laporan Diproses</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rata-Rata Rating --}}
        <div class="mt-4 text-center">
            <strong>Rata-rata Rating:</strong>
            <span class="text-yellow-500">
                @if($rating > 0)
                {{ number_format($rating, 1) }} / 5
                <br>
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <=floor($rating))
                    ★
                    @elseif ($i - $rating <=0.5)
                    <span class="text-yellow-400">★</span>
            @else
            <span class="text-gray-300">★</span>
            @endif
            @endfor
            @else
            <span class="text-gray-500">Belum ada penilaian</span>
            @endif
            </span>
        </div>
    </div>
    @endif


    {{-- Tombol Tutup --}}
    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded shadow-sm transition duration-150">
            Tutup
        </a>
    </div>

</div>
@endsection