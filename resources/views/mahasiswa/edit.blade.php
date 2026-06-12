@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4 py-2">
            <a href="{{ route('mahasiswa.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Ubah Data Mahasiswa</h1>
                <p class="text-sm text-slate-500">Ubah informasi data mahasiswa di bawah ini. NIM bersifat tetap (readonly).
                </p>
            </div>
        </div>

        <!-- Card Form Grid -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-8 shadow-sm">
            <form action="{{ route('mahasiswa.update', ['nim' => $student->getNim()]) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Grid Konten -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-bold text-slate-900 tracking-wide uppercase">Informasi Pribadi</h3>
                            <p class="text-xs text-slate-400">Nama lengkap dan kontak mahasiswa.</p>
                        </div>

                        <!-- Nama -->
                        <div class="space-y-2">
                            <label for="nama" class="text-xs font-semibold text-slate-600">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama"
                                value="{{ old('nama', $student->getNama()) }}" placeholder="Contoh: I Made Devano"
                                class="w-full px-4 py-3 text-sm bg-slate-50 border @error('nama') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @else border-slate-200 focus:border-primary focus:ring-primary/20 @enderror rounded-xl focus:outline-none focus:bg-white focus:ring-2 transition-all">
                            @error('nama')
                                <p class="text-xs text-rose-650 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[10px] text-slate-400">Hanya berupa huruf dan spasi (3-50 karakter).</p>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-slate-600">Jenis Kelamin</label>
                            <div class="flex gap-6 pt-1">
                                <label class="inline-flex items-center text-sm gap-2 cursor-pointer group">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki"
                                        {{ old('jenis_kelamin', $student->getJenisKelamin()) === 'Laki-laki' ? 'checked' : '' }}
                                        class="w-4.5 h-4.5 text-primary border-slate-350 focus:ring-primary">
                                    <span class="text-slate-700 group-hover:text-slate-900 font-medium">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center text-sm gap-2 cursor-pointer group">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                                        {{ old('jenis_kelamin', $student->getJenisKelamin()) === 'Perempuan' ? 'checked' : '' }}
                                        class="w-4.5 h-4.5 text-primary border-slate-350 focus:ring-primary">
                                    <span class="text-slate-700 group-hover:text-slate-900 font-medium">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="text-xs text-rose-655 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pengerjaan Tugas -->
                        <div class="space-y-2">
                            <label for="tugas" class="text-xs font-semibold text-slate-600">Pengerjaan Tugas</label>
                            <select name="tugas" id="tugas" 
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border @error('tugas') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @else border-slate-200 focus:border-primary focus:ring-primary/20 @enderror rounded-xl focus:outline-none focus:bg-white focus:ring-2 transition-all">
                                <option value="Selesai" {{ old('tugas', $student->getTugas()) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Belum Selesai" {{ old('tugas', $student->getTugas()) === 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                            </select>
                            @error('tugas')
                                <p class="text-xs text-rose-650 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-bold text-slate-900 tracking-wide uppercase">Informasi Akademik</h3>
                            <p class="text-xs text-slate-400">NIM universitas dan program studi.</p>
                        </div>

                        <!-- NIM -->
                        <div class="space-y-2">
                            <label for="nim" class="text-xs font-semibold text-slate-600">NIM (Nomor Induk
                                Mahasiswa)</label>
                            <input type="text" id="nim" value="{{ $student->getNim() }}" readonly
                                class="w-full px-4 py-3 text-sm bg-slate-100 border border-slate-200 text-slate-500 rounded-xl cursor-not-allowed focus:outline-none font-mono">
                            <p class="text-[10px] text-slate-400">NIM bersifat unik dan tidak dapat diubah kembali.</p>
                        </div>

                        <!-- Jurusan -->
                        <div class="space-y-2">
                            <label for="jurusan" class="text-xs font-semibold text-slate-600">Jurusan / Program
                                Studi</label>
                            <input type="text" name="jurusan" id="jurusan"
                                value="{{ old('jurusan', $student->getJurusan()) }}"
                                placeholder="Contoh: Teknik Informatika"
                                class="w-full px-4 py-3 text-sm bg-slate-50 border @error('jurusan') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @else border-slate-200 focus:border-primary focus:ring-primary/20 @enderror rounded-xl focus:outline-none focus:bg-white focus:ring-2 transition-all">
                            @error('jurusan')
                                <p class="text-xs text-rose-650 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[10px] text-slate-400">Hanya berupa huruf dan spasi.</p>
                        </div>
                    </div>

                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-slate-150">
                    <a href="{{ route('mahasiswa.index') }}"
                        class="w-full sm:w-auto text-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
