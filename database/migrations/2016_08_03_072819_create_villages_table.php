<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagesTable extends Migration
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
        Schema::connection($this->connection())->create(config('laravolt.indonesia.table_prefix').'villages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 10)->unique();
            $table->char('district_code', 7);
            $table->string('name', 255);
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->foreign('district_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix').'districts')
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
        Schema::drop(config('laravolt.indonesia.table_prefix').'villages');
    }
}
