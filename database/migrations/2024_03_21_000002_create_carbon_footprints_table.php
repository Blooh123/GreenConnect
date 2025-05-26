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
            $table->decimal('transportation_emissions', 10, 2)->default(0);
            $table->decimal('electricity_emissions', 10, 2)->default(0);
            $table->decimal('food_emissions', 10, 2)->default(0);
            $table->decimal('shopping_emissions', 10, 2)->default(0);
            $table->decimal('total_emissions', 10, 2)->default(0);
            $table->date('recorded_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carbon_footprints');
    }
}; 