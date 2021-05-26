<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Customer') }}
    </h2>
</x-slot>

<div class="py-12 container mx-auto">
    <div class="mt-4 p-5 bg-white border shadow">
        <div class="border-b-2 font-black uppercase text-lg">
            Customer list
        </div>
        <div class="mt-4 space-y-5">
            <table class="w-full border">
                <tr class="border-b bg-gray-100">
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">#</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Name</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Email</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Phone</td>
                </tr>
                @forelse($users as $user)
                    <tr>
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $user->name }}</td>
                        <td class="px-3 py-2">{{ $user->email }}</td>
                        <td class="px-3 py-2">{{ $user->phone }}</td>
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
</div>
