@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-light text-gray-900 font-serif">All Products</h1>
            <p class="mt-2 text-lg text-gray-600">Discover our complete collection</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filters</h3>
                    
                    <form method="GET" id="filter-form">
                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search products..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <div class="flex gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" 
                                       class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" 
                                       class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <select name="size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <option value="">All Sizes</option>
                                <option value="XS" {{ request('size') == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ request('size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                        </div>

                        <!-- Color -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                            <select name="color" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <option value="">All Colors</option>
                                <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="White" {{ request('color') == 'White' ? 'selected' : '' }}>White</option>
                                <option value="Gray" {{ request('color') == 'Gray' ? 'selected' : '' }}>Gray</option>
                                <option value="Navy" {{ request('color') == 'Navy' ? 'selected' : '' }}>Navy</option>
                                <option value="Brown" {{ request('color') == 'Brown' ? 'selected' : '' }}>Brown</option>
                                <option value="Beige" {{ request('color') == 'Beige' ? 'selected' : '' }}>Beige</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 transition-colors">
                            Apply Filters
                        </button>
                        
                        <a href="{{ route('products.index') }}" class="block w-full text-center mt-2 text-gray-600 hover:text-gray-900 text-sm">
                            Clear All Filters
                        </a>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Sort Options -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">{{ $products->total() }} products found</p>
                    
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select name="sort" onchange="updateSort(this.value)" class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                        </select>
                    </div>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($products as $product)
                        <div class="product-card">
                            <div class="relative overflow-hidden bg-white aspect-square mb-4 border border-gray-200 rounded-lg">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                
                                @if($product->isOnSale())
                                    <div class="absolute top-4 left-4 bg-red-600 text-white px-2 py-1 text-xs font-medium rounded">
                                        -{{ $product->getDiscountPercentage() }}%
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('products.show', $product) }}" class="bg-white text-gray-900 px-6 py-2 text-sm font-medium hover:bg-gray-100 transition-colors rounded-md">
                                        View Details
                                    </a>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($product->short_description, 60) }}</p>
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

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4.5"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateSort(value) {
    const url = new URL(window.location);
    url.searchParams.set('sort', value);
    window.location = url;
}
</script>
@endsection
