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
        Schema::create('apexforms', function (Blueprint $table) {
            $table->id();

            $table->date('date'); 
            $table->string('subject');
            $table->decimal('financial_amount', 10, 2); // Financial Amount (with decimal precision)
            $table->decimal('advanced_amount', 10, 2); // Advanced Amount (with decimal precision)
            $table->text('description'); // Description
            $table->string('department_name');
           
            $table->string('faculty_name');
            $table->string('faculty_id');
            $table->json('requirements'); 
            $table->string('expected_outcome'); // JSON for outcome expected & auditable (placement, internship, etc.)
            $table->string('submitted_by');
           
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apexforms');
    }
};
