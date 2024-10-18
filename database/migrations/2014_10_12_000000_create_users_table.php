<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password')->nullable();
            $table->enum('level', ['admin', 'driver', 'customer'])->default('customer');
            $table->text('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->integer('point')->default(0);
            $table->text('kecamatan');
            $table->text('kelurahan');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'level' => 'admin'
        ]);

        User::create([
            'name' => 'Driver',
            'email' => 'driver@gmail.com',
            'password' => Hash::make('driver'),
            'level' => 'driver'
        ]);

        // User::create([
        //     'name' => 'Customer',
        //     'email' => 'customer@gmail.com',
        //     'password' => Hash::make('customer'),
        //     'level' => 'customer'
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
