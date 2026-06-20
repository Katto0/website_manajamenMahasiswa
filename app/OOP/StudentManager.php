<?php

namespace App\OOP;

use Illuminate\Support\Facades\Storage;
use Exception;

class StudentManager
{
    private string $filePath = 'mahasiswa.json';

    // File I/O: Membaca data dari file JSON dan mengubahnya menjadi array objek Mahasiswa
    public function getAll(): array
    {
        try {
            if (!Storage::disk('local')->exists($this->filePath)) {
                return [];
            }

            $jsonContent = Storage::disk('local')->get($this->filePath);
            $dataArray = json_decode($jsonContent, true) ?? [];
            
            $students = [];
            foreach ($dataArray as $item) {
                // Instansiasi objek baru dari class Mahasiswa
                $students[] = new Mahasiswa(
                    $item['nim'],
                    $item['nama'],
                    $item['jenis_kelamin'],
                    $item['tugas'] ?? 'Selesai',
                    $item['jurusan']
                );
            }
            return $students;
        } catch (Exception $e) {
            throw new Exception("Gagal membaca database mahasiswa: " . $e->getMessage());
        }
    }

    // File I/O: Menyimpan array objek Mahasiswa kembali ke file JSON
    private function saveAll(array $students): void
    {
        try {
            $dataArray = [];
            foreach ($students as $mhs) {
                // Polimorfisme: Memanggil tampilkanInfo() untuk mendapatkan format array
                $info = $mhs->tampilkanInfo();
                $dataArray[] = [
                    'nim' => $info['NIM'],
                    'nama' => $info['Nama'],
                    'jenis_kelamin' => $info['Jenis Kelamin'],
                    'tugas' => $info['Pengerjaan Tugas'],
                    'jurusan' => $info['Jurusan'],
                ];
            }

            Storage::disk('local')->put($this->filePath, json_encode($dataArray, JSON_PRETTY_PRINT));
        } catch (Exception $e) {
            throw new Exception("Gagal menyimpan data ke file: " . $e->getMessage());
        }
    }

    // Pointer/Reference: Menambahkan mahasiswa baru dengan mereferensikan array asli
    public function add(Mahasiswa $mhs): void
    {
        $students = $this->getAll();
        
        // Cek duplikasi NIM
        foreach ($students as $s) {
            if ($s->getNim() === $mhs->getNim()) {
                throw new Exception("NIM sudah terdaftar!");
            }
        }

        $students[] = $mhs;
        $this->saveAll($students);
    }

    // Mengedit data mahasiswa yang sudah ada
    public function update(string $nim, string $nama, string $jenisKelamin, string $tugas, string $jurusan): void
    {
        $students = $this->getAll();
        $found = false;

        foreach ($students as $s) {
            if ($s->getNim() === $nim) {
                $s->setNama($nama);
                $s->setJenisKelamin($jenisKelamin);
                $s->setTugas($tugas);
                $s->setJurusan($jurusan);
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new Exception("Mahasiswa dengan NIM $nim tidak ditemukan!");
        }

        $this->saveAll($students);
    }

    // Menghapus data mahasiswa
    public function delete(string $nim): void
    {
        $students = $this->getAll();
        $filtered = array_filter($students, function ($s) use ($nim) {
            return $s->getNim() !== $nim;
        });

        if (count($students) === count($filtered)) {
            throw new Exception("Mahasiswa tidak ditemukan untuk dihapus!");
        }

        $this->saveAll(array_values($filtered));
    }

    // Pointer/Reference (&): Urutkan data menggunakan Bubble Sort langsung di memori asal
    public function bubbleSort(array &$list, string $sortBy = 'nama'): void
    {
        $n = count($list);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                
                switch ($sortBy) {
                    case 'nim':
                        $val1 = $list[$j]->getNim();
                        $val2 = $list[$j + 1]->getNim();
                        break;
                    case 'jenis_kelamin':
                        $val1 = $list[$j]->getJenisKelamin();
                        $val2 = $list[$j + 1]->getJenisKelamin();
                        break;
                    case 'tugas':
                        $val1 = $list[$j]->getTugas();
                        $val2 = $list[$j + 1]->getTugas();
                        break;
                    case 'jurusan':
                        $val1 = $list[$j]->getJurusan();
                        $val2 = $list[$j + 1]->getJurusan();
                        break;
                    case 'nama':
                    default:
                        $val1 = $list[$j]->getNama();
                        $val2 = $list[$j + 1]->getNama();
                        break;
                }

                if (strcasecmp($val1, $val2) > 0) {
                    // Tukar posisi (swap)
                    $temp = $list[$j];
                    $list[$j] = $list[$j + 1];
                    $list[$j + 1] = $temp;
                }
            }
        }
    }

    // Pointer/Reference (&): Urutkan data menggunakan Selection Sort langsung di memori asal
    public function selectionSort(array &$list, string $sortBy = 'nama'): void
    {
        $n = count($list);
        for ($i = 0; $i < $n - 1; $i++) {
            $minIdx = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                
                switch ($sortBy) {
                    case 'nim':
                        $val1 = $list[$j]->getNim();
                        $val2 = $list[$minIdx]->getNim();
                        break;
                    case 'jenis_kelamin':
                        $val1 = $list[$j]->getJenisKelamin();
                        $val2 = $list[$minIdx]->getJenisKelamin();
                        break;
                    case 'tugas':
                        $val1 = $list[$j]->getTugas();
                        $val2 = $list[$minIdx]->getTugas();
                        break;
                    case 'jurusan':
                        $val1 = $list[$j]->getJurusan();
                        $val2 = $list[$minIdx]->getJurusan();
                        break;
                    case 'nama':
                    default:
                        $val1 = $list[$j]->getNama();
                        $val2 = $list[$minIdx]->getNama();
                        break;
                }

                if (strcasecmp($val1, $val2) < 0) {
                    $minIdx = $j;
                }
            }
            // Swap
            $temp = $list[$i];
            $list[$i] = $list[$minIdx];
            $list[$minIdx] = $temp;
        }
    }

    // Searching: Linear Search (Mencari teks parsial pada nama/NIM/jurusan)
    public function linearSearch(array $list, string $keyword): array
    {
        $results = [];
        foreach ($list as $s) {
            if (
                stripos($s->getNama(), $keyword) !== false ||
                stripos($s->getNim(), $keyword) !== false ||
                stripos($s->getJurusan(), $keyword) !== false
            ) {
                $results[] = $s;
            }
        }
        return $results;
    }


    // Searching: Binary Search (Pencarian cepat berdasarkan NIM presisi)
    // Syarat: List harus diurutkan berdasarkan NIM terlebih dahulu
    public function binarySearch(array $list, string $targetNim): ?Mahasiswa
    {
        // Urutkan list berdasarkan NIM dulu
        $this->bubbleSort($list, 'nim');

        $low = 0;
        $high = count($list) - 1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            $midNim = $list[$mid]->getNim();

            if ($midNim === $targetNim) {
                return $list[$mid]; // Ketemu
            }

            if (strcasecmp($midNim, $targetNim) < 0) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        return null; // Tidak ketemu
    }
}
