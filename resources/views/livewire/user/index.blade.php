<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin') }}
    </h2>
</x-slot>

<div class="py-12 container mx-auto">
    <div class="flex justify-end">
        <x-jet-button wire:click="create">Add new</x-jet-button>
    </div>
    <div class="mt-4 p-5 bg-white border shadow">
        <div class="border-b-2 font-black uppercase text-lg">
            Admin list
        </div>
        <div class="mt-4 space-y-5">
            <table class="w-full border">
                <tr class="border-b bg-gray-100">
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">#</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Name</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Email</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Phone</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500"></td>
                </tr>
                @forelse($users as $user)
                    <tr>
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $user->name }}</td>
                        <td class="px-3 py-2">{{ $user->email }}</td>
                        <td class="px-3 py-2">{{ $user->phone }}</td>
                        <td class="px-3 py-2 border-l w-1">
                            <div class="flex justify-end space-x-1">
                                <x-jet-button class="bg-green-500" wire:click="editUser({{ $user->id }})">Edit</x-jet-button>
                                <x-jet-button class="bg-red-500" wire:click="deleteUser({{ $user->id }})">Delete</x-jet-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-3 py-2">No records.</td>
                    </tr>
                @endforelse
            </table>
{{--            @forelse($users as $user)--}}
{{--                <div class="flex justify-between">--}}
{{--                    <div class="">{{ $user->name }}</div>--}}
{{--                    <div>--}}
{{--                        <x-jet-button class="bg-green-500">Edit</x-jet-button>--}}
{{--                        <x-jet-button class="bg-red-500">Delete</x-jet-button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                <div>No records.</div>--}}
{{--            @endforelse--}}
        </div>
    </div>

    <x-jet-modal wire:model="createUserModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Create new user
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
                        <x-jet-label>Email</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="email"/>
                        <x-jet-input-error for="email"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Email</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="phone"/>
                        <x-jet-input-error for="phone"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Password</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="password" type="password"/>
                        <x-jet-input-error for="password"/>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-jet-button>Save</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-modal wire:model="editUserModal">

        <div class="p-4">
            <div class="uppercase text-lg border-b-2 font-black">
                Create new user
            </div>
            <div>
                <form wire:submit.prevent="updateUser">
                    @csrf

                    <div class="mt-3">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="selected_user.name"/>
                        <x-jet-input-error for="selected_user.name"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Email</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="selected_user.email"/>
                        <x-jet-input-error for="selected_user.email"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Phone</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="selected_user.phone"/>
                        <x-jet-input-error for="selected_user.phone"/>
                    </div>

                    <div class="mt-3">
                        <x-jet-label>Password</x-jet-label>
                        <x-jet-input class="bg-gray-200 focus:bg-white w-full" wire:model="password" type="password"/>
                        <x-jet-input-error for="password"/>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-jet-button>Save</x-jet-button>
                    </div>
                </form>
            </div>
        </div>

    </x-jet-modal>

    <x-jet-confirmation-modal wire:model="deleteUserModal">
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
