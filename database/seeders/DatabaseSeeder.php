<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Good;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrderStatusSeeder::class,
            CreateRoleSeeder::class
        ]);

         User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@gmail.com',
             'password' => Hash::make('password')
         ])->assignRole('admin');

         Brand::factory(10)->create();

         for ($i = 0; $i < 30; $i++) {
             $image = 'http://192.168.1.44:8080/storage/good_img/6527b7d2c399b.png';
             if ($i >= 7) {
                 $parent_id = rand(1, 7);
                 $image = null;
             }
             Category::create([
                 'name' => fake()->name(),
                 'category_id' => rand(1000, 2000),
                 'slug' => Str::slug(fake()->name()),
                 'parent_id' => $parent_id ?? null,
                 'image' => $image ?? null
             ]);
         }

         for ($i = 0; $i < 1000; $i++) {
             $data = [
                 fake()->title => fake()->name,
                 fake()->title => fake()->name,
                 fake()->title => fake()->name
             ];

             $category_id = rand(1, 20);
             $good = Good::create([
                 'name' => fake()->name(),
                 'slug' => Str::slug(fake()->name()),
                 'description' => fake()->text,
                 'full_description' => json_encode($data),
                 'category_id' => $category_id,
                 'price' => rand(100, 100000),
                 'count' => rand(1, 20),
                 'sale' => rand(15, 30),
                 'brand_id' => rand(1, 10)
             ]);

             Image::updateOrInsert([
                 'good_id' => $good->id,
                 'image' => 'http://192.168.1.44:8080/storage/good_img/6527b8d7c3f03.png',
                 'is_main' => 1
             ]);
         }
    }
}
