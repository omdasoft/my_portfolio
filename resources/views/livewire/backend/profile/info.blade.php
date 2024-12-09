<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <form wire:submit="update" class="py-3 space-y-6 px-3">
                            @csrf

                            <div>
                                <x-input-label for="phone" value="Phone" />
                                <x-text-input wire:model="profileInfo.phone" id="phone" name="phone" type="text" class="mt-1 block w-full" required autofocus autocomplete="phone" />
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfo.phone')" />
                            </div>

                            <div>
                                <x-input-label for="github" value="Github" />
                                <x-text-input wire:model="profileInfo.github" id="github" name="github" type="text" class="mt-1 block w-full" required autofocus autocomplete="github" />
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfo.github')" />
                            </div>

                            <div>
                                <x-input-label for="twitter" value="Twitter" />
                                <x-text-input wire:model="profileInfo.twitter" id="twitter" name="twitter" type="text" class="mt-1 block w-full" required autofocus autocomplete="twitter" />
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfo.twitter')" />
                            </div>

                            <div>
                                <x-input-label for="linkedin" value="Linkedin" />
                                <x-text-input wire:model="profileInfo.linkedin" id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" required autofocus autocomplete="linkedin" />
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfo.linkedin')" />
                            </div>

                            <div>
                                <x-input-label for="designation" value="Designation" />
                                <x-text-input wire:model="profileInfo.designation" id="designation" name="designation" type="text" class="mt-1 block w-full" required autofocus autocomplete="designation" />
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfo.designation')" />
                            </div>

                            <div>
                                <x-input-label for="intro" value="Intro" />
                                <x-text-area wire:model="profileInfo.intro" id="intro" name="intro" type="text" class="mt-1 block w-full" required autocomplete="intro" rows="5"/>
                                <x-input-error class="mt-2" :messages="$errors->get('profileInfos.intro')" />
                            </div>

                            @if ($profile->image) 
                                <div class="flex gap-2 mb-2">
                                    <div class="w-1/2">
                                        <img src="{{ $profile->image_path }}" alt="Profile Image" width="200" height="200">
                                        <x-danger-button class="mt-1" wire:click.prevent="deleteImage({{ $profile->image->id }})">Delete</x-danger-button>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <x-input-label for="image" value="Image" />
                                <x-text-input wire:model.live="image" id="image" name="image" type="file" class="mt-1 block w-full" autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>

                            @if($image)
                                <div class="flex gap-2">
                                    <div class="w-1/2">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Profile Image" width="200" height="200">
                                        <x-danger-button class="mt-1" wire:click.prevent="removeImage">Remove</x-danger-button>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <x-input-label for="resume" value="Resume" />
                                <x-text-input wire:model.live="resume" id="resume" name="resume" type="file" class="mt-1 block w-full" autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('resume')" />
                            </div>

                            @if ($profile->resume_path && !$resumePath)
                                <div class="mt-4">
                                    <x-nav-link  href="{{ $profile->resume_path }}" 
                                        class="text-blue-600"
                                        target="_blank" >
                                        View Resume 
                                    </x-nav-link>
                                </div>
                            @endif

                            @if ($resumePath)
                                <div class="mt-4">
                                    <x-input-label value="Resume Uploaded" />
                                    <div class="flex gap-2">
                                        <x-nav-link  href="{{ asset('storage/' . $resumePath) }}" 
                                            class="text-blue-600"
                                            target="_blank" >
                                            view
                                        </x-nav-link>
                                        <x-nav-link  href="#"
                                            class="text-red-600"
                                            wire:click.prevent="removeResume" 
                                            target="_blank" >
                                            remove
                                        </x-nav-link>
                                    </div>
                                </div>
                            @endif


                            <div class="flex items-center gap-2 mb-3">
                                <x-primary-button>Update</x-primary-button>
                            </div>
                        </form>
                        <x-action-message class="mr-3 mt-3" on="updated">
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