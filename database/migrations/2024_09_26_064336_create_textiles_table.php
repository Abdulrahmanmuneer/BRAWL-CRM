<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextilesTable extends Migration
{
    public function up()
    {
        // Create the 'textiles' table with all the necessary columns.
        Schema::create('textiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock');
            $table->string('categories')->nullable(); // Directly make it nullable here
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('seller');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the 'textiles' table when rolling back
        Schema::dropIfExists('textiles');
    }
}
