<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('user_id');
            $table->string('logo')->nullable();
            $table->string('description')->nullable();
            $table->string('verification_file')->nullable();
            $table->string('website')->nullable();
			$table->boolean('is_verified')->default(0);
			$table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('companies');
    }
}
