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
        Schema::create('internal_transfer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('whallet_sender_id')->constrained('wallet')->onDelete('cascade');
            $table->foreignId('whallet_destination_id')->constrained('wallet')->onDelete('cascade');
            $table->decimal('amount');
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
        Schema::dropIfExists('internal_transfer');
    }
};
