<?php

use App\Models\SuitCase;
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
        Schema::create('sale_suit_cases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(SuitCase::class);
            $table->float('saletotalvalue');
            $table->float('profitvalue');
            $table->float('paymentvalue');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_suit_cases');
    }
};
