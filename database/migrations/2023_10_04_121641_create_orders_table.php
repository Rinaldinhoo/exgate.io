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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('persons')->onDelete('cascade');
            $table->decimal('price_open', 15, 2);
            $table->decimal('price_closed', 15, 2)->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('direction');
            $table->decimal('take_proft', 15, 2)->nullable();
            $table->decimal('stop_loss', 15, 2)->nullable();
            $table->string('status');
            $table->decimal('gain_loss', 15, 2)->nullable();
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
        Schema::dropIfExists('orders');
    }
};
