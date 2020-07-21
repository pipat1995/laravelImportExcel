<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbMatVendor', function (Blueprint $table) {
            $table->string('PLANT_CODE', 20);
            $table->string('MAT_CODE', 20)->primary();
            $table->string('VENDOR_ID', 20);
            $table->string('VENDOR_NAME', 200);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbMatVendor');
    }
}
