<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndonesiaTable extends Migration
{
    public function up(): void
    {
        Schema::create(config('indonesia.table_prefix').'provinces', function (Blueprint $table) {
            $table->char('code', 2)->primary();
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });

        Schema::create(config('indonesia.table_prefix').'cities', function (Blueprint $table) {
            $table->char('code', 4)->primary();
            $table->char('province_code', 2);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->foreign('province_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'provinces')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::create(config('indonesia.table_prefix').'districts', function (Blueprint $table) {
            $table->char('code', 7)->primary();
            $table->char('city_code', 4);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->foreign('city_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'cities')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::create(config('indonesia.table_prefix').'villages', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('district_code', 7);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('postal_code')->nullable();

            $table->foreign('district_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'districts')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::drop(config('indonesia.table_prefix').'provinces');

        Schema::drop(config('indonesia.table_prefix').'cities');

        Schema::drop(config('indonesia.table_prefix').'districts');

        Schema::drop(config('indonesia.table_prefix').'villages');
    }
};
