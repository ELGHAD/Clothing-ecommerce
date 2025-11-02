@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-6">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-light text-gray-900 mb-4 font-serif">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-8">Thank you for your purchase. Your order has been successfully placed.</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Order Details</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Order Number:</dt>
                            <dd class="text-gray-900 font-medium">{{ $order->order_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Order Date:</dt>
                            <dd class="text-gray-900">{{ $order->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Status:</dt>
                            <dd class="text-gray-900 capitalize">{{ $order->status }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Total:</dt>
                            <dd class="text-gray-900 font-medium">${{ number_format($order->total_amount, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Shipping Address</h3>
                    <address class="text-sm text-gray-600 not-italic">
                        {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                        {{ $order->shipping_address_line_1 }}<br>
                        @if($order->shipping_address_line_2)
                            {{ $order->shipping_address_line_2 }}<br>
                        @endif
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                        {{ $order->shipping_country }}
                    </address>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 last:border-b-0">
                        <div class="w-16 h-16 flex-shrink-0">
                            @if($item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <div class="w-full h-full bg-gray-200 rounded-lg"></div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                            <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                            <div class="text-sm text-gray-500 mt-1">
                                @if($item->size) Size: {{ $item->size }} @endif
                                @if($item->color) Color: {{ $item->color }} @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm font-medium text-gray-900">${{ number_format($item->total, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Subtotal:</dt>
                        <dd class="text-gray-900">${{ number_format($order->subtotal, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Shipping:</dt>
                        <dd class="text-gray-900">${{ number_format($order->shipping_amount, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Tax:</dt>
                        <dd class="text-gray-900">${{ number_format($order->tax_amount, 2) }}</dd>
                    </div>
                    <div class="flex justify-between text-lg font-medium border-t border-gray-200 pt-2">
                        <dt class="text-gray-900">Total:</dt>
                        <dd class="text-gray-900">${{ number_format($order->total_amount, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="text-center space-y-4">
            <p class="text-gray-600">
                A confirmation email has been sent to <strong>{{ $order->billing_email }}</strong>
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('profile.orders') }}" 
                       class="inline-block bg-gray-900 text-white px-6 py-3 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md">
                        View All Orders
                    </a>
                @endauth
                <a href="{{ route('products.index') }}" 
                   class="inline-block border border-gray-900 text-gray-900 px-6 py-3 text-lg font-medium hover:bg-gray-900 hover:text-white transition-colors rounded-md">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
