<?php

use App\Models\User;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\SuitCase;
use App\Enums\PaymentSaleEnum;
use App\Models\PaymentForm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(SuitCase::class);
            $table->json('order');
            $table->integer('quantity');
            $table->float('total_value');
            $table->foreignIdFor(PaymentForm::class);
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
