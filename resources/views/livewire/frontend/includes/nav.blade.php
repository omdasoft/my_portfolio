<nav class="flex justify-between items-center">
    <a href="{{ route('index') }}" class="text-2xl text-black-400 font-montserrat">
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
            <a href="#hire" wire:click="showModal"
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
        <img src="{{ asset('assets/images/hamburger.svg') }}" alt='Hamburger' width="25" height="25"
            id="toggleMenuBtn" class="hover:cursor-pointer" />
        <img src="{{ asset('assets/images/close.png') }}" class="hidden hover:cursor-pointer" width="25"
            height="25" id="closeMenuBtn" />
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
    <x-modal name="contact-me" :show="$show">
        <div class="modal-content px-4 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-lg font-bold">
                        Book a call.
                    </div>
                    <div class="text-zinc-300 font-medium">
                        Let's discuss your next project.
                    </div>
                </div>
                <button class="btn btn-sm btn-circle btn-ghost"
                @click="$dispatch('close-modal', 'contact-me')">
                    <svg class="size-6 fill-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                            clip-rule="evenodd"></path>
                    </svg> </button>
            </div>
            <form wire:submit.prevent="store" class="py-3 space-y-6 px-3">
                @csrf
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-input-label for="name" value="Name" />
                        <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="w-1/2">
                        <x-input-label for="email" value="Email" />
                        <x-text-input wire:model="email" id="email" name="email" type="text" class="mt-1 block w-full" required autocomplete="email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <x-text-area wire:model="description" id="description" name="description" type="text" class="mt-1 block w-full" required autocomplete="description" rows="5"/>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                
                <div class="flex items-center gap-2 mb-3">
                    <x-primary-button>Save</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</nav>
