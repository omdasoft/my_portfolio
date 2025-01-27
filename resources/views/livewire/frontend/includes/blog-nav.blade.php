<nav class="flex justify-between items-center">
    <a href="{{ route('index') }}" class="text-2xl text-black-400 font-montserrat">
        <img src="{{ asset('assets/images/logo.png') }}" width="180" alt="logo" title="logo">
    </a>
    <ul class="flex gap-16 max-md:hidden">
        <li>
            <a href="{{ route('index') }}"
                class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Home</a>
        </li>

        </li>
            @auth
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">
                        Dashboard</a>
                </li>
            @endauth
        </ul>
    <div class='hidden max-md:block z-20'>
        <img src="{{ asset('assets/images/hamburger.svg') }}" alt='Hamburger' width="25" height="25" id="toggleMenuBtn"
            class="hover:cursor-pointer" />
        <img src="{{ asset('assets/images/close.png') }}" class="hidden hover:cursor-pointer" width="25" height="25"
            id="closeMenuBtn" />
    </div>
    
    <!--Mobile nav-->
    <div id="mobileNav" class="absolute z-10 top-0 left-0 w-full h-screen bg-white px-6 py-6 hidden">
        <ul class="block space-y-3">
            <li>
                <a href="/" onclick="toggleMenu()"
                    class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Home</a>
            </li>
            @if(request()->routeIs('posts.show'))                
                <li>
                    <a href="/posts" onclick="toggleMenu()"
                        class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Blogs</a>
                </li>
            @endif
        </ul>
    </div>
</nav>