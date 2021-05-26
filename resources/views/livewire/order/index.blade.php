<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Order') }}
    </h2>
</x-slot>

<div class="py-12 container mx-auto">
    <div class="mt-4 p-5 bg-white border shadow">
        <div class="border-b-2 font-black uppercase text-lg">
            Order list
        </div>
        <div class="mt-4 space-y-5">
            <table class="w-full border">
                <tr class="border-b bg-gray-100">
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Order Id</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Customer Name</td>
{{--                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Sub Total</td>--}}
{{--                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Tax</td>--}}
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Total (RM)</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Status</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Date Time</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500"></td>
                </tr>
                @forelse($orders as $order)
                    <tr>
                        <td class="px-3 py-2">{{ $order->id }}</td>
                        <td class="px-3 py-2">{{ $order->user->name }}</td>
{{--                        <td class="px-3 py-2">{{ $order->sub_total }}</td>--}}
{{--                        <td class="px-3 py-2">{{ $order->tax }}</td>--}}
                        <td class="px-3 py-2">{{ number_format($order->grand_total, 2) }}</td>
                        <td class="px-3 py-2">{{ $order->getStatusDescription() }}</td>
                        <td class="px-3 py-2">{{ $order->created_at }}</td>
                        <td class="px-3 py-2 border-l w-1">
                            <div class="flex justify-end space-x-1">
                                <x-jet-button class="bg-green-500" wire:click="viewProducts({{ $order->id }})">View</x-jet-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-2">No records.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <x-jet-modal wire:model="viewOrderProductModal">
        <div class="p-4">
            <h1>Pickup Location</h1>
            <div class="p-2 border rounded-md">
                {{ $selected_order ? $selected_order->branch->name : '' }}
            </div>
            <br>
            <h1>Notes to the girls</h1>
            <div class="p-2 border rounded-md" style="min-height: 100px;">
                {!! $selected_order ? nl2br($selected_order->note) : '' !!}
            </div>
            <br>
            <h1>Status</h1>
            <div class="p-2 border rounded-md flex justify-between">
                <div>
                    {{ $selected_order ? $selected_order->getStatusDescription() : '' }}
                </div>
                <div class="flex space-x-3">
                    <button class="underline text-blue-500" wire:click="ready">Ready</button>
                    <button class="underline text-blue-500" wire:click="collected">Collected</button>
                </div>
            </div>
            <br>
            <h1>Order Date Time</h1>
            <div class="p-2 border rounded-md">
                {{ $selected_order ? $selected_order->created_at : '' }}
            </div>
            <br>
            <h1>Items</h1>
            <table class="w-full border">
                <tr class="border-b bg-gray-100">
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">#</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500">Name</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500 text-center">Price</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500 text-center">Quantity</td>
                    <td class="px-3 py-2 uppercase font-medium text-gray-500 text-center">Total Price (RM)</td>
                </tr>
                @forelse($order_products as $order_product)
                    <tr>
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $order_product->product->name }}</td>
                        <td class="px-3 py-2 text-center">{{ number_format($order_product->product->price, 2) }}</td>
                        <td class="px-3 py-2 text-center">{{ $order_product->quantity }}</td>
                        <td class="px-3 py-2 text-center">{{ number_format($order_product->price, 2) }}</td>
                    </tr>
                    @if($loop->last)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-right font-bold" colspan="4">Total</td>
                            <td class="px-3 py-2 text-center font-bold">{{ number_format($selected_order->grand_total, 2) }}</td>
                        </tr>
                    @endif
                @empty
                    <tr class="border-b bg-gray-100">
                        <td class="px-3 py-2" colspan="5">Problem loading items..</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </x-jet-modal>
</div>
