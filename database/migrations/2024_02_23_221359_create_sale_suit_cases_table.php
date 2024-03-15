<?php

use App\Models\User;
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
        Schema::create('sale_suit_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SuitCase::class);
            $table->float('saletotalvalue');
            $table->float('profitvalue');
            $table->float('paymentvalue');
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
        Schema::dropIfExists('sale_suit_cases');
    }
};
