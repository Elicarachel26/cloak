<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('picture')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Product::create([
            'name' => 'Product 1',
            'slug' => 'product-1',
            'description' => 'Product 1 description',
        ]);

        Product::create([
            'name' => 'Product 2',
            'slug' => 'product-2',
            'description' => 'Product 2 description',
        ]);

        Product::create([
            'name' => 'Product 3',
            'slug' => 'product-3',
            'description' => 'Product 3 description',
        ]);

        Product::create([
            'name' => 'Product 4',
            'slug' => 'product-4',
            'description' => 'Product 4 description',
        ]);

        Product::create([
            'name' => 'Product 5',
            'slug' => 'product-5',
            'description' => 'Product 5 description',
        ]);

        Product::create([
            'name' => 'Product 6',
            'slug' => 'product-6',
            'description' => 'Product 6 description',
        ]);

        Product::create([
            'name' => 'Product 7',
            'slug' => 'product-7',
            'description' => 'Product 7 description',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
