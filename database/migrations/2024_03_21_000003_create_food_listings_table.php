<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('quantity', 8, 2);
            $table->string('quantity_unit'); // kg, pieces, etc.
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->dateTime('expiry_date');
            $table->string('status')->default('available'); // available, reserved, collected
            $table->string('image_path')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_listings');
    }
}; 