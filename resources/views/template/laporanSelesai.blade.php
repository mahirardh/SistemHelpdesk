@extends('template.master')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 font-weight-bold">Laporan Selesai</h4>

        <!-- Form Pencarian (nonaktif sementara karena dummy) -->
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

        <!-- Tabel Laporan Selesai -->
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
                    $dummySelesai = [
                        [
                            'ticket_number' => 'TKT010',
                            'created_at' => '2025-04-25 08:30',
                            'category' => 'Jaringan',
                            'reporter_name' => 'Rina',
                            'status' => 'closed',
                        ],
                        [
                            'ticket_number' => 'TKT011',
                            'created_at' => '2025-04-26 11:15',
                            'category' => 'Hardware',
                            'reporter_name' => 'Dian',
                            'status' => 'closed',
                        ],
                        [
                            'ticket_number' => 'TKT012',
                            'created_at' => '2025-04-27 15:45',
                            'category' => 'Software',
                            'reporter_name' => 'Fajar',
                            'status' => 'closed',
                        ],
                    ];
                @endphp

                @foreach ($dummySelesai as $laporan)
                    <tr>
                        <td>{{ $laporan['ticket_number'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan['created_at'])->format('d-m-Y H:i') }}</td>
                        <td>{{ $laporan['category'] }}</td>
                        <td>{{ $laporan['reporter_name'] }}</td>
                        <td>
                            <span class="badge badge-success">
                                {{ ucfirst($laporan['status']) }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info disabled">Detail</a>
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
