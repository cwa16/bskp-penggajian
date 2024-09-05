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
        Schema::create('overtime_approveds', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->unsignedBigInteger('id_salary_year')->index();
            $table->integer('hour_call')->nullable();
            $table->integer('overtime_call')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('id_salary_year')->references('id')->on('salary_years')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nik')->references('nik')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by')->references('nik')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_approveds');
    }
};
