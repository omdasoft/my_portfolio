<!doctype html>
<html class="!scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet">
    <title>Emad Aldin Ali</title>
</head>

<body>
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu blur-3xl sm:-top-1/6" aria-hidden="true">
        <div
            class="relative aspect-[1155/678] -translate-x-1/2 rotate-[60deg] bg-gradient-to-r opacity-10 sm:left-[calc(70%-30rem)] sm:w-[72.1875rem] bg-gradient-to-r from-blue-300 via-indigo-500 to-purple-600">
        </div>
    </div>

    <header
        class="relative mb-16 md:mb-36 max-w-[52rem] mx-auto px-4 sm:px-6 md:px-8 xl:px-12 lg:max-w-7xl pt-6 md:w-auto">
        <livewire:frontend.includes.nav />
    </header>
    <!--//end header-->

    <main class="h-full mb-20 relative max-w-[52rem] mx-auto px-6 sm:px-6 md:px-8 xl:px-12 lg:max-w-7xl md:w-auto">
        {{ $slot }}
    </main>
    <!--//end main-->

    <footer
        class="mb-20 text-gray-500 text-sm relative max-w-[52rem] mx-auto px-4 sm:px-6 md:px-8 xl:px-12 lg:max-w-7xl pt-6 md:w-auto md:flex items-center">
        <span>© Emad Aldin 2023. All rights reserved.</span>
        <div class="ml-auto mt-5 mb:mt-0">
            <nav>
                <ul class="text-xs flex space-x-5">
                    <li class="uppercase">
                        <a href="https://twitter.com/themsaid">Twitter</a>
                    </li>
                    <li class="uppercase">
                        <a href="https://www.youtube.com/themsaid">Linkedin</a>
                    </li>
                    <li class="uppercase">
                        <a href="https://www.youtube.com/themsaid">Github</a>
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
    <!--//end footer-->
    <script>
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const toggleMenuBtn = document.getElementById('toggleMenuBtn');
        const mobileNav = document.getElementById('mobileNav');

        toggleMenuBtn.onclick = () => {
            toggleMenu();
        }

        closeMenuBtn.onclick = () => {
            toggleMenu();
        }

        function toggleMenu() {
            mobileNav.classList.toggle("hidden");
            toggleBtns();
        }

        function toggleBtns() {
            closeMenuBtn.classList.toggle('hidden');
            toggleMenuBtn.classList.toggle('hidden');
        }

        // Get the 'to top' button element by ID
        var toTopButton = document.getElementById("to-top-button");

        // Check if the button exists
        if (toTopButton) {

            // On scroll event, toggle button visibility based on scroll position
            window.onscroll = function () {
                if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                    toTopButton.classList.remove("hidden");
                } else {
                    toTopButton.classList.add("hidden");
                }
            };

            // Function to scroll to the top of the page smoothly
            window.goToTop = function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
        }

    </script>
</body>

</html>