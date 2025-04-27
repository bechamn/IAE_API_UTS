<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create([
            'name' => 'Laptop',
            'description' => 'High performance laptop',
            'price' => 999.99,
            'stock' => 50,
            'image_url' => 'https://example.com/laptop.jpg'
        ]);

        Item::create([
            'name' => 'Smartphone',
            'description' => 'Latest model smartphone',
            'price' => 699.99,
            'stock' => 100,
            'image_url' => 'https://example.com/phone.jpg'
        ]);

        // Add more items as needed
    }
}