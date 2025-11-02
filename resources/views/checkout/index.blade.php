@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-light text-gray-900 mb-8 font-serif">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Checkout Form -->
            <div>
                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                    @csrf

                    <!-- Billing Information -->
                    <div>
                        <h2 class="text-xl font-medium text-gray-900 mb-4">Billing Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="billing_first_name" value="{{ old('billing_first_name', Auth::user()->first_name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('billing_first_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="billing_last_name" value="{{ old('billing_last_name', Auth::user()->last_name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('billing_last_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="billing_email" value="{{ old('billing_email', Auth::user()->email) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            @error('billing_email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" name="billing_phone" value="{{ old('billing_phone', Auth::user()->phone) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            @error('billing_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                            <input type="text" name="billing_address_line_1" value="{{ old('billing_address_line_1') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            @error('billing_address_line_1')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                            <input type="text" name="billing_address_line_2" value="{{ old('billing_address_line_2') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" name="billing_city" value="{{ old('billing_city') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('billing_city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                <input type="text" name="billing_state" value="{{ old('billing_state') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('billing_state')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" name="billing_postal_code" value="{{ old('billing_postal_code') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('billing_postal_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select name="billing_country" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <option value="US" {{ old('billing_country') == 'US' ? 'selected' : '' }}>United States</option>
                                <option value="CA" {{ old('billing_country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="GB" {{ old('billing_country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                            </select>
                            @error('billing_country')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium text-gray-900">Shipping Information</h2>
                            <label class="flex items-center">
                                <input type="checkbox" id="same-as-billing" class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                                <span class="ml-2 text-sm text-gray-600">Same as billing</span>
                            </label>
                        </div>

                        <div id="shipping-fields" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" name="shipping_first_name" value="{{ old('shipping_first_name', Auth::user()->first_name) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    @error('shipping_first_name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" name="shipping_last_name" value="{{ old('shipping_last_name', Auth::user()->last_name) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    @error('shipping_last_name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                                <input type="text" name="shipping_address_line_1" value="{{ old('shipping_address_line_1') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                @error('shipping_address_line_1')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                <input type="text" name="shipping_address_line_2" value="{{ old('shipping_address_line_2') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    @error('shipping_city')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                    <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    @error('shipping_state')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                    <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    @error('shipping_postal_code')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <select name="shipping_country" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <option value="US" {{ old('shipping_country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('shipping_country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('shipping_country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                </select>
                                @error('shipping_country')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="border-t border-gray-200 pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                        <textarea name="notes" rows="3" placeholder="Special delivery instructions..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white py-3 px-6 text-lg font-medium hover:bg-gray-800 transition-colors rounded-md">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-gray-50 rounded-lg p-6 sticky top-24">
                    <h2 class="text-xl font-medium text-gray-900 mb-4">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-3">
                                <div class="w-16 h-16 flex-shrink-0">
                                    @if($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-200 rounded-lg"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @if($item->size) Size: {{ $item->size }} @endif
                                        @if($item->color) Color: {{ $item->color }} @endif
                                    </div>
                                    <div class="text-sm text-gray-600">Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->getTotalPrice(), 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="text-gray-900">${{ number_format($shippingAmount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax:</span>
                            <span class="text-gray-900">${{ number_format($taxAmount, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 flex justify-between text-lg font-medium">
                            <span class="text-gray-900">Total:</span>
                            <span class="text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Same as billing functionality
document.getElementById('same-as-billing').addEventListener('change', function() {
    const shippingFields = document.getElementById('shipping-fields');
    const billingInputs = document.querySelectorAll('[name^="billing_"]');
    const shippingInputs = document.querySelectorAll('[name^="shipping_"]');
    
    if (this.checked) {
        billingInputs.forEach((input, index) => {
            const fieldName = input.name.replace('billing_', 'shipping_');
            const shippingInput = document.querySelector(`[name="${fieldName}"]`);
            if (shippingInput) {
                shippingInput.value = input.value;
            }
        });
        shippingFields.style.opacity = '0.5';
        shippingInputs.forEach(input => input.readOnly = true);
    } else {
        shippingFields.style.opacity = '1';
        shippingInputs.forEach(input => input.readOnly = false);
    }
});

// Update shipping when billing changes if same as billing is checked
document.querySelectorAll('[name^="billing_"]').forEach(input => {
    input.addEventListener('input', function() {
        if (document.getElementById('same-as-billing').checked) {
            const fieldName = this.name.replace('billing_', 'shipping_');
            const shippingInput = document.querySelector(`[name="${fieldName}"]`);
            if (shippingInput) {
                shippingInput.value = this.value;
            }
        }
    });
});
</script>
@endsection
