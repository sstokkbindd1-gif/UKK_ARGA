<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Anggota</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f5f6fc;
        }

        .main {
            max-width: 750px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .btn-primary {
            background: #6574ee;
            border: none;
        }

    </style>

</head>

<body>

<div class="main">

    <h3 class="fw-bold">
        Edit Anggota
    </h3>

    <p class="text-muted">
        Ubah data anggota.
    </p>


    <div class="card shadow-sm mt-4">

        <div class="card-body p-4">

            <form
                action="{{ route('anggota.update', $anggota->id_anggota) }}"
                method="POST">

                @csrf

                @method('PUT')


                <!-- USER -->

                <div class="mb-3">

                    <label class="form-label">
                        User
                    </label>

                    <select
                        name="id_user"
                        class="form-select"
                        required>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ $anggota->id_user == $user->id ? 'selected' : '' }}>

                                {{ $user->name }}
                                -
                                {{ $user->email }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- NIS -->

                <div class="mb-3">

                    <label class="form-label">
                        NIS
                    </label>

                    <input
                        type="text"
                        name="nis"
                        class="form-control"
                        value="{{ $anggota->nis }}"
                        required>

                </div>


                <!-- NAMA -->

                <div class="mb-3">

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        class="form-control"
                        value="{{ $anggota->nama_lengkap }}"
                        required>

                </div>


                <!-- ALAMAT -->

                <div class="mb-3">

                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="3">{{ $anggota->alamat }}</textarea>

                </div>


                <!-- KELAS -->

                <div class="mb-3">

                    <label class="form-label">
                        Kelas
                    </label>

                    <input
                        type="text"
                        name="kelas"
                        class="form-control"
                        value="{{ $anggota->kelas }}">

                </div>


                <div class="d-flex gap-2 mt-4">

                    <a
                        href="{{ route('anggota.index') }}"
                        class="btn btn-light">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>