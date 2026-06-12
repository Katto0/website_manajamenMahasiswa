<?php

namespace App\OOP;

class Mahasiswa extends Orang {
    private string $nim;
    private string $tugas;
    private string $jurusan;

    public function __construct(string $nim, string $nama,string $jenisKelamin, string $tugas, string $jurusan) {
        
        // Memanggil constructor dari class parent (Orang)
        parent::__construct($nama, $jenisKelamin);

        $this->nim = $nim;
        $this->tugas = $tugas;
        $this->jurusan = $jurusan;
    }
    
    public function getNim(): string
    {
        return $this->nim;
    }

    public function setNim(string $nim): void
    {
        $this->nim = $nim;
    }

    public function getTugas(): string
    {
        return $this->tugas;
    }

    public function setTugas(string $tugas): void
    {
        $this->tugas = $tugas;
    }

    public function getJurusan(): string
    {
        return $this->jurusan;
    }

    public function setJurusan(string $jurusan): void
    {
        $this->jurusan = $jurusan;
    }

    public function tampilkanInfo(): array
    {
        return [
            'NIM' => $this->nim,
            'Nama' => $this->nama,
            'Jenis Kelamin' => $this->jenisKelamin,
            'Pengerjaan Tugas' => $this->tugas,
            'Jurusan' => $this->jurusan
        ];
    }
}