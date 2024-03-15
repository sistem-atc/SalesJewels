<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('profit_ranges', function (Blueprint $table) {
            $table->id();
            $table->float('rangeinitial', 8,2);
            $table->float('rangefinal', 8,2);
            $table->float('percent', 8,2)->default(0);
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profit_ranges');
    }
};
