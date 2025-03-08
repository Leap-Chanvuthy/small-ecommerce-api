<?php
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create 10 categories and 50 products
        Category::factory(10)->create();
        Product::factory(50)->create();
    }
}