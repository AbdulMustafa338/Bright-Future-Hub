<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organization_profiles')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('eligibility')->nullable();
            $table->enum('type', ['internship', 'scholarship', 'admission', 'job']);
            $table->date('deadline');
            $table->string('location')->nullable();
            $table->string('fees')->nullable();
            $table->string('application_link')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Critical indexes for performance
            $table->index('type');
            $table->index('deadline');
            $table->index('status');
            $table->index(['status', 'deadline']); // Composite index for filtering active opportunities
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
