<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OOP\StudentManager;
use App\OOP\Mahasiswa;
use Exception;

class MahasiswaController extends Controller
{
    private StudentManager $manager;

    public function __construct()
    {
        $this->manager = new StudentManager();
    }

    // Menampilkan halaman utama dengan fitur Pencarian dan Pengurutan
    public function index(Request $request)
    {
        try {
            $students = $this->manager->getAll();

            // 1. Fitur Pencarian (Searching)
            $search = $request->input('search');
            $searchType = $request->input('search_type', 'linear'); // linear atau binary

            if (!empty($search)) {
                if ($searchType === 'binary') {
                    // Validasi: Binary Search hanya boleh angka (NIM)
                    if (!preg_match('/^[0-9]+$/', $search)) {
                        throw new Exception("Pencarian biner hanya mendukung input angka (NIM)!");
                    }
                    // Binary Search mensyaratkan pencarian NIM presisi
                    $found = $this->manager->binarySearch($students, $search);
                    $students = $found ? [$found] : [];
                } else {
                    // Linear/Sequential Search untuk pencarian teks parsial (Nama/NIM/Jurusan)
                    $students = $this->manager->linearSearch($students, $search);
                }
            }

            // 2. Fitur Pengurutan (Sorting)
            $sortBy = $request->input('sort_by', 'nama'); // sort berdasarkan nama atau nim
            $sortMethod = $request->input('sort_method', 'bubble'); // bubble atau selection

            if (!empty($students)) {
                if ($sortMethod === 'selection') {
                    $this->manager->selectionSort($students, $sortBy);
                } else {
                    $this->manager->bubbleSort($students, $sortBy);
                }
            }

            // 3. Paginasi Manual (Limit 10 data per halaman)
            $total = count($students);
            $limit = 10;
            $totalPages = (int) ceil($total / $limit);
            $page = (int) $request->input('page', 1);
            
            if ($totalPages > 0) {
                $page = max(1, min($totalPages, $page));
            } else {
                $page = 1;
            }

            $offset = ($page - 1) * $limit;
            $paginatedStudents = array_slice($students, $offset, $limit);

            return view('mahasiswa.index', compact(
                'paginatedStudents', 'search', 'searchType', 'sortBy', 'sortMethod', 'page', 'totalPages', 'total', 'limit'
            ));
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan form tambah mahasiswa
    public function create()
    {
        return view('mahasiswa.create');
    }

    // Menyimpan mahasiswa baru (terdapat validasi Regex & Try-Catch)
    public function store(Request $request)
    {
        // Validasi input menggunakan Regular Expression (Regex)
        $request->validate([
            'nim' => ['required', 'regex:/^[0-9]{12}$/'], // NIM hanya boleh angka, panjang 12 karakter
            'nama' => ['required', 'regex:/^[a-zA-Z\s]{3,50}$/'], // Nama hanya huruf & spasi, panjang 3-50
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tugas' => 'required|in:Selesai,Belum Selesai',
            'jurusan' => ['required', 'regex:/^[a-zA-Z\s]{3,50}$/'], // Jurusan hanya huruf & spasi
        ], [
            'nim.regex' => 'NIM harus berupa angka sepanjang 12 karakter.',
            'nama.regex' => 'Nama hanya boleh mengandung huruf dan spasi (minimal 3 karakter).',
            'jurusan.regex' => 'Jurusan hanya boleh mengandung huruf dan spasi.',
        ]);

        try {
            // Membuat objek Mahasiswa baru
            $mhs = new Mahasiswa(
                $request->nim,
                $request->nama,
                $request->jenis_kelamin,
                $request->tugas,
                $request->jurusan
            );

            // Menyimpan ke file JSON via StudentManager
            $this->manager->add($mhs);

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan!');
        } catch (Exception $e) {
            // Penanganan error menggunakan try-catch
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Menampilkan form edit
    public function edit(string $nim)
    {
        try {
            $students = $this->manager->getAll();
            $student = null;
            
            // Mencari objek mahasiswa yang ingin diedit
            foreach ($students as $s) {
                if ($s->getNim() === $nim) {
                    $student = $s;
                    break;
                }
            }

            if (!$student) {
                throw new Exception("Mahasiswa tidak ditemukan.");
            }

            return view('mahasiswa.edit', compact('student'));
        } catch (Exception $e) {
            return redirect()->route('mahasiswa.index')->with('error', $e->getMessage());
        }
    }

    // Memperbarui data mahasiswa (dengan validasi Regex & Try-Catch)
    public function update(Request $request, string $nim)
    {
        $request->validate([
            'nama' => ['required', 'regex:/^[a-zA-Z\s]{3,50}$/'],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tugas' => 'required|in:Selesai,Belum Selesai',
            'jurusan' => ['required', 'regex:/^[a-zA-Z\s]{3,50}$/'],
        ], [
            'nama.regex' => 'Nama hanya boleh mengandung huruf dan spasi (minimal 3 karakter).',
            'jurusan.regex' => 'Jurusan hanya boleh mengandung huruf dan spasi.',
        ]);

        try {
            $this->manager->update(
                $nim,
                $request->nama,
                $request->jenis_kelamin,
                $request->tugas,
                $request->jurusan
            );

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Menghapus data mahasiswa
    public function destroy(string $nim)
    {
        try {
            $this->manager->delete($nim);
            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('mahasiswa.index')->with('error', $e->getMessage());
        }
    }
}
