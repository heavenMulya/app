<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('receipts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link to the order
        $table->decimal('amount_paid', 10,2);
        $table->enum('payment_method', ['cash', 'card', 'mobile']);
        $table->string('transaction_id')->nullable();
        $table->timestamp('issued_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
