<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_quizzes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id')->unsigned();
            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->bigInteger('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('who_resolved');
            $table->json('response');
            $table->decimal('score');
            $table->timestamps();
        });
        /* Todo: Borrar el comentario
        [
            [
                'sections' => [
                    'name' => 'Durante las ultimas 2 semanas',
                    'response_scale' => [
                        ['value' => 'Ningu dia', 'point' => '0'],
                        ['value' => 'Varios dias', 'point' => '1'],
                        ['value' => 'Mas de la mitad de los dias', 'point' => '2'],
                        ['value' => 'Casi todos los dias', 'point' => '3']
                    ],
                    'questions' => [
                        ["value" => ¿hola que tal?, "response" => "0"]
                    ]
                ],
                'sections' => [
                    'name' => 'Durante las ultimas  semanas',
                    'response_scale' => [
                        ['value' => 'Ningu dia', 'point' => '0'],
                        ['value' => 'Varios dias', 'point' => '0'],
                        ['value' => 'Mas de la mitad de los dias', 'point' => '0'],
                        ['value' => 'Casi todos los dias', 'point' => '0']
                    ],
                    'response' => null
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
        Schema::dropIfExists('patient_quizzes');
    }
}
