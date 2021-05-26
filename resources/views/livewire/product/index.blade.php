<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Product') }}
    </h2>
</x-slot>

<div class="py-12 container mx-auto">
    <div class="flex justify-end">
        <x-jet-button wire:click="create">Add new</x-jet-button>
    </div>
    <div class="mt-4 p-5 bg-white border shadow">
        <div class="border-b-2 font-black uppercase text-lg">
            Product list
        </div>
        <div class="mt-4 space-y-5">
            <table class="w-full border">
                <tr class="border-b bg-gray-100">
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Name</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Description</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Price</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Category</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500"></td>
                </tr>
                @forelse($products as $product)
                    <tr>
                        <td class="px-3 py-2">{{ $product->name }}</td>
                        <td class="px-3 py-2">{{ $product->description }}</td>
                        <td class="px-3 py-2">{{ $product->price }}</td>
                        <td class="px-3 py-2">{{ $product->category ? $product->category->name : '' }}</td>
                        <td class="px-3 py-2 border-l w-1">
                            <div class="flex justify-end space-x-1">
                                <x-jet-button class="bg-green-500" wire:click="edit({{ $product->id }})">Edit</x-jet-button>
                                <x-jet-button class="bg-red-500" wire:click="deleteProduct({{ $product->id }})">Delete</x-jet-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-2">No records.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <x-jet-modal wire:model="createProductModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Create new product
            </div>
            <div>
                <form wire:submit.prevent="save">
                    @csrf

                    <div class="mt-3">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="name"/>
                        <x-jet-input-error for="name"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Description</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="description"/>
                        <x-jet-input-error for="description"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Price</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="price"/>
                        <x-jet-input-error for="price"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Category</x-jet-label>
                        <select class="border-gray-300 py-2 px-3 shadow-sm rounded-md bg-gray-200 focus:bg-white w-full" wire:model="category_id">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="category_id"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Photo</x-jet-label>
                        @if($file)
                            <img class="border p-1 rounded max-w-full h-auto" src="{{ $file->temporaryUrl() }}">
                        @endif
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="file" type="file" accept="image/*"/>
                        <x-jet-input-error for="file"/>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-jet-button>Save</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-modal wire:model="editProductModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Update {{ $productToEdit ? '(' . $productToEdit->name . ')' : '' }}
            </div>
            <div>
                <form wire:submit.prevent="update">
                    @csrf

                    <div class="mt-3">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="productToEdit.name"/>
                        <x-jet-input-error for="productToEdit.name"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Description</x-jet-label>
                        <textarea class="bg-gray-200 focus:bg-white w-full" wire:model="productToEdit.description"></textarea>
                        <x-jet-input-error for="productToEdit.description"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Price</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="productToEdit.price"/>
                        <x-jet-input-error for="productToEdit.price"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Category</x-jet-label>
                        <select class="border-gray-300 py-2 px-3 shadow-sm rounded-md bg-gray-200 focus:bg-white w-full" wire:model="productToEdit.category_id">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="productToEdit.category_id"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Photo</x-jet-label>
                        @if($file)
                            <img class="border p-1 rounded max-w-full h-auto mx-auto mb-1" src="{{ $file->temporaryUrl() }}">
                        @elseif($productToEdit && $productToEdit->photo_path)
                            <img class="border p-1 rounded max-w-full h-auto mx-auto mb-1" src="{{ asset('storage/' . $productToEdit->photo_path) }}">
                        @endif
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="file" type="file" accept="image/*"/>
                        <x-jet-input-error for="file"/>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-jet-button>Update</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-confirmation-modal wire:model="deleteProductModal">
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

    <x-jet-confirmation-modal wire:model="alertModal">
        <x-slot name="title">
            <div>
                Alert
            </div>
        </x-slot>
        <x-slot name="content">
            <div>
                {!! nl2br($message) !!}
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click="$toggle('alertModal')">OK</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
