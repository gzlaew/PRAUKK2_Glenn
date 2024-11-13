<!-- Start Sidebar -->
<nav class="sidebar lg:z-[9] z-[10]">
    <div class="h-full bg-white dark:bg-darklight group-data-[sidebar=dark]/item:bg-darklight group-data-[sidebar=brand]/item:bg-sky-950 ">
        <div class="p-4">
            <a href="{{ url('/index') }}" class="w-full main-logo">
                <img src="{{ URL::asset('build/images/logo-dark.svg') }}" class="mx-auto dark-logo h-7 logo dark:hidden group-data-[sidebar=dark]/item:hidden group-data-[sidebar=brand]/item:hidden" alt="logo" />
                <img src="{{ URL::asset('build/images/logo-light.svg') }}" class="hidden mx-auto light-logo h-7 logo dark:block group-data-[sidebar=dark]/item:block group-data-[sidebar=brand]/item:block" alt="logo" />
                <img src="{{ URL::asset('build/images/logo-icon.svg') }}" class="hidden mx-auto logo-icon h-7" alt="">
            </a>
        </div>
        <div class="h-[calc(100vh-60px)]  overflow-y-auto overflow-x-hidden px-5 pb-4 space-y-16 detached-menu">
            <ul class="relative flex flex-col gap-1 " x-data="sidebarMenu">
                <h2 class="my-2 text-sm text-black/50 dark:text-white/30 group-data-[sidebar=dark]/item:text-white/30 group-data-[sidebar=brand]/item:text-sky-200/50"><span>Menu</span></h2>
                <li class="menu nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link group" :class="{'active' : isActive('dashboard')}" @click="toggle('dashboard')">
                        <div class="flex items-center">
                            <i class="ri-speed-up-line text-lg"></i>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Dashboard</span>
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
            <div class="relative p-4 pt-0 text-center rounded-md bg-purple help-box group-data-[sidebar=brand]/item:bg-sky-500">
                <div class="relative -top-6">
                    <span class="text-black mx-auto border border-black/10 shadow-[0_0.75rem_1.5rem_rgba(18,38,63,.03)]  bg-white flex items-center justify-center h-12 w-12 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM13 13.3551V14H11V12.5C11 11.9477 11.4477 11.5 12 11.5C12.8284 11.5 13.5 10.8284 13.5 10C13.5 9.17157 12.8284 8.5 12 8.5C11.2723 8.5 10.6656 9.01823 10.5288 9.70577L8.56731 9.31346C8.88637 7.70919 10.302 6.5 12 6.5C13.933 6.5 15.5 8.067 15.5 10C15.5 11.5855 14.4457 12.9248 13 13.3551Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </div>
                <h4 class="text-xl text-white">Help Center</h4>
                <p class="mt-4 text-white/70">Looks like there might be a new theme soon.</p>
                <div class="mt-5">
                    <a href="javascript:void(0);" class="btn-white text-slate-500">Go to help</a>
                </div>
            </div>
        </div>
    </div>
</nav>