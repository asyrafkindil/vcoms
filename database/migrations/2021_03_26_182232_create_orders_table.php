<?php

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
            $table->id()->from(1001);
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('status');
            $table->float('sub_total');
            $table->float('tax');
            $table->float('total');
            $table->string('promo', 50)->nullable();
            $table->float('discount');
            $table->float('grand_total');
            $table->unsignedBigInteger('branch_id')->nullable(); // pickup location
            $table->text('note')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches');
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
