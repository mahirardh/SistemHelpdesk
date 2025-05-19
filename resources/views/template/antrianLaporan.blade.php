@extends('template.master')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 font-weight-bold">Antrian Laporan</h4>

        <!-- Form Pencarian -->
        <form method="GET" action="#">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" disabled>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" disabled>Cari</button>
                </div>
            </div>
        </form>

        <!-- Tabel Antrian -->
        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>No. Tiket</th>
                    <th>Tanggal Dibuat</th>
                    <th>Kategori Masalah</th>
                    <th>Pelapor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dummyAntrian = [
                        [
                            'ticket_number' => 'TKT020',
                            'created_at' => '2025-04-29 08:10',
                            'category' => 'Jaringan',
                            'reporter_name' => 'Lina',
                            'status' => 'open',
                        ],
                        [
                            'ticket_number' => 'TKT021',
                            'created_at' => '2025-04-29 10:45',
                            'category' => 'Hardware',
                            'reporter_name' => 'Sandi',
                            'status' => 'open',
                        ],
                        [
                            'ticket_number' => 'TKT022',
                            'created_at' => '2025-04-29 13:30',
                            'category' => 'Software',
                            'reporter_name' => 'Ayu',
                            'status' => 'open',
                        ],
                    ];
                @endphp

                @foreach ($dummyAntrian as $laporan)
                    <tr>
                        <td>{{ $laporan['ticket_number'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan['created_at'])->format('d-m-Y H:i') }}</td>
                        <td>{{ $laporan['category'] }}</td>
                        <td>{{ $laporan['reporter_name'] }}</td>
                        <td>
                            <span class="badge badge-warning">{{ ucfirst($laporan['status']) }}</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info disabled">Detail</a>
                            <a href="#" class="btn btn-sm btn-success disabled">Respon</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Placeholder -->
        <nav>
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection
