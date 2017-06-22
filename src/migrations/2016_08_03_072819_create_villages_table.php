<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laravolt.indonesia.table_prefix') . 'villages', function(Blueprint $table)
        {
            $table->char('id', 10);
            $table->char('district_id', 7);
            $table->string('name', 255);
            $table->primary('id');
            $table->foreign('district_id')->references('id')->on(config('laravolt.indonesia.table_prefix') . 'districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('laravolt.indonesia.table_prefix') . 'villages');
    }
}
