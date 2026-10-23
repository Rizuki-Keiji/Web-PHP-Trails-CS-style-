<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama'      => 'required|min:3',
            'fakultas'  => 'required',
            'prodi'     => 'required',
            'angkatan'  => 'required|digits:4',
            'nim_urut'  => 'nullable|numeric|digits_between:1,3',
            'email'     => 'required|email|unique:posts,email',
            'no_telp'   => 'required|numeric'
        ]);

        // Ambil 2 digit awal dari value prodi (contoh '15 INFORMATIKA' -> '15')
        $kodeProdi = substr($request->input('prodi'), 0, 2);
        $prefix = $kodeProdi . $request->input('angkatan'); // 6 digit pertama

        if ($request->filled('nim_urut')) {
            $nimSuffix = str_pad($request->input('nim_urut'), 3, '0', STR_PAD_LEFT);
            $finalNim = $prefix . $nimSuffix;

            if (Post::where('nim', $finalNim)->exists()) {
                throw ValidationException::withMessages([
                    'nim_urut' => "NIM $finalNim sudah terdaftar! Gunakan 3 digit urutan lain atau kosongkan untuk otomatis."
                ]);
            }
        } else {
            // Cari data terakhir dengan prefix yang sama untuk auto-increment
            $lastPost = Post::where('nim', 'LIKE', $prefix . '%')
                            ->orderBy('nim', 'desc')
                            ->first();

            if ($lastPost) {
                $lastNumber = (int) substr($lastPost->nim, -3);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $finalNim = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        Post::create([
            'nim'      => $finalNim,
            'nama'     => $request->input('nama'),
            'fakultas' => $request->input('fakultas'),
            'prodi'    => $request->input('prodi'),
            'angkatan' => $request->input('angkatan'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
        ]);

        return redirect()->route('posts.index')->with(['success' => 'Data Mahasiswa Berhasil Disimpan dengan NIM: ' . $finalNim]);
    }

    public function show(string $id): View
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit(string $id): View
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nim'      => 'required|unique:posts,nim,' . $id,
            'nama'     => 'required|min:3',
            'fakultas' => 'required',
            'prodi'    => 'required',
            'angkatan' => 'required|digits:4',
            'email'    => 'required|email|unique:posts,email,' . $id,
            'no_telp'  => 'required|numeric'
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('posts.index')->with(['success' => 'Data Mahasiswa Berhasil Diubah!']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with(['success' => 'Data Mahasiswa Berhasil Dihapus!']);
    }
}
