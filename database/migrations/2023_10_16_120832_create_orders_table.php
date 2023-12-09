<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string( 'good_id');
            $table->integer('count');
            $table->decimal('price');
            $table->decimal('sale')->nullable();
            $table->text('comments')->nullable();
            $table->text('address')->nullable();
            $table->decimal('totalPrice', 18, 2);
            $table->boolean('delivery')->default(false);
            $table->unsignedBigInteger('order_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
