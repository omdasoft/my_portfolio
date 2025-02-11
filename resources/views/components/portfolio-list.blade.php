@props(['name' => 'Portfolio List','portfolios'])

<section class="py-5" id="work">
    <h1
        class="mb-10 md:mb-16 flex items-center after:ml-4 after:bg-gray-300 after:h-px after:w-1/2 after:grow uppercase text-xs font-medium">
        {{ $name }}
    </h1>
    <div class="container">
        <div class="text-center">
            <div class="grid gap-6 lg:grid-cols-3 xl:gap-x-12">
                @foreach ($portfolios as $portfolio)
                    <div class="mb-6 lg:mb-10">
                        <div
                            class="relative block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
                            <div class="flex">
                                <div class="relative mx-4 -mt-4 w-full overflow-hidden rounded-lg bg-cover bg-no-repeat shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]"
                                    data-te-ripple-init data-te-ripple-color="light">
                                    <img src="{{ $portfolio->image }}" class="w-full" />
                                    <a href="#!">
                                        <div
                                            class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-[hsl(0,0%,98.4%,0.15)] bg-fixed opacity-0 transition duration-300 ease-in-out hover:opacity-100">
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="p-6">
                                <h5 class="mb-4 text-lg font-bold">{{ $portfolio->title }}</h5>
                                <p class="mb-6 text-neutral-600">
                                    {{ $portfolio->short_description }}
                                </p>
                                <a href="{{ route('portfolios.show', $portfolio->id) }}" data-te-ripple-init data-te-ripple-color="light"
                                    class="inline-block rounded-full border border-indigo-400 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-indigo-600 shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-indigo-500 hover:text-white hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-indigo-500 focus:text-white focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-indigo-500 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                    view details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>