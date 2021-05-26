<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    Welcome to your Velvetriess Cake Ordering Management System (VCOMS)
                </div>
            </div>

            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
                <div class="p-6">
                    <div class="flex items-center">
{{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>--}}
                        <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laravel.com/docs">Pending orders</a></div>
                    </div>

                    <div class="ml-12 mt-4">

                        <table class="w-full shadow-md bg-white">
                            <tr class="border-b">
                                <td class="p-4 font-bold">Order ID</td>
                                <td class="p-4 font-bold">Customer Name</td>
                                <td class="p-4 font-bold">Customer Email</td>
                                <td class="p-4 font-bold">Contact No</td>
                                <td class="p-4 font-bold">Status</td>
                                <td class="p-4 font-bold">Date Time</td>
                                <td class="p-4"></td>
                            </tr>
                            @forelse($pending_orders as $order)
                                <tr>
                                    <td class="p-4">{{ $order->id }}</td>
                                    <td class="p-4">{{ $order->user->name }}</td>
                                    <td class="p-4">{{ $order->user->email }}</td>
                                    <td class="p-4">{{ $order->phone }}</td>
                                    <td class="p-4">{{ $order->getStatusDescription() }}</td>
                                    <td class="p-4">{{ $order->created_at }}</td>
                                    <td class="p-4">
                                        <x-jet-button wire:click="viewProducts({{ $order->id }})">View</x-jet-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4" colspan="6">No pending orders..</td>
                                </tr>
                            @endforelse
                        </table>

                    </div>
                </div>
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center">
                        {{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>--}}
                        <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laravel.com/docs">Product summary</a></div>
                    </div>

                    <div class="ml-12 mt-4">

                        <table class="w-full shadow-md bg-white">
                            <tr class="border-b">
                                <td class="p-4 font-bold">#</td>
                                <td class="p-4 font-bold">Product Name</td>
                                <td class="p-4 font-bold text-center">Total Item Purchase</td>
                                <td class="p-4 font-bold text-center">Total Item Revenue (RM)</td>
                            </tr>
                            @forelse($products as $product)
                                <tr>
                                    <td class="p-4">{{ $loop->iteration }}.</td>
                                    <td class="p-4">{{ $product->name }}</td>
                                    <td class="p-4 text-center">{{ $product->getTotalOrder() }}</td>
                                    <td class="p-4 text-center">{{ number_format($product->getTotalRevenue(), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4" colspan="4">No product register..</td>
                                </tr>
                            @endforelse
                        </table>

                    </div>
                </div>
            </div>

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
