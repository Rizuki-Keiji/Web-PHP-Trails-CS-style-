<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/cold-steel.css') }}">
</head>
<body style="background: lightgray">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-primary text-white font-weight-bold">
                    DETAIL MAHASISWA
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered mb-4">
                        <tr>
                            <th width="30%">NIM</th>
                            <td class="font-weight-bold">{{ $post->nim }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $post->nama }}</td>
                        </tr>
                        <tr>
                            <th>Fakultas</th>
                            <td>{{ $post->fakultas }}</td>
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td>{{ $post->prodi }}</td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td>{{ $post->angkatan }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $post->email }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $post->no_telp }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('posts.index') }}" class="btn btn-md btn-dark">KEMBALI</a>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-md btn-primary">EDIT DATA</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="{{ asset('js/cold-steel-audio.js') }}"></script>
</html>
