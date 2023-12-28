<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\OrderStatus::insert([
            ['title' => 'На рассмотрение'],
            ['title' => 'Одобрено'],
            ['title' => 'Завершено'],
            ['title' => 'Отклонен']
        ]);
    }
}
