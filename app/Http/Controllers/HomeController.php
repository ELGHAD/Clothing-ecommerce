<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['images', 'categories'])
            ->active()
            ->featured()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->parent()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        return response()->json(['message' => 'Successfully subscribed to newsletter!']);
    }
}
