<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Sistem Helpdesk</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .register-title {
            margin-bottom: 30px;
        }

        .form-group small {
            color: red;
        }
    </style>
    <link rel="icon" href="{{ asset('dist/img/Logo_PTPN4.png') }}" type="image/png">
</head>

<body>
    <div class="register-box">
        <h3 class="text-center register-title"><b>Registrasi Pengguna</b></h3>
        <hr />

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                @error('name') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required />
                @error('email') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>No. SAP</label>
                <input type="text" name="no_sap" class="form-control" placeholder="No. SAP" value="{{ old('no_sap') }}" required />
                @error('no_sap') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required />
                @error('no_hp') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Departemen --</option>
                    <option value="HRD" {{ old('departemen') == 'HRD' ? 'selected' : '' }}>HRD</option>
                    <option value="Keuangan" {{ old('departemen') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                    <option value="Produksi" {{ old('departemen') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                    <option value="Logistik" {{ old('departemen') == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                    <option value="TI" {{ old('departemen') == 'TI' ? 'selected' : '' }}>TI</option>
                    <option value="Lainnya" {{ old('departemen') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('departemen') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required />
                @error('password') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>

        <hr />

        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-default">Kembali ke Login</a>
        </div>
    </div>
</body>

</html>
