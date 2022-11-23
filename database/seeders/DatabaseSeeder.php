<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        

        User::factory()->create([
             'name' => 'Facundo Esteban',
             'surname' => 'Palermo',
             'email' => 'facundo.e.palermo@gmail.com',
             'password' => '1234',
             'dni' => 34172722,
             'address' => 'Calle Falsa 123',
             'phone' => '+5491112345678',
             'isAdmin' => true
        ]);

        User::factory()->create([
            'name' => 'Usuario',
            'surname' => 'Normalito',
            'email' => 'usuario@gmail.com',
            'password' => '1234',
            'dni' => 12345678,
            'address' => 'Calle Falsa 234',
            'phone' => '+5491187654321',
            'isAdmin' => false
        ]);

        User::factory()->create([
            'name' => 'test',
            'surname' => 'Test',
            'email' => 'test@test.com',
            'password' =>'1234',
            'dni' => 10000001,
            'address' => 'calle falsa 123',
            'phone' => '+54911123456789',
            'isAdmin' => false
        ]);

       /*
        * Preguntas y respuestas 
            $question = Question::create(['text' => '']);
            Answer::create(['question_id'=>$question->id, 'text' => '', 'isCorrect' => 0]);
            Answer::create(['question_id'=>$question->id, 'text' => '', 'isCorrect' => 0]);
            Answer::create(['question_id'=>$question->id, 'text' => '', 'isCorrect' => 0]);
        */

       //1
       $question = Question::create(['text' => 'El alcohol produce en el conductor:']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Un estado de euforia y de falsa seguridad en sí mismo.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Un gran retraso del tiempo de reacción.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Un aumento del campo visual.', 'isCorrect' => 0]);

       //2
       $question = Question::create(['text' => '¿Cuál de estos elementos forma parte de la Seguridad Pasiva?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Sistema de suspensión.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Silla porta bebé.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Sistema de frenos.', 'isCorrect' => 0]);

       //3
       $question = Question::create(['text' => '¿Qué es una calle de doble mano?.']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Una calle ancha que cruza con otra calle.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Una calle donde se circula en ambos sentidos de tránsito.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Una calle reservada al uso de transporte público.', 'isCorrect' => 0]);

       //4
       $question = Question::create(['text' => '¿Está permitido penetrar en un paso a nivel cuando las barreras están en movimiento?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Si, solo cuando están levantándose.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'No está permitido.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Solo si me cercioro de que puedo pasar con seguridad.', 'isCorrect' => 0]);

       //5
       $question = Question::create(['text' => '¿Está permitido adelantar a otro vehículo en una intersección?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Depende de la intersección.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Si, está permitido.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'No, está prohibido.', 'isCorrect' => 1]);

       //6
       $question = Question::create(['text' => '¿Qué luces deben usarse obligatoriamente en rutas, autopista y semiautopistas?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Las luces bajas.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Las luces altas.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Las luces de posición.', 'isCorrect' => 0]);

       //7
       $question = Question::create(['text' => 'Algunos de los dispositivos de seguridad que como mínimo deben tener los automóviles son:']);
       Answer::create(['question_id'=>$question->id, 'text' => 'levanta vidrios.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Cierre centralizado de puertas.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Paragolpes y guardabarros.', 'isCorrect' => 1]);

       //8
       $question = Question::create(['text' => 'Con lluvia, el automóvil se adhiere mejor a la calzada si:']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Se aumenta la presión del inflado del neumático.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'El neumático conserva el dibujo en toda la superficie.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Se baja la presión del inflado del neumático. ', 'isCorrect' => 0]);

       //9
       $question = Question::create(['text' => '¿Quién tiene prioridad de paso sobre un camino con una mano obstruida?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'El que llega primero a la obstrucción.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'El vehículo que circula por la mano obstruida.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'El vehículo que circula en el carril libre, conservando su mano.', 'isCorrect' => 1]);

       //10
       $question = Question::create(['text' => '¿Cuáles son los factores a tener en cuenta para el buen funcionamiento de los neumáticos?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Presión y aceite.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Presión y estado del dibujo.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Presión y altura.', 'isCorrect' => 0]);

       //11
       $question = Question::create(['text' => 'Si el conductor de un vehículo no es el titular ¿Qué documentación lo autoriza a conducirlo?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'La cédula verde del titular vigente es suficiente.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'La cédula azul a nombre del conductor y cédula verde del titular vigente.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'La licencia de conducir del titular', 'isCorrect' => 0]);

       //12
       $question = Question::create(['text' => '¿Qué es un carril de circulación vehicular?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Franja de la calzada por donde circulan los vehículos en una fila', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Banquina de la derecha', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Banquina de la izquierda', 'isCorrect' => 0]);

       //13
       $question = Question::create(['text' => 'Los vehículos estacionados en doble fila producen:']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Un estrechamiento de la vía provocando retenciones de tráfico, así como el bloqueo de la salida de los coches estacionados correctamente.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Un mejoramiento en la fluidez del tránsito ya que no hay reducción de vía.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Una disminución en la fluidez del tránsito, ya que quedan más carriles para circular.', 'isCorrect' => 0]);

       //14
       $question = Question::create(['text' => 'Todo usuario de la vía pública debe, como premisa básica']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Concurrir a cursos de actualización en temática vial, con una frecuencia no mayor a seis meses.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Acreditar experiencia de manejo en vehículos, que por su categoría de licencia le corresponda, no menor a un año.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Asumir la obligación de no generar peligro innecesario.', 'isCorrect' => 1]);

       //15
       $question = Question::create(['text' => '¿Es obligatorio realizar la verificación técnica vehicular (VTV) en vehículos de más de dos años de antigüedad?']);
       Answer::create(['question_id'=>$question->id, 'text' => 'Si, anualmente.', 'isCorrect' => 1]);
       Answer::create(['question_id'=>$question->id, 'text' => 'No, se realiza a partir de los cuatro años de antigüedad.', 'isCorrect' => 0]);
       Answer::create(['question_id'=>$question->id, 'text' => 'Si, cada dos años.', 'isCorrect' => 0]);
    }
}