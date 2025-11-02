<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Men\'s Clothing',
                'slug' => 'mens-clothing',
                'description' => 'Premium men\'s clothing collection featuring timeless designs and exceptional quality.',
                'is_active' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Shirts', 'slug' => 'mens-shirts', 'description' => 'Classic and contemporary shirts for the modern gentleman.'],
                    ['name' => 'Pants', 'slug' => 'mens-pants', 'description' => 'Tailored pants and trousers for every occasion.'],
                    ['name' => 'Jackets', 'slug' => 'mens-jackets', 'description' => 'Sophisticated jackets and outerwear.'],
                    ['name' => 'Suits', 'slug' => 'mens-suits', 'description' => 'Impeccably tailored suits for the discerning professional.'],
                ]
            ],
            [
                'name' => 'Women\'s Clothing',
                'slug' => 'womens-clothing',
                'description' => 'Elegant women\'s clothing that embodies sophistication and grace.',
                'is_active' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Dresses', 'slug' => 'womens-dresses', 'description' => 'Elegant dresses for every occasion.'],
                    ['name' => 'Blouses', 'slug' => 'womens-blouses', 'description' => 'Refined blouses and tops.'],
                    ['name' => 'Skirts', 'slug' => 'womens-skirts', 'description' => 'Classic and contemporary skirts.'],
                    ['name' => 'Pants', 'slug' => 'womens-pants', 'description' => 'Tailored pants and trousers.'],
                ]
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Carefully curated accessories to complete your look.',
                'is_active' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Bags', 'slug' => 'bags', 'description' => 'Luxury handbags and accessories.'],
                    ['name' => 'Belts', 'slug' => 'belts', 'description' => 'Premium leather belts.'],
                    ['name' => 'Scarves', 'slug' => 'scarves', 'description' => 'Elegant scarves and wraps.'],
                ]
            ],
            [
                'name' => 'Footwear',
                'slug' => 'footwear',
                'description' => 'Premium footwear collection combining comfort and style.',
                'is_active' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Dress Shoes', 'slug' => 'dress-shoes', 'description' => 'Classic dress shoes for formal occasions.'],
                    ['name' => 'Casual Shoes', 'slug' => 'casual-shoes', 'description' => 'Comfortable casual footwear.'],
                    ['name' => 'Boots', 'slug' => 'boots', 'description' => 'Stylish boots for all seasons.'],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['is_active'] = true;
                $childData['sort_order'] = 0;
                Category::create($childData);
            }
        }
    }
}
