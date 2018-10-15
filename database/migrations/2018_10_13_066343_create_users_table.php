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
            $table->string('second_surname', 30)->nullable();
            $table->integer('type_identification_id')->unsigned();
            $table->integer('identification')->unique();
            $table->string('address', 125);
            $table->integer('phone_number')->unique()->nullable();
            $table->string('email', 50)->nullable()->unique();
            $table->string('ocupation', 100)->nullable();
            // $table->string('password')->nullable();
            $table->integer('departamento_id')->unsigned()->nullable();
            $table->integer('municipio_id')->unsigned()->nullable();

            $table->foreign('type_identification_id')->references('id')->on('type_identifications')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('departamento_id')->references('id')->on('departamentos')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('municipio_id')->references('id')->on('municipios')
                ->onUpdate('cascade')->onDelete('cascade');


            // $table->rememberToken();
            $table->timestamps();

        });
        DB::statement('ALTER TABLE users MODIFY COLUMN identification INT(30)');
        DB::statement('ALTER TABLE users MODIFY COLUMN phone_number INT(12)');
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
