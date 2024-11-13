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
                    <a href="javascript:void(0);" class="items-center justify-between text-black nav-link group " :class="{'active' : isActive('dashboard')}" @click="toggle('dashboard')">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM15.8329 7.33748C16.0697 7.17128 16.3916 7.19926 16.5962 7.40381C16.8002 7.60784 16.8267 7.92955 16.6587 8.16418C14.479 11.2095 13.2796 12.8417 13.0607 13.0607C12.4749 13.6464 11.5251 13.6464 10.9393 13.0607C10.3536 12.4749 10.3536 11.5251 10.9393 10.9393C11.3126 10.5661 12.9438 9.36549 15.8329 7.33748ZM17.5 11C18.0523 11 18.5 11.4477 18.5 12C18.5 12.5523 18.0523 13 17.5 13C16.9477 13 16.5 12.5523 16.5 12C16.5 11.4477 16.9477 11 17.5 11ZM6.5 11C7.05228 11 7.5 11.4477 7.5 12C7.5 12.5523 7.05228 13 6.5 13C5.94772 13 5.5 12.5523 5.5 12C5.5 11.4477 5.94772 11 6.5 11ZM8.81802 7.40381C9.20854 7.79433 9.20854 8.4275 8.81802 8.81802C8.4275 9.20854 7.79433 9.20854 7.40381 8.81802C7.01328 8.4275 7.01328 7.79433 7.40381 7.40381C7.79433 7.01328 8.4275 7.01328 8.81802 7.40381ZM12 5.5C12.5523 5.5 13 5.94772 13 6.5C13 7.05228 12.5523 7.5 12 7.5C11.4477 7.5 11 7.05228 11 6.5C11 5.94772 11.4477 5.5 12 5.5Z" fill="currentColor"></path>
                            </svg>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Dashboard</span>
                        </div>
                        <div class="flex items-center justify-center w-4 h-4 dropdown-icon" :class="{'!rotate-180' : isActive('dashboard')}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                                <path d="M11.9997 13.1714L16.9495 8.22168L18.3637 9.63589L11.9997 15.9999L5.63574 9.63589L7.04996 8.22168L11.9997 13.1714Z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </a>
                    <ul x-cloak x-show="isActive('dashboard')" x-collapse class="flex flex-col gap-1 text-black sub-menu dark:text-white/60 group-data-[sidebar=dark]/item:text-white/60 group-data-[sidebar=brand]/item:text-sky-200/50">
                        <li><a href="{{ url('/index') }}">Default</a></li>
                        <li><a href="{{ url('/project-dashboard') }}">Projects</a></li>
                        <li><a href="{{ url('/ecommerce-dashboard') }}">eCommerce</a></li>
                    </ul>
                </li>

                <h2 class="my-2 text-sm text-black/50 dark:text-white/30 group-data-[sidebar=dark]/item:text-white/30 group-data-[sidebar=brand]/item:text-sky-200/50"><span>Supports</span></h2>
                <li class="menu nav-item">
                    <a href="https://sliced-tailwind.netlify.app/docs/html/#change" target="_blank" class="nav-link group" :class="{'active' : isActive('change')}">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path d="M8 4H21V6H8V4ZM4.5 6.5C3.67157 6.5 3 5.82843 3 5C3 4.17157 3.67157 3.5 4.5 3.5C5.32843 3.5 6 4.17157 6 5C6 5.82843 5.32843 6.5 4.5 6.5ZM4.5 13.5C3.67157 13.5 3 12.8284 3 12C3 11.1716 3.67157 10.5 4.5 10.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5ZM4.5 20.4C3.67157 20.4 3 19.7284 3 18.9C3 18.0716 3.67157 17.4 4.5 17.4C5.32843 17.4 6 18.0716 6 18.9C6 19.7284 5.32843 20.4 4.5 20.4ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z" fill="currentColor"></path>
                            </svg>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Changelog</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="https://sliced-tailwind.netlify.app/docs/html/" target="_blank" class="nav-link group" :class="{'active' : isActive('docs')}">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM8 7H16V9H8V7ZM8 11H16V13H8V11ZM8 15H13V17H8V15Z" fill="currentColor"></path>
                            </svg>
                            <span class="ltr:pl-1.5 rtl:pr-1.5">Documentation</span>
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