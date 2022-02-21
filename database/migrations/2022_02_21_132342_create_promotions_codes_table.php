<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 30) -> nullable();
            $table->date('start_date') -> nullable();
            $table->date('end_date') -> nullable();
            $table->double('amount', 8, 2) -> nullable();
            $table->integer('quota') -> default(0);
            $table->integer('quota_used') -> nullable();
            $table->enum('status', ['active', 'used', 'pause']) -> default('active');
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
        Schema::dropIfExists('promotions_codes');
    }
}
