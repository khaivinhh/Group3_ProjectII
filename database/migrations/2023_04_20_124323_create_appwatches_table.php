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
        Schema::create('appwatches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorydetail_id');
            $table->unsignedBigInteger('category_id'); 
            $table->unsignedBigInteger('size_id'); 
            $table->unsignedBigInteger('color_id'); 
            $table->unsignedBigInteger('capacity_id'); 
            $table->string('image')->nullable();
            $table->integer('price');
            $table->integer('quantity');
            $table->text('description');
            $table->timestamps();
            $table->foreign('categorydetail_id')->references('id')->on('categorydetails')->onDelete('cascade');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('capacity_id')->references('id')->on('capacities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appwatches');
    }
};
