@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen bg-gray-100">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative h-full flex items-center justify-center text-center text-white">
        <div class="max-w-4xl px-4">
            <h1 class="text-5xl md:text-7xl font-light mb-6 font-serif">Timeless Elegance</h1>
            <p class="text-xl md:text-2xl mb-8 font-light">Discover our curated collection of premium clothing</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-white text-gray-900 px-8 py-3 text-lg font-medium hover:bg-gray-100 transition-colors">
                Shop Collection
            </a>
        </div>
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-gray-800 via-gray-600 to-gray-800 opacity-90"></div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-light text-gray-900 mb-4 font-serif">Shop by Category</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our carefully curated collections designed for the modern lifestyle</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
            <div class="group relative overflow-hidden bg-gray-100 aspect-square">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300"></div>
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-300"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white">
                        <h3 class="text-2xl font-light mb-2 font-serif">{{ $category->name }}</h3>
                        <a href="{{ route('products.category', $category) }}" class="inline-block border border-white px-6 py-2 text-sm font-medium hover:bg-white hover:text-gray-900 transition-colors">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-light text-gray-900 mb-4 font-serif">Featured Products</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Handpicked pieces that define contemporary elegance</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="group">
                <div class="relative overflow-hidden bg-white aspect-square mb-4">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    
                    @if($product->isOnSale())
                        <div class="absolute top-4 left-4 bg-red-600 text-white px-2 py-1 text-xs font-medium">
                            -{{ $product->getDiscountPercentage() }}%
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('products.show', $product) }}" class="bg-white text-gray-900 px-6 py-2 text-sm font-medium hover:bg-gray-100 transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
                
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                    <div class="flex items-center justify-center space-x-2">
                        @if($product->isOnSale())
                            <span class="text-lg font-medium text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-lg font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="inline-block bg-gray-900 text-white px-8 py-3 text-lg font-medium hover:bg-gray-800 transition-colors">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Brand Story -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-light text-gray-900 mb-6 font-serif">Our Story</h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Founded on the principles of timeless design and exceptional craftsmanship, our brand represents the perfect fusion of classic elegance and contemporary style. Each piece in our collection is thoughtfully designed to transcend seasonal trends.
                </p>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    We believe in creating clothing that not only looks exceptional but feels extraordinary to wear. Our commitment to quality materials and attention to detail ensures that every garment becomes a cherished part of your wardrobe.
                </p>
                <a href="{{ route('products.index') }}" class="inline-block border border-gray-900 text-gray-900 px-8 py-3 text-lg font-medium hover:bg-gray-900 hover:text-white transition-colors">
                    Discover More
                </a>
            </div>
            <div class="relative">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                    <div class="w-full h-full bg-gradient-to-br from-gray-200 via-gray-100 to-gray-300"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-light mb-4 font-serif">Stay Connected</h2>
        <p class="text-xl text-gray-300 mb-8">Be the first to know about new arrivals, exclusive offers, and style inspiration</p>
        
        <form id="newsletter-form" class="max-w-md mx-auto">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="email" name="email" placeholder="Enter your email address" required
                       class="flex-1 px-4 py-3 bg-transparent border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-white transition-colors">
                <button type="submit" class="bg-white text-gray-900 px-8 py-3 font-medium hover:bg-gray-100 transition-colors">
                    Subscribe
                </button>
            </div>
        </form>
    </div>
</section>

<script>
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        this.reset();
    })
    .catch(error => {
        alert('Error subscribing to newsletter');
    });
});
</script>
@endsection
