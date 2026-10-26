<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Buku</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f5f6fc;
        }

        .main {
            max-width: 800px;
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

    <script>
        function previewCover(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('coverPreview');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>

</head>

<body>

<div class="main">

    <div class="mb-4">

        <h3 class="fw-bold">
            Edit Buku
        </h3>

        <p class="text-muted">
            Ubah informasi buku.
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body p-4">

            <form
                action="{{ route('buku.update', $buku->id_buku) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                @method('PUT')


                <!-- JUDUL -->

                <div class="mb-3">

                    <label class="form-label">
                        Judul Buku
                    </label>

                    <input
                        type="text"
                        name="judul_buku"
                        class="form-control"
                        value="{{ $buku->judul_buku }}"
                        required>

                </div>


                <!-- PENGARANG -->

                <div class="mb-3">

                    <label class="form-label">
                        Pengarang
                    </label>

                    <textarea
                        name="pengarang"
                        class="form-control"
                        rows="2"
                        required>{{ $buku->pengarang }}</textarea>

                </div>


                <!-- PENERBIT -->

                <div class="mb-3">

                    <label class="form-label">
                        Penerbit
                    </label>

                    <textarea
                        name="penerbit"
                        class="form-control"
                        rows="2">{{ $buku->penerbit }}</textarea>

                </div>


                <div class="row">

                    <!-- TAHUN -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tahun Terbit
                        </label>

                        <input
                            type="number"
                            name="tahun_terbit"
                            class="form-control"
                            value="{{ $buku->tahun_terbit }}">

                    </div>


                    <!-- STOK -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Jumlah Stok
                        </label>

                        <input
                            type="number"
                            name="jumlah_stok"
                            class="form-control"
                            value="{{ $buku->jumlah_stok }}">

                    </div>

                </div>


                <!-- KATEGORI -->

                <div class="mb-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <input
                        type="text"
                        name="kategori"
                        class="form-control"
                        value="{{ $buku->kategori }}">

                </div>


                <!-- COVER -->

                <div class="mb-3">

                    <label class="form-label">
                        Foto Cover Buku
                    </label>

                    <input
                        type="file"
                        name="cover"
                        id="cover"
                        class="form-control"
                        accept="image/*"
                        onchange="previewCover(event)">

                    <small class="text-muted">
                        Format: JPG, PNG, GIF (Maks: 2MB). Kosongkan jika tidak ingin mengubah.
                    </small>

                    <!-- PREVIEW EXISTING -->
                    @if($buku->cover && file_exists(storage_path('app/public/' . $buku->cover)))
                        <div class="mt-3">
                            <small class="text-muted d-block mb-2">Foto saat ini:</small>
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover" style="max-width: 200px; max-height: 250px; border-radius: 8px;">
                        </div>
                    @endif

                    <!-- PREVIEW NEW -->
                    <div id="coverPreview" class="mt-3" style="display: none;">
                        <small class="text-muted d-block mb-2">Preview baru:</small>
                        <img id="previewImage" src="" alt="Preview" style="max-width: 200px; max-height: 250px; border-radius: 8px;">
                    </div>

                </div>

                </div>


                <!-- BUTTON -->

                <div class="d-flex gap-2 mt-4">

                    <a
                        href="{{ route('buku.index') }}"
                        class="btn btn-light">

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Simpan Perubahan

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>

</body>

</html>