<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('beneficiaries', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('gender');
        $table->string('district');
        $table->string('taluka');
        $table->integer('department_id');
        $table->string('scheme_id');
        $table->boolean('aadhaar_seeded');
        $table->boolean('bank_seeded');
        // Add other columns as needed
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
