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
        Schema::create('transaction_history', function (Blueprint $table) {

            $table->id();
            $table->foreignId('wallet_id')->constrained('wallet')->onDelete('cascade'); // ou outro comportamento desejado
            $table->decimal('amount', 15, 2); // Você pode querer especificar a precisão e escala
            $table->text('address')->nullable();
            $table->string('type');
            $table->string('coin');
            $table->string('status');
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
        Schema::dropIfExists('transaction_history');
    }
};
