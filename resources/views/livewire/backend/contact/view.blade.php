<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact View') }}
        </h2>
    </x-slot>
    
    <div class="py-5">
        <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
             <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $contact->name }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Received on {{ $contact->created_at }}
                </p>
            </div>

              <!-- Message Body -->
            <div class="px-6 py-6">
                <p class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                    {{ $contact->description }}
                </p>
            </div>
        </div>
    </div>
</div>