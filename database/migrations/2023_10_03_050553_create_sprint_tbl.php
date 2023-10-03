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
        Schema::create('sprint_tbl', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50);

            $table->date('start_date');

            $table->date('end_date');

            $table->foreignId('project_id')->constrained('project_tbl', 'id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprint_tbl');
    }
};
