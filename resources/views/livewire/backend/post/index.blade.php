<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post List') }}
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

                    <x-link-button class="mb-4" :href="route('admin.posts.create')" wire:navigate>
                        Create
                    </x-link-button>
                    
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Created At</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <img src="{{ $post->image_path }}" alt="Portfolio Image" width="150" height="150">
                                        </td>
                                        <td class="px-6 py-4">{{ $post->title }}</td>
                                        <td class="px-6 py-4">{{ $post->status }}</td>
                                        <td class="px-6 py-4">{{ $post->created_at }}</td>
                                        <td class="px-6 py-4 flex flex-row gap-1">
                                            <x-secondary-button wire:click="edit({{ $post->id }})">Edit</x-secondary-button>
                                            <x-secondary-button wire:click="view({{ $post->id }})">View</x-secondary-button>
                                            <x-danger-button wire:click.prevent="showConfirmationModal({{ $post->id }})">
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

                        <x-pagination :collection="$posts"/>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation modal -->
    <x-modal name="confirmationModal" maxWidth="md">
        <div>
            <h2 class="text-center text-gray-500 py-2">Delete Confirmation</h2>
            <p class="text-center text-gray-800 py-3 text-lg">Are you sure you want to delete this post?</p>
            <div class="mt-4 flex gap-4 justify-center mb-3">
                <x-danger-button wire:click="deleteConfirmed">Yes, Delete</x-danger-button>
                <x-secondary-button wire:click="closeModal('confirmationModal')">Cancel</x-secondary-button>
            </div>
        </div>
    </x-modal>
</div>