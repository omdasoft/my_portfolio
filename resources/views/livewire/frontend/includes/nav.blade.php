<nav class="flex justify-between items-center">
    <a href="#" class="text-2xl text-black-400 font-montserrat">
        <img src="assets/images/logo.png" width="180" alt="logo" title="logo">
    </a>
    <ul class="flex gap-16 max-md:hidden">
        <li>
            <a href="#about"
                class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">About</a>
        </li>
        <li>
            <a href="#work"
                class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">My
                Work</a>
        </li>
        <li>
            <a href="#blog"
                class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Blog</a>
        </li>
        <li>
            <a href="#hire"
                class="font-montserrat leading-normal text-lg text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Hire
                Me</a>
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
        <img src="assets/images/hamburger.svg" alt='Hamburger' width="25" height="25" id="toggleMenuBtn"
            class="hover:cursor-pointer" />
        <img src="assets/images/close.png" class="hidden hover:cursor-pointer" width="25" height="25"
            id="closeMenuBtn" />
    </div>
    
    <!--Mobile nav-->
    <div id="mobileNav" class="absolute z-10 top-0 left-0 w-full h-screen bg-white px-6 py-6 hidden">
        <ul class="block space-y-3">
            <li>
                <a href="#about" onclick="toggleMenu()"
                    class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">About</a>
            </li>
            <li>
                <a href="#work" onclick="toggleMenu()"
                    class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">My
                    Work</a>
            </li>
            <li>
                <a href="#blog" onclick="toggleMenu()"
                    class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Blog</a>
            </li>
            <li>
                <a href="#hire" onclick="toggleMenu()"
                    class="font-montserrat leading-normal text-md text-slate-gray hover:underline hover:decoration-2 hover:underline-offset-8 hover:decoration-indigo-600 hover:text-gray-500">Hire
                    Me</a>
            </li>
        </ul>
    </div>
</nav>