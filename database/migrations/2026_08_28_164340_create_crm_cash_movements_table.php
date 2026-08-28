<?php

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
        Schema::create('crm_cash_movements', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['in', 'out']); // entrada ou saída
            $table->decimal('amount', 12, 2);
            $table->string('description');
            $table->string('reference')->nullable(); // Recibo, fatura, ref pagamento
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete(); // Quem registou
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_cash_movements');
    }
};
