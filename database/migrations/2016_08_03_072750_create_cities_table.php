<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    protected function connection()
    {
        // New config (optional)
        return config('indonesia.database.connection')
            // Backward compatibility
            ?? config('database.default');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection())->create(config('laravolt.indonesia.table_prefix').'cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 4)->unique();
            $table->char('province_code', 2);
            $table->string('name', 255);
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->foreign('province_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix').'provinces')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('laravolt.indonesia.table_prefix').'cities');
    }
}
