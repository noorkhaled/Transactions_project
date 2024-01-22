<?php
namespace laravel\LaravelTransactionPackage\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('account_id');
            $table->decimal('balance',8,2);
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->dropColumn('account_id');
            $table->dropColumn('balance');
        });
    }
};
