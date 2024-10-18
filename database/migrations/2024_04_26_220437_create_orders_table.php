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
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['cart', 'not paid', 'waiting delivery', 'processing', 'picked up', 'delivered', 'cancelled', 'completed'])->default('cart');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('payment', ['cash', 'transfer'])->nullable();
            $table->enum('shipping', ['dropoff', 'pickup'])->nullable();
            $table->integer('total_weight')->nullable();
            $table->integer('total_price')->default(0);
            $table->text('proof_payment')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
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
