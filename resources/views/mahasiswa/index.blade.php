@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="relative flex items-center justify-center min-h-screen overflow-hidden rounded-3xl bg-slate-900 text-white p-6 md:p-16 text-center shadow-lg"
            style="background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), url('{{ asset('images/background.webp') }}'); background-size: cover; background-position: center;">
            <div class="max-w-4xl mx-auto flex flex-col items-center justify-center space-y-6 py-8">
                <img src="{{ asset('images/logo.webp') }}" alt="Logo"
                    class="w-32 h-32 object-cover rounded-2xl shadow-xl border-2 border-white/20">

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white">Manajemen Data Mahasiswa
                </h1>
                <p class="text-sm md:text-lg text-slate-200 max-w-3xl leading-relaxed">
                    Kelola seluruh informasi mahasiswa dengan lebih mudah, cepat, dan terstruktur. Sistem ini membantu Anda
                    menyimpan, mengelola, memperbarui, serta mencari data mahasiswa secara efisien dalam satu platform yang
                    terintegrasi.
                </p>
            </div>
        </div>

        <!-- Filters: Search & Sort Forms -->
        <div id="daftar-mahasiswa" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <form method="GET" action="{{ route('mahasiswa.index') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-4">

                <!-- Pencarian (Searching) -->
                <div class="lg:col-span-5 space-y-1">
                    <label for="search" class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Pencarian
                        Data</label>
                    <div class="flex gap-2">
                        <input type="text" name="search" id="search" value="{{ $search }}"
                            placeholder="Cari Nama, NIM, atau Jurusan..."
                            class="w-full px-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-colors">
                        <select name="search_type"
                            class="px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-colors">
                            <option value="linear" {{ $searchType === 'linear' ? 'selected' : '' }}>Linear Search
                                (Nama/Jurusan)</option>
                            <option value="binary" {{ $searchType === 'binary' ? 'selected' : '' }}>Binary Search (NIM)
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Pengurutan (Sorting) -->
                <div class="lg:col-span-5 space-y-1">
                    <label for="sort_by" class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Pengurutan
                        (Sorting)</label>
                    <div class="flex gap-2">
                        <select name="sort_by" id="sort_by"
                            class="w-1/2 px-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-colors">
                            <option value="nama" {{ $sortBy === 'nama' ? 'selected' : '' }}>Nama Mahasiswa</option>
                            <option value="nim" {{ $sortBy === 'nim' ? 'selected' : '' }}>Nomor Induk Mahasiswa</option>
                        </select>
                        <select name="sort_method"
                            class="w-1/2 px-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-colors">
                            <option value="bubble" {{ $sortMethod === 'bubble' ? 'selected' : '' }}>Bubble Sort</option>
                            <option value="selection" {{ $sortMethod === 'selection' ? 'selected' : '' }}>Selection Sort
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="lg:col-span-2 flex flex-col justify-end">
                    <span
                        class="hidden lg:block text-xs font-semibold text-transparent uppercase tracking-wider select-none mb-1">Aksi</span>
                    <div class="flex gap-2 w-full">
                        <button type="submit"
                            class="flex-grow px-4 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded-xl shadow-md transition-all cursor-pointer">
                            Terapkan
                        </button>
                        <a href="{{ route('mahasiswa.index') }}"
                            class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all flex items-center justify-center"
                            title="Reset Filters">
                            Reset
                        </a>
                    </div>
                </div>

            </form>
        </div>

        <!-- Data Table & Mobile Cards -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <!-- Mobile View -->
            <div class="block md:hidden divide-y divide-slate-150">
                @forelse ($paginatedStudents as $student)
                    @php
                        $info = $student->tampilkanInfo();
                    @endphp
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-650 rounded-lg">
                                {{ $info['NIM'] }}
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase {{ $info['Jenis Kelamin'] === 'Laki-laki' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-pink-50 text-pink-700 border border-pink-100' }}">
                                {{ $info['Jenis Kelamin'] }}
                            </span>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-900 text-base leading-tight">{{ $info['Nama'] }}</h4>
                            <div class="mt-2.5 space-y-1.5">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                        </path>
                                    </svg>
                                    <span class="font-medium text-slate-700">{{ $info['Jurusan'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    <span class="truncate">{{ $info['Pengerjaan Tugas'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                            <a href="{{ route('mahasiswa.edit', ['nim' => $info['NIM']]) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-primary bg-indigo-50/70 hover:bg-primary hover:text-white px-3 py-2 rounded-xl transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('mahasiswa.destroy', ['nim' => $info['NIM']]) }}" method="POST"
                                class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-danger bg-rose-50/70 hover:bg-danger hover:text-white px-3 py-2 rounded-xl transition-all cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 px-6 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <p class="text-sm font-semibold">Data mahasiswa tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-6">NIM</th>
                            <th class="py-4 px-6">Nama</th>
                            <th class="py-4 px-6">Jenis Kelamin</th>
                            <th class="py-4 px-6">Pengerjaan Tugas</th>
                            <th class="py-4 px-6">Jurusan</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($paginatedStudents as $student)
                            @php
                                $info = $student->tampilkanInfo();
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 font-mono font-medium text-slate-600">{{ $info['NIM'] }}</td>
                                <td class="py-4 px-6 font-semibold text-slate-900">{{ $info['Nama'] }}</td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $info['Jenis Kelamin'] === 'Laki-laki' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                        {{ $info['Jenis Kelamin'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-500">{{ $info['Pengerjaan Tugas'] }}</td>
                                <td class="py-4 px-6 text-slate-700 font-medium">{{ $info['Jurusan'] }}</td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('mahasiswa.edit', ['nim' => $info['NIM']]) }}"
                                        class="inline-flex items-center text-xs font-semibold text-primary hover:opacity-85 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', ['nim' => $info['NIM']]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-xs font-semibold text-danger hover:opacity-85 transition-colors cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <p class="text-sm font-medium">Data mahasiswa tidak ditemukan.</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci atau tambah data baru.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if ($totalPages > 1)
                <div class="flex items-center justify-between border-t border-slate-200 bg-slate-50/50 px-4 py-4 sm:px-6">
                    <!-- Mobile View -->
                    <div class="flex flex-1 justify-between sm:hidden">
                        @if ($page > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
                                class="relative inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">Sebelumnya</a>
                        @else
                            <span
                                class="relative inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-xs font-bold text-slate-400 cursor-not-allowed">Sebelumnya</span>
                        @endif

                        @if ($page < $totalPages)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
                                class="relative ml-3 inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">Selanjutnya</a>
                        @else
                            <span
                                class="relative ml-3 inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-xs font-bold text-slate-400 cursor-not-allowed">Selanjutnya</span>
                        @endif
                    </div>

                    <!-- Desktop View -->
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Menampilkan
                                <span
                                    class="font-bold text-slate-800">{{ $total > 0 ? ($page - 1) * $limit + 1 : 0 }}</span>
                                sampai
                                <span class="font-bold text-slate-800">{{ min($page * $limit, $total) }}</span>
                                dari
                                <span class="font-bold text-slate-800">{{ $total }}</span>
                                mahasiswa
                            </p>
                        </div>
                        <div>
                            <nav aria-label="Page navigation example">
                                <ul class="flex -space-x-px text-sm select-none">
                                    <li>
                                        @if ($page > 1)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
                                                class="flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-l-xl w-10 h-10 focus:outline-none transition-colors">
                                                <span class="sr-only">Previous</span>
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                                </svg>
                                            </a>
                                        @else
                                            <span
                                                class="flex items-center justify-center text-slate-300 bg-slate-50 border border-slate-200 font-semibold rounded-l-xl w-10 h-10 cursor-not-allowed">
                                                <span class="sr-only">Previous</span>
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                                </svg>
                                            </span>
                                        @endif
                                    </li>

                                    @for ($i = 1; $i <= $totalPages; $i++)
                                        <li>
                                            @if ($i === $page)
                                                <span aria-current="page"
                                                    class="flex items-center justify-center text-white bg-primary border border-slate-200 font-bold text-sm w-10 h-10 focus:outline-none">
                                                    {{ $i }}
                                                </span>
                                            @else
                                                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                                    class="flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm w-10 h-10 focus:outline-none transition-colors">
                                                    {{ $i }}
                                                </a>
                                            @endif
                                        </li>
                                    @endfor

                                    <li>
                                        @if ($page < $totalPages)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
                                                class="flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-r-xl w-10 h-10 focus:outline-none transition-colors">
                                                <span class="sr-only">Next</span>
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                                </svg>
                                            </a>
                                        @else
                                            <span
                                                class="flex items-center justify-center text-slate-300 bg-slate-50 border border-slate-200 font-semibold rounded-r-xl w-10 h-10 cursor-not-allowed">
                                                <span class="sr-only">Next</span>
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                                </svg>
                                            </span>
                                        @endif
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (request()->has('search') || request()->has('sort_by') || request()->has('page'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const element = document.getElementById("daftar-mahasiswa");
                if (element) {
                    setTimeout(() => {
                        element.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });
                    }, 100);
                }
            });
        </script>
    @endif
@endsection
