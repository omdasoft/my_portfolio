<div>

    <!--About section-->
    <x-about :profile="$profile"/>

    <!--Portfolios section-->
    @if($portfolios)
        <div class="mb-16">
            <x-portfolio-list :portfolios="$portfolios" name="Latest Work"/>
            <x-nav-link href="{{ route('portfolios.index') }}">
                view all
            </x-nav-link>
        </div>
    @endif


    <!--Latest post section-->
    @if ($latestPosts)
        <section class="md:flex" id="blog">
            <div class="md:w-2/3 md:mr-20 mb-20">
                <h1
                    class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                    Content
                </h1>

                @foreach ($latestPosts as $post)
                    <x-post-summary :post="$post"/>
                @endforeach
                <div class="w-full flex justify-content-center">
                    <x-nav-link href="{{ route('posts.index') }}">
                        view all
                    </x-nav-link>
                </div>
            </div>
            
            @if ($tags)
                <div class="md:w-1/3">
                    <h1
                        class="mb-5 md:mb-10 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
                        Topics
                    </h1>
                    <div>
                        @foreach ($tags as $tag)
                           <x-tag :tag="$tag"/>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    @endif  

    <!-- Contact Modal -->
    <x-modal name="contact-me" :show="$show">
        <div class="modal-content px-4 py-4">
            <div class="flex justify-between items-start" x-show="!$wire.isSent">
                <div>
                    <div class="text-lg font-bold">
                        Book a call.
                    </div>
                    <div class="text-zinc-300 font-medium">
                        Let's discuss your next project.
                    </div>
                </div>
                <button class="btn btn-sm btn-circle btn-ghost" @click="$dispatch('close-modal', 'contact-me')">
                    <svg class="size-6 fill-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                            clip-rule="evenodd"></path>
                    </svg> </button>
            </div>
            @if ($isSent)
                <div class="alert bg-green-50 border border-green-200 rounded-lg p-4 text-green-800 font-medium"
                    x-show="$wire.isSent" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <div class="flex items-start space-x-4">
                        <svg class="w-10 h-10 flex-shrink-0 text-green-600" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="text-left">
                            <p class="font-semibold">Hey! Thank you for reaching out.</p>
                            <p class="mt-1 text-sm">
                                I've received your message and I'll get back to you shortly.
                            </p>
                            <button wire:click="closeModal"
                                class="mt-3 inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 rounded hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <form wire:submit.prevent="send" class="py-3 space-y-6 px-3">
                    @csrf
                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <x-input-label for="name" value="Name" />
                            <x-text-input wire:model="name" id="name" name="name" type="text"
                                class="mt-1 block w-full" autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="w-1/2">
                            <x-input-label for="email" value="Email" />
                            <x-text-input wire:model="email" id="email" name="email" type="text"
                                class="mt-1 block w-full" autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <x-text-area wire:model="description" id="description" name="description" type="text"
                            class="mt-1 block w-full" autocomplete="description" rows="5" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center gap-2 mb-3">
                        <x-primary-button>Send</x-primary-button>
                    </div>
                </form>
            @endif
        </div>
    </x-modal>
</div>