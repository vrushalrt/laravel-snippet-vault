<?php

use App\Models\Address;
use App\Models\Cart;
use App\Models\User;
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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(User::class)->constrained();
                $table->foreignIdFor(Cart::class)->constrained();
                $table->string('reference', 12);

                $table->foreignIdFor(Address::class, 'billing_address_id')
                    ->constrained('addresses');

                $table->foreignIdFor(Address::class, 'shipping_address_id')
                    ->constrained('addresses');
                
                $table->integer('total_price');
                $table->integer('total_quantity');
                $table->string('status')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('payment_status')->nullable();
                $table->integer('invoice_number');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
