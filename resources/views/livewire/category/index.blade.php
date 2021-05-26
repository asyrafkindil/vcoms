<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Category') }}
    </h2>
</x-slot>

<div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-end">
        <x-jet-button wire:click="create">Add new</x-jet-button>
    </div>
    <div class="mt-4 p-5 bg-white border shadow">
        <div class="border-b-2 font-black uppercase text-lg">
            Category list
        </div>
        <div class="mt-4 space-y-5">
            @forelse($categories as $category)

                <div class="flex justify-between">
                    <div class="">{{ $category->name }}</div>
                    <div>
                        <x-jet-button class="bg-green-500" wire:click="editCategory({{ $category->id }})">Edit</x-jet-button>
                        <x-jet-button class="bg-red-500" wire:click="deleteCategory({{ $category->id }})">Delete</x-jet-button>
                    </div>
                </div>
            @empty
                <div>No records.</div>
            @endforelse
        </div>
    </div>

    <x-jet-modal wire:model="createCategoryModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Create new branch
            </div>
            <div>
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="mt-3">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="name" />
                        <x-jet-input-error for="name" />
                    </div>
                    <div class="flex justify-end">
                        <x-jet-button class="mt-4">Save</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-modal wire:model="editCategoryModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Edit category
            </div>
            <div>
                <form wire:submit.prevent="update">
                    @csrf
                    <div class="mt-3">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="selected_category.name" />
                        <x-jet-input-error for="selected_category.name" />
                    </div>
                    <div class="flex justify-end">
                        <x-jet-button class="mt-4">Save</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-confirmation-modal wire:model="deleteCategoryModal">
        <x-slot name="title">
            <div>
                Delete confirmation
            </div>
        </x-slot>
        <x-slot name="content">
            <div>
                Proceed to delete?
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click="proceedToDelete">Proceed</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
