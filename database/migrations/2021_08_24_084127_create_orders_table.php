<?php

use App\Schemas\OrderStatusSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamp('from_date')->nullable();
            $table->timestamp('to_date')->nullable();
            $table->unsignedFloat('total');
            $table->string('status')->default(OrderStatusSchema::UNPAID);
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_refund_id')->nullable();
            $table->json('user_location')->nullable();
            $table->timestamps();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
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
        Schema::dropIfExists('orders');
    }
}
