<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portfolio List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-action-message class="mr-3 mb-3" on="action-success">
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
                    <x-primary-button class="mb-5" wire:click="create">
                        Add Portfolio
                    </x-primary-button>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">Project Title</th>
                                    <th scope="col" class="px-6 py-3">URL</th>
                                    <th scope="col" class="px-6 py-3">GitHub URL</th>
                                    <th scope="col" class="px-6 py-3">Completed At</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($portfolios as $portfolio)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <img src="{{ asset($portfolio->image) }}" alt="Portfolio Image" width="200" height="200">
                                        </td>
                                        <td class="px-6 py-4">{{ $portfolio->title }}</td>
                                        <td class="px-6 py-4">{{ $portfolio->url }}</td>
                                        <td class="px-6 py-4">{{ $portfolio->github_url }}</td>
                                        <td class="px-6 py-4">{{ $portfolio->created_at }}</td>
                                        <td class="px-6 py-4 flex flex-row gap-1">
                                            <x-secondary-button wire:click="edit({{ $portfolio->id }})">Edit</x-secondary-button>
                                            <x-danger-button wire:click="showConfirmationModal({{ $portfolio->id }})">
                                                Delete
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="py-4">
                            {{ $portfolios->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation modal -->
    <x-modal name="confirmationModal" maxWidth="md">
        <div>
            <h2 class="text-center text-gray-500 py-2">Delete Confirmation</h2>
            <p class="text-center text-gray-800 py-3 text-lg">Are you sure you want to delete this portfolio item?</p>
            <div class="mt-4 flex gap-4 justify-center mb-3">
                <x-danger-button wire:click="deleteConfirmed">Yes, Delete</x-danger-button>
                <x-secondary-button wire:click="closeModal('confirmationModal')">Cancel</x-secondary-button>
            </div>
        </div>
    </x-modal>

     <!-- Create Edit Modal -->
     <x-modal name="createEditPortfolio" maxWidth="2xl">
        <div>
            <h2 class="text-center text-gray-500 py-2">{{ $isCreate ? 'Create Portfolio' : 'Edit Portfolio'}}</h2>
            <form wire:submit.prevent="{{ $isCreate ? 'store' : 'update' }}" class="py-3 space-y-6 px-3" enctype="multipart/form-data">
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
                    <x-input-label for="images" value="Images" />
                    <x-text-input wire:model.live="images" id="images" name="images" type="file" class="mt-1 block w-full" autofocus multiple/>
                    @error('images.*')
                        <x-input-error class="mt-2" :messages="$message"/>
                    @enderror        
                </div>

                <div class="flex items-center gap-2 mb-3">
                    <x-primary-button>{{ $isCreate ? 'Save' : 'Update' }}</x-primary-button>
                    <x-danger-button wire:click.prevent="cancelForm">Cancel</x-secondary-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>