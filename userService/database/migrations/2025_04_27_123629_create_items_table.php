<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // This creates an unsignedBigInteger auto-increment primary key
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
            
            // Explicitly set engine if needed
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};