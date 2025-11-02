@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index') }}" class="hover:text-gray-900">Products</a></li>
                @if($product->categories->count() > 0)
                    <li>/</li>
                    <li><a href="{{ route('products.category', $product->categories->first()) }}" class="hover:text-gray-900">{{ $product->categories->first()->name }}</a></li>
                @endif
                <li>/</li>
                <li class="text-gray-900">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                    @if($product->images->count() > 0)
                        <img id="main-image" 
                             src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover cursor-zoom-in"
                             onclick="openImageModal(this.src)">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-lg">No Image Available</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="aspect-square overflow-hidden rounded-lg bg-gray-100 cursor-pointer hover:opacity-75 transition-opacity">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover"
                                     onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-light text-gray-900 font-serif">{{ $product->name }}</h1>
                    <p class="mt-2 text-lg text-gray-600">{{ $product->short_description }}</p>
                </div>

                <!-- Price -->
                <div class="flex items-center space-x-4">
                    @if($product->isOnSale())
                        <span class="text-3xl font-medium text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 text-sm font-medium rounded">
                            {{ $product->getDiscountPercentage() }}% OFF
                        </span>
                    @else
                        <span class="text-3xl font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form id="add-to-cart-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Size Selection -->
                    @if($product->sizes && count($product->sizes) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <div class="grid grid-cols-6 gap-2">
                                @foreach($product->sizes as $size)
                                    <label class="relative">
                                        <input type="radio" name="size" value="{{ $size }}" class="sr-only peer" required>
                                        <div class="border border-gray-300 rounded-md px-3 py-2 text-center text-sm font-medium cursor-pointer peer-checked:bg-gray-900 peer-checked:text-white peer-checked:border-gray-900 hover:border-gray-400 transition-colors">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Color Selection -->
                    @if($product->colors && count($product->colors) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->colors as $color)
                                    <label class="relative">
                                        <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" required>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 text-sm font-medium cursor-pointer peer-checked:bg-gray-900 peer-checked:text-white peer-checked:border-gray-900 hover:border-gray-400 transition-colors">
                                            {{ $color }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="decrementQuantity()" class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                   class="w-16 text-center border border-gray-300 rounded-md py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <button type="button" onclick="incrementQuantity()" class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                        @if($product->stock_quantity <= 10)
                            <p class="mt-1 text-sm text-orange-600">Only {{ $product->stock_quantity }} left in stock</p>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    @if($product->in_stock && $product->stock_quantity > 0)
                        <button type="submit" class="w-full bg-gray-900 text-white py-3 px-6 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md">
                            Add to Cart
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-3 px-6 text-lg font-medium cursor-not-allowed rounded-md">
                            Out of Stock
                        </button>
                    @endif
                </form>

                <!-- Product Details -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Details</h3>
                    <div class="prose prose-sm text-gray-600">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <!-- Product Info -->
                <div class="border-t border-gray-200 pt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">SKU:</span>
                        <span class="text-gray-900">{{ $product->sku }}</span>
                    </div>
                    @if($product->categories->count() > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Category:</span>
                            <span class="text-gray-900">{{ $product->categories->pluck('name')->join(', ') }}</span>
                        </div>
                    @endif
                    @if($product->weight)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Weight:</span>
                            <span class="text-gray-900">{{ $product->weight }} lbs</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <h2 class="text-2xl font-light text-gray-900 mb-8 font-serif">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card">
                            <div class="relative overflow-hidden bg-white aspect-square mb-4 border border-gray-200 rounded-lg">
                                @if($relatedProduct->images->count() > 0)
                                    <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_path) }}" 
                                         alt="{{ $relatedProduct->name }}" 
                                         class="product-image">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="bg-white text-gray-900 px-6 py-2 text-sm font-medium hover:bg-gray-100 transition-colors rounded-md">
                                        View Details
                                    </a>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $relatedProduct->name }}</h3>
                                <div class="flex items-center justify-center space-x-2">
                                    @if($relatedProduct->isOnSale())
                                        <span class="text-lg font-medium text-red-600">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                        <span class="text-sm text-gray-500 line-through">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-medium text-gray-900">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-full p-4">
        <img id="modal-image" src="" alt="" class="max-w-full max-h-full object-contain">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
// Image functionality
function changeMainImage(src) {
    document.getElementById('main-image').src = src;
}

function openImageModal(src) {
    document.getElementById('modal-image').src = src;
    document.getElementById('image-modal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('image-modal').classList.add('hidden');
}

// Quantity controls
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Add to cart
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            alert(data.message);
            document.getElementById('cart-count').textContent = data.cart_count;
        }
    })
    .catch(error => {
        alert('Error adding product to cart');
    });
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
