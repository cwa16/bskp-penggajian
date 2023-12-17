<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedBigInteger('id_salary_grade')->index();
            $table->integer('ability')->nullable();
            $table->integer('fungtional_allowance')->nullable();
            $table->integer('family_allowance')->nullable();
            $table->integer('adjustment')->nullable();
            $table->integer('transport_allowance')->nullable();
            $table->integer('hour_ori')->nullable();
            $table->integer('hour_call')->nullable();
            $table->integer('total_overtime')->nullable();
            $table->integer('thr')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('incentive')->nullable();
            $table->integer('salary_gross')->nullable();
            $table->integer('jamsostek_jkk_ben')->nullable();
            $table->integer('jamsostek_tk_ben')->nullable();
            $table->integer('jamsostek_tht_ben')->nullable();
            $table->integer('pph21_ben')->nullable();
            $table->integer('total_benefit')->nullable();
            $table->integer('bruto_salary')->nullable();
            $table->integer('bpjs')->nullable();
            $table->integer('jamsostek')->nullable();
            $table->integer('union')->nullable();
            $table->integer('absent')->nullable();
            $table->integer('electricity')->nullable();
            $table->integer('koperasi')->nullable();
            $table->integer('sub_deduction')->nullable();
            $table->integer('jamsostek_jkk_deb')->nullable();
            $table->integer('jamsostek_tk_deb')->nullable();
            $table->integer('jamsostek_tht_deb')->nullable();
            $table->integer('pph21_deb')->nullable();
            $table->integer('total_debenefit')->nullable();
            $table->integer('total_deduction')->nullable();
            $table->integer('nett_salary')->nullable();
            $table->string('month')->nullable();
            $table->boolean('is_checked')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_salary_grade')->references('id')->on('salary_grades')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
