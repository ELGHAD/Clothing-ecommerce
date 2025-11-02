<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clothing Brand') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900 font-serif">
                            {{ config('app.name', 'BRAND') }}
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">Products</a>
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">Categories</button>
                            <div class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                @php
                                    $categories = \App\Models\Category::active()->parent()->orderBy('sort_order')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <a href="{{ route('products.category', $category) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-gray-900 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>

                        <!-- User Menu -->
                        @auth
                            <div class="relative group">
                                <button class="flex items-center text-gray-700 hover:text-gray-900 transition-colors">
                                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                    <a href="{{ route('profile.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Orders</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-800 transition-colors">Register</a>
                        @endauth

                        <!-- Mobile menu button -->
                        <button class="md:hidden text-gray-700 hover:text-gray-900" id="mobile-menu-button">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
                        <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900">Home</a>
                        <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900">Products</a>
                        @foreach($categories as $category)
                            <a href="{{ route('products.category', $category) }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4 font-serif">{{ config('app.name') }}</h3>
                        <p class="text-gray-300 text-sm">Premium clothing brand offering timeless elegance and sophisticated style for the modern individual.</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold mb-4 uppercase tracking-wider">Shop</h4>
                        <ul class="space-y-2 text-sm">
                            @foreach($categories->take(4) as $category)
                                <li><a href="{{ route('products.category', $category) }}" class="text-gray-300 hover:text-white transition-colors">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold mb-4 uppercase tracking-wider">Customer Care</h4>
                        <ul class="space-y-2 text-sm text-gray-300">
                            <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Size Guide</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Shipping & Returns</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold mb-4 uppercase tracking-wider">Newsletter</h4>
                        <p class="text-gray-300 text-sm mb-4">Subscribe to receive updates on new arrivals and exclusive offers.</p>
                        <form id="footer-newsletter-form" class="space-y-2">
                            @csrf
                            <input type="email" name="email" placeholder="Enter your email" class="w-full px-3 py-2 bg-gray-800 text-white placeholder-gray-400 border border-gray-700 rounded-md focus:outline-none focus:border-white">
                            <button type="submit" class="w-full bg-white text-gray-900 px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 transition-colors">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }

        // Newsletter subscription
        document.getElementById('footer-newsletter-form').addEventListener('submit', function(e) {
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

        // Load cart count on page load
        updateCartCount();
    </script>
</body>
</html>
