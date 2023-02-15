<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->json('structure');
            $table->timestamps();
        });
        /* Todo: Borrar el comentario
        [
            [
                'sections' => [
                    'name' => 'Durante las ultimas 2 semanas',
                    'response_scale' => [
                        ['value' => 'Ningu dia', 'point' => '0'],
                        ['value' => 'Varios dias', 'point' => '0'],
                        ['value' => 'Mas de la mitad de los dias', 'point' => '0'],
                        ['value' => 'Casi todos los dias', 'point' => '0']
                    ],
                    'questions' => []
                ],
                'sections' => [
                    'name' => 'Durante las ultimas  semanas',
                    'response_scale' => [
                        ['value' => 'Ningu dia', 'point' => '0'],
                        ['value' => 'Varios dias', 'point' => '0'],
                        ['value' => 'Mas de la mitad de los dias', 'point' => '0'],
                        ['value' => 'Casi todos los dias', 'point' => '0']
                    ],
                    'questions' => []
                ]
        ];
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
