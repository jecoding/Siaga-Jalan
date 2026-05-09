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
        // Enable PostGIS extension for spatial queries
        \DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');

        Schema::create('black_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('radius')->default(100);
            $table->timestamps();
        });

        // Add geography column
        // We use 'geography(Geometry, 4326)' so it can store Point, LineString, Polygon natively
        \DB::statement('ALTER TABLE black_spots ADD COLUMN location geography(Geometry, 4326)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('black_spots');
    }
};
