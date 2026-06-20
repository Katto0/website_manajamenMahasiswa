<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke Portal Manajemen Mahasiswa - MahasiswaHub">
    <meta name="keywords" content="login, mahasiswahub, mahasiswa, manajemen mahasiswa">
    <meta name="author" content="MahasiswaHub">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Login - MahasiswaHub">
    <meta property="og:description" content="Login ke Portal Manajemen Mahasiswa - MahasiswaHub">
    <meta property="og:image" content="{{ asset('images/logo.webp') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Login - MahasiswaHub">
    <meta property="twitter:description" content="Login ke Portal Manajemen Mahasiswa - MahasiswaHub">
    <meta property="twitter:image" content="{{ asset('images/logo.webp') }}">

    <title>Login - MahasiswaHub</title>

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white min-h-screen flex items-center justify-center p-4">

    <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="flex flex-col justify-center px-2 md:px-12">

            <!-- Mobile Logo / Branding (hanya muncul di mobile) -->
            <div class="flex flex-col items-center text-center mb-6 md:hidden">
                <div
                    class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center shadow-md shadow-indigo-200 mb-3 animate-bounce">
                    <img src="{{ asset('images/logo.webp') }}" alt="Logo"
                        class="w-full h-full object-cover rounded-xl border border-white/10">
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Mahasiswa<span class="text-primary">Hub</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Sistem Informasi Manajemen Data Mahasiswa</p>
            </div>

            <!-- Notifikasi Error dari Controller -->
            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Notifikasi Logout Sukses -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Card Login -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 sm:p-8 shadow-2xl shadow-slate-150">
                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Input Username -->
                    <div class="space-y-2">
                        <label for="username" class="text-xs font-semibold text-slate-500">Your username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all shadow-sm">
                    </div>

                    <!-- Input Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-semibold text-slate-500">Your password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all shadow-sm">
                    </div>


                    <button type="submit"
                        class="w-full sm:w-32 py-3 px-6 text-sm font-semibold tracking-wider text-white bg-secondary hover:bg-secondary-hover rounded-xl shadow-md transition-all uppercase">
                        MASUK
                    </button>

                </form>
            </div>
        </div>

        <div class="hidden md:flex flex-col items-center justify-center text-center space-y-6 px-4">
            <div class="space-y-2">
                <h1 class="text-4xl md:text-5xl font-extrabold text-secondary tracking-tight leading-none uppercase">
                    MAHASISWA<br><span class="text-secondary">PORTAL</span>
                </h1>
            </div>

            <div
                class="relative w-80 h-80 md:w-96 md:h-96 rounded-t-full overflow-hidden bg-sky-100 flex items-end justify-center shadow-lg border border-slate-100">
                <img src="{{ asset('images/login_student_illustration.webp') }}" alt="Ilustrasi Mahasiswa"
                    class="w-full h-full object-cover" loading="lazy">
            </div>

        </div>

    </div>

</body>

</html>
