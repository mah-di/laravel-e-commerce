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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_des');
            $table->unsignedDouble('price');
            $table->unsignedTinyInteger('discount');
            $table->unsignedDouble('discount_price');
            $table->string('image');
            $table->unsignedTinyInteger('stock');
            $table->unsignedDouble('star', 3, 2);
            $table->enum('remark', ['New', 'Hot', 'Trending', 'Discount', 'Flash Sale', 'Popular']);

            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
