<?php

use App\Models\User;
use App\Enums\SuitCaseStateEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('suit_cases', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->float('totalvalue', 8, 2);
            $table->string('state');
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suit_cases');
    }
};
