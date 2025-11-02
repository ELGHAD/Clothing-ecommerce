<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function ($item) {
            return $item->getTotalPrice();
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->in_stock || $product->stock_quantity < $request->quantity) {
            return response()->json(['error' => 'Product is out of stock'], 400);
        }

        $cartItem = CartItem::where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->where('color', $request->color);

        if (Auth::check()) {
            $cartItem->where('user_id', Auth::id());
        } else {
            $cartItem->where('session_id', session()->getId());
        }

        $existingItem = $cartItem->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : session()->getId(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
            ]);
        }

        $cartCount = $this->getCartCount();

        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (!$this->canAccessCartItem($cartItem)) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function remove(CartItem $cartItem)
    {
        if (!$this->canAccessCartItem($cartItem)) {
            abort(403);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function clear()
    {
        $this->getCartItems()->each->delete();

        return response()->json(['message' => 'Cart cleared']);
    }

    public function count()
    {
        return response()->json(['count' => $this->getCartCount()]);
    }

    private function getCartItems()
    {
        $query = CartItem::with('product.images');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->get();
    }

    private function getCartCount()
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->sum('quantity');
    }

    private function canAccessCartItem(CartItem $cartItem)
    {
        if (Auth::check()) {
            return $cartItem->user_id === Auth::id();
        }

        return $cartItem->session_id === session()->getId();
    }
}
