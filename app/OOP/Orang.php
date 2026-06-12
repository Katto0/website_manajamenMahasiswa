<?php

namespace App\OOP;

class Orang {

    protected string $nama;
    protected string $jenisKelamin;

    public function __construct(string $nama, string $jenisKelamin)
    {
        $this->nama = $nama;
        $this->jenisKelamin = $jenisKelamin;
    }

    // Getter untuk Nama
    public function getNama(): string
    {
        return $this->nama;
    }

    // Setter untuk Nama
    public function setNama(): string
    {
        return $this->nama;
    }

    // Getter untuk Jenis Kelamin
    public function getJenisKelamin(): string
    {
        return $this->jenisKelamin;
    }

    // Setter untuk Jenis Kelamin
    public function setJenisKelamin(string $jenisKelamin): void
    {
        $this->jenisKelamin = $jenisKelamin;
    }

    
    public function tampilkanInfo(): array
    {
        return [
            "Nama" => $this->nama,
            "Jenis Kelamin" => $this->jenisKelamin
        ];
    }

}