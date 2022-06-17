<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('category_id');
            $table->boolean('isCompany');
            $table->integer('sender');
            $table->integer('receiver')->nullable();
            $table->string('description');
            $table->string('photo')->nullable();
            $table->integer('max_budget')->nullable();
            $table->integer('min_budget')->nullable();
			$table->boolean('is_active')->default(true);
            $table->integer('ViewCount')->default(0);
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
        Schema::dropIfExists('ads');
    }
}
