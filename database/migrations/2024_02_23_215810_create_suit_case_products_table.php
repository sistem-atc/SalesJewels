<?php

use App\Models\User;
use App\Models\Product;
use App\Models\SuitCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suit_case_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SuitCase::class);
            $table->foreignIdFor(Product::class);
            $table->integer('quantity');
            $table->integer('quantitystock')->nullable();
            $table->float('unityvalue');
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suit_case_products');
    }
};
