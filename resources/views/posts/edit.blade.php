<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/cold-steel.css') }}">
</head>
<body style="background: lightgray">

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-primary text-white font-weight-bold">
                    EDIT DATA MAHASISWA
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim', $post->nim) }}">
                            @error('nim') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">NAMA LENGKAP</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $post->nama) }}">
                            @error('nama') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">FAKULTAS</label>
                                    <select class="form-control @error('fakultas') is-invalid @enderror" id="fakultas" name="fakultas">
                                        <option value="">-- Pilih Fakultas --</option>
                                        <option value="FAKULTAS TEKNOLOGI INDUSTRI (FTI)" {{ old('fakultas', $post->fakultas) == 'FAKULTAS TEKNOLOGI INDUSTRI (FTI)' ? 'selected' : '' }}>FAKULTAS TEKNOLOGI INDUSTRI (FTI)</option>
                                        <option value="FAKULTAS TEKNIK SIPIL DAN PERENCANAAN (FTSP)" {{ old('fakultas', $post->fakultas) == 'FAKULTAS TEKNIK SIPIL DAN PERENCANAAN (FTSP)' ? 'selected' : '' }}>FAKULTAS TEKNIK SIPIL DAN PERENCANAAN (FTSP)</option>
                                        <option value="FAKULTAS ARISTEKTUR DAN DESAIN (FAD)" {{ old('fakultas', $post->fakultas) == 'FAKULTAS ARISTEKTUR DAN DESAIN (FAD)' ? 'selected' : '' }}>FAKULTAS ARISTEKTUR DAN DESAIN (FAD)</option>
                                    </select>
                                    @error('fakultas') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PROGRAM STUDI</label>
                                    <select class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi">
                                        <option value="">-- Pilih Program Studi --</option>
                                    </select>
                                    @error('prodi') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">ANGKATAN</label>
                            <select class="form-control @error('angkatan') is-invalid @enderror" name="angkatan">
                                @for ($year = 2015; $year <= 2027; $year++)
                                    <option value="{{ $year }}" {{ old('angkatan', $post->angkatan) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('angkatan') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">EMAIL</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $post->email) }}">
                            @error('email') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">NO TELEPON</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp', $post->no_telp) }}">
                            @error('no_telp') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">UPDATE MAHASISWA</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-md btn-secondary">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/cold-steel-audio.js') }}"></script>
<script>
    const prodiData = {
        "FAKULTAS TEKNOLOGI INDUSTRI (FTI)": [
            "11 TEKNIK ELEKTRO",
            "12 TEKNIK MESIN",
            "13 TEKNIK INDUSTRI",
            "14 TEKNIK KIMIA",
            "15 INFORMATIKA",
            "16 SISTEM INFORMASI"
        ],
        "FAKULTAS TEKNIK SIPIL DAN PERENCANAAN (FTSP)": [
            "21 TEKNIK SIPIL",
            "22 TEKNIK GEODESI",
            "23 PERENCANAAN WILAYAH DAN KOTA",
            "24 TEKNIK LINGKUNGAN"
        ],
        "FAKULTAS ARISTEKTUR DAN DESAIN (FAD)": [
            "31 ARSITEKTUR",
            "32 DESAIN INTERIOR",
            "33 DESAIN PRODUK",
            "34 DESAIN KOMUNIKASI VISUAL"
        ]
    };

    const fakultasSelect = document.getElementById('fakultas');
    const prodiSelect = document.getElementById('prodi');
    const selectedProdi = "{{ old('prodi', $post->prodi) }}";

    function updateProdiOptions(selectedFakultas, preselectValue = '') {
        prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
        if (selectedFakultas && prodiData[selectedFakultas]) {
            prodiData[selectedFakultas].forEach(function(prodi) {
                const opt = document.createElement('option');
                opt.value = prodi;
                opt.textContent = prodi;
                if (prodi === preselectValue) {
                    opt.selected = true;
                }
                prodiSelect.appendChild(opt);
            });
        }
    }

    fakultasSelect.addEventListener('change', function() {
        updateProdiOptions(this.value);
    });

    if (fakultasSelect.value) {
        updateProdiOptions(fakultasSelect.value, selectedProdi);
    }
</script>

</body>
</html>
