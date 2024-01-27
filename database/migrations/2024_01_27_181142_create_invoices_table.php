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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('total');
            $table->unsignedDouble('vat');
            $table->unsignedDouble('payable');
            $table->string('cus_detail');
            $table->string('ship_detail');
            $table->string('transaction_id');
            $table->string('validation_id');
            $table->enum('delivery_status', ['PENDING', 'SHIPPED', 'DELIVERED']);
            $table->string('payment_status');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
