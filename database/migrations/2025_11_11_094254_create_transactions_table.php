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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['transfer', 'deposit', 'withdrawal']);
            $table->string('recipient_name')->nullable();
            $table->string('recipient_iban')->nullable();
            $table->string('recipient_bic')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('reason')->nullable();
            $table->string('activation_code')->nullable();
            $table->enum('status', ['pending', 'on_hold', 'success', 'failed'])->default('pending');
            $table->tinyInteger('progress')->default(0);
            $table->text('message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

