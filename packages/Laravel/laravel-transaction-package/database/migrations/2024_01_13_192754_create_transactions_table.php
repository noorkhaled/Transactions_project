<?php
namespace Laravel\LaravelTransactionPackage\Database;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','id');
            $table->foreignId('type')->constrained('transactions_types');
            $table->unsignedBigInteger('from_account_id');
            $table->string('from_type');
            $table->decimal('from_account_balance',8,2);
            $table->unsignedBigInteger('to_account_id');
            $table->string('to_type');
            $table->decimal('to_account_balance',8,2);
            $table->decimal('amount',8,2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
