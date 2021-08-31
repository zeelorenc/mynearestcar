<?php

use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('carpark_id');
            $table->enum('status', VehicleStatusSchema::all());
            $table->unsignedFloat('price');
            $table->tinyInteger('seats')->nullable();
            $table->string('type');
            $table->string('brand');
            $table->string('model');
            $table->timestamps();

            $table
                ->foreign('carpark_id')
                ->references('id')
                ->on('carparks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
