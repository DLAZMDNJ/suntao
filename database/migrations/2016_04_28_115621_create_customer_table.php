<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name',120);
            $table->string('short_name',30);
            $table->string('contact_name',30);
            $table->string('phone',30);
            $table->string('address',120);
            $table->text('introduction');
            $table->string('logo',120);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('saas_customer');
    }
}
