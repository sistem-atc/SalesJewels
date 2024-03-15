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
        Schema::create('close_suit_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SuitCase::class);
            $table->float('saletotalvalue');
            $table->float('balancepayable');
            $table->float('profit');
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

        /*
        * Gravar uma linha no banco de dados com os resumos
        * Resumos compostos por, Valor Total Vendido / Recuperar a Faixa de Lucro / Valor Total do Lucro /
        * Saldo a Pagar da Maleta e Retornar os dados desta linha no Notification
         */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('close_suit_cases');
    }
};
