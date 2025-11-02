<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Men's Shirts
            [
                'name' => 'Classic White Oxford Shirt',
                'slug' => 'classic-white-oxford-shirt',
                'description' => 'A timeless white Oxford shirt crafted from premium cotton. Features a classic fit with button-down collar and barrel cuffs. Perfect for both business and casual occasions.',
                'short_description' => 'Premium cotton Oxford shirt with classic fit',
                'sku' => 'MEN-SHIRT-001',
                'price' => 89.00,
                'sale_price' => null,
                'stock_quantity' => 50,
                'is_featured' => true,
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors' => ['White'],
                'categories' => ['mens-shirts'],
            ],
            [
                'name' => 'Navy Dress Shirt',
                'slug' => 'navy-dress-shirt',
                'description' => 'Sophisticated navy dress shirt made from fine cotton poplin. Features French cuffs and a spread collar for a refined look.',
                'short_description' => 'Elegant navy dress shirt with French cuffs',
                'sku' => 'MEN-SHIRT-002',
                'price' => 125.00,
                'sale_price' => 99.00,
                'stock_quantity' => 30,
                'is_featured' => true,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Navy'],
                'categories' => ['mens-shirts'],
            ],
            
            // Men's Pants
            [
                'name' => 'Tailored Chino Pants',
                'slug' => 'tailored-chino-pants',
                'description' => 'Premium chino pants with a tailored fit. Made from stretch cotton twill for comfort and style. Features flat front and clean finish.',
                'short_description' => 'Tailored fit chino pants in stretch cotton',
                'sku' => 'MEN-PANTS-001',
                'price' => 95.00,
                'sale_price' => null,
                'stock_quantity' => 40,
                'is_featured' => false,
                'sizes' => ['30', '32', '34', '36', '38'],
                'colors' => ['Khaki', 'Navy', 'Black'],
                'categories' => ['mens-pants'],
            ],
            
            // Women's Dresses
            [
                'name' => 'Elegant Midi Dress',
                'slug' => 'elegant-midi-dress',
                'description' => 'A sophisticated midi dress perfect for both day and evening wear. Features a flattering A-line silhouette and three-quarter sleeves.',
                'short_description' => 'Sophisticated A-line midi dress',
                'sku' => 'WOM-DRESS-001',
                'price' => 165.00,
                'sale_price' => null,
                'stock_quantity' => 25,
                'is_featured' => true,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'colors' => ['Black', 'Navy', 'Burgundy'],
                'categories' => ['womens-dresses'],
            ],
            [
                'name' => 'Classic Wrap Dress',
                'slug' => 'classic-wrap-dress',
                'description' => 'Timeless wrap dress in luxurious silk blend. Features adjustable tie waist and elegant draping for a flattering fit.',
                'short_description' => 'Luxurious silk blend wrap dress',
                'sku' => 'WOM-DRESS-002',
                'price' => 225.00,
                'sale_price' => 180.00,
                'stock_quantity' => 20,
                'is_featured' => true,
                'sizes' => ['XS', 'S', 'M', 'L'],
                'colors' => ['Black', 'Emerald', 'Cream'],
                'categories' => ['womens-dresses'],
            ],
            
            // Women's Blouses
            [
                'name' => 'Silk Button-Up Blouse',
                'slug' => 'silk-button-up-blouse',
                'description' => 'Elegant silk blouse with a relaxed fit. Features mother-of-pearl buttons and a classic collar for timeless sophistication.',
                'short_description' => 'Elegant silk blouse with relaxed fit',
                'sku' => 'WOM-BLOUSE-001',
                'price' => 145.00,
                'sale_price' => null,
                'stock_quantity' => 35,
                'is_featured' => false,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'colors' => ['White', 'Blush', 'Navy'],
                'categories' => ['womens-blouses'],
            ],
            
            // Accessories
            [
                'name' => 'Leather Crossbody Bag',
                'slug' => 'leather-crossbody-bag',
                'description' => 'Handcrafted leather crossbody bag with adjustable strap. Features multiple compartments and premium hardware.',
                'short_description' => 'Handcrafted leather crossbody bag',
                'sku' => 'ACC-BAG-001',
                'price' => 195.00,
                'sale_price' => null,
                'stock_quantity' => 15,
                'is_featured' => true,
                'sizes' => ['One Size'],
                'colors' => ['Black', 'Brown', 'Cognac'],
                'categories' => ['bags'],
            ],
            [
                'name' => 'Premium Leather Belt',
                'slug' => 'premium-leather-belt',
                'description' => 'Classic leather belt made from full-grain leather. Features a polished buckle and comes in multiple sizes.',
                'short_description' => 'Classic full-grain leather belt',
                'sku' => 'ACC-BELT-001',
                'price' => 75.00,
                'sale_price' => 60.00,
                'stock_quantity' => 45,
                'is_featured' => false,
                'sizes' => ['32', '34', '36', '38', '40'],
                'colors' => ['Black', 'Brown'],
                'categories' => ['belts'],
            ],
        ];

        foreach ($products as $productData) {
            $categories = $productData['categories'];
            unset($productData['categories']);

            $product = Product::create($productData);

            // Attach categories
            foreach ($categories as $categorySlug) {
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $product->categories()->attach($category->id);
                }
            }

            // Create placeholder product images
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder.jpg',
                'alt_text' => $product->name,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
