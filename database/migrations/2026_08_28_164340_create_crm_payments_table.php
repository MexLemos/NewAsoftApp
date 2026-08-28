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
        Schema::create('crm_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference')->unique();
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['multicaixa', 'transferencia', 'dinheiro', 'tpa', 'online']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('observation')->nullable();
            
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete(); // Aluno/Cliente
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete(); // Quem registou/aprovou
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_payments');
    }
};
