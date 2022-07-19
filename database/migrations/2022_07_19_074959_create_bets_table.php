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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_player_id')->nullable();
            $table->foreign('first_player_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('first_player_avatar_id')->nullable();
            $table->foreign('first_player_avatar_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('first_player_name')->default("");
            $table->string('first_player_bet_amount')->default("");
            $table->string('first_player_payment_id')->default("");
            $table->string('first_player_payment_status')->default("");
            $table->unsignedBigInteger('second_player_id')->nullable();
            $table->foreign('second_player_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('second_player_avatar_id')->nullable();
            $table->foreign('second_player_avatar_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('second_player_name')->default("");
            $table->string('second_player_bet_amount')->default("");
            $table->string('second_player_payment_id')->default("");
            $table->string('second_player_payment_status')->default("");
            $table->string('bet_status')->default("pending");
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('cascade'); 
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
        Schema::dropIfExists('bets');
    }
};
