<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('contact');
            $table->json('services'); // Untuk menyimpan multiple services
            $table->time('opening_hour');
            $table->time('closing_hour');
            $table->text('description')->nullable();
            $table->string('owner_name');
            $table->string('owner_contact');
            $table->string('location'); // Untuk alamat/koordinat lokasi
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundries');
    }
};