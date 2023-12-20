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
             $image = 'http://artel-admin.fingroup.tj/storage/good_img/6582be8d9c4e1.png';
             if ($i >= 7) {
                 $parent_id = '00-000000'.rand(1, 7);
                 $image = null;
             }
             Category::create([
                 'name' => fake()->name(),
                 'category_id' => '00-000000'.rand(1, 30),
                 'slug' => Str::slug(fake()->name()),
                 'parent_id' => $parent_id ?? null,
                 'image' => $image ?? null
             ]);
         }

         $c = 1;
         for ($i = 0; $i < 1000; $i++) {
             $data = [
                 fake()->title => fake()->name,
                 fake()->title => fake()->name,
                 fake()->title => fake()->name
             ];

             $category_id = '00-000000'.rand(1, 20);
             $brand_id = '00-000000'.rand(1, 10);
             $good = Good::create([
                 'good_id' => '00-000000'.$c,
                 'name' => fake()->name(),
                 'slug' => Str::slug(fake()->name()),
                 'description' => fake()->text,
                 'full_description' => json_encode($data),
                 'category_id' => $category_id,
                 'price' => rand(100, 100000),
                 'count' => rand(1, 20),
                 'sale' => rand(15, 30),
                 'brand_id' => $brand_id
             ]);

             $c += 1;

             Image::updateOrInsert([
                 'good_id' => $good->good_id,
                 'image' => 'http://192.168.1.44:8080/storage/good_img/6527b8d7c3f03.png',
                 'is_main' => 1
             ]);
         }
    }
}
