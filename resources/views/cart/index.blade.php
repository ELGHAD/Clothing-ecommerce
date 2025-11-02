@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-light text-gray-900 mb-8 font-serif">Shopping Cart</h1>

        @if($cartItems->count() > 0)
            <div class="space-y-6">
                @foreach($cartItems as $item)
                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-6">
                        <!-- Product Image -->
                        <div class="w-24 h-24 flex-shrink-0">
                            @if($item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-gray-700">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $item->product->short_description }}</p>
                            
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                @if($item->size)
                                    <span>Size: {{ $item->size }}</span>
                                @endif
                                @if($item->color)
                                    <span>Color: {{ $item->color }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                    class="w-8 h-8 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50 {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <span class="w-8 text-center">{{ $item->quantity }}</span>
                            <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                    class="w-8 h-8 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Price -->
                        <div class="text-right">
                            <p class="text-lg font-medium text-gray-900">${{ number_format($item->getTotalPrice(), 2) }}</p>
                            <p class="text-sm text-gray-500">${{ number_format($item->product->getCurrentPrice(), 2) }} each</p>
                        </div>

                        <!-- Remove Button -->
                        <button onclick="removeItem({{ $item->id }})" 
                                class="text-red-600 hover:text-red-800 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach

                <!-- Cart Summary -->
                <div class="bg-gray-50 rounded-lg p-6 mt-8">
                    <div class="flex justify-between items-center text-xl font-medium text-gray-900 mb-4">
                        <span>Total:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="space-y-3">
                        @auth
                            <a href="{{ route('checkout.index') }}" 
                               class="block w-full bg-gray-900 text-white text-center py-3 px-6 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md">
                                Proceed to Checkout
                            </a>
                        @else
                            <div class="text-center">
                                <p class="text-gray-600 mb-3">Please log in to continue with checkout</p>
                                <a href="{{ route('login') }}" 
                                   class="inline-block bg-gray-900 text-white py-3 px-6 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md mr-4">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="inline-block border border-gray-900 text-gray-900 py-3 px-6 text-lg font-medium hover:bg-gray-900 hover:text-white transition-colors rounded-md">
                                    Register
                                </a>
                            </div>
                        @endauth
                        
                        <a href="{{ route('products.index') }}" 
                           class="block w-full text-center border border-gray-300 text-gray-700 py-3 px-6 text-lg font-medium hover:bg-gray-50 transition-colors rounded-md">
                            Continue Shopping
                        </a>
                        
                        <button onclick="clearCart()" 
                                class="block w-full text-center text-red-600 hover:text-red-800 py-2 text-sm">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-gray-500">Start shopping to add items to your cart.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" 
                       class="inline-block bg-gray-900 text-white px-6 py-3 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md">
                        Shop Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(itemId, quantity) {
    if (quantity < 1) return;
    
    fetch(`/cart/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            location.reload();
        }
    })
    .catch(error => {
        alert('Error updating cart');
    });
}

function removeItem(itemId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch(`/cart/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            }
        })
        .catch(error => {
            alert('Error removing item');
        });
    }
}

function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        fetch('/cart', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            }
        })
        .catch(error => {
            alert('Error clearing cart');
        });
    }
}
</script>
@endsection
