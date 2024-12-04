<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portfolio Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form wire:submit.prevent="store" class="py-3 space-y-6 px-3" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <x-input-label for="title" value="Title" />
                                <x-text-input wire:model="title" id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>


                            <div class="flex gap-2">
                                <div class="w-1/2">
                                    <x-input-label for="url" value="URL" />
                                    <x-text-input wire:model="url" id="url" name="url" type="text" class="mt-1 block w-full" required autocomplete="url" />
                                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                                </div>

                                <div class="w-1/2">
                                    <x-input-label for="github_url" value="Github URL" />
                                    <x-text-input wire:model="github_url" id="github_url" name="github_url" type="text" class="mt-1 block w-full" required autocomplete="github_url" />
                                    <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="description" value="Description" />
                                <x-text-area wire:model="description" id="description" name="description" type="text" class="mt-1 block w-full" required autocomplete="description" rows="5"/>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="image" value="Image" />
                                <x-text-input wire:model.live="image" id="image" name="image" type="file" class="mt-1 block w-full" autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>
                            @if($imagePathes)
                                <div class="flex gap-2">
                                    @foreach ($imagePathes as $key => $imagePath)
                                        <div class="w-1/2">
                                            <img src="{{ asset($imagePath) }}" alt="Portfolio Image" width="200" height="200">
                                            <x-danger-button class="mt-1" wire:click.prevent="removeImage({{$key}})">Remove</x-danger-button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="flex items-center gap-2 mb-3">
                                <x-primary-button>Save</x-primary-button>
                            </div>
                        </form>
                        <x-action-message class="mr-3 mt-3" on="created">
                            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                                <div class="flex">
                                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                    <div>
                                        <p class="font-bold">Success</p>
                                        <p class="text-sm">{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        </x-action-message>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>