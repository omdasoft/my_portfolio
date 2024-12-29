@props(['profile'])
<section class="mb-16 md:mb-36 flex flex md:gap-8" id="about">
    <div class="md:w-3/4 md:text-lg md:leading-8">
        <h1 class="text-4xl md:text-6xl font-extrabold text-indigo-600">
            {{ $profile->designation }}
        </h1>
        <p class="mt-5 text-neutral-600 leading-9 text-justify">
            {{ $profile->intro }}
        </p>
        <div class="mt-10 flex gap-2">
            <button type="button"
                class="inline-block rounded bg-indigo-500 px-6 py-3 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                Hire Me
            </button>
            <button type="button"
                class="inline-block rounded border border-indigo-400 px-6 py-3 text-indigo-600 text-xs font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:border-indigo-400 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] hover:bg-indigo-500 hover:text-white focus:border-indigo-400 focus:text-white focus:outline-none focus:ring-0 active:border-indigo-400 active:text-white"
                data-te-ripple-init>
                Download my resume
            </button>
        </div>
    </div>
    <div class="hidden md:block md:w-1/3">
        <img src="{{ $profile->image_path }}" class="mx-auto md:w-64 rounded-lg shadow-md" alt="Profile Pic" />
    </div>
</section>