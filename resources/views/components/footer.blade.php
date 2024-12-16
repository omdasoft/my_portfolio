@props(['profile'])
<footer
class="mb-20 text-gray-500 text-sm relative max-w-[52rem] mx-auto px-4 sm:px-6 md:px-8 xl:px-12 lg:max-w-7xl pt-6 md:w-auto md:flex items-center">
    <span>© Emad Aldin {{ date('Y') }}. All rights reserved.</span>
    <div class="ml-auto mt-5 mb:mt-0">
        <nav>
            <ul class="text-xs flex space-x-5">
                <li class="uppercase">
                    <a href="{{ $profile->twitter }}">Twitter</a>
                </li>
                <li class="uppercase">
                    <a href="{{ $profile->linkedin }}">Linkedin</a>
                </li>
                <li class="uppercase">
                    <a href="{{ $profile->github }}">Github</a>
                </li>
            </ul>
        </nav>
    </div>
    <button id="to-top-button" onclick="goToTop()" title="Go To Top"
        class="hidden fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded-full shadow-md bg-indigo-500 hover:bg-indigo-500 text-white text-lg font-semibold transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
        </svg>
        <span class="sr-only">Go to top</span>
    </button>
</footer>