<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrasi Pengguna</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: #f0f2f5;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.2);
            width: 720px; /* lebih lebar untuk 2 kolom */
            max-height: none; /* hilangkan batas tinggi */
            overflow-y: visible; /* hilangkan scroll */
            padding: 1.5rem 2rem;
            background: white;

            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem 2rem;
        }
        form {
            display: contents; /* biar grid di .card yang berjalan */
        }
        .mb-3, .mb-4 {
            margin-bottom: 0; /* hapus margin bawah agar grid rapih */
        }
        h3 {
            grid-column: 1 / -1; /* judul full width */
            margin-bottom: 1rem;
            font-weight: 700;
            color: #5a67d8;
        }
        button[type="submit"] {
            grid-column: 1 / -1; /* tombol full width */
            margin-top: 1.5rem;
            padding: 0.6rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            background-color: #5a67d8;
            border: none;
            color: white;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #434190;
        }
        .form-control:focus {
            border-color: #5a67d8;
            box-shadow: 0 0 8px rgba(90, 103, 216, 0.4);
        }
        .input-group-text {
            background: #5a67d8;
            color: white;
            border: none;
            border-radius: 0.375rem 0 0 0.375rem;
        }
        .error-text {
            font-size: 0.85rem;
            color: #e53e3e;
            margin-top: 0.25rem;
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 768px) {
            .card {
                width: 90vw;
                grid-template-columns: 1fr;
                padding: 1rem 1.2rem;
            }
            button[type="submit"] {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        <h3>Registrasi Pengguna</h3>

        @if ($errors->any())
            <div class="alert alert-danger py-2" style="grid-column: 1 / -1;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input id="email" type="email" name="email" class="form-control" placeholder="contoh@mail.com" required value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="no_sap" class="form-label">No. SAP</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                    <input id="no_sap" type="text" name="no_sap" class="form-control" placeholder="Nomor SAP Anda" required value="{{ old('no_sap') }}">
                </div>
                @error('no_sap')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
                    <input id="no_hp" type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required value="{{ old('no_hp') }}">
                </div>
                @error('no_hp')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="departemen" class="form-label">Departemen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                    <input id="departemen" type="text" name="departemen" class="form-control" placeholder="Departemen kerja" required value="{{ old('departemen') }}">
                </div>
                @error('departemen')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --</option>
                    <option value="pelapor" {{ old('role') == 'pelapor' ? 'selected' : '' }}>Pelapor</option>
                    <option value="krani" {{ old('role') == 'krani' ? 'selected' : '' }}>Krani</option>
                    <option value="asisten" {{ old('role') == 'asisten' ? 'selected' : '' }}>Asisten</option>
                </select>
                @error('role')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Daftar</button>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
