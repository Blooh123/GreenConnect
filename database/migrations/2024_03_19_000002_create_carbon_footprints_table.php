<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carbon_footprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('car_distance', 8, 2);
            $table->decimal('public_transport_distance', 8, 2);
            $table->decimal('electricity_usage', 8, 2);
            $table->integer('meat_meals');
            $table->integer('vegetarian_meals');
            $table->integer('clothing_items');
            $table->integer('electronics');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->decimal('total_footprint', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carbon_footprints');
    }
}; 