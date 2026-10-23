<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/cold-steel.css') }}">
</head>
<body style="background: lightgray">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div>
                <h3 class="text-center my-4">DATA MAHASISWA</h3>
                <hr>
            </div>
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('posts.create') }}" class="btn btn-md btn-success mb-3">TAMBAH DATA MAHASISWA</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark text-center">
                              <tr>
                                <th scope="col" width="5%">No</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Program Studi</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col">Email</th>
                                <th scope="col">No Telepon</th>
                                <th scope="col" width="20%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($posts as $post)
                                <tr>
                                    <td class="text-center">{{ $posts->firstItem() + $loop->index }}</td>
                                    <td class="font-weight-bold">{{ $post->nim }}</td>
                                    <td>{{ $post->nama }}</td>
                                    <td>{{ $post->fakultas }}</td>
                                    <td>{{ $post->prodi }}</td>
                                    <td class="text-center">{{ $post->angkatan }}</td>
                                    <td>{{ $post->email }}</td>
                                    <td>{{ $post->no_telp }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="form-delete d-inline">
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                    </td>
                                </tr>
                              @empty
                                  <tr>
                                      <td colspan="9" class="text-center">
                                          <div class="alert alert-danger mb-0">
                                              Data Mahasiswa belum Tersedia.
                                          </div>
                                      </td>
                                  </tr>
                              @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('js/cold-steel-audio.js') }}"></script>
<script>
    @if(session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif(session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>

</body>
</html>
