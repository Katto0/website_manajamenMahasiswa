<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 backdrop-blur-md bg-white/90">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('mahasiswa.index') }}" class="flex items-center gap-2.5">

            <img src="{{ asset('images/logo.webp') }}" alt="" class="w-14 h-14 rounded-2xl">

            <span class="self-center text-xl font-bold whitespace-nowrap text-slate-900 tracking-tight">
                Mahasiswa<span class="text-primary">Hub</span>
            </span>
        </a>

        <!-- Menu Kanan: User Profile & Dropdown -->
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse relative">
            @if (session()->has('username'))
                <button type="button"
                    class="flex text-sm bg-slate-50 border border-slate-200 rounded-full md:me-0 focus:ring-4 focus:ring-slate-100 focus:outline-none cursor-pointer"
                    id="user-menu-button" aria-expanded="false"
                    onclick="event.stopPropagation(); document.getElementById('user-dropdown').classList.toggle('hidden')">
                    <span class="sr-only">Open user menu</span>
                    <!-- Generate avatar image dynamically using UI Avatars -->
                    <img class="w-8 h-8 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ urlencode(session('username')) }}&background=4f46e5&color=fff&bold=true"
                        alt="User Avatar">
                </button>

                <!-- Dropdown menu -->
                <div class="z-50 hidden absolute right-0 top-11 bg-white border border-slate-200 rounded-xl shadow-lg w-48 py-1 animate-fade-in"
                    id="user-dropdown">
                    <div class="px-4 py-3 text-sm border-b border-slate-100">
                        <span class="block text-slate-900 font-bold">{{ session('username') }}</span>
                        <span class="block text-slate-500 text-xs truncate">admin@mahasiswahub.com</span>
                    </div>
                    <ul class="p-1.5 text-sm font-semibold text-slate-700 space-y-0.5"
                        aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('mahasiswa.index') }}"
                                class="inline-flex items-center w-full px-3 py-2 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.create') }}"
                                class="inline-flex items-center w-full px-3 py-2 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                                Tambah Mahasiswa
                            </a>
                        </li>
                        <li class="border-t border-slate-100 my-1 pt-1">
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center w-full px-3 py-2 text-danger hover:bg-rose-50 hover:text-rose-700 rounded-lg transition-colors font-bold text-left cursor-pointer">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Hamburger Button (Mobile) -->
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-slate-500 rounded-xl md:hidden hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors"
                aria-controls="navbar-user" aria-expanded="false"
                onclick="document.getElementById('navbar-user').classList.toggle('hidden')">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
        </div>

        <!-- Menu Navigasi Kiri / Tengah (Dashboard & Add) -->
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="font-semibold flex flex-col p-4 md:p-0 mt-4 border border-slate-100 rounded-2xl bg-slate-50/70 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-transparent">
                <li>
                    <a href="{{ route('mahasiswa.index') }}"
                        class="block py-2 px-3 rounded-xl md:p-0 {{ request()->routeIs('mahasiswa.index') ? 'text-primary bg-indigo-50/80 md:bg-transparent md:text-primary' : 'text-slate-700 hover:text-primary hover:bg-slate-100/50 md:hover:bg-transparent' }}"
                        aria-current="page">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.create') }}"
                        class="block py-2 px-3 rounded-xl md:p-0 {{ request()->routeIs('mahasiswa.create') ? 'text-primary bg-indigo-50/80 md:bg-transparent md:text-primary' : 'text-slate-700 hover:text-primary hover:bg-slate-100/50 md:hover:bg-transparent' }}">
                        Tambah Mahasiswa
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const button = document.getElementById('user-menu-button');
        if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
