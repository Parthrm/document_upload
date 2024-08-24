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
        // Schema::table('beneficiaries', function (Blueprint $table) {
        //     $table->decimal('amount_awarded', 10, 2);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table('beneficiaries', function (Blueprint $table) {
        //     $table->dropColumn('amount_awarded');
        // });
        Schema::dropIfExists('beneficiaries');
    }
};
