<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('second_name', 30)->nullable();
            $table->string('surname', 30);
            $table->string('second_surname', 30);
            $table->integer('type_identification_id')->unsigned();
            $table->string('identification', 30)->unique();
            $table->string('address', 125);
            $table->string('phone_number')->unique();
            $table->string('email', 50)->unique();
            $table->string('ocupation', 100);
            $table->string('password');
            $table->integer('departamento_id')->unsigned();
            $table->integer('municipio_id')->unsigned();

            $table->foreign('type_identification_id')->references('id')->on('type_identifications')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('departamento_id')->references('id')->on('departamentos')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('municipio_id')->references('id')->on('municipios')
                ->onUpdate('cascade')->onDelete('cascade');


            // $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
