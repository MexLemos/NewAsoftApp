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
        Schema::create('tuitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('turma_id')->constrained('turmas')->cascadeOnDelete();
            $table->string('reference_month'); // e.g. "08/2026"
            $table->date('due_date'); // Dia 10 do mês
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, paid
            $table->foreignId('crm_payment_id')->nullable()->constrained('crm_payments')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuitions');
    }
};
