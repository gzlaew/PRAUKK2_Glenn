<!-- Start Sidebar -->
<nav class="sidebar lg:z-[9] z-[10]">
    <div class="h-full bg-white dark:bg-darklight group-data-[sidebar=dark]/item:bg-darklight group-data-[sidebar=brand]/item:bg-sky-950 ">
        <div class="p-4">
        <a href="{{ url('/dashboard') }}" class="w-full main-logo flex items-center space-x-3">
            @php
                use App\Models\settings;
                $setting = settings::first();
            @endphp
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 w-12 object-cover rounded-full" alt="Logo" />
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $setting->name }}</h2>
        </a>
        </div>
        <div class="h-[calc(100vh-60px)]  overflow-y-auto overflow-x-hidden px-5 pb-4 space-y-16 detached-menu">
            <ul class="relative flex flex-col gap-1 " x-data="sidebarMenu">
                <h2 class="my-2 text-sm text-black/50 dark:text-white/30 group-data-[sidebar=dark]/item:text-white/30 group-data-[sidebar=brand]/item:text-sky-200/50"><span>Menu</span></h2>
                 <li class="menu nav-item">
                    <a href="{{ url('users') }}" class="nav-link group" :class="{'active' : isActive('users')}" @click="toggle('users')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Users</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link group" :class="{'active' : isActive('dashboard')}" @click="toggle('dashboard')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item"class="menu nav-item">
                    <a href="{{ url('shift') }}" class="nav-link group" :class="{'active' : isActive('shift')}" @click="toggle('shifts')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Shifts</span>
                        </div>
                    </a>
                </li>
                                <li class="menu nav-item"class="menu nav-item">
                    <a href="{{ url('alat') }}" class="nav-link group" :class="{'active' : isActive('alat')}" @click="toggle('alats')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Alat</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item"class="menu nav-item">
                    <a href="{{ url('jamkerja') }}" class="nav-link group" :class="{'active' : isActive('jamkerja')}" @click="toggle('jamkerjas')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Jam Kerja</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item"class="menu nav-item">
                    <a href="{{ url('sparepart') }}" class="nav-link group" :class="{'active' : isActive('sparepart')}" @click="toggle('spareparts')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Data Sparepart</span>
                        </div>
                    </a>
                </li>
                 <li class="menu nav-item"class="menu nav-item">
                    <a href="{{ url('riwayat') }}" class="nav-link group" :class="{'active' : isActive('riwayat')}" @click="toggle('riwayats')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Riwayat data Sparepart</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="{{ url('settings') }}" class="nav-link group" :class="{'active' : isActive('user')}" @click="toggle('settings')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Setting Aplikasi</span>
                        </div>
                    </a>
                </li>
                 <li class="menu nav-item">
                    <a href="{{ url('peminjaman') }}" class="nav-link group" :class="{'active' : isActive('user')}" @click="toggle('peminjaman')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Peminjaman</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="{{ url('service') }}" class="nav-link group" :class="{'active' : isActive('user')}" @click="toggle('service')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">service</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="{{ url('absensi') }}" class="nav-link group" :class="{'active' : isActive('user')}" @click="toggle('absensi')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">absensi</span>
                        </div>
                    </a>
                </li>

                <h2 class="my-2 text-sm text-black/50 dark:text-white/30 group-data-[sidebar=dark]/item:text-white/30 group-data-[sidebar=brand]/item:text-sky-200/50"><span>Supports</span></h2>

                <li class="menu nav-item">
                    <a href="https://triyatna.is-a.dev/" target="_blank" class="nav-link group" :class="{'active' : isActive('docs')}">
                        <div class="flex items-center">
                            <i class="ri-bookmark-3-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Website</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
