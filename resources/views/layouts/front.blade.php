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
        @section('header')
            <livewire:frontend.includes.nav />
        @show
    </header>
    <!--//end header-->

    <main class="h-full mb-20 relative max-w-[52rem] mx-auto px-6 sm:px-6 md:px-8 xl:px-12 lg:max-w-7xl md:w-auto">
        {{ $slot }}
    </main>
    <!--//end main-->

    <!--Footer-->
    <livewire:frontend.includes.footer />
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